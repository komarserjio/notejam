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

}
