<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\Pads\Pad;
use Notejam\UI\FormFactory;



class PadsControl extends Nette\Application\UI\Control
{

	public $onSuccess = [];

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @var Nette\Security\User
	 */
	private $user;

	/**
	 * @var Pad
	 */
	private $pad;

	/**
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(EntityManager $em, Nette\Security\User $user, FormFactory $formFactory)
	{
		parent::__construct();
		$this->em = $em;
		$this->user = $user;
		$this->formFactory = $formFactory;
	}



	/**
	 * @param Pad $pad
	 */
	public function setPad(Pad $pad)
	{
		$this->pad = $pad;
		$this['form']->setDefaults([
			'name' => $pad->getName(),
		]);
	}



	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('name');

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	public function formSucceeded(Form $form, $values)
	{
		if ($this->pad === NULL) {
			$this->em->persist($pad = new Pad($this->user->getIdentity()));

		} else {
			$pad = $this->pad;
		}

		$pad->setName($values->name);
		$this->em->flush($pad);

		$this->onSuccess($this, $pad);
	}

}



interface IPadsControlFactory
{

	/**
	 * @return PadsControl
	 */
	function create();
}
