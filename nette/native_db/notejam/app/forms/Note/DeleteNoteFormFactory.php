<?php

namespace App\Forms\Note;

use App\Model\NoteManager;
use Nette\Application\UI\Form;


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
	 * Creates a DeleteNoteForm.
	 * @param int $id Id of the note to be deleted.
	 * @return Form
	 */
	public function create($id)
	{
		$form = new Form;
		$form->addProtection(); // Adds CSRF protection

		$form->addSubmit('submit', 'Yes, I want to delete this note');

		$form->onSuccess[] = function (Form $form) use ($id) {
			if (!$this->noteManager->delete($id)) {
				$form->addError("Failed to delete note");
			}
		};

		return $form;
	}

}
