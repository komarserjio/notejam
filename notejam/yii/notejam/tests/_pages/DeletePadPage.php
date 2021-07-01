<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class DeletePadPage extends SignedInPage
{
    public $route = 'pad/delete';

    /**
     * @param string $name
     */
    public function delete()
    {
        $this->guy->click('button[type=submit]');
    }
}




