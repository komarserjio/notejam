<?php
namespace Notejam\NoteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Notejam\UserBundle\Entity\User;
use Notejam\NoteBundle\Entity\Pad;

class PadControllerTest extends WebTestCase
{
    public function setUp() 
    {
        $this->loadFixtures(array());
        // init kernel to init entity manager
        static::$kernel = static::createKernel(array('environment' => 'test'));
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager() ;
    }
    
    private function _createUser($email, $password) {
        $user = new User();

        $encoder = static::$kernel->getContainer()
            ->get('security.encoder_factory')
            ->getEncoder($user);

        $password = $encoder->encodePassword($password, $user->getSalt());
        $user->setEmail($email)
             ->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    private function _createPad($name, $user) {
        $pad = new Pad();
        $pad->setName($name);
        $pad->setUser($user);

        $this->em->persist($pad);
        $this->em->flush();

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
            1, $this->em->getRepository('NotejamNoteBundle:Pad')->findAll()
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
    }

    public function testEditPadErrorRequiredFields() 
    {
    }

    public function testDeletePadSuccess()
    {
    }

    public function testDeletePadErrorAnotherUser()
    {
    }

    public function testViewPadNotesSuccess()
    {
        $email = 'test@example.com';
        $password = '123123';
        $user = $this->_createUser($email, $password);

        $pad = $this->_createPad('test pad', $user);
        $client = $this->_signIn($user);
        $client->followRedirects();
        $crawler = $client->request('GET', "/pads/{$pad->getId()}");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}


