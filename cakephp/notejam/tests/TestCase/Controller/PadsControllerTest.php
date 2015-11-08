<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PadsController;
use App\Test\TestCase\NotejamTestCase;
use Cake\ORM\TableRegistry;

/**
 * Pads test case
 */
class PadsControllerTest extends NotejamTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pads',
        'app.users',
        'app.notes'
    ];

    /**
     * Test if pad can be successfully created
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $this->signin($this->user);
        $data = ['name' => 'New pad'];
        $this->post('/pads/create', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect('/pads/2');
        $this->assertEquals(
            TableRegistry::get('Pads')->get(2)->name,
            $data['name']
        );
    }

    /**
     * Test if validation works when create a pad
     *
     * @return void
     */
    public function testCreateFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/pads/create', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

    /**
     * Test if pad can be successfully edited
     *
     * @return void
     */
    public function testEditSuccess()
    {
        $this->signin($this->user);
        $data = ['name' => 'New pad name'];
        $this->post('/pads/1/edit', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect('/pads/1');
        $this->assertEquals(
            TableRegistry::get('Pads')->get(1)->name,
            $data['name']
        );
    }

    /**
     * Test if validation works when edit a pad
     *
     * @return void
     */
    public function testEditFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/pads/1/edit', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

    /**
     * Test if pad cannot be edited by not an owner
     *
     * @return void
     */
    public function testEditFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $data = ['name' => 'New pad name'];
        $this->post('/pads/1/edit', $data);
        $this->assertResponseError();
    }

    /**
     * Test if pad can be successfully viewed
     *
     * @return void
     */
    public function testViewSuccess()
    {
        $this->signin($this->user);
        $this->get('/pads/1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('Pad (1)');
    }

    /**
     * Test if pad cannot be viewed by not an owner
     *
     * @return void
     */
    public function testViewFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $this->get('/pads/1');
        $this->assertResponseError();
    }

    /**
     * Test if pad can be successfully deleted
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->signin($this->user);
        $this->post('/pads/1/delete', []);
        $this->assertResponseSuccess();
        $this->assertRedirect('/');
        $this->assertEquals(
            TableRegistry::get('Pads')->find('all')->count(),
            0
        );
    }

    /**
     * Test if pad cannot be deleted by not an owner
     *
     * @return void
     */
    public function testDeleteFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $this->post('/pads/1/delete', []);
        $this->assertResponseError();
    }
}
