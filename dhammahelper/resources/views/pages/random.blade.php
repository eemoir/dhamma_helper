@extends('layouts.meditation')

@section('content')

    {!! Form::open(['action' => 'MeditationController@random', 'method' => 'POST', 'id' => 'random-form']) !!}
        <div class="form-group text-center">
                <div style="display:flex;flex-wrap:wrap;flex-direction:row;align-items:baseline;justify-content:center"><p>I would like to meditate for a time between</p><div class="number-input">{{Form::number('lower', isset($data) ? $data['lower'] : '15', ['type' => 'number', 'id' => 'lower', 'class' => 'form-control'])}}</div><p>and</p><div class="number-input">{{Form::number('upper', isset($data) ? $data['upper'] : '30', ['type' => 'number', 'id' => 'upper', 'class' => 'form-control'])}}</div><p>minutes.</p></div>
            {{Form::submit('Begin', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}

@endsection