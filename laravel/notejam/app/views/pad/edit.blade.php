@extends('user')

@section('page_title')
{{ $pad->name }}
@stop

@section('content')
    {{ Form::open() }}

    {{ Form::label('name', 'Name') . Form::text('name', $pad->name) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::submit('Save') }}
    {{ Form::close() }}
    <a class="red" href="{{ URL::route('delete_pad', array('id' => $pad->id)) }}">Delete pad</a>

@stop
