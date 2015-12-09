<?php

namespace App\Forms\Sign;

use App\Model\UserManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;


class ForgottenPasswordFormFactory extends Nette\Object
{

	/** @var UserManager */
	private $userManager;

	/**
	 * @var Nette\Mail\IMailer
	 */
	private $mailer;

	/**
	 * ForgottenPasswordFormFactory constructor.
	 * @param UserManager        $userManager
	 * @param Nette\Mail\IMailer $mailer
	 */
	public function __construct(UserManager $userManager, Nette\Mail\IMailer $mailer)
	{
		$this->userManager = $userManager;
		$this->mailer = $mailer;
	}

	/**
	 * Creates a ForgottenPasswordForm.
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('email', 'Email')
			->setRequired('%label is required')
			->addRule(Form::EMAIL, 'Invalid %label');

		$form->addSubmit('submit', 'Get new password');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	/**
	 * Callback for ForgottenPasswordForm onSuccess event.
	 * @param Form      $form
	 * @param ArrayHash $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		$user = $this->userManager->findByEmail($values->email);
		if (!$user) {
			$form->addError('No user with given email found');
			return;
		}
		$password = Nette\Utils\Random::generate(10);
		$this->userManager->setNewPassword($user->id, $password);

		try {
			// !!! Never send passwords through email !!!
			// This is only for demonstration purposes of Notejam.
			// Ideally, you can create a unique link where user can change his password
			// himself for limited amount of time, and then send the link.
			$mail = new Nette\Mail\Message();
			$mail->setFrom('noreply@notejamapp.com', 'Notejamapp');
			$mail->addTo($user->email);
			$mail->setSubject('New notejam password');
			$mail->setBody(sprintf('Your new password: %s', $password));
			$this->mailer->send($mail);

		} catch (Nette\Mail\SendException $e) {
			Debugger::log($e, Debugger::EXCEPTION);
			$form->addError('Could not send email with new password');
		}
	}

}
