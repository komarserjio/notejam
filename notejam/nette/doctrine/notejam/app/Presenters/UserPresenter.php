<?php

namespace Notejam\Presenters;

use Nette;
use Notejam\Components\IForgottenPasswordControlFactory;
use Notejam\Components\ISettingsControlFactory;
use Notejam\Components\ISignInControlFactory;
use Notejam\Components\ISignUpControlFactory;



class UserPresenter extends BasePresenter
{

	/**
	 * @inject
	 * @var ISignInControlFactory
	 */
	public $signInFormFactory;

	/**
	 * @inject
	 * @var ISignUpControlFactory
	 */
	public $signUpFormFactory;

	/**
	 * @inject
	 * @var ISettingsControlFactory
	 */
	public $settingsControlFactory;

	/**
	 * @inject
	 * @var IForgottenPasswordControlFactory
	 */
	public $forgottenPasswordControlFactory;



	/**
	 * The action for logout.
	 */
	public function actionSignOut()
	{
		$this->user->logout(TRUE);
		$this->flashMessage("You've been logged out.", 'success');
		$this->redirect('User:signIn');
	}



	/**
	 * This method is here only for the user annotation, that creates a protected section of app.
	 * Meaning that if you try to access this action when you're not logged in, you'll be redirected to login form page.
	 *
	 * @User()
	 */
	public function actionSettings()
	{

	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return \Notejam\Components\SignInControl
	 */
	protected function createComponentSignIn()
	{
		$control = $this->signInFormFactory->create();
		$control->onSuccess[] = function () {
			$this->redirect('Note:');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return \Notejam\Components\SignUpControl
	 */
	protected function createComponentSignUp()
	{
		$control = $this->signUpFormFactory->create();
		$control->onSuccess[] = function () {
			$this->flashMessage('Thank you for registration. Now you can sign in', 'success');
			$this->redirect('User:signIn');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return \Notejam\Components\SettingsControl
	 * @throws Nette\Application\BadRequestException
	 */
	protected function createComponentSettings()
	{
		if ($this->action !== 'settings') {
			$this->error();
		}

		$control = $this->settingsControlFactory->create();
		$control->onSuccess[] = function () {
			$this->flashMessage('The password has been changed', 'success');
			$this->redirect('Note:');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return \Notejam\Components\ForgottenPasswordControl
	 */
	protected function createComponentForgottenPassword()
	{
		$control = $this->forgottenPasswordControlFactory->create();
		$control->onSuccess[] = function () {
			$this->flashMessage('New password sent to your inbox', 'success');
			$this->redirect('User:signIn');
		};

		return $control;
	}

}
