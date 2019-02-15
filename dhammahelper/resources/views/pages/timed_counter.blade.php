@extends('layouts.meditation')

@section('content')
@csrf
<div id="counter-container" style="text-align:center">
<h1 id="time">{{$minutes}}</h1>
<button class='btn btn-primary' id="pause-resume" onclick="resumeMeditation()">Start</button>
<button class='btn btn-primary' id="finish-button" hidden>Finish Meditation</button>
</div>
@auth
@include('inc.journalform')
@endauth
@endsection
