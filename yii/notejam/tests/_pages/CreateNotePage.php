<?php
namespace tests\_pages;

class CreateNotePage extends SignedInPage
{
    public $route = 'note/create';

    /**
     * @param string $name
     */
    public function create($name, $text)
    {
        $this->guy->fillField('input[name="Note[name]"]', $name);
        $this->guy->fillField('textarea[name="Note[text]"]', $text);
        $this->guy->click('button[type=submit]');
    }
}


