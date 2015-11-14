<?php

namespace Notejam\Presenters;

use Nette;
use Nette\Application\UI\PresenterComponentReflection;
use Nextras\Application\UI\SecuredLinksPresenterTrait;
use Notejam\Components\PadsList\IPadsListControlFactory;



abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	use SecuredLinksPresenterTrait;

	/**
	 * @inject
	 * @var IPadsListControlFactory
	 */
	public $padsListControlFactory;



	protected function createComponentPadsList()
	{
		return $this->padsListControlFactory->create();
	}



	/**
	 * @return void
	 */
	public function checkRequirements($element)
	{
		$user = PresenterComponentReflection::parseAnnotation($element, 'User');
		if ($user === FALSE) {
			return; // not protected
		}

		if (!$this->getUser()->isLoggedIn()) {
			$this->forbiddenAccess();
		}
	}



	private function forbiddenAccess()
	{
		$this->redirect('User:signIn');
	}

}
