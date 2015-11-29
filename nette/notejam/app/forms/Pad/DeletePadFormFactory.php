<?php

namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;


class DeletePadFormFactory extends Nette\Object
{

	/** @var PadManager */
	private $padManager;

	/**
	 * EditPadFormFactory constructor.
	 * @param PadManager $padManager
	 */
	public function __construct(PadManager $padManager)
	{
		$this->padManager = $padManager;
	}

	/**
	 * Creates a DeletePadForm.
	 * @param int $id Id of the pad to be deleted.
	 * @return Form
	 */
	public function create($id)
	{
		$form = new Form;
		$form->addProtection(); // Adds CSRF protection

		$form->addSubmit('submit', 'Yes, I want to delete this pad');

		$form->onSuccess[] = function (Form $form) use ($id) {
			if (!$this->padManager->delete($id)) {
				$form->addError("Failed to delete pad");
			}
		};

		return $form;
	}

}
