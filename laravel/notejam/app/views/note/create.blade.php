@extends('user')

@section('page_title')
New note
@stop

@section('content')
    {{ Form::open(array("route" => "notes.store", "class" => "note")) }}

    {{ Form::label('name', 'Name') . Form::text('name', Input::old('name'), array('class' => 'thirteen')) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::label('text', 'Text') . Form::textarea('text', Input::old('text'), array('class' => 'thirteen')) }}
    @include('partials.error', array('error' => $errors->first('text')))

    {{ Form::label('pad_id', 'Pad') . Form::select('pad_id', array(0 => '-----------') + Auth::user()->pads()->lists('name', 'id'), Input::old('pad_id')) }}

    {{ Form::submit('Create') }}

    {{ Form::close() }}

@stop


