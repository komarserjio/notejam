@extends('user')

@section('page_title')
{{ $note->name }}
@stop

@section('content')
    {{ Form::open() }}
    <p>Are you sure you want to delete {{ $note->name }}?</p>
    {{ Form::submit('Yes, I want to delete this note', array('class' => 'button red')) }}
    <a href="{{ URL::route('notes.show', array('id' => $note->id))}}">Cancel</a>

    {{ Form::close() }}
@stop


