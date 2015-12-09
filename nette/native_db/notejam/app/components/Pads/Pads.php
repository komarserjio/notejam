<?php

namespace App\Components\Pads;

use Nette\Application\UI\Control;


class Pads extends Control
{

	/** @var object[] */
	private $pads;

	/**
	 * Pads constructor.
	 * @param \Nette\ComponentModel\IContainer $pads
	 */
	public function __construct($pads)
	{
		$this->pads = $pads;
	}


	/**
	 * Renders the component.
	 */
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/Pads.latte');
		$template->pads = $this->pads;
		$template->render();
	}

}
