<?php


namespace App\Presenters;

use App\Forms\Note\DeleteNoteFormFactory;
use App\Forms\Note\EditNoteFormFactory;
use App\Forms\Note\NewNoteFormFactory;
use App\Model\NoteManager;
use App\Model\PadManager;
use Nette;
use App\Model;
use Nette\Application\BadRequestException;


class NotePresenter extends BasePresenter
{

	/** @var PadManager @inject */
	public $padManager;

	/** @var NoteManager @inject */
	public $noteManager;

	/** @var EditNoteFormFactory @inject */
	public $editPadFormFactory;

	/** @var DeleteNoteFormFactory @inject */
	public $deletePadFormFactory;

	/** @var NewNoteFormFactory @inject */
	public $newPadFormFactory;

	/** @var int */
	private $id;

	/** @var int */
	private $padId;

	/** @var object */
	private $note;

	/** @var object[] */
	private $notes;

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentEditNoteForm()
	{
		$form = $this->editPadFormFactory->create($this->id, $this->note->name, $this->note->text, $this->note->pad_id);
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Note successfully updated', 'success');
			$form->getPresenter()->redirect('default', ['id' => $this->id]);
		};
		return $form;
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentDeleteNoteForm()
	{
		$form = $this->deletePadFormFactory->create($this->id);
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Note successfully deleted', 'success');
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentNewNoteForm()
	{
		$form = $this->newPadFormFactory->create($this->padId);
		$form->onSuccess[] = function ($form) {
			$this->flashMessage('Note successfully created', 'success');
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	public function actionDefault($id)
	{
		$this->loadNote($id);
		$this->notes = $this->noteManager->findByPad($id);
	}

	public function renderDefault()
	{
		$this->template->note = $this->note;
	}

	public function actionEdit($id)
	{
		$this->loadNote($id);
	}

	public function renderEdit()
	{
		$this->template->note = $this->note;
	}

	public function actionDelete($id)
	{
		$this->loadNote($id);
	}

	public function renderDelete()
	{
		$this->template->note = $this->note;
	}

	public function actionNew($pad)
	{
		$this->padId = $pad;
	}

	/**
	 * @param int $id
	 * @throws BadRequestException
	 */
	private function loadNote($id)
	{
		$this->id = $id;
		$this->note = $this->noteManager->find($this->id);
		if (!$this->note) {
			throw new BadRequestException("Pad with given id not found");
		}
	}


}
