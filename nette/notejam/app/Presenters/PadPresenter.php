<?php

namespace Notejam\Presenters;

use Doctrine\ORM\EntityManager;
use Nette;
use Notejam\Components\IPadsControlFactory;
use Notejam\Notes\NoteRepository;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;



/**
 * @User()
 */
class PadPresenter extends BasePresenter
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
	 * @var IPadsControlFactory
	 */
	public $padsControlFactory;

	/**
	 * @inject
	 * @var EntityManager
	 */
	public $em;

	/**
	 * @var Pad
	 */
	private $pad;



	protected function startup()
	{
		parent::startup();

		// so we don't have to repeat the code in every action
		if ($id = $this->getParameter('id')) {
			$this->pad = $this->padRepository->findOneBy([
				'id' => $id,
				'user' => $this->user->getId()
			]);
		}
	}



	protected function beforeRender()
	{
		parent::beforeRender();

		// so we don't have to repeat the code in every render method
		$this->template->pad = $this->pad;
	}



	public function actionDetail($id, $order = 'name')
	{
		if (!$this->pad) {
			$this->error();
		}

		$this->template->notes = $this->noteRepository->findBy(
			[
				'user' => $this->getUser()->getId(),
				'pad' => $this->pad->getId()
			],
			$this->noteRepository->buildOrderBy($order)
		);
	}



	public function actionEdit($id)
	{
		if (!$this->pad) {
			$this->error();
		}
	}



	/**
	 * @secured
	 */
	public function handleDelete($id)
	{
		if (!$this->pad) {
			$this->error();
		}

		$this->em->remove($this->pad);
		$this->em->flush();
		$this->redirect('Note:');
	}



	protected function createComponentCreatePad()
	{
		if ($this->action !== 'create') {
			$this->error();
		}

		$control = $this->padsControlFactory->create();
		$control->onSuccess[] = function ($control, Pad $createdPad) {
			$this->redirect('Pad:detail', ['id' => $createdPad->getId()]);
		};

		return $control;
	}



	protected function createComponentEditPad()
	{
		if ($this->action !== 'edit' || !$this->pad) {
			$this->error();
		}

		$control = $this->padsControlFactory->create();
		$control->setPad($this->pad);
		$control->onSuccess[] = function () {
			$this->redirect('Pad:detail', ['id' => $this->pad->getId()]);
		};

		return $control;
	}

}
