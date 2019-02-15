@extends('layouts.app')

@section('content')
@auth
<h1>Meditation log</h1>
    @if(count($data['posts']) > 0)
        @foreach($data['posts'] as $post)
            <div class="well" style="border:1px solid black; margin:5px; padding:5px">
            <small>{{$data['weekMap'][$post->created_at->addMinutes(-$post->offset)->dayOfWeek]}}, {{$post->created_at->addMinutes(-$post->offset)->format('F d, Y')}} at {{$post->created_at->addMinutes(-$post->offset)->format('H:i')}}</small>
                <p><strong>You meditated for {{$post->minutes}} minute(s)</strong></p>
                @if($post->entry)
                    <div class="entry-text"><p>{!! str_limit($post->entry, 250,  "...") !!}</p></div>
                    <div style="display:flex;flex-direction:column;align-items:flex-start">
                    @if($post->audio) 
                    <audio src={{$post->audio}} controls></audio>
                    @endif
                    @if($post->created_at->addHours(24)->greaterThan(Carbon::now()))
                        <a class="btn btn-basic" href="/view/{{$post->id}}">Edit/View entry</a>
                    @else
                        <a class="btn btn-basic" href="/view/{{$post->id}}">View entry</a>
                    @endif</div>
                @elseif($post->audio)
                <div style="display:flex;flex-direction:column;align-items:flex-start">
                <audio src={{$post->audio}} controls></audio>
                    @if($post->created_at->addHours(24)->greaterThan(Carbon::now()))
                        <a class="btn btn-basic" href="/view/{{$post->id}}">Edit/View entry</a>
                    @endif</div>
                @else
                    @if($post->created_at->addHours(24)->greaterThan(Carbon::now()))
                    <a class="btn btn-basic" href="/view/{{$post->id}}">Create journal entry</a>
                    @endif
                @endif
            </div>
        @endforeach
        {{$data['posts']->links()}}
    @else

    <p>Nothing to see here!</p>

    @endif

@else
<h1>You must register and log in to view your log</p>
@endauth
@endsection
