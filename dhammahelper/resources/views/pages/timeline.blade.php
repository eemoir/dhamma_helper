@extends('layouts.app')

@section('content')
<div id="content-div">
<h1 style="text-align: center">Friend Timeline</h1>
@if(count($data['friends']) > 0)
{!! Form::open(['id' => 'friends-boxes']) !!}
        @foreach($data['friends'] as $friend)
        <div class="form-group">
        {{Form::checkbox('friend', $friend['id'], $friend['show'], ['onchange' => 'toggleFriend()'])}}
        {{Form::label('friend', $friend['username'])}}
        </div>
        @endforeach
    {!! Form::close() !!}
@endif
@if(count($data['posts']) > 0)
    @foreach($data['posts'] as $post) 
        <div class="well" style="border:1px solid black; margin:5px; padding:5px">
            <small>{{$data['weekMap'][$post->created_at->addMinutes(-$post->offset)->dayOfWeek]}}, {{$post->created_at->addMinutes(-$post->offset)->format('F d, Y')}} at {{$post->created_at->addMinutes(-$post->offset)->format('H:i')}}</small>
                <p><strong>{{$post->username}} meditated for {{$post->minutes}} minute(s)</strong></p>
                @if($post->shared == 1)
                    <div style="display:flex;flex-direction:column;align-items:flex-start">
                    @if($post->entry)
                        <div class="entry-text"><p>{!! $post->entry !!}</p></div>
                    @endif
                    @if(isset($post->audio)) 
                        <audio src={{$post->audio}} controls></audio>
                    @endif</div>
                @endif
            </div>

    @endforeach
    {{--{{$data['posts']->links()}}--}}
@else
    <p>Nothing to see here!</p>
@endif
</div>
@endsection

@section('scripts')
<script src="/js/timeline.js"></script>
@endsection