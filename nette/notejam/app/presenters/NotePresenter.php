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


class NotePresenter extends SecuredBasePresenter
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

	/** @var int @persistent */
	public $id;

	/** @var int */
	private $padId;

	/** @var object */
	private $note;

	/** @var object[] */
	private $notes;

	/**
	 * Creates EditNoteForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentEditNoteForm()
	{
		$form = $this->editPadFormFactory->create($this->note->id, $this->note->name, $this->note->text, $this->note->pad_id);
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Note successfully updated', 'success');
			$this->redirect('default', ['id' => $this->id]);
		};
		return $form;
	}

	/**
	 * Creates DeleteNoteForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentDeleteNoteForm()
	{
		$form = $this->deletePadFormFactory->create($this->id);
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Note successfully deleted', 'success');
			$this->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * Creates NewNoteForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentNewNoteForm()
	{
		$form = $this->newPadFormFactory->create($this->padId);
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Note successfully created', 'success');
			$this->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * Note:default.
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionDefault($id)
	{
		$this->loadNote($id);
		$this->notes = $this->noteManager->findByPad($id);
	}

	/**
	 * Note:default render.
	 */
	public function renderDefault()
	{
		$this->template->note = $this->note;
	}

	/**
	 * Note:edit.
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionEdit($id)
	{
		$this->loadNote($id);
	}

	/**
	 * Note:edit render.
	 */
	public function renderEdit()
	{
		$this->template->note = $this->note;
	}

	/**
	 * Note:delete.
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionDelete($id)
	{
		$this->loadNote($id);
	}

	/**
	 * Note:delete render.
	 */
	public function renderDelete()
	{
		$this->template->note = $this->note;
	}

	/**
	 * Note:new.
	 * @param int $pad
	 */
	public function actionNew($pad)
	{
		$this->padId = $pad;
	}

	/**
	 * Loads note with given id and if not found, throws BadRequestException.
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
