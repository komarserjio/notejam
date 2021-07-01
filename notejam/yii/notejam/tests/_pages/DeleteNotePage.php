<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class DeleteNotePage extends SignedInPage
{
    public $route = 'note/delete';

    /**
     * @param string $name
     */
    public function delete()
    {
        $this->guy->click('button[type=submit]');
    }
}





