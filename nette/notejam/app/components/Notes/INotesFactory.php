<?php

namespace App\Components\Notes;

use Nette\Database\Table\Selection;


interface INotesFactory
{

	/**
	 * @param Selection $notes
	 * @param object    $pad
	 * @return Notes
	 */
	public function create($notes, $pad = null);

}
