<?php

namespace App\Components\Notes;

use Nette;
use Nette\Database\Table\Selection;


class Notes extends Nette\Application\UI\Control
{

	/** @var Selection */
	private $notes;

	/** @var object */
	private $pad;

	/**
	 * Pads constructor.
	 * @param Selection $notes
	 * @param object    $pad
	 */
	public function __construct($notes, $pad = null)
	{
		$this->notes = $notes;
		$this->pad = $pad;
	}


	/**
	 * Renders the component.
	 */
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/Notes.latte');
		$template->notes = $this->notes;
		$template->pad = $this->pad;
		$template->render();
	}

}
