<?php

namespace App\Forms\Sign;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Utils\ArrayHash;


class SignInFormFactory extends Nette\Object
{

	/** @var User */
	private $user;

	/**
	 * SignInFormFactory constructor.
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;

		$form->addText('email', 'Email')
			->setRequired('Email is required');

		$form->addPassword('password', 'Password')
			->setRequired('Password is required');

		$form->addSubmit('submit', 'Sign In');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		try {
			$this->user->login($values->email, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

}
