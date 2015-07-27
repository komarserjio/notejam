<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 */
class NotesController extends AppController
{

    protected $layout = 'signedin';

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
        $note = $this->Notes->get($id, [
            'contain' => ['Pads', 'Users']
        ]);
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

        $pads = (new Collection($this->getUser()->pads))->combine('id', 'name')->toArray();
        $this->set(compact('note', 'pads'));
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
        $note = $this->Notes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $note = $this->Notes->patchEntity($note, $this->request->data);
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }
        $pads = (new Collection($this->getUser()->pads))->combine('id', 'name')->toArray();
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
        $note = $this->Notes->get($id);
        if ($this->request->is('post')) {
            $this->Notes->delete($note);
            $this->Flash->success(__('The note has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('note'));
    }
}
