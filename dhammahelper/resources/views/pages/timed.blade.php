@extends('layouts.meditation')

@section('content')

    {!! Form::open(['action' => 'MeditationController@timed', 'method' => 'POST', 'id' => 'timed-form']) !!}
        <div class="form-group text-center">
            <div style="display:flex;flex-direction:row;align-items:baseline;justify-content:center"><p>I would like to meditate for</p><div class="number-input">{{Form::number('minutes', isset($minutes) ? $minutes : '20', ['type' => 'number', 'id' => 'minutes', 'class' => 'form-control'])}}</div><p>minute(s).</p></div>
            {{Form::submit('Begin', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}

@endsection