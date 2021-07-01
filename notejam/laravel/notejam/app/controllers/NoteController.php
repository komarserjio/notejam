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
        return View::make('note/create');
    }

    public function store()
    {
        $validation = $this->validator();
        if ($validation->fails())
        {
            return Redirect::route('notes.create')->withErrors($validation);
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
        return Redirect::route('notes.show', array('id' => $note->id))
            ->with('success', 'Note is successfully created.');
    }

    public function edit($id)
    {
        $note = $this->getNoteOrFail($id);
        return View::make('note/edit', array('note' => $note));
    }

    public function update($id)
    {
        $note = $this->getNoteOrFail($id);
        $validation = $this->validator();
        if ($validation->fails())
        {
            return Redirect::route('notes.edit')->withErrors($validation);
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

        return Redirect::route('notes.show', array('id' => $note->id))
            ->with('success', 'Note is successfully updated.');
    }

    public function delete($id)
    {
        $note = $this->getNoteOrFail($id);
        return View::make('note/delete', array('note' => $note));
    }

    public function destroy($id)
    {
        $note = $this->getNoteOrFail($id);
        $note->delete();
        return Redirect::route('all_notes')
            ->with('success', 'Note is deleted.');
    }

    public function show($id)
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
