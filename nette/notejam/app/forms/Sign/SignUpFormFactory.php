<?php

namespace App\Forms\Sign;

use App\Model\DuplicateNameException;
use App\Model\UserManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;


class SignUpFormFactory extends Nette\Object
{

	/** @var UserManager */
	private $userManager;

	/**
	 * SignUpFormFactory constructor.
	 * @param UserManager $userManager
	 */
	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('email', 'Email')
			->setRequired('Email is required')
			->addRule(Form::EMAIL, 'Invalid email');

		$form->addPassword('password', 'Password')
			->setRequired('Password is required');

		$form->addPassword('confirm', 'Confirm Password')
			->setRequired('Please confirm password')
			->addRule(Form::EQUAL, 'Passwords must match', $form['password']);

		$form->addSubmit('submit', 'Sign Up');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 * @throws \App\Model\DuplicateNameException
	 */
	public function formSucceeded(Form $form, $values)
	{
		try {
			$this->userManager->add($values->email, $values->password);
		} catch (DuplicateNameException $e) {
			$form->addError($e->getMessage());
		}
	}

}
