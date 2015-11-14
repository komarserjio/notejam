<?php


namespace App\Components\Notes;


use Nette;


class Notes extends Nette\Application\UI\Control
{

	/** @var object[] */
	private $notes;

	/**
	 * Pads constructor.
	 * @param object[] $notes
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

}
