<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 */
class NotesController extends AppController
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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set(
            'notes',
            $this->Notes->find('all', ['contain' => 'Pads'])
                ->where(['Notes.user_id' => $this->getUser()->id])
                ->order($this->buildOrderBy($this->request->query('order')))
        );
    }

    /**
     * View note
     *
     * @param string|null $id Note id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $note = $this->getNote($id);
        $this->set('note', $note);
    }

    /**
     * Create note action
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function create()
    {
        $note = $this->Notes->newEntity();
        if ($this->request->is('post')) {
            $note = $this->Notes->patchEntity($note, array_merge(
                $this->request->data,
                ['user_id' => $this->getUser()->id]
            ));
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }
        // current pad
        $pad = $this->request->query('pad');

        $pads = collection($this->getUser()->pads)->combine('id', 'name')->toArray();
        $this->set(compact('note', 'pads', 'pad'));
    }


    /**
     * Edit note
     *
     * @param string|null $id Note id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $note = $this->getNote($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $note = $this->Notes->patchEntity($note, $this->request->data);
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));
                return $this->redirect(['action' => 'view', 'id' => $note->id]);
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }
        $pads = collection($this->getUser()->pads)->combine('id', 'name')->toArray();
        $this->set(compact('note', 'pads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Note id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $note = $this->getNote($id);
        if ($this->request->is('post')) {
            $this->Notes->delete($note);
            $this->Flash->success(__('The note has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('note'));
    }

    /**
     * Get note
     *
     * @param int $id Note id
     * @return Note
     */
    protected function getNote($id)
    {
        return TableRegistry::get('Notes')->find()
            ->contain(['Pads', 'Users'])
            ->where(['Notes.id' => $id])
            ->where(['Notes.user_id' => $this->getUser()->id])
            ->firstOrFail();
    }
}
