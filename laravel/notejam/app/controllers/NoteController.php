<?php

class NoteController extends BaseController {


	public function index()
	{
        $orderParams = $this->processOrderParam();
        $notes = Auth::user()->notes()->orderBy(
            $orderParams[0], $orderParams[1]
        )->get();
		return View::make('note/index', array('notes' => $notes));
	}

	public function create()
	{
        if (Request::isMethod('post'))
        {
            $validation = $this->validator();
            if ($validation->fails())
            {
                return Redirect::route('create_note')->withErrors($validation);
            }
            $note = new Note(
                array(
                    'name' => Input::get('name'),
                    'text' => Input::get('text')
                )
            );
            $padId = (int)Input::get('pad_id');
            if ($padId) {
                $pad = Auth::user()->pads()
                    ->where('id', $padId)->firstOrFail();
                $note->pad_id = $pad->id;
            }
            Auth::user()->notes()->save($note);
            return Redirect::route('view_note', array('id' => $note->id))
                ->with('success', 'Note is created.');
        }
		return View::make('note/create');
	}

    public function edit($id)
    {
        $note = $this->getNoteOrFail($id);
        if (Request::isMethod('post'))
        {
            $validation = $this->validator();
            if ($validation->fails())
            {
                return Redirect::route('edit_note')->withErrors($validation);
            }
            $note->update(
                array(
                    'name' => Input::get('name'),
                    'text' => Input::get('text')
                )
            );
            $padId = (int)Input::get('pad_id');
            if ($padId) {
                $pad = Auth::user()->pads()
                    ->where('id', $padId)->firstOrFail();
                $note->pad_id = $pad->id;
            } else {
                $note->pad_id = null;
            }
            Auth::user()->notes()->save($note);

            return Redirect::route('view_note', array('id' => $note->id))
                ->with('success', 'Note is updated.');
        }
		return View::make('note/edit', array('note' => $note));
    }

	public function delete($id)
	{
        $note = $this->getNoteOrFail($id);
        if (Request::isMethod('post'))
        {
            $note->delete();
            return Redirect::route('all_notes')
                ->with('success', 'Note is deleted.');
        }
		return View::make('note/delete', array('note' => $note));
	}

    public function view($id)
    {
        $note = $this->getNoteOrFail($id);
		return View::make('note/view', array('note' => $note));
    }

    private function getNoteOrFail($id)
    {
        return Auth::user()->notes()
            ->where('id', '=', $id)->firstOrFail();
    }

    private function validator()
    {
        return Validator::make(
            Input::all(),
            array(
                'name' => 'required',
                'text' => 'required',
            )
        );
    }
}
