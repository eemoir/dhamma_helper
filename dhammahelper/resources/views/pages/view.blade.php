@extends('layouts.app')

@section('content')

<strong>{{$data['weekMap'][$data['post']->created_at->addMinutes(-$data['post']->offset)->dayOfWeek]}}, {{$data['post']->created_at->addMinutes(-$data['post']->offset)->format('F d, Y')}} at {{$data['post']->created_at->addMinutes(-$data['post']->offset)->format('H:i')}}</strong>
<p>You meditated for {{$data['post']->minutes}} minute(s).</p>
    @if($data['post']->created_at->addHours(24)->greaterThan(Carbon::now()))
    {!! Form::open(['action' => 'MeditationController@journal', 'method' => 'POST', 'id' => 'journal-form', 'style' => "list-style-type:none"]) !!}
    <div class="form-group">
            {{Form::textarea('entry', $data['post']->entry ?  $data['post']->entry : '', ['id' => 'article-ckeditor'])}}
            @if($data['post']->audio)
            <br/>
            <div id="post-audio" style="display:flex;flex-direction:row;align-items:center">
            <audio src={{$data['post']->audio}} controls id="audio"></audio>
            <button class="btn btn-danger" type="button" id="delete-audio" onclick="deleteAudio()">Delete</button></div>
            <p id="audio-message"></p>
            @endif
            <br/>
            <p>Make a recording:</p>
            <div style="display:'flex';flex-direction:'row'">
            {{ Form::button('Start Recording', ['id' => 'recordButton']) }}
            {{ Form::button('Stop Recording', ['id' => 'stopButton', 'disabled']) }}<div id="recording-message" class="recording-message-invisible"><b>Recording in progress <span class="loading">. </span><span class="loading">. </span><span class="loading">. </span></b></div></div>
            <div id="audio-container"></div>
            {{Form::hidden('user-id', $data['post']->user_id)}}
            {{Form::hidden('post-id', $data['post']->id, ['id' => 'post-id'])}}
            {{Form::hidden('audio', '', ['id' => 'audio-url'])}}
            <br/>
            <div style="display:flex;flex-direction:row;justify-content:flex-end;align-items:center">{{Form::label('share', 'Share this entry with friends', ['style' => 'margin:0'])}}
                {{Form::checkbox('share', 'share', true, ['style' => 'margin:3px'])}}
        {{Form::submit('Submit journal entry', ['class' => 'btn btn-default', 'id' => 'submitButton'])}}</div>
    </div>
    
    <div style="float:right"><button class="btn btn-primary" onclick="goBack()">Back to Log</button></div>
    <br/>
    
{!! Form::close() !!}
    @else
        <div class="entry-text"><p>{!! $data['post']->entry !!}</p></div>
        <div style="display:flex;flex-direction:column">
        @if($data['post']->audio)
            <audio src={{$data['post']->audio}} controls id="audio"></audio>
            @endif
            <div style="align-self:flex-end"><button class="btn btn-primary" onclick="goBack()">Back to Log</button></div>
            <br/>
    @endif
    

@endsection

@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'entry' );
    </script>
    <script src="/js/WebAudioRecorder.js"></script>
    <script src="/js/audioScript.js"></script>
@endsection