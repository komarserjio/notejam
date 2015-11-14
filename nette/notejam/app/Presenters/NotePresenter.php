<?php

namespace Notejam\Presenters;

use Doctrine\ORM\EntityManager;
use Nette;
use Notejam\Components\INoteControlFactory;
use Notejam\Notes\Note;
use Notejam\Notes\NoteRepository;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;



/**
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



	protected function beforeRender()
	{
		parent::beforeRender();

		// so we don't have to repeat the code in every render method
		$this->template->note = $this->note;
	}



	public function renderDefault($order = 'name')
	{
		$this->template->notes = $this->noteRepository->findBy(
			[
				'user' => $this->getUser()->getId()
			],
			$this->noteRepository->buildOrderBy($order)
		);
	}



	public function actionDetail($id)
	{
		if (!$this->note) {
			$this->error();
		}
	}



	public function actionEdit($id)
	{
		if (!$this->note) {
			$this->error();
		}
	}



	/**
	 * @secured
	 */
	public function handleDelete($id)
	{
		if (!$this->note) {
			$this->error();
		}

		$this->em->remove($this->note);
		$this->em->flush();
		$this->redirect('Note:');
	}



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
