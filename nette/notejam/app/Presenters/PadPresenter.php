<?php

namespace Notejam\Presenters;

use Doctrine\ORM\EntityManager;
use Nette;
use Notejam\Components\IConfirmationControlFactory;
use Notejam\Components\IPadsControlFactory;
use Notejam\Notes\NoteRepository;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;



/**
 * Thanks to the User annotation, if you try to access this presenter when you're not logged in, you'll be redirected to login form page.
 *
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
	 * @var IConfirmationControlFactory
	 */
	public $confirmationControlFactory;

	/**
	 * @inject
	 * @var EntityManager
	 */
	public $em;

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
			$this->pad = $this->padRepository->findOneBy([
				'id' => $id,
				'user' => $this->user->getId()
			]);
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
		$this->template->pad = $this->pad;
	}



	/**
	 * Since the pad is required for the edit,
	 * if it haven't been found, the presenter should end with 404 error.
	 *
	 * Prepares template variables for the detail action.
	 */
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



	/**
	 * Since the pad is required for the edit,
	 * if it haven't been found, the presenter should end with 404 error.
	 */
	public function actionEdit($id)
	{
		if (!$this->pad) {
			$this->error();
		}
	}



	/**
	 * Since the pad is required for the delete,
	 * if it haven't been found, the presenter should end with 404 error.
	 */
	public function actionDelete($id)
	{
		if (!$this->pad) {
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
	protected function createComponentDeletePad()
	{
		if ($this->action !== 'delete') {
			$this->error();
		}

		$control = $this->confirmationControlFactory->create();
		$control->onConfirm[] = function () {
			$this->em->remove($this->pad);
			$this->em->flush();
			$this->flashMessage('The pad has been deleted', 'success');
			$this->redirect('Note:');
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * This factory creates a PadsControl that handles creation of new pads.
	 *
	 * @return \Notejam\Components\PadsControl
	 * @throws Nette\Application\BadRequestException
	 */
	protected function createComponentCreatePad()
	{
		if ($this->action !== 'create') {
			$this->error();
		}

		$control = $this->padsControlFactory->create();
		$control->onSuccess[] = function ($control, Pad $createdPad) {
			$this->flashMessage('New pad has been created', 'success');
			$this->redirect('Pad:detail', ['id' => $createdPad->getId()]);
		};

		return $control;
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * This factory creates a PadsControl that handles edit of existing pads.
	 *
	 * @return \Notejam\Components\PadsControl
	 * @throws Nette\Application\BadRequestException
	 */
	protected function createComponentEditPad()
	{
		if ($this->action !== 'edit' || !$this->pad) {
			$this->error();
		}

		$control = $this->padsControlFactory->create();
		$control->setPad($this->pad);
		$control->onSuccess[] = function () {
			$this->flashMessage('Pad has been edited', 'success');
			$this->redirect('Pad:detail', ['id' => $this->pad->getId()]);
		};

		return $control;
	}

}
