<?php

namespace Notejam\Presenters;

use Doctrine\ORM\EntityManager;
use Nette;
use Notejam\Components\IConfirmationControlFactory;
use Notejam\Components\INoteControlFactory;
use Notejam\Notes\Note;
use Notejam\Notes\NoteRepository;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;



/**
 * Thanks to the User annotation, if you try to access this presenter when you're not logged in, you'll be redirected to login form page.
 *
 * @User()
 */
class NotePresenter extends BasePresenter
{

	/**
	 * @inject
	 * @var NoteRepository
	 */
	public $noteRepository;

	/**
	 * @inject
	 * @var PadRepository
	 */
	public $padRepository;

	/**
	 * @inject
	 * @var INoteControlFactory
	 */
	public $noteControlFactory;

	/**
	 * @inject
	 * @var IConfirmationControlFactory
	 */
	public $confirmationControlFactory;

	/**
	 * @inject
	 * @var EntityManager
	 */
	public $em;

	/**
	 * @var Note
	 */
	private $note;

	/**
	 * @var Pad
	 */
	private $pad;



	/**
	 * This method is called on the presenter lifecycle begin,
	 * so we can put here code that would be duplicated among the action methods.
	 *
	 * Also, this is a good place to add some common checks that apply to all presenter actions.
	 */
	protected function startup()
	{
		parent::startup();

		// so we don't have to repeat the code in every action
		if ($id = $this->getParameter('id')) {
			$this->note = $this->noteRepository->findOneBy([
				'id' => $id,
				'user' => $this->user->getId()
			]);

			if (!$this->note) {
				$this->error();
			}
		}

		if ($padId = $this->getParameter('pad')) {
			$this->pad = $this->padRepository->findOneBy([
				'id' => $padId,
				'user' => $this->user->getId()
			]);

			if (!$this->pad) {
				$this->error();
			}
		}
	}



	/**
	 * This method is called before the render method.
	 * It is a good place to add code that would be duplicated in all render methods.
	 */
	protected function beforeRender()
	{
		parent::beforeRender();

		// so we don't have to repeat the code in every render method
		$this->template->note = $this->note;
	}



	/**
	 * Prepares template variables for the default action.
	 *
	 * @param string $order
	 */
	public function renderDefault($order = 'name')
	{
		$this->template->notes = $this->noteRepository->findBy(
			[
				'user' => $this->getUser()->getId()
			],
			$this->noteRepository->buildOrderBy($order)
		);
	}



	/**
	 * Since the note is required for the detail,
	 * if it haven't been found, the presenter should end with 404 error.
	 */
	public function actionDetail($id)
	{
		if (!$this->note) {
			$this->error();
		}
	}



	/**
	 * Since the note is required for the edit,
	 * if it haven't been found, the presenter should end with 404 error.
	 */
	public function actionEdit($id)
	{
		if (!$this->note) {
			$this->error();
		}
	}



	/**
	 * Since the note is required for the delete,
	 * if it haven't been found, the presenter should end with 404 error.
	 */
	public function actionDelete($id)
	{
		if (!$this->note) {
			$this->error();
		}
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * This factory creates a ConfirmationControl,
	 * that calls the onConfirm event if user clicks on the button.
	 *
	 * @return \Notejam\Components\ConfirmationControl
	 */
	protected function createComponentDeleteNote()
	{
		if ($this->action !== 'delete') {
			$this->error();
		}

		$control = $this->confirmationControlFactory->create();
		$control->onConfirm[] = function () {
			$this->em->remove($this->note);
			$this->em->flush();
			$this->flashMessage('The note has been deleted', 'success');
			$this->redirect('Note:');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * This factory creates a NoteControl that handles creation of new notes.
	 *
	 * @return \Notejam\Components\NoteControl
	 * @throws Nette\Application\BadRequestException
	 */
	protected function createComponentCreateNote()
	{
		if ($this->action !== 'create') {
			$this->error();
		}

		$control = $this->noteControlFactory->create();
		$control->setPad($this->pad);
		$control->onSuccess[] = function () {
			$this->flashMessage('Note was successfully created', 'success');
			$this->redirect('Note:');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * This factory creates a NoteControl that handles edit of existing notes.
	 *
	 * @return \Notejam\Components\NoteControl
	 * @throws Nette\Application\BadRequestException
	 */
	protected function createComponentEditNote()
	{
		if ($this->action !== 'edit' || !$this->note) {
			$this->error();
		}

		$control = $this->noteControlFactory->create();
		$control->setNote($this->note);
		$control->onSuccess[] = function () {
			$this->flashMessage('Note was successfully edited', 'success');
			$this->redirect('Note:');
		};

		return $control;
	}

}
