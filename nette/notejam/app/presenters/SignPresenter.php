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
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Email with new password sent', 'success');
			$form->getPresenter()->redirect('this');
		};
		return $form;
	}


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->restoreRequest($this->backlink);
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->signUpFormFactory->create();
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('User is successfully created. Now you can sign in.', 'success');
			$form->getPresenter()->redirect('Sign:in');
		};
		return $form;
	}


	public function actionIn()
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect('Homepage:');
		}
	}

	public function actionUp()
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect('Homepage:');
		}
	}

	public function actionOut()
	{
		$this->getUser()->logout(true);
		$this->flashMessage('You have been signed out.', 'info');
		$this->redirect('in');
	}

}
