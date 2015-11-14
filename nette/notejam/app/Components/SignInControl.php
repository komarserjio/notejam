<?php

namespace Notejam\Components;

use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;



class SignInControl extends Nette\Application\UI\Control
{

	public $onSuccess = [];

	/**
	 * @var Nette\Security\User
	 */
	private $user;

	/**
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(Nette\Security\User $user, FormFactory $formFactory)
	{
		parent::__construct();
		$this->user = $user;
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

		$form->addSubmit('send');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	public function formSucceeded(Form $form, $values)
	{
		try {
			$this->user->login($values->email, $values->password);
			$this->onSuccess($this);

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

}



interface ISignInControlFactory
{

	/**
	 * @return SignInControl
	 */
	public function create();
}
