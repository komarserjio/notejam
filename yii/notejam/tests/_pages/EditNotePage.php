<?php
namespace tests\_pages;

use yii\codeception\BasePage;

class EditNotePage extends SignedInPage
{
    public $route = 'note/edit';

    /**
     * @param string $name
     * @param string $text
     */
    public function edit($name, $text)
    {
        $this->guy->fillField('input[name="Note[name]"]', $name);
        $this->guy->fillField('textarea[name="Note[text]"]', $text);
        $this->guy->click('button[type=submit]');
    }
}




