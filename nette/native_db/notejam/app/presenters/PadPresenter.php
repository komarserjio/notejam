<?php

namespace App\Presenters;

use App\Components\Notes\INotesFactory;
use App\Forms\Pad\DeletePadFormFactory;
use App\Forms\Pad\NewPadFormFactory;
use App\Helpers\OrderHelper;
use App\Model\NoteManager;
use App\Model\PadManager;
use App\Forms\Pad\EditPadFormFactory;
use Nette\Application\BadRequestException;
use Nette\Database\Table\Selection;


class PadPresenter extends SecuredBasePresenter
{

	/** @var PadManager @inject */
	public $padManager;

	/** @var NoteManager @inject */
	public $noteManager;

	/** @var EditPadFormFactory @inject */
	public $editPadFormFactory;

	/** @var DeletePadFormFactory @inject */
	public $deletePadFormFactory;

	/** @var NewPadFormFactory @inject */
	public $newPadFormFactory;

	/** @var INotesFactory @inject */
	public $notesFactory;

	/** @var int @persistent */
	public $id;

	/** @var object */
	private $pad;

	/** @var Selection */
	private $notes;

	/**
	 * Creates EditPadForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentEditPadForm()
	{
		$form = $this->editPadFormFactory->create($this->id, $this->pad->name);
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Pad successfully updated', 'success');
			$this->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * Creates DeletePadForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentDeletePadForm()
	{
		$form = $this->deletePadFormFactory->create($this->id);
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Pad successfully deleted', 'success');
			$this->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * Creates NewPadForm component.
	 * Called automagically by the framework.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentNewPadForm()
	{
		$form = $this->newPadFormFactory->create();
		$form->onError[] = function ($form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function () {
			$this->flashMessage('Pad successfully created', 'success');
			$this->redirect('Homepage:');
		};
		return $form;
	}

	/**
	 * Creates Notes component.
	 * Called automagically by the framework.
	 * @return \App\Components\Notes\Notes
	 */
	protected function createComponentNotes()
	{
		return $this->notesFactory->create($this->notes, $this->pad);
	}

	/**
	 * Pad:default.
	 * @param int         $id
	 * @param string|null $order
	 * @throws BadRequestException
	 */
	public function actionDefault($id, $order)
	{
		$this->loadPad($id);
		$this->notes = $this->noteManager->findByPad($id);
		if ($order) {
			$this->notes->order(OrderHelper::translateParameterToColumns($order));
		}
	}

	/**
	 * Pad:default render.
	 */
	public function renderDefault()
	{
		$this->template->pad = $this->pad;
	}

	/**
	 * Pad:edit.
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionEdit($id)
	{
		$this->loadPad($id);
	}

	/**
	 * Pad:edit render.
	 */
	public function renderEdit()
	{
		$this->template->pad = $this->pad;
	}

	/**
	 * Pad:delete.
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionDelete($id)
	{
		$this->loadPad($id);
	}

	/**
	 * Pad:delete render.
	 */
	public function renderDelete()
	{
		$this->template->pad = $this->pad;
	}

	/**
	 * Loads pad with given id and if not found, throws BadRequestException.
	 * @param int $id
	 * @throws BadRequestException
	 */
	private function loadPad($id)
	{
		$this->id = $id;
		$this->pad = $this->padManager->find($this->id);
		if (!$this->pad) {
			throw new BadRequestException("Pad with given id not found");
		}
	}

}
