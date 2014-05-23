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
        $this->assertRedirectedToRoute('all_notes');
        $this->assertEquals(1, $user->pads()->count());
    }

}


