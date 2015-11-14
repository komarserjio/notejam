<?php


namespace App\Presenters;


use App\Model\PadManager;
use App\Forms\EditPadFormFactory;

class PadPresenter extends BasePresenter
{

	/** @var PadManager @inject */
	public $padManager;

	/** @var EditPadFormFactory @inject */
	public $formFactory;


	public function renderDefault($id)
	{
		$this->template->pad = $this->padManager->find($id);
	}


	public function renderEdit($id)
	{
		$this->template->pad = $this->padManager->find($id);
	}


	public function renderDelete($id)
	{

	}

}
