<?php

namespace App\Components\UserBar;


interface IUserBarFactory
{

	/**
	 * @return UserBar
	 */
	public function create();

}
