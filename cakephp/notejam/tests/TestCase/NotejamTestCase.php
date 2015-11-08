<?php
namespace App\Test\TestCase;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class NotejamTestCase extends IntegrationTestCase
{
    protected $user = [
        'id' => 1,
        'email'  => 'user@example.com'
    ];

    /**
     * Sign in user
     *
     * @param array $user User
     * @return void
     */
    public function signin($user)
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => $user['id'],
                    'username' => $user['email']
                ]
            ]
        ]);
    }

    /**
     * Create a user
     *
     * @param array $userData User data
     * @return User
     */
    public function createUser($userData)
    {
        $user = TableRegistry::get('Users')->newEntity($userData);
        TableRegistry::get('Users')->save($user);
        return $user;
    }
}
