<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pads Controller
 *
 * @property \App\Model\Table\PadsTable $Pads
 */
class PadsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('pads', $this->paginate($this->Pads));
        $this->set('_serialize', ['pads']);
    }

    /**
     * View method
     *
     * @param string|null $id Pad id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pad = $this->Pads->get($id, [
            'contain' => ['Users', 'Notes']
        ]);
        $this->set('pad', $pad);
        $this->set('_serialize', ['pad']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pad = $this->Pads->newEntity();
        if ($this->request->is('post')) {
            $pad = $this->Pads->patchEntity($pad, $this->request->data);
            if ($this->Pads->save($pad)) {
                $this->Flash->success(__('The pad has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pad could not be saved. Please, try again.'));
            }
        }
        $users = $this->Pads->Users->find('list', ['limit' => 200]);
        $this->set(compact('pad', 'users'));
        $this->set('_serialize', ['pad']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pad id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pad = $this->Pads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pad = $this->Pads->patchEntity($pad, $this->request->data);
            if ($this->Pads->save($pad)) {
                $this->Flash->success(__('The pad has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pad could not be saved. Please, try again.'));
            }
        }
        $users = $this->Pads->Users->find('list', ['limit' => 200]);
        $this->set(compact('pad', 'users'));
        $this->set('_serialize', ['pad']);
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
        $this->request->allowMethod(['post', 'delete']);
        $pad = $this->Pads->get($id);
        if ($this->Pads->delete($pad)) {
            $this->Flash->success(__('The pad has been deleted.'));
        } else {
            $this->Flash->error(__('The pad could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
