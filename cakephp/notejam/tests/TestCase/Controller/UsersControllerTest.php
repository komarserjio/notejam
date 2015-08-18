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
            'password' => 'user@example.com',
            'confirm_password' => 'user@example.com'
        ];
        $this->post('/signup', $data);
        $this->assertResponseSuccess();
        $users = TableRegistry::get('Users');
        $query = $users->find()->where(['email' => $data['email']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
