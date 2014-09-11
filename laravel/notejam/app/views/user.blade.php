@extends('layout')

@section('content_class')
thirteen
@stop

@section('pads')
    <div class="three columns">
        <h4 id="logo">My pads</h4>
        <nav>
            @if(Auth::user()->pads->count())
                <ul>
                @foreach(Auth::user()->pads as $pad)
                    <li><a href="{{ URL::route('pads.show', array('id' => $pad->id) )}}">{{ $pad->name; }}</a></li>
                @endforeach
                </ul>
            @else
                <p class="empty">No pads</p>
            @endif
            <hr />
            <a href="{{ URL::route('pads.create'); }}">New pad</a>
        </nav>
    </div>
@stop
