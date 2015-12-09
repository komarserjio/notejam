<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$router[] = new Route('/signup', 'Sign:up');
		$router[] = new Route('/signin', 'Sign:in');
		$router[] = new Route('/signout', 'Sign:out');
		$router[] = new Route('/forgot-password', 'Sign:forgotten');
		$router[] = new Route('/settings', 'Account:settings');

		$router[] = new Route('/notes/create', 'Note:new');
		$router[] = new Route('/notes/<id>', 'Note:default');
		$router[] = new Route('/notes/<id>/edit', 'Note:edit');
		$router[] = new Route('/notes/<id>/delete', 'Note:delete');

		$router[] = new Route('/pads/create', 'Pad:new');
		$router[] = new Route('/pads/<id>', 'Pad:default');
		$router[] = new Route('/pads/<id>/edit', 'Pad:edit');
		$router[] = new Route('/pads/<id>/delete', 'Pad:delete');

		$router[] = new Route('<presenter>[/<action>]', 'Homepage:default');
		return $router;
	}

}
