@extends('user')

@section('page_title')
{{ $note->name }}
@stop

@section('content')
    <p class="hidden-text">Last edited at {{ $note->smartDate() }}</p>
    <div class="note">
        <p>
            {{ $note->text }}
        </p>
    </div>
    <a href="{{ URL::route('notes.edit', array('id' => $note->id))}}" class="button">Edit</a>
    <a href="{{ URL::route('notes.delete', array('id' => $note->id))}}" class="delete-note">Delete it</a>
@stop





