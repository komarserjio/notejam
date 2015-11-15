<?php


namespace App\Presenters;

use Nette;
use App\Forms\Account\AccountSettingsFormFactory;


class AccountPresenter extends BasePresenter
{

	/** @var AccountSettingsFormFactory @inject */
	public $formFactory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentAccountSettingsForm()
	{
		$form = $this->formFactory->create();
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Password is successfully changed', 'success');
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}

}
