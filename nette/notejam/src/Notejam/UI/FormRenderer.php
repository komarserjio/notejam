<?php

namespace Notejam\UI;

use Nette\Forms\Rendering\DefaultFormRenderer;



/**
 * The DefaultFormRenderer knows how to render the entire form instance into HTML.
 * But the notejam app has different element structure, so this child overrides it.
 */
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
