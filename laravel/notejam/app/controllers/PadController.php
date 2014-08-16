<?php

class PadController extends BaseController {

    public function create()
    {
        if (Request::isMethod('post'))
        {
            $validation = $this->validator();
            if ($validation->fails())
            {
                return Redirect::route('create_pad')->withErrors($validation);
            }
            
            $pad = new Pad(array(
                'name' => Input::get('name')
            ));
            Auth::user()->pads()->save($pad);
            
            return Redirect::route('view_pad', array('id' => $pad->id))
                ->with('success', 'Pad is created.');
        }
        return View::make('pad/create');
    }

    public function edit($id)
    {
        $pad = $this->getPadOrFail($id);
        if (Request::isMethod('post'))
        {
            $validation = $this->validator();
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
        $pad = $this->getPadOrFail($id);
        $orderParams = $this->processOrderParam();
        
        $notes = $pad->notes()
            ->orderBy($orderParams[0], $orderParams[1])
            ->get();
        
        return View::make('pad/view', array(
            'pad' => $pad,
            'notes' => $notes
        ));
    }

    public function delete($id)
    {
        $pad = $this->getPadOrFail($id);
        if (Request::isMethod('post'))
        {
            $pad->delete();
            return Redirect::route('all_notes')
                ->with('success', 'Pad is deleted.');
        }
        
        return View::make('pad/delete', array('pad' => $pad));
    }

    private function getPadOrFail($id)
    {
        return Auth::user()->pads()
            ->where('id', '=', $id)
            ->firstOrFail();
    }

    private function validator()
    {
        return Validator::make(Input::all(), array(
            'name' => 'required',
        ));
    }

}

