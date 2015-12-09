<?php

namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;
use Nette\Utils\ArrayHash;


class NewPadFormFactory extends Nette\Object
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
	 * Creates a NewPadForm.
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setRequired('%label is required');

		$form->addSubmit('submit', 'Save');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * Callback for NewPadForm onSuccess event.
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->padManager->add($values->name)) {
			$form->addError("Failed to create new pad");
		}
	}

}
