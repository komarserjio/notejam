<?php

namespace App\Forms\Account;

use App\Model\CurrentPasswordMismatch;
use App\Model\UserManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;


class AccountSettingsFormFactory extends Nette\Object
{

	/** @var UserManager */
	private $userManager;

	/** @var Nette\Security\User */
	private $user;

	/**
	 * AccountSettingsFormFactory constructor.
	 * @param UserManager         $userManager
	 * @param Nette\Security\User $user
	 */
	public function __construct(UserManager $userManager, Nette\Security\User $user)
	{
		$this->userManager = $userManager;
		$this->user = $user;
	}

	/**
	 * Creates Account Settings Form.
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addPassword('current', 'Current password')
			->setRequired('%label is required');

		$form->addPassword('new', 'New Password')
			->setRequired('%label is required');

		$form->addPassword('confirm', 'Confirm New Password')
			->setRequired('New password is required')
			->addRule(Form::EQUAL, 'New passwords must match', $form['new']);

		$form->addSubmit('submit', 'Change Password');

		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}

	/**
	 * Callback for Account Settings Form onSuccess event.
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->userManager->checkPassword($this->user->getId(), $values->current)) {
			$form->addError("Invalid current password");
		}
		$this->userManager->setNewPassword($this->user->getId(), $values->new);
	}

}
