<?php

class PadController extends BaseController {

    public function create()
    {
        return View::make('pad/create');
    }

    public function store()
    {
        $validation = $this->validator();
        if ($validation->fails())
        {
            return Redirect::route('pads.create')->withErrors($validation);
        }
        $pad = new Pad(array('name' => Input::get('name')));
        Auth::user()->pads()->save($pad);
        return Redirect::route('pads.show', array('id' => $pad->id))
            ->with('success', 'Pad is created.');
    }

    public function edit($id)
    {
        $pad = $this->getPadOrFail($id);
        return View::make('pad/edit', array('pad' => $pad));
    }

    public function update($id)
    {
        $pad = $this->getPadOrFail($id);
        $validation = $this->validator();
        if ($validation->fails())
        {
            return Redirect::route('pads.edit', array('id' => $pad->id))
                ->withErrors($validation);
        }
        $pad->name = Input::get('name');
        $pad->save();
        return Redirect::route('pads.show', array('id' => $pad->id))
            ->with('success', 'Pad is updated.');
    }

    public function show($id)
    {
        $pad = $this->getPadOrFail($id);
        $orderParams = $this->processOrderParam();
        $notes = $pad->notes()->orderBy(
            $orderParams[0], $orderParams[1]
        )->get();
        return View::make(
            'pad/view',
            array('pad' => $pad, 'notes' => $notes)
        );
    }

    public function delete($id)
    {
        $pad = $this->getPadOrFail($id);
        return View::make('pad/delete', array('pad' => $pad));
    }

    public function destroy($id)
    {
        $pad = $this->getPadOrFail($id);
        $pad->delete();
        return Redirect::route('all_notes')
            ->with('success', 'Pad is deleted.');
    }

    private function getPadOrFail($id)
    {
        return Auth::user()->pads()
            ->where('id', '=', $id)->firstOrFail();
    }

    private function validator()
    {
        return Validator::make(
            Input::all(),
            array(
                'name' => 'required',
            )
        );
    }
}

