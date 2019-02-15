@extends('layouts.app')

@section('content')
@auth
    
<h1 style="text-align: center">Account Details</h1>

{!! Form::open(['action' => 'PagesController@changeUsername', 'method' => 'POST', 'style' => "margin: 5px", 'id' => 'change-username']) !!}
{{Form::label('username', "Username: ")}}{{Form::text('username', Auth::user()->username, ['style' => 'margin-left:5px'])}}
<button class="btn btn-secondary" type="submit" id="submit" disabled>Change Username</button>{!! Form::close() !!}
<p style="margin:5px;color:red" id="error"></p>
<div style="margin: 5px">First name: {{ Auth::user()->first_name }}</div>
<div style="margin: 5px">Last name: {{ Auth::user()->last_name }}</div>
<div style="margin: 5px">Email address: {{ Auth::user()->email }}</div>

@endauth

@guest
<p>You must register and log in to view your account details.</p>
@endguest
@endsection

@section('scripts')
<script src="/js/details.js"></script>
@endsection