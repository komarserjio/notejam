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
            return Redirect::route('view_pad', array('id' => $pad->id))
                ->with('success', 'Pad is created.');
        }
		return View::make('pad/create');
	}

	public function edit($id)
	{
        $pad = Auth::user()->pads()->where('id', '=', $id)->firstOrFail();
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
                return Redirect::route('edit_pad', array('id' => $pad->id))
                    ->withErrors($validation);
            }
            $pad->name = Input::get('name');
            $pad->save();
            return Redirect::route('view_pad', array('id' => $pad->id))
                ->with('success', 'Pad is updated.');
        }
		return View::make('pad/edit', array('pad' => $pad));
	}

	public function view($id)
	{
        $pad = Auth::user()->pads()->where('id', '=', $id)->firstOrFail();
        $orderParams = $this->processOrderParam();
        $notes = $pad->notes()->orderBy(
            $orderParams[0], $orderParams[1]
        )->get();
		return View::make('pad/view', array('pad' => $pad, 'notes' => $notes));
	}

	public function delete($id)
	{
        if (Request::isMethod('post'))
        {
            $pad->delete();
            return Redirect::route('all_notes')
                ->with('success', 'Pad is deleted.');
        }
		return View::make('pad/delete', array('pad' => $pad));
	}

}

