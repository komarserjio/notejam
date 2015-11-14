<?php

namespace Notejam\UI;

use Nette\Forms\Rendering\DefaultFormRenderer;



class FormRenderer extends DefaultFormRenderer
{

	public function __construct()
	{
		$this->wrappers['error']['container'] = 'ul class=errorlist';
		$this->wrappers['control']['errorcontainer'] = 'ul class=errorlist';
		$this->wrappers['control']['erroritem'] = 'li';

		// remove rendering in table
		$this->wrappers['controls']['container'] = NULL;
		$this->wrappers['pair']['container'] = NULL;
		$this->wrappers['control']['container'] = NULL;
		$this->wrappers['label']['container'] = NULL;
	}

}
