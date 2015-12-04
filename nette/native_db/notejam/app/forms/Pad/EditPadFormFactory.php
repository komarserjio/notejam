<?php

namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;


class EditPadFormFactory extends Nette\Object
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
	 * Creates an EditPadForm.
	 * @param int    $id   Id of the pad to be edited.
	 * @param string $name Current name of the pad.
	 * @return Form
	 */
	public function create($id, $name)
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setDefaultValue($name)
			->setRequired('%label is required');

		$form->addSubmit('submit', 'Save');

		$form->onSuccess[] = function (Form $form, $values) use ($id) {
			if (!$this->padManager->update($id, $values->name)) {
				$form->addError("Failed to edit pad");
			}
		};

		return $form;
	}

}
