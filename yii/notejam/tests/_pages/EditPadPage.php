<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class EditPadPage extends SignedInPage
{
    public $route = 'pad/edit';

    /**
     * @param string $name
     */
    public function edit($name)
    {
        $this->guy->fillField('input[name="Pad[name]"]', $name);
        $this->guy->click('button[type=submit]');
    }
}



