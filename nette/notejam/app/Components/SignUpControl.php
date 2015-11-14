<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;
use Notejam\Users\User;
use Notejam\Users\UserRepository;



class SignUpControl extends Nette\Application\UI\Control
{

	public $onSuccess = [];

	/**
	 * @var Nette\Security\User
	 */
	private $user;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(Nette\Security\User $user, UserRepository $userRepository, EntityManager $em, FormFactory $formFactory)
	{
		parent::__construct();
		$this->user = $user;
		$this->em = $em;
		$this->userRepository = $userRepository;
		$this->formFactory = $formFactory;
	}



	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('email')
			->setRequired()
			->addRule($form::EMAIL);
		$form->addPassword('password')
			->setRequired()
			->addRule($form::REQUIRED);
		$form->addPassword('confirm')
			->addRule(Form::EQUAL, 'New passwords must match', $form['password']);

		$form->addSubmit('send');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		$form->onValidate[] = function (Form $form, $values) {
			if ($this->userRepository->countBy(['email' => $values->email]) > 0) {
				$form->addError('Account with this email already exists');
			}
		};

		return $form;
	}



	public function formSucceeded(Form $form, $values)
	{
		$user = new User($values->email, $values->password);
		$this->em->persist($user);
		$this->em->flush();

		// directly login user on signup
		$this->user->login($user);

		$this->onSuccess($this);
	}

}



interface ISignUpControlFactory
{

	/**
	 * @return SignUpControl
	 */
	public function create();
}
