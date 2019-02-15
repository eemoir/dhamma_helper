@extends('layouts.app')

@section('content')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                    
                    @if ($data['modal'])
                    <div id="modal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Change Username</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <p>You have been assigned a username of {{ Auth::user()->username}}. If you would like to change it, 
                            you may do so now.</p>
                            {!! Form::open(['action' => 'PagesController@changeUsername', 'method' => 'POST', 'style' => "margin: 5px", 'id' => 'change-username']) !!}
                            {{Form::label('username', "Username: ")}}{{Form::text('username', Auth::user()->username, ['style' => 'margin-left:5px'])}}
                            <p id="error" style="color:red"></p>
                            <p>You may also change your username at any time by visiting the "Account Details" page linked at the bottom of your homepage.</p>
                            </div>
                            <div class="modal-footer">
                            <button class="btn btn-secondary" type="submit" id="submit" disabled>Change Username</button>
                            <button class="btn btn-primary" data-dismiss="modal" type="button" id="decline">No thanks, I like {{ Auth::user()->username}}</button>
                            {!! Form::close() !!}
                          </div>
                          </div>
                        </div>
                      </div>


                    @endif
                    
                    <h1 style="text-align:center">Welcome, {{ Auth::user()->username }}!</h1>

                    <h2>Time to Meditate</h2>
                    <p>Click <a href="/meditate">here</a> to start a new meditation.</p>

                    <h2>Meditation Log</h2>
                    <p>View your meditation log <a href="/log">here</a>.</p>

                    <h2>Friends</h2>

                    @if (count($data['friends']) > 0)
                        <div class="text-center"><a class="btn btn-secondary" href="/timeline">View Friend Timeline</a></div>
                        <br/>
                        <p>Your friends:</p>
                        <ul>
                            @foreach ($data['friends'] as $friend) 
                            <li>{{$friend['username']}}</li>
                            @endforeach
                        </ul>
                    @endif
                    {!! Form::open(['action' => 'FriendsController@search', 'method' => 'POST', 'id' => 'friend-search-form']) !!}
                        <div class="form-group">
                    <p>Add a new friend (search by name, username, or email address):</p>                    {{Form::text('friend', '',['id' => 'friend'])}}
                    {{Form::submit('Search', ['class' => 'btn btn-default', 'disabled' => true, 'id' => 'friend-search-submit'])}}
                    </div>
                    <p id='search-error' style="color:red"></p>
                    <label id="ul-label" for="friend-invites"></label>
                    <ul id="friend-invites" style="list-style-type:none"></ul>
                    {!! Form::close() !!}

                    <h2>Account Metrics</h2>
                    @if ($data['nostats']) 
                        <p id="no-stats">You have not meditated yet. Click <a href="/meditate">here</a> to start a new meditation.</p>
                    @else
                    <div class="row justify-content-center" style="text-align:center"><div id="loader" class="loader-visible"></div></div>
                    <div id="stats" class="invisible">
                        <p>Average length of meditation: <span id="average"></span> minutes.</p>
                        <p>Average minutes meditated per day: <span id="average-day"></span> minutes.</p>
                        <p>Highest number of days in a row meditated: <span id="longest-run"></span>.</p>
                        <p>Current number of days in a row meditated: <span id="current-run"></span>.</p>
                        <h3 id="chart-title" style="text-align:center"></h3>
                        <div style="text-align: left"><div id="select-div" style="display: inline-block"></div></div>
                        <canvas id="chart-div"></canvas>
                    </div>
                    @endif
                    
                    <br/>
                    <div style="text-align:center"><a href="/details">View/Edit Account Details</a></div>
                @endauth
                
@endsection

@section('scripts')
<script src="/js/friendsearch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" charset="utf-8"></script>
<script src="/js/home.js"></script>
<script src="/js/details.js"></script>
@endsection
