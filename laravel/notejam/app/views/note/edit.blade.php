@extends('user')

@section('page_title')
{{ $note->name }}
@stop

@section('content')
    {{ Form::open(array("route" => array("notes.update", $note->id), "class" => "note")) }}

    {{ Form::label('name', 'Name') . Form::text('name', $note->name, array('class' => 'thirteen')) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::label('text', 'Text') . Form::textarea('text', $note->text, array('class' => 'thirteen')) }}
    @include('partials.error', array('error' => $errors->first('text')))

    {{ Form::label('pad_id', 'Pad') . Form::select('pad_id', array(0 => '-----------') + Auth::user()->pads()->lists('name', 'id'), $note->pad_id) }}

    {{ Form::submit('Save') }}

    {{ Form::close() }}

@stop




