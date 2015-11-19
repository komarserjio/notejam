<?php


namespace App\Forms\Pad;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PadManager;
use Nette\Utils\ArrayHash;


class EditPadFormFactory extends Nette\Object
{

	/** @var PadManager */
	private $padManager;

	/**
	 * EditPadFormFactory constructor.
	 * @param PadManager $padManager
	 */
	public function __construct(PadManager $padManager)
	{
		$this->padManager = $padManager;
	}

	/**
	 * @param int    $id
	 * @param string $name
	 * @return Form
	 */
	public function create($id, $name)
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setDefaultValue($name)
			->setRequired('Name is required');

		$form->addHidden('id', $id);

		$form->addSubmit('submit', 'Save');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		if (!$this->padManager->update($values->id, $values->name)) {
			$form->addError("Failed to edit pad");
		}
	}

}
