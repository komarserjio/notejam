<?php

class NoteController extends BaseController {

	public function index()
	{
		return View::make('note/index');
	}

	public function create()
	{
        if (Request::isMethod('post'))
        {
            $validation = Validator::make(
                Input::all(),
                array(
                    'name' => 'required',
                    'text' => 'required',
                )
            );
            if ($validation->fails())
            {
                return Redirect::route('create_note')->withErrors($validation);
            }
            $note = new Pad(
                array(
                    'name' => Input::get('name'),
                    'text' => Input::get('text')
                )
            );
            Auth::user()->pads()->save($note);
            return Redirect::route('all_notes')
                ->with('success', 'Note is created.');
        }
		return View::make('pad/create');
	}

}
