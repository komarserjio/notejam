<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    protected function processOrderParam()
    {
        $order = array(
            'name' => array('name', 'ASC'),
            '-name' => array('name', 'DESC'),
            'updated_at' => array('updated_at', 'ASC'),
            '-updated_at' => array('updated_at', 'DESC'),
        );
        return $order[Input::get('order', '-updated_at')];
    }
}
