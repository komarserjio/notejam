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



	public function actionSignOut()
	{
		$this->user->logout(TRUE);
		$this->flashMessage('You\'ve been logged out.', 'success');
		$this->redirect('User:signIn');
	}



	/**
	 * @User()
	 */
	public function actionSettings()
	{

	}



	protected function createComponentSignIn()
	{
		$control = $this->signInFormFactory->create();
		$control->onSuccess[] = function () {
			$this->redirect('Note:');
		};

		return $control;
	}



	protected function createComponentSignUp()
	{
		$control = $this->signUpFormFactory->create();
		$control->onSuccess[] = function () {
			$this->redirect('Note:');
		};

		return $control;
	}



	protected function createComponentSettings()
	{
		if ($this->action !== 'settings') {
			$this->error();
		}

		$control = $this->settingsControlFactory->create();
		$control->onSuccess[] = function () {
			$this->redirect('Note:');
		};

		return $control;
	}



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
