<?php

namespace Notejam\Components\PadsList;

use Nette;
use Notejam\Pads\PadRepository;



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



interface IPadsListControlFactory
{

	/**
	 * @return PadsListControl
	 */
	public function create();
}
