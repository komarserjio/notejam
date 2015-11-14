<?php

namespace Notejam\Templating;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Notejam\InvalidArgumentException;



class RuntimeFilters
{

	/**
	 * Returns length of given data type.
	 *
	 * @return int
	 */
	public static function length($s)
	{
		if (is_array($s)) {
			return count($s);

		} elseif ($s instanceof \Traversable) {
			return iterator_count($s);
		}

		return strlen(utf8_decode($s)); // fastest way
	}



	/**
	 * @param Nette\Forms\Form|Nette\Forms\Controls\BaseControl $formOrControl
	 * @return Nette\Utils\Html
	 */
	public static function formErrors($formOrControl)
	{
		/** @var DefaultFormRenderer $renderer */
		if ($formOrControl instanceof Nette\Forms\Form) {
			$renderer = $formOrControl->getRenderer();
			return $renderer->render($formOrControl, 'ownErrors');

		} elseif ($formOrControl instanceof Nette\Forms\Controls\BaseControl) {
			$renderer = $formOrControl->getForm()->getRenderer();
			return $renderer->renderErrors($formOrControl);
		}

		throw new InvalidArgumentException;
	}

}
