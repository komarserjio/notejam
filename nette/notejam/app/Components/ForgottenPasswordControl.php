<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;
use Notejam\Users\UserRepository;



class ForgottenPasswordControl extends Nette\Application\UI\Control
{

	public $onSuccess = [];

	/**
	 * @var FormFactory
	 */
	private $formFactory;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var Nette\Mail\IMailer
	 */
	private $mailer;



	public function __construct(EntityManager $em, UserRepository $userRepository, Nette\Mail\IMailer $mailer, FormFactory $formFactory)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->em = $em;
		$this->userRepository = $userRepository;
		$this->mailer = $mailer;
	}



	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('email', 'Email')
			->setRequired()
			->addRule($form::EMAIL);

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	public function formSucceeded(Form $form, $values)
	{
		if (!$user = $this->userRepository->findOneBy(['email' => $values->email])) {
			$form['email']->addError("User with given email doesn't exist");
			return;
		}

		// this is not a very secure way of getting new password
		// but it's the same way the symfony app is doing it...
		$newPassword = $user->generateRandomPassword();
		$this->em->flush();

		$message = new Nette\Mail\Message();
		$message->setSubject('Notejam password');
		$message->setFrom('noreply@notejamapp.com');
		$message->addTo($user->getEmail());
		$message->setBody("Your new password is {$newPassword}");

		$this->mailer->send($message);

		$this->onSuccess($this);
	}

}



interface IForgottenPasswordControlFactory
{

	/**
	 * @return ForgottenPasswordControl
	 */
	public function create();
}
