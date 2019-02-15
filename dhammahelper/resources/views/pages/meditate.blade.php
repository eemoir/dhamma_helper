@extends('layouts.app')

@section('content')
<div style="text-align:center"><h1>Meditate</h1>
<br/>
<h2>I would like for my meditation to be:</h2>
<div style="display:flex;flex-direction:column;align-items:center"><a class="btn btn-secondary" id="timed-btn" href="/timed">Timed</a><label for="timed-btn">(if you know the exact amount of time you would like to meditate)</label></div>
<div style="display:flex;flex-direction:column;align-items:center"><a class="btn btn-secondary" id="random-btn" href="/random">Randomized</a><label for="random-btn">(if you would like me to pick a time within a certain window)</label></div>
</div>
@endsection