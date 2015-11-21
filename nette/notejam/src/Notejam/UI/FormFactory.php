<?php

namespace Notejam\UI;

use Nette;



class FormFactory
{

	/**
	 * Creates an empty form with notejam form renderer.
	 *
	 * @return Nette\Application\UI\Form
	 */
	public function create()
	{
		$form = new Nette\Application\UI\Form();
		$form->setRenderer(new FormRenderer());

		return $form;
	}

}
