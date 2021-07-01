<?php

namespace Notejam\Presenters;

use Nette;


/**
 * If only a BadRequestException occurs, you wanna be able to render a nice page that uses your app's layout,
 * but instead of the usual content, you want a clear message about the page not existing, or not being accessible.
 */
class Error4xxPresenter extends Nette\Application\UI\Presenter
{

	/**
	 * Renders a 4xx page for the appropriate BadRequestException.
	 *
	 * @param \Exception $exception
	 */
	public function renderDefault(\Exception $exception)
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}

}
