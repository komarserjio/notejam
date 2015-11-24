<?php

namespace Notejam\Components;

use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;



/**
 * Component that handles login.
 *
 * @method onSuccess(SignInControl $self) Magic method that is used to invoke the onSuccess event.
 */
class SignInControl extends Nette\Application\UI\Control
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
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(Nette\Security\User $user, FormFactory $formFactory)
	{
		parent::__construct();
		$this->user = $user;
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

		$form->addText('email', 'Email')
			->setRequired('%label is required')
			->addRule($form::EMAIL);
		$form->addPassword('password', 'Password')
			->setRequired('%label is required');

		$form->addSubmit('send');
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
		try {
			$this->user->login($values->email, $values->password);
			$this->onSuccess($this);

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

}



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface ISignInControlFactory
{

	/**
	 * @return SignInControl
	 */
	public function create();
}
