<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\InvalidPasswordException;
use Notejam\UI\FormFactory;
use Notejam\Users\User;



/**
 * Component that handles changing the settings of the user.
 * Currently only change of password is allowed.
 *
 * @method onSuccess(SettingsControl $self) Magic method that is used to invoke the onSuccess event.
 */
class SettingsControl extends Nette\Application\UI\Control
{

	/**
	 * @var array|callable[]
	 */
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



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addPassword('current', 'Current password')
			->setRequired('%label is required');
		$form->addPassword('password', 'New password')
			->setRequired('%label is required');
		$form->addPassword('confirm', 'Confirm')
			->setRequired('%label is required')
			->addRule(Form::EQUAL, 'New passwords must match', $form['password']);

		$form->addSubmit('save', 'Change password');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	/**
	 * Callback method, that is called once form is successfully submitted, without validation errors.
	 *
	 * @param Form $form
	 * @param Nette\Utils\ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		/** @var User $user */
		$user = $this->user->getIdentity();

		try {
			$user->changePassword($values->current, $values->password);
			$this->em->flush();
			$this->onSuccess($this);

		} catch (InvalidPasswordException $e) {
			$form['current']->addError('Invalid current password');
		}
	}

}



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface ISettingsControlFactory
{

	/**
	 * @return SettingsControl
	 */
	public function create();
}
