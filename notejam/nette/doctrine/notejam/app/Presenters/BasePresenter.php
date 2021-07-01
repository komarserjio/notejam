<?php

namespace Notejam\Presenters;

use Nette;
use Nette\Application\UI\PresenterComponentReflection;
use Notejam\Components\PadsList\IPadsListControlFactory;



/**
 * It's a best practise to avoid sharing code using BasePresenters, but it's very practical.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @inject
	 * @var IPadsListControlFactory
	 */
	public $padsListControlFactory;



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return \Notejam\Components\PadsList\PadsListControl
	 */
	protected function createComponentPadsList()
	{
		return $this->padsListControlFactory->create();
	}



	/**
	 * This allows me to implement a basic access control for presenters.
	 *
	 * This method is called for every presenter run,
	 * once it's created before the presenter startup,
	 * and for every other lifecycle methods, like render, action and signals.
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



	/**
	 * The default behaviour for parts of app, where the user is not allowed for some reason.
	 * This can be overwritten in subclasses to achieve different behaviour.
	 */
	protected function forbiddenAccess()
	{
		$this->redirect('User:signIn');
	}

}
