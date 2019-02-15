@extends('layouts.app')

@section('content')
@auth
<div style="text-align:center"><h1>Notifications</h1></div>
    @if(count($data) > 0)
        @foreach($data as $notification)
            <div class="well" style="border:1px solid black; margin:5px; padding:5px"><small class="timestamp">{{$notification['time']}}</small>
            @if($notification['type'] == 'friend request')
            {!! Form::open(['action' => 'PagesController@resolve', 'method' => 'POST', 'class' => 'friend-request-form']) !!}
                {{Form::hidden('notification_id', $notification['id'])}}
                {{Form::hidden('username', $notification['from'])}}
                <strong>{{$notification['text']}}</strong>
                <div style="display:flex;justify-content:flex-end">
                {{Form::button('Accept', ['name' => 'accept', 'class' => 'accept-button btn btn-default'])}}
                {{Form::button('Decline', ['name' => 'decline', 'class' => 'decline-button btn btn-default', 'style' => 'margin-left:5px'])}}
                </div>
                <p class="error"></p>
            {!! Form::close() !!}
            @elseif($notification['type'] == 'friend request accepted' || $notification['type'] == 'friend request declined')
            {!! Form::open(['action' => 'PagesController@resolve', 'method' => 'POST', 'class' => 'mark-as-resolved']) !!}
                {{Form::hidden('notification_id', $notification['id'])}}
                <strong>{{$notification['text']}}</strong>
                <div style="display:flex;justify-content:flex-end">
                {{Form::button('OK', ['class' => 'mark-button btn btn-default'])}}
                </div>
                <p class="error"></p>
            {!! Form::close() !!}
            @endif</div>
        @endforeach
    @else

    <p>Nothing to see here!</p>

    @endif

@else
<h1>You must register and log in to view your notifications</p>
@endauth
@endsection

@section('scripts')
<script src="/js/notifications.js"></script>
@endsection
