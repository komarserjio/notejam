@extends('user')

@section('page_title')
Delete pad {{ $pad->name }}
@stop

@section('content')
    {{ Form::open() }}
    <p>Are you sure you want to delete {{ $pad->name }}?</p>
    {{ Form::submit('Yes, I want to delete this pad', array('class' => 'button red')) }}

    {{ Form::close() }}
@stop

