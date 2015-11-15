<?php

namespace App\Presenters;

use App\Components\Pads\IPadsFactory;
use App\Components\UserBar\IUserBarFactory;
use App\Model\PadManager;
use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var IUserBarFactory @inject */
	public $userBarFactory;

	/** @var IPadsFactory @inject */
	public $padsFactory;

	/** @var PadManager @inject */
	public $padManager;

	/** @var object[] */
	protected $pads;

	/**
	 * @return \App\Components\UserBar\UserBar
	 */
	protected function createComponentUserBar()
	{
		return $this->userBarFactory->create();
	}

	/**
	 * @return \App\Components\Pads\Pads
	 */
	protected function createComponentPads()
	{
		$this->pads = $this->padManager->findAll();
		return $this->padsFactory->create($this->pads);
	}

}
