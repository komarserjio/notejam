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

}
