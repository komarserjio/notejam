<?php

class PadController extends BaseController {

	public function create()
	{
        if (Request::isMethod('post'))
        {
            $validation = Validator::make(
                Input::all(),
                array(
                    'name' => 'required',
                )
            );
            if ($validation->fails())
            {
                return Redirect::route('create_pad')->withErrors($validation);
            }
            $pad = new Pad(array('name' => Input::get('name')));
            Auth::user()->pads()->save($pad);
            return Redirect::route('all_notes')
                ->with('success', 'Pad is created.');
        }
		return View::make('pad/create');
	}

	public function edit()
	{
		return View::make('pad/edit');
	}

	public function view()
	{
		return View::make('pad/view');
	}

	public function delete()
	{
		return View::make('pad/delete');
	}

}

