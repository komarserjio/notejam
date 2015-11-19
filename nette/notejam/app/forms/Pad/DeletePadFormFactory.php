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

	/**
	 * EditPadFormFactory constructor.
	 * @param PadManager $padManager
	 */
	public function __construct(PadManager $padManager)
	{
		$this->padManager = $padManager;
	}

	/**
	 * @param $id
	 * @return Form
	 */
	public function create($id)
	{
		$form = new Form;
		$form->addHidden('id', $id);

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
		if (!$this->padManager->delete($values->id)) {
			$form->addError("Failed to delete pad");
		}
	}

}
