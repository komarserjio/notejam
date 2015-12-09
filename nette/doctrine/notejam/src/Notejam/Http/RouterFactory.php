<?php

namespace Notejam\Http;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nextras\Routing\StaticRouter;



class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$router[] = new StaticRouter([
			'User:signUp' => 'signup',
			'User:signIn' => 'signin',
			'User:signOut' => 'signout',
			'User:forgottenPassword' => 'forgot-password',
			'User:settings' => 'settings',
		]);

		$router[] = new Route('pads/<id [0-9]+>[/<action (detail|delete|edit)>]', 'Pad:detail');
		$router[] = new Route('pads[/<action (create)>]', 'Pad:default');

		$router[] = new Route('notes/<id [0-9]+>[/<action (detail|delete|edit)>]', 'Note:detail');
		$router[] = new Route('notes[/<action (create)>]', 'Note:');
		$router[] = new Route('<presenter>[/<action>]', 'Note:default');

		return $router;
	}

}
