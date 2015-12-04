<?php

namespace App\Components\Pads;


interface IPadsFactory
{

	/**
	 * @param object[] $pads
	 * @return Pads
	 */
	public function create($pads);

}
