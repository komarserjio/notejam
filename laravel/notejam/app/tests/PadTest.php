<?php

class PadTest extends TestCase {

    public function getPadData($override = array()) {
        return array_merge(
            array(
                'name' => 'Pad',
            ),
            $override
        );
    }

    public function testCreateSuccess()
    {
        $data = $this->getPadData();
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $crawler = $this->client->request(
            'POST', URL::route('pads.store'), $data
        );
        $this->assertRedirectedToRoute(
            'pads.show',
            array('id' => $user->pads()->first()->id)
        );
        $this->assertEquals(1, $user->pads()->count());
    }

    public function testCreateFailRequiredFields()
    {
        $this->be($this->createUser('exists@example.com'));
        $crawler = $this->client->request(
            'POST', URL::route('pads.store'), array()
        );
        $this->assertSessionHasErrors(
            array('name')
        );
    }

    public function testEditSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $crawler = $this->client->request(
            'POST',
            URL::route('pads.update', array('id' => $pad->id)),
            array('name' => 'new name')
        );
        $this->assertRedirectedToRoute('pads.show', array('id' => $pad->id));
    }

    public function testEditFailRequiredFields()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $crawler = $this->client->request(
            'POST',
            URL::route('pads.update', array('id' => $pad->id)),
            array()
        );
        $this->assertSessionHasErrors(
            array('name')
        );
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testEditFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));

        $this->be($this->createUser('exists2@example.com'));
        $crawler = $this->client->request(
            'POST',
            URL::route('pads.update', array('id' => $pad->id)),
            array('name' => 'new name')
        );
    }

    public function testViewSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $crawler = $this->client->request(
            'GET',
            URL::route('pads.show', array('id' => $pad->id))
        );
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testViewFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $this->be($this->createUser('exists2@example.com'));
        $crawler = $this->client->request(
            'GET',
            URL::route('pads.show', array('id' => $pad->id))
        );
    }

    public function testDeleteSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $crawler = $this->client->request(
            'POST',
            URL::route('pads.destroy', array('id' => $pad->id))
        );
        $this->assertRedirectedToRoute('all_notes');
        $this->assertEquals(0, $user->pads()->count());
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testDeleteFailNotAnOwner()
    {
        $user = $this->createUser('exists@example.com');
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $this->be($this->createUser('exists2@example.com'));
        $crawler = $this->client->request(
            'POST',
            URL::route('pads.destroy', array('id' => $pad->id))
        );
    }
}


