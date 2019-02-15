<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
        <title>Meditation</title>
        
    </head>
    <body>
        @auth
    <input id="logged-in" hidden value="{{ Auth::id() }}" />
        @endauth
        @include('inc.messages')
        <div class="container" style="margin-top:5%">
        <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
        @yield('content')
        </div>
    </div>
                        </div></div></div>
                        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        if (document.querySelector('#article-ckeditor')) {
        CKEDITOR.replace( 'article-ckeditor' )
        }
    </script>
    <script src="/js/med_script.js"></script>
    <script src="/js/audioScript.js"></script>
    <script src="/js/WebAudioRecorder.js"></script>
    </body>
</html>