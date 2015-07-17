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
     * Layout setting
     *
     * @var string
     */
    protected $layout = 'signedin';

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
                $this->Flash->success(__('The pad has been saved.'));
                return $this->redirect(['action' => 'create']);
            }
        }
        $this->set(compact('pad'));
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
        $pad = $this->Pads->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pad = $this->Pads->patchEntity($pad, $this->request->data);
            if ($this->Pads->save($pad)) {
                $this->Flash->success(__('The pad has been saved.'));
                return $this->redirect(['action' => 'create']);
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
        $pad = $this->Pads->get($id);
        if ($this->request->is('post')) {
            $this->Pads->delete($pad);
            $this->Flash->success(__('The pad has been deleted.'));
            return $this->redirect(['_name' => 'create_pad']);
        }
        $this->set(compact('pad'));
    }
}
