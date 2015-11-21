<?php

namespace Notejam\Components;

use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\UI\Form;
use Notejam\Notes\Note;
use Notejam\Pads\Pad;
use Notejam\Pads\PadRepository;
use Notejam\UI\FormFactory;



class NoteControl extends Nette\Application\UI\Control
{

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
	 * @param Note $note
	 */
	public function setNote(Note $note)
	{
		$this->note = $note;
		$this['form']->setDefaults([
			'name' => $note->getName(),
			'text' => $note->getText(),
			'pad' => $note->getPad()->getId(),
		]);
	}



	public function setPad(Pad $pad = NULL)
	{
		if ($pad === NULL) {
			return; // ignore
		}

		$this['form']->setDefaults([
			'pad' => $pad->getId(),
		]);
	}



	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('name', 'Name')
			->setRequired();
		$form->addTextArea('text', 'Text')
			->setRequired();
		$form->addSelect('pad', 'Pad')
			->setPrompt('----------')
			->setItems($this->padRepository->findPairs('name'));

		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}



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



interface INoteControlFactory
{

	/**
	 * @return NoteControl
	 */
	function create();
}
