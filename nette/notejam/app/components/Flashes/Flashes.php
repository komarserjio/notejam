<?php


namespace App\Components\Flashes;

use Nette;


class Flashes extends Nette\Application\UI\Control
{

	/** @var object[] */
	private $flashes;

	/**
	 * Pads constructor.
	 * @param object[] $flashes
	 */
	public function __construct($flashes)
	{
		$this->flashes = $flashes;
	}


	/**
	 * Renders the component.
	 */
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/Flashes.latte');
		$template->flashes = $this->flashes;
		$template->render();
	}


}
