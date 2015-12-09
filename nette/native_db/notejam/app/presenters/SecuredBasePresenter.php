<?php

namespace App\Presenters;


abstract class SecuredBasePresenter extends BasePresenter
{

	/**
	 * {@inheritdoc}
	 */
	protected function startup()
	{
		parent::startup();
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
		}
	}

}
