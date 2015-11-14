<?php

namespace App\Presenters;

use App\Model\NoteManager;
use App\Model\PadManager;
use Nette;


class HomepagePresenter extends BasePresenter
{

	/** @var PadManager @inject */
	public $padManager;

	/** @var NoteManager @inject */
	public $noteManager;

	public function actionDefault()
	{
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}

	public function renderDefault()
	{
		$this->template->pads = $this->padManager->findAll();
		$this->template->notes = $this->noteManager->findAll();
	}

}
