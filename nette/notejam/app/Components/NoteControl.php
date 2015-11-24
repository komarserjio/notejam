<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\Notes\Note;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;
use Notejam\UI\FormFactory;



/**
 * Component that handles creation of new notes and edit of existing notes.
 *
 * @method onSuccess(NoteControl $self) Magic method that is used to invoke the onSuccess event.
 */
class NoteControl extends Nette\Application\UI\Control
{

	/**
	 * @var array|callable[]
	 */
	public $onSuccess = [];

	/**
	 * @var PadRepository
	 */
	private $padRepository;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @var Note
	 */
	private $note;

	/**
	 * @var Nette\Security\User
	 */
	private $user;

	/**
	 * @var FormFactory
	 */
	private $formFactory;



	public function __construct(PadRepository $padRepository, EntityManager $em, Nette\Security\User $user, FormFactory $formFactory)
	{
		parent::__construct();
		$this->padRepository = $padRepository;
		$this->em = $em;
		$this->user = $user;
		$this->formFactory = $formFactory;
	}



	/**
	 * This setter allows to edit notes instead of only creating them.
	 *
	 * @param Note $note
	 */
	public function setNote(Note $note)
	{
		$this->note = $note;
		$this['form']->setDefaults([
			'name' => $note->getName(),
			'text' => $note->getText(),
			'pad' => $note->getPad() ? $note->getPad()->getId() : NULL,
		]);
	}



	/**
	 * Setter for the default pad, to be pre-selected in the pad select form element.
	 *
	 * @param Pad|null $pad
	 */
	public function setPad(Pad $pad = NULL)
	{
		if ($pad === NULL) {
			return; // ignore
		}

		$this['form']->setDefaults([
			'pad' => $pad->getId(),
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
		$form->addTextArea('text', 'Text')
			->setRequired('%label is required');
		$form->addSelect('pad', 'Pad')
			->setPrompt('----------')
			->setItems($this->padRepository->findPairs('name'));

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
		if ($this->note === NULL) {
			$note = new Note($this->user->getIdentity());
			$this->em->persist($note);

		} else {
			$note = $this->note;
		}

		$note->setName($values->name);
		$note->setText($values->text);

		if ($values->pad === NULL) {
			$note->setPad(NULL);

		} else {
			$note->setPad($this->padRepository->find($values->pad));
		}

		$this->em->flush();

		$this->onSuccess($this);
	}

}



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface INoteControlFactory
{

	/**
	 * @return NoteControl
	 */
	function create();
}
