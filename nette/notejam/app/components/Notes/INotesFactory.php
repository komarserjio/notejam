<?php


namespace App\Components\Notes;


interface INotesFactory
{

	/**
	 * @param object[] $notes
	 * @return Notes
	 */
	public function create($notes);

}
