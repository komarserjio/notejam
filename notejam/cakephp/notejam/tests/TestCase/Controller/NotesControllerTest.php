<?php
namespace App\Test\TestCase\Controller;

use App\Controller\NotesController;
use App\Test\TestCase\NotejamTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\NotesController Test Case
 */
class NotesControllerTest extends NotejamTestCase
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
     * Test if note can be successfully created
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $this->signin($this->user);
        $data = ['name' => 'New note', 'text' => 'Text'];
        $this->post('/notes/create', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect('/');
        $this->assertEquals(
            TableRegistry::get('Notes')->get(2)->name,
            $data['name']
        );
    }

    /**
     * Test if validation works when create a note
     *
     * @return void
     */
    public function testCreateFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/notes/create', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

    /**
     * Test if note can be successfully edited
     *
     * @return void
     */
    public function testEditSuccess()
    {
        $this->signin($this->user);
        $data = ['name' => 'New note name'];
        $this->post('/notes/1/edit', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect('/notes/1');
        $this->assertEquals(
            TableRegistry::get('Notes')->get(1)->name,
            $data['name']
        );
    }

    /**
     * Test if validation works when edit a note
     *
     * @return void
     */
    public function testEditFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/notes/1/edit', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

    /**
     * Test if note cannot be successfully viewed by not an owner
     *
     * @return void
     */
    public function testEditFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $data = ['name' => 'New note name'];
        $this->post('/notes/1/edit', $data);
        $this->assertResponseError();
    }

    /**
     * Test if note can be successfully viewed
     *
     * @return void
     */
    public function testViewSuccess()
    {
        $this->signin($this->user);
        $this->get('/notes/1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('Note #1');
    }

    /**
     * Test if note cannot be viewed by not an owner
     *
     * @return void
     */
    public function testViewFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $this->get('/notes/1/');
        $this->assertResponseError();
    }

    /**
     * Test if note can be successfully deleted
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->signin($this->user);
        $this->post('/notes/1/delete', []);
        $this->assertResponseSuccess();
        $this->assertRedirect('/');
        $this->assertEquals(
            TableRegistry::get('Notes')->find('all')->count(),
            0
        );
    }

    /**
     * Test if note cannot be deleted by not an owner
     *
     * @return void
     */
    public function testDeleteFailNotAnOwner()
    {
        $this->signin(['id' => 2, 'email' => 'user2@example.com']);
        $this->post('/notes/1/delete', []);
        $this->assertResponseError();
    }
}
