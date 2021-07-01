<?php
namespace tests\_pages;

class CreatePadPage extends SignedInPage
{
    public $route = 'pad/create';

    /**
     * @param string $name
     */
    public function create($name)
    {
        $this->guy->fillField('input[name="Pad[name]"]', $name);
        $this->guy->click('button[type=submit]');
    }
}

