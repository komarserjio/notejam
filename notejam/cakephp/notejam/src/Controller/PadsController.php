<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Pads Controller
 *
 * @property \App\Model\Table\PadsTable $Pads
 */
class PadsController extends AppController
{

    /**
     * Set layout
     *
     * @param \Cake\Event\Event $event Event object
     * @return void
     */
    public function beforeRender(\Cake\Event\Event $event)
    {
        $this->viewBuilder()->layout('user');
    }

    /**
     * View pad
     *
     * @param string|null $id Pad id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pad = $this->getPad($id);
        $notes = TableRegistry::get('Notes')->find('all', ['contain' => 'Pads'])
            ->where(['Notes.pad_id' => $id])
            ->where(['Notes.user_id' => $this->getUser()->id])
            ->order($this->buildOrderBy($this->request->query('order')));

        $this->set('pad', $pad);
        $this->set('notes', $notes);
    }

    /**
     * Create a pad
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function create()
    {
        $pad = $this->Pads->newEntity();
        if ($this->request->is('post')) {
            $pad = $this->Pads->patchEntity($pad, array_merge(
                $this->request->data,
                ['user_id' => $this->Auth->user('id')]
            ));
            if ($this->Pads->save($pad)) {
                $this->Flash->success(__('The pad has been created.'));
                return $this->redirect(['action' => 'view', 'id' => $pad->id]);
            }
        }
        $this->set(compact('pad'));
    }

    /**
     * Edit pad
     *
     * @param string|null $id Pad id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pad = $this->getPad($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pad = $this->Pads->patchEntity($pad, $this->request->data);
            if ($this->Pads->save($pad)) {
                $this->Flash->success(__('The pad has been saved.'));
                return $this->redirect(['action' => 'view', 'id' => $pad->id]);
            } else {
                $this->Flash->error(__('The pad could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('pad'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pad id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $pad = $this->getPad($id);
        if ($this->request->is('post')) {
            $this->Pads->delete($pad);
            $this->Flash->success(__('The pad has been deleted.'));
            return $this->redirect(['_name' => 'index']);
        }
        $this->set(compact('pad'));
    }

    /**
     * Get pad
     *
     * @param int $id Pad id
     * @return Pad
     */
    protected function getPad($id)
    {
         return TableRegistry::get('Pads')->find()
            ->contain(['Users'])
            ->where(['Pads.id' => $id])
            ->where(['Pads.user_id' => $this->getUser()->id])
            ->firstOrFail();
    }
}
