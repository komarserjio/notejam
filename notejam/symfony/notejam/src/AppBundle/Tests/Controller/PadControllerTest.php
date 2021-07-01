<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;
use AppBundle\Entity\Pad;

class PadControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(array());
        // init kernel to init entity manager
        static::$kernel = static::createKernel(array('environment' => 'test'));
        static::$kernel->boot();
    }

    public function getEm() {
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager() ;
        return $this->em;
    }

    private function _createUser($email, $password) {
        $user = new User();

        $encoder = static::$kernel->getContainer()
            ->get('security.encoder_factory')
            ->getEncoder($user);

        $password = $encoder->encodePassword($password, $user->getSalt());
        $user->setEmail($email)
             ->setPassword($password);

        $this->getEm()->persist($user);
        $this->getEm()->flush();

        return $user;
    }

    private function _createPad($name, $user) {
        $pad = new Pad();
        $pad->setName($name);
        $pad->setUser($user);

        $this->getEm()->persist($pad);
        $this->getEm()->flush();

        return $pad;
    }

    private function _signIn($user)
    {
        $client = static::createClient();
        $session = $client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken(
            $user, $user->getPassword(), $firewall, array('ROLE_USER')
        );
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        return $client;
    }

    public function testCreatePadSuccess()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);

        $client = $this->_signIn($user);
        $client->followRedirects();
        $crawler = $client->request('GET', '/pads/create');
        $form = $crawler->filter('button')->form();
        $form['pad[name]'] = 'Pad';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('nav > ul > li')->count());
        $this->assertCount(
            1, $this->getEm()->getRepository('AppBundle:Pad')->findAll()
        );
    }

    public function testCreatePadErrorRequiredFields()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);

        $client = $this->_signIn($user);
        $crawler = $client->request('GET', '/pads/create');
        $form = $crawler->filter('button')->form();
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
    }

    public function testEditPadSuccess()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);
        $pad = $this->_createPad('initial pad', $user);

        $client = $this->_signIn($user);
        $crawler = $client->request('GET', "/pads/{$pad->getId()}/edit");
        $form = $crawler->filter('button')->form();
        $newName = 'new pad name';
        $form['pad[name]'] = $newName;
        $crawler = $client->submit($form);

        $updatedPad = $this->getEm()->getRepository(
            'AppBundle:Pad'
        )->find(1);
        $this->assertEquals($newName, $updatedPad->getName());
    }

    public function testEditPadErrorRequiredFields()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);
        $pad = $this->_createPad('initial pad', $user);

        $client = $this->_signIn($user);
        $crawler = $client->request('GET', "/pads/{$pad->getId()}/edit");
        $form = $crawler->filter('button')->form();
        $form['pad[name]'] = "";
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
    }

    public function testDeletePadSuccess()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);
        $pad = $this->_createPad('test pad', $user);

        $client = $this->_signIn($user);
        $crawler = $client->request('GET', "/pads/{$pad->getId()}/delete");
        $form = $crawler->filter('button')->form();
        $crawler = $client->submit($form);

        $this->assertCount(
            0, $this->getEm()->getRepository('AppBundle:Pad')->findAll()
        );
    }

    public function testDeletePadErrorAnotherUser()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);
        $pad = $this->_createPad('test pad', $user);

        $anotherUser = $this->_createUser('test2@example.com', $password);
        $client = $this->_signIn($anotherUser);
        $crawler = $client->request('GET', "/pads/{$pad->getId()}/delete");
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function testViewPadNotesSuccess()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);
        $pad = $this->_createPad('test pad', $user);

        $client = $this->_signIn($user);
        $client->followRedirects();
        $crawler = $client->request('GET', "/pads/{$pad->getId()}/notes");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}


