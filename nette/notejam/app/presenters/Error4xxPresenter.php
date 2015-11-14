<?php

namespace Notejam\Presenters;

use Nette;


class Error4xxPresenter extends Nette\Application\UI\Presenter
{

	public function renderDefault(\Exception $exception)
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}

}
