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
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Password is successfully changed', 'success');
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}

}
