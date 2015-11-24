<?php

namespace Notejam\Components;

use Kdyby;
use Nette;
use Nette\Application\UI\Form;
use Notejam\UI\FormFactory;



/**
 * Component that wraps an universal confirmation form.
 *
 * @method onConfirm(ConfirmationControl $self) Magic method that is used to invoke the onSuccess event.
 */
class ConfirmationControl extends Nette\Application\UI\Control
{

    /**
     * @var array
     */
    public $onConfirm = [];

    /**
     * @var FormFactory
     */
    private $formFactory;



    public function __construct(FormFactory $formFactory)
    {
        parent::__construct();
        $this->formFactory = $formFactory;
    }



    /**
     * @return Form
     */
    protected function createComponentForm()
    {
        $form = $this->formFactory->create();

        $form->addProtection();
        $form->addSubmit('confirm', 'Confirm');
        $form->onSuccess[] = function (Form $form) {
            $this->onConfirm($this);
        };

        return $form;
    }


}



/**
 * @see \Notejam\Components\PadsList\IPadsListControlFactory
 */
interface IConfirmationControlFactory
{

    /**
     * @return ConfirmationControl
     */
    public function create();
}
