<?php

namespace Notejam\UI;

use Nette;



class FormFactory
{

	/**
	 * @return Nette\Application\UI\Form
	 */
	public function create()
	{
		$form = new Nette\Application\UI\Form();
		$form->setRenderer(new FormRenderer());

		return $form;
	}

}
