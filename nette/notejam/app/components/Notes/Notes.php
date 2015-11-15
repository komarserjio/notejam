<?php


namespace App\Components\Notes;


use Nette;
use Nette\Database\Table\Selection;


class Notes extends Nette\Application\UI\Control
{

	/** @var Selection */
	private $notes;

	/**
	 * Pads constructor.
	 * @param Selection $notes
	 */
	public function __construct($notes)
	{
		$this->notes = $notes;
	}


	/**
	 * Renders the component.
	 */
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/Notes.latte');
		$template->notes = $this->notes;
		$template->render();
	}

	/**
	 * Handles subreqest for ordering the notes.
	 */
	public function handleOrder($order)
	{
		$this->notes->order($order);
		$this->redrawControl('notes');
	}

}
