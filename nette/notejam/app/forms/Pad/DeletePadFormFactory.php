<?php

namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;
use Nette\Utils\ArrayHash;


class DeletePadFormFactory extends Nette\Object
{

	/** @var PadManager */
	private $padManager;

	/** @var int */
	private $id;

	/**
	 * EditPadFormFactory constructor.
	 * @param PadManager $padManager
	 */
	public function __construct(PadManager $padManager)
	{
		$this->padManager = $padManager;
	}

	/**
	 * @param int $id
	 * @return Form
	 */
	public function create($id)
	{
		$this->id = $id;

		$form = new Form;
		$form->addProtection(); // Adds CSRF protection

		$form->addSubmit('submit', 'Yes, I want to delete this pad');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->padManager->delete($this->id)) {
			$form->addError("Failed to delete pad");
		}
	}

}
