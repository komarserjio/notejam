<?php

class NoteTest extends TestCase {

    public function getNoteData($override = array()) {
        return array_merge(
            array(
                'name' => 'Note',
                'text' => 'Text',
            ),
            $override
        );
    }

    public function testCreateSuccess()
    {
        $data = $this->getNoteData();
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $crawler = $this->client->request(
            'POST', URL::route('create_note'), $data
        );
        $this->assertRedirectedToRoute(
            'view_note',
            array('id' => $user->notes()->first()->id)
        );
        $this->assertEquals(1, $user->notes()->count());
    }

    public function testCreateFailRequiredFields()
    {
        $this->be($this->createUser('exists@example.com'));
        $crawler = $this->client->request(
            'POST', URL::route('create_note'), array()
        );
        $this->assertSessionHasErrors(
            array('name', 'text')
        );
    }

    public function testCreateFailAnonymousUser()
    {
        $data = $this->getNoteData();
        $crawler = $this->client->request(
            'POST', URL::route('create_note'), $data
        );
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testCreateFailAnothersUserPad()
    {
        $user2 = $this->createUser('exists@example.com');
        $pad = $user2->pads()->save(new Pad(array('name' => 'pad')));

        $user = $this->createUser('exists@example.com');
        $data = $this->getNoteData(array('pad_id' => $pad->id));
        $this->be($user);
        $crawler = $this->client->request(
            'POST', URL::route('create_note'), $data
        );
    }

    public function testEditSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $crawler = $this->client->request(
            'POST',
            URL::route('edit_note', array('id' => $note->id)),
            array('name' => 'new name', 'text' => 'new text')
        );
        $this->assertRedirectedToRoute('view_note', array('id' => $note->id));
    }

    public function testEditFailRequiredFields()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $crawler = $this->client->request(
            'POST',
            URL::route('edit_note', array('id' => $note->id)),
            array()
        );
        $this->assertSessionHasErrors(
            array('name', 'text')
        );
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testEditFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $this->be($this->createUser('exists2@example.com'));

        $crawler = $this->client->request(
            'POST',
            URL::route('edit_note', array('id' => $note->id)),
            array('name' => 'new name', 'text' => 'new text')
        );
    }

    public function testViewSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $this->be($user);
        $crawler = $this->client->request(
            'GET',
            URL::route('view_note', array('id' => $note->id))
        );
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testViewFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $this->be($this->createUser('exists2@example.com'));
        $crawler = $this->client->request(
            'GET',
            URL::route('view_note', array('id' => $note->id))
        );
    }

    public function testDeleteSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $this->be($user);
        $crawler = $this->client->request(
            'POST',
            URL::route('delete_note', array('id' => $note->id))
        );
        $this->assertRedirectedToRoute('all_notes');
        $this->assertEquals(0, $user->notes()->count());
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testDeleteFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $note = $user->notes()->save(
            new Note($this->getNoteData())
        );
        $this->be($this->createUser('exists2@example.com'));
        $crawler = $this->client->request(
            'POST',
            URL::route('delete_note', array('id' => $note->id))
        );
    }
}



