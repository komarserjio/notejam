<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users'
    ];

    /**
     * Test success signup
     *
     * @return void
     */
    public function testSignupSuccess()
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'pa$$word',
            'confirm_password' => 'pa$$word'
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $users = TableRegistry::get('Users');
        $query = $users->find()->where(['email' => $data['email']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test if signup fails if required fields are missing
     *
     * @return void
     */
    public function testSignupFailRequiredFields()
    {
        $data = [
            'email' => '',
            'password' => '',
            'confirm_password' => ''
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('This field cannot be left empty');
    }

    /**
     * Test if signup fails if email is invalid
     *
     * @return void
     */
    public function testSignupFailInvalidEmail()
    {
        $data = [
            'email' => 'invalid email'
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('The provided value is invalid');
    }

    /**
     * Test if signup fails if email already exists
     *
     * @return void
     */
    public function testSignupFailEmailExists()
    {
        $data = [
            'email' => 'user1@example.com',
            'password' => 'pa$$word',
            'confirm_password' => 'pa$$word'
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('This value is already in use');
    }

    /**
     * Test if signup fails if passwords do not match
     *
     * @return void
     */
    public function testSignupFailPasswordsNotMatch()
    {
        $data = [
            'email' => 'user1@example.com',
            'password' => 'pa$$word1',
            'confirm_password' => 'pa$$word2'
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('Passwords do not match');
    }

    /**
     * Test if signin success
     *
     * @return void
     */
    public function testSigninSuccess()
    {
        $data = [
            'email' => 'user1@example.com',
            'password' => '111111'
        ];
        $this->post('/signin', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Notes', 'action' => 'index']);
        $this->assertSession('user1@example.com', 'Auth.User.email');

    }

    /**
     * Test if signin fails if provided credentials are wroing
     *
     * @return void
     */
    public function testSigninFailWrongCredentials()
    {
        $data = [
            'email' => 'user2@example.com',
            'password' => 'wrong password'
        ];
        $this->post('/signin', $data);
        $this->assertResponseContains('Your username or password is incorrect.');
    }
}
