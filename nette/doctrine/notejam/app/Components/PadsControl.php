<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\Pads\Pad;
use Notejam\UI\FormFactory;



/**
 * Component that handles creation of new pads and edit of existing pads.
 *
 * @method onSuccess(PadsControl $self) Magic method that is used to invoke the onSuccess event.
 */
class PadsControl extends Nette\Application\UI\Control
{

	/**
	 * @var array|callable[]
	 */
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
	 * This setter allows to edit pads instead of only creating them.
	 *
	 * @param Pad $pad
	 */
	public function setPad(Pad $pad)
	{
		$this->pad = $pad;
		$this['form']->setDefaults([
			'name' => $pad->getName(),
		]);
	}



	/**
	 * Factory method for subcomponent form instance.
	 * This factory is called internally by Nette in the component model.
	 *
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('name', 'Name')
			->setRequired('%label is required');

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



	/**
	 * Callback method, that is called once form is successfully submitted, without validation errors.
	 *
	 * @param Form $form
	 * @param Nette\Utils\ArrayHash $values
	 */
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



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface IPadsControlFactory
{

	/**
	 * @return PadsControl
	 */
	function create();
}
