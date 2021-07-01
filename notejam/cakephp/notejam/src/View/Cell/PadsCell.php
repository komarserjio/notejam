<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Pads cell
 */
class PadsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $id = $this->request->session()->read('Auth.User.id');
        $user = \Cake\ORM\TableRegistry::get('Users')->get($id, [
            'contain' => ['Pads']
        ]);
        $this->set('pads', $user->pads);
    }
}
