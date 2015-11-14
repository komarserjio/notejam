<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\InvalidPasswordException;
use Notejam\UI\FormFactory;
use Notejam\Users\User;



class SettingsControl extends Nette\Application\UI\Control
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
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(Nette\Security\User $user, EntityManager $em, FormFactory $formFactory)
	{
		parent::__construct();
		$this->user = $user;
		$this->em = $em;
		$this->formFactory = $formFactory;
	}



	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addPassword('current', 'Current password')
			->setRequired()
			->addRule($form::REQUIRED);
		$form->addPassword('password', 'New password')
			->setRequired()
			->addRule($form::REQUIRED);
		$form->addPassword('confirm', 'Confirm')
			->addRule(Form::EQUAL, 'New passwords must match', $form['password']);

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	public function formSucceeded(Form $form, $values)
	{
		/** @var User $user */
		$user = $this->user->getIdentity();

		try {
			$user->changePassword($values->current, $values->password);
			$this->em->flush();
			$this->onSuccess($this);

		} catch (InvalidPasswordException $e) {
			$form['current']->addError('Invalid password');
		}
	}

}



interface ISettingsControlFactory
{

	/**
	 * @return SettingsControl
	 */
	public function create();
}
