<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'signin'
            ]
        ]);
        $this->Auth->allow(['signup', 'forgotpassword']);
    }

    /**
     * Get authenticated user
     *
     * @return App\Model\Entity\User
     */
    protected function getUser()
    {
        $id = $this->request->session()->read('Auth.User.id');
        return TableRegistry::get('Users')->get($id, [
            'contain' => ['Pads', 'Notes']
        ]);
    }

    /**
     * Build order statetment
     *
     * @param string $order Order param
     * @return array
     */
    public function buildOrderBy($order)
    {
        $config = [
            'name' => ['Notes.name' => 'ASC'],
            '-name' => ['Notes.name' => 'DESC'],
            'updated_at' => ['Notes.updated_at' => 'ASC'],
            '-updated_at' => ['Notes.updated_at' => 'DESC'],
        ];
        return $config[$order ? $order : 'updated_at'];
    }
}
