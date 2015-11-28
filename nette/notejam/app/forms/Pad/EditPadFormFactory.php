<?php

namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;
use Nette\Utils\ArrayHash;


class EditPadFormFactory extends Nette\Object
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
	 * @param int    $id
	 * @param string $name
	 * @return Form
	 */
	public function create($id, $name)
	{
        $this->id = $id;

		$form = new Form;
		$form->addText('name', 'Name')
			->setDefaultValue($name)
			->setRequired('%label is required');

		$form->addSubmit('submit', 'Save');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->padManager->update($this->id, $values->name)) {
			$form->addError("Failed to edit pad");
		}
	}

}
