@extends('layout')

@section('content_class')
thirteen
@stop

@section('pad_menu')
<div class="three columns">
    <h4 id="logo">My pads</h4>
    <nav>
        @if(Auth::user()->pads)
            <ul>
            @foreach(Auth::user()->pads as $pad)
                <li><a href="#">{{ $pad->name; }}</a></li>
            @endforeach
            </ul>
        @else
            <p class="empty">No pads yet</p>
        @endif
        <hr />
        <a href="{{ URL::route('create_pad'); }}">Add pad</a>
    </nav>
</div>
@stop
