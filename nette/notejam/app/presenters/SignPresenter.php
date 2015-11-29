<?php

namespace App\Presenters;

use Nette;
use App\Forms\Sign\ForgottenPasswordFormFactory;
use App\Forms\Sign\SignInFormFactory;
use App\Forms\Sign\SignUpFormFactory;


class SignPresenter extends BasePresenter
{

	/** @var string @persistent */
	public $backlink;

	/** @var ForgottenPasswordFormFactory @inject */
	public $forgottenPasswordFormFactory;

	/** @var SignInFormFactory @inject */
	public $signInFormFactory;

	/** @var SignUpFormFactory @inject */
	public $signUpFormFactory;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentForgottenPasswordForm()
	{
		$form = $this->forgottenPasswordFormFactory->create();
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('New password sent to your inbox', 'success');
			$this->redirect('Sign:in');
		};
		return $form;
	}

	/**
	 * Creates SignInForm component.
	 * Called automagically by the framework.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->restoreRequest($this->backlink);
			$this->redirect('Homepage:');
		};
		return $form;
	}


	/**
	 * Creates SignUpForm component.
	 * Called automagically by the framework.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->signUpFormFactory->create();
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('User is successfully created. Now you can sign in.', 'success');
			$this->redirect('Sign:in');
		};
		return $form;
	}

	/**
	 * Sign:in.
	 */
	public function actionIn()
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect('Homepage:');
		}
	}

	/**
	 * Sign:up.
	 */
	public function actionUp()
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect('Homepage:');
		}
	}

	/**
	 * Sign:out.
	 */
	public function actionOut()
	{
		$this->getUser()->logout(true);
		$this->flashMessage('You have been signed out.', 'info');
		$this->redirect('in');
	}

}
