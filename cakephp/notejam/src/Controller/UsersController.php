<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\SettingsForm;
use App\Form\ForgotPasswordForm;
use Cake\Core\Configure;
use Cake\Network\Email\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Set layout
     *
     * @param \Cake\Event\Event $event Event object
     * @return void
     */
    public function beforeRender(\Cake\Event\Event $event)
    {
        $this->viewBuilder()->layout('anonymous');
    }

    /**
     * Signup action
     *
     * @return void Redirects on successful signup, renders errors otherwise.
     */
    public function signup()
    {
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

    /**
     * Forgot password action
     *
     * @return void
     */
    public function forgotPassword()
    {
        $form = new ForgotPasswordForm();
        if ($this->request->is('post') &&
            $form->validate($this->request->data)) {

            $user = $this->Users->find()
                         ->where(['email' => $this->request->data['email']])
                         ->first();
            if ($user) {
                $this->resetPassword($user);
                $this->Flash->success('New temp password is sent to your inbox.');
                return $this->redirect(['_name' => 'index']);
            }
            $this->Flash->error('User with given email does not exist.');
        }
        $this->set(compact('form'));
    }

    /**
     * Reset user's password
     *
     * @param App\Model\Entity\User $user User
     * @return void
     */
    protected function resetPassword($user)
    {
        // primitive way to generate temporary password
        $user->password = $password = substr(
            sha1(time() . rand() . Configure::read('Security.salt')), 0, 8
        );
        $this->Users->save($user);

        Email::deliver(
            $user->email,
            "New notejam password",
            "Your new temporary password is {$password}.
             We recommend you to change it after signing in.",
            ["from" => "noreply@notejamapp.com", "transport" => "default"]
        );
    }
}
