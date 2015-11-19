<?php

namespace App\Forms\Note;

use App\Model\NoteManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;


class DeleteNoteFormFactory
{

	/** @var NoteManager */
	private $noteManager;

	/**
	 * EditPadFormFactory constructor.
	 * @param NoteManager $noteManager
	 */
	public function __construct(NoteManager $noteManager)
	{
		$this->noteManager = $noteManager;
	}

	/**
	 * @param int $id
	 * @return Form
	 */
	public function create($id)
	{
		$form = new Form;
		$form->addHidden('id', $id);

		$form->addSubmit('submit', 'Yes, I want to delete this note');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->noteManager->delete($values->id)) {
			$form->addError("Failed to delete note");
		}
	}

}
