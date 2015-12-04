<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{

	use _generated\AcceptanceTesterActions;

	/**
	 * @param string $email
	 * @param string $password
	 */
	public function testLogin($email = 'john.doe@example.com', $password = 'pass')
	{
		$this->amOnPage('/signin');
		$this->see('Sign in');
		$this->fillField("Email", $email);
		$this->fillField("Password", $password);
		$this->click('Sign In');
	}

}
