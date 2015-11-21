<?php

namespace Notejam\Components\PadsList;

use Nette;
use Notejam\Pads\PadRepository;



/**
 * Component that renders side panel with pads list.
 */
class PadsListControl extends Nette\Application\UI\Control
{

	/**
	 * @var PadRepository
	 */
	private $padRepository;

	/**
	 * @var Nette\Security\User
	 */
	private $user;



	public function __construct(PadRepository $padRepository, Nette\Security\User $user)
	{
		parent::__construct();
		$this->padRepository = $padRepository;
		$this->user = $user;
	}



	public function render()
	{
		$this->template->pads = $this->padRepository->findBy(['user' => $this->user->getId()]);
		$this->template->render(__DIR__ . '/default.latte');
	}

}



/**
 * Interface for automatically generated factory (handled by Nette/DI),
 * that is used for creating new instance of the PadsListControl.
 *
 * This probably should be in a separated file, but this is more convenient.
 */
interface IPadsListControlFactory
{

	/**
	 * @return PadsListControl
	 */
	public function create();
}
