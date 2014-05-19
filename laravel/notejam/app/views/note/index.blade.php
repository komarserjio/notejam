@extends('user')

@section('page_title')
All notes
@stop

@section('content')
    @if (Auth::user()->notes()->count())
        <table class="notes">
            <tr>
                <th class="note">Note <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
                <th>Pad</th>
                <th class="date">Last modified <a href="#" class="sort_arrow" >&uarr;</a><a href="#" class="sort_arrow" >&darr;</a></th>
            </tr>
            @foreach (Auth::user()->notes as $note)
                <tr>
                    <td><a href="{{ URL::route('view_note', array('id' => $note->id)) }}">{{ $note->name }}</a></td>
                    <td class="pad">
                        @if ($note->pad)
                            <a href="#">{{ $note->pad->name }}</a>
                        @else
                            No pad
                        @endif
                    </td>
                    <td class="hidden-text date">Today at 10:51</td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="empty">You don't have notes yet.</p>
    @endif
    <a href="{{ URL::route('create_note') }}" class="button">Create a note</a>
@stop
