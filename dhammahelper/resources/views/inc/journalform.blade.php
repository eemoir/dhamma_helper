{!! Form::open(['action' => 'MeditationController@journal', 'method' => 'POST', 'hidden', 'id' => 'journal-form', 'style' => "list-style-type:none"]) !!}
        <div class="form-group">
                {{Form::textarea('entry', '', ['id' => 'article-ckeditor'])}}
                <br/>
                <p>Make a recording:</p>
                <div style="display:'flex';flex-direction:'row'">
                    {{ Form::button('Start Recording', ['id' => 'recordButton']) }}
                    {{ Form::button('Stop Recording', ['id' => 'stopButton', 'disabled']) }}<div id="recording-message" class="recording-message-invisible"><b>Recording in progress <span class="loading">. </span><span class="loading">. </span><span class="loading">. </span></b></div></div>
                    <div id="audio-container"></div>
                {{Form::hidden('user-id', "{!! Auth::id() !!}")}}
                {{Form::hidden('post-id', "", ['id' => 'post-id'])}}
                {{Form::hidden('audio', '', ['id' => 'audio-url'])}}
                <br/>
                <div style="display:flex;flex-direction:row;justify-content:flex-end;align-items:center">{{Form::label('share', 'Share this entry with friends', ['style' => 'margin:0'])}}
                {{Form::checkbox('share', 'share', true, ['style' => 'margin:3px'])}}
            {{Form::submit('Submit journal entry', ['class' => 'btn btn-default', 'id' => 'submitButton'])}}</div>
        </div>
        <a href="/home" class="btn btn-primary" style="float:right">Return Home</a>
    {!! Form::close() !!}
    