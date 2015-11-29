<?php

namespace App\Forms\Note;

use App\Model\NoteManager;
use App\Model\PadManager;
use Nette;
use Nette\Application\UI\Form;


class EditNoteFormFactory extends Nette\Object
{

	/** @var PadManager */
	private $padManager;

	/** @var NoteManager */
	private $noteManager;

	/**
	 * EditPadFormFactory constructor.
	 * @param PadManager  $padManager
	 * @param NoteManager $noteManager
	 */
	public function __construct(PadManager $padManager, NoteManager $noteManager)
	{
		$this->padManager = $padManager;
		$this->noteManager = $noteManager;
	}

	/**
	 * Creates an EditNoteForm.
	 * @param int    $id
	 * @param string $name
	 * @param string $text
	 * @param int    $pad
	 * @return Form
	 */
	public function create($id, $name, $text, $pad)
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setDefaultValue($name)
			->setRequired('%label is required');

		$form->addTextArea('text', 'Text')
			->setDefaultValue($text)
			->setRequired('%label is required');

		$form->addSelect('pad', 'Pad', $this->padManager->findAll()->fetchPairs('id', 'name'))
			->setPrompt('Select pad')
			->setDefaultValue($pad);

		$form->addSubmit('submit', 'Save');

		$form->onSuccess[] = function (Form $form, $values) use ($id) {
			if (!$this->noteManager->update($id, $values->name, $values->text, $values->pad)) {
				$form->addError("Failed to edit pad");
			}
		};

		return $form;
	}

}
