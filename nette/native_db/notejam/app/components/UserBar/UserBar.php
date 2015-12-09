<?php

namespace App\Components\UserBar;

use Nette;


class UserBar extends Nette\Application\UI\Control
{

	/**
	 * @var Nette\Security\User
	 */
	private $user;

	/**
	 * UserBar constructor.
	 * @param Nette\Security\User $user
	 */
	public function __construct(Nette\Security\User $user)
	{
		$this->user = $user;
	}

	/**
	 * Renders the component.
	 */
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/UserBar.latte');
		$template->render();
	}

}
