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
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEditSuccess()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEditFailRequiredFields()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
