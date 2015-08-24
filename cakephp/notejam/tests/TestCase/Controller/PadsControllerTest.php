<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\PadsController;
use App\Test\TestCase\NotejamTestCase;

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

    public function testCreateFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/pads/create', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

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

    public function testEditFailRequiredFields()
    {
        $this->signin($this->user);
        $this->post('/pads/1/edit', ['name' => '']);
        $this->assertResponseContains('This field cannot be left empty');
    }

    public function testEditFailNotAnOwner()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testViewSuccess()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testViewFailNotAnOwner()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testDeleteSuccess()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testDeleteFailNotAnOwner()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

}
