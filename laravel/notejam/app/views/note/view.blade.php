@extends('user')

@section('page_title')
View note {{ $note->name }}
@stop

@section('content')
    <p class="hidden-text">Last edited at 10:32</p>
    <div class="note">
        {{ $note->text }}
    </div>
    <a href="{{ URL::route('edit_note', array('id' => $note->id))}}" class="button">Edit</a>
    <a href="{{ URL::route('delete_note', array('id' => $note->id))}}" class="delete-note">Delete it</a>
@stop





