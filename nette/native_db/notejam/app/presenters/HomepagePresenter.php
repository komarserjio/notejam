<?php

namespace App\Presenters;

use App\Components\Notes\INotesFactory;
use App\Helpers\OrderHelper;
use App\Model\NoteManager;
use Nette;


class HomepagePresenter extends SecuredBasePresenter
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

	/**
	 * Homepage:default.
	 * @param string $order
	 */
	public function actionDefault($order)
	{
		$this->notes = $this->noteManager->findAll();
		if ($order) {
			$this->notes->order(OrderHelper::translateParameterToColumns($order));
		}
	}

	/**
	 * Homepage:default render.
	 */
	public function renderDefault()
	{
		$this->template->notes = $this->notes;
	}

}
