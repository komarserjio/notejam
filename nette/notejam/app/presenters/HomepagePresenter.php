<?php

namespace App\Presenters;

use App\Components\Notes\INotesFactory;
use App\Model\NoteManager;
use Nette;


class HomepagePresenter extends BasePresenter
{

	/** @var NoteManager @inject */
	public $noteManager;

	/** @var INotesFactory @inject */
	public $notesFactory;

	/** @var object[] */
	protected $notes;

	/**
	 * @return \App\Components\Notes\Notes
	 */
	protected function createComponentNotes()
	{
		return $this->notesFactory->create($this->notes);
	}

	public function actionDefault()
	{
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
		$this->notes = $this->noteManager->findAll();
	}

	public function renderDefault()
	{
		$this->template->notes = $this->notes;
	}

}
