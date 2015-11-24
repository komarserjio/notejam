<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;
use Notejam\Users\User;
use Notejam\Users\UserRepository;



/**
 * Component that handles registration.
 *
 * @method onSuccess(SignUpControl $self) Magic method that is used to invoke the onSuccess event.
 */
class SignUpControl extends Nette\Application\UI\Control
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
		$form->addPassword('confirm', 'Confirm')
			->setRequired('%label is required')
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



	/**
	 * Callback method, that is called once form is successfully submitted, without validation errors.
	 *
	 * @param Form $form
	 * @param Nette\Utils\ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		$user = new User($values->email, $values->password);
		$this->em->persist($user);
		$this->em->flush();

		// directly login user on signup
		// $this->user->login($user);

		$this->onSuccess($this);
	}

}



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface ISignUpControlFactory
{

	/**
	 * @return SignUpControl
	 */
	public function create();
}
