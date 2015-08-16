<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\SettingsForm;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Layout setting
     *
     * @var string
     */
    protected $layout = 'user';

    /**
     * Signup action
     *
     * @return void Redirects on successful signup, renders errors otherwise.
     */
    public function signup()
    {
        $this->layout = 'user';
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Now you can signin'));
                return $this->redirect(['action' => 'signin']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Signin action
     *
     * @return void Redirects on successful signup, renders errors otherwise.
     */
    public function signin()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    /**
     * Sign out action
     *
     * @return void Redirects on successful signin
     */
    public function signout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Account settings action
     *
     * @return void
     */
    public function settings()
    {
        $settings = new SettingsForm();
        if ($this->request->is('post') &&
            $settings->validate($this->request->data)) {

            $user = $this->getUser();
            if ($user->checkPassword($this->request->data['current_password'])) {
                $user->password = $this->request->data['new_password'];
                $this->Users->save($user);
                $this->Flash->success('Password is successfully changed.');
                return $this->redirect(['_name' => 'index']);
            }
            $this->Flash->error('Current password is not correct.');
        }
        $this->set(compact('settings'));
    }
}
