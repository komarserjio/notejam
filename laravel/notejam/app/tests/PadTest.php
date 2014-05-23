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

    protected function createUser($email, $password = 'password') {
        $user = new User(
            array(
                'email' => $email,
                'password' => Hash::make($password)
            )
        );
        $user->save();
        return $user;
    }

    public function testCreateSuccess()
    {
        $data = $this->getPadData();
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $crawler = $this->client->request(
            'POST', URL::route('create_pad'), $data
        );
        $this->assertRedirectedToRoute(
            'view_pad',
            array('id' => $user->pads()->first()->id)
        );
        $this->assertEquals(1, $user->pads()->count());
    }

    public function testCreateFailRequiredFields()
    {
        $this->be($this->createUser('exists@example.com'));
        $crawler = $this->client->request(
            'POST', URL::route('create_pad'), array()
        );
        $this->assertSessionHasErrors(
            array('name')
        );
    }

    public function testEditByOwnerSuccess()
    {
        $user = $this->createUser('exists@example.com');
        $this->be($user);
        $pad = $user->pads()->save(new Pad(array('name' => 'pad')));
        $crawler = $this->client->request(
            'POST',
            URL::route('edit_pad', array('id' => $pad->id)),
            array('name' => 'new name')
        );
        $this->assertRedirectedToRoute('view_pad', array('id' => $pad->id));
    }

}


