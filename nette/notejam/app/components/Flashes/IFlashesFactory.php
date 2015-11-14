<?php


namespace App\Components\Flashes;


interface IFlashesFactory
{

	/**
	 * @param object[] $flashes
	 * @return Flashes
	 */
	public function create($flashes);

}
