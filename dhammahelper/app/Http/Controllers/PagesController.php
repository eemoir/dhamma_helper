<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Preference;
use App\Notification;
use App\User;
use App\Friendship;
use Log;
use View;
use DB;

class PagesController extends Controller
{
    public $weekMap = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];
    
    public function index() {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('pages.index');
        }
    }

    public function about() {
        return view('pages.about');
    }

    public function meditate() {
        return view('pages.meditate');
    }

    public function account() {
        return view('pages.account');
    }

    public function timed() {
        if (Auth::check()) {
            $id = Auth::id();
            $preference = Preference::where('user_id', $id)->first();
            if ($preference != null) {
                $minutes = $preference->preferred_time;
                return view('pages.timed')->with('minutes', $minutes);
            }
            
        }
        return view('pages.timed');
    }

    public function random() {
        if (Auth::check()) {
            $id = Auth::id();
            $preference = Preference::where('user_id', $id)->first();
            if ($preference != null) {
                $data = [
                    'lower' => $preference->lower,
                    'upper' => $preference->upper
                ];
                return view('pages.random')->with('data', $data);
            }
            
        }
        return view('pages.random');
    }

    public function log() {
        $id = Auth::id();

        $posts = Post::where('user_id', $id)->orderBy('id', 'desc')->paginate(10);

        $data = [
            'posts' => $posts,
            'weekMap' => $this->weekMap
        ];

        return view('pages.log')->with('data', $data);
    }

    public function view($id) {

        $post = Post::where('id', $id)->first();
        
        if (!$post) {
            return view('errors.404');
        }

        Log::info(Auth::id());
        Log::info($post->user_id);

        if ($post->user_id != Auth::id()) {
            return view('errors.notauthorized');
        }

        $data = [
            'post' => $post,
            'weekMap' => $this->weekMap
        ];

        return view('pages.view')->with('data', $data);
    }

    public function notifications() {
        $id = Auth::id();

        $notifications = Notification::where([['user_id', $id], ['resolved', false]])->orderBy('created_at', 'desc')->get();

        $data = Array();

        foreach ($notifications as $notification) {
            if ($notification->type == 'friend request') {
                $from = User::where('id', $notification->requester)->first()->username;
                $note = [
                    'type' => 'friend request',
                    'text' => 'You have a friend request from '.$from.'.',
                    'from' => $from,
                    'time' => $notification->created_at,
                    'id' => $notification->id
                ];
                array_push($data, $note);
            } else if ($notification->type == 'friend request accepted' || $notification->type == 'friend request declined') {
                $from = User::where('id', $notification->requester)->first()->username;
                $type = $notification->type;
                $note = [
                    'type' => 'friend request accepted',
                    'text' => $type == 'friend request accepted' ? $from.' has accepted your friend request!' : $from.' has declined your friend request.',
                    'time' => $notification->created_at,
                    'id' => $notification->id
                ];
                array_push($data, $note);
            }
        }

        return view('pages.notifications')->with('data', $data);
    }

    public function resolve(Request $request) {
        if ($request->input('type') == 'friend request') {
            if ($request->input('action') == 'accept') {
                try {
                    $notification = Notification::where('id', $request->input('id'))->first();
                    $requester = $notification->requester;
                    $acceptor = $notification->user_id;
                    if (!Friendship::where([['friend1', $requester], ['friend2', $acceptor]])->exists()) {
                        $friendship = new Friendship;
                        $friendship->friend1 = $acceptor;
                        $friendship->friend2 = $requester;
                        $friendship->save();
                        $revFriendship = new Friendship;
                        $revFriendship->friend1 = $requester;
                        $revFriendship->friend2 = $acceptor;
                        $revFriendship->save();
                        $notification->resolved = true;
                        $notification->save();
                        $newNote = new Notification;
                        $newNote->type = 'friend request accepted';
                        $newNote->user_id = $requester;
                        $newNote->requester = $acceptor;
                        $newNote->resolved = false;
                        $newNote->save();
                        return response()->json([
                            'success' => true
                        ]);
                    }
                    else {
                        return response()->json([
                            'success' => false
                        ]);
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    $errorInfo = $exception->errorInfo;
                    return response()->json([
                        'error' => $errorInfo
                    ]);
                }
            } else {
                try {
                    $notification = Notification::where('id', $request->input('id'))->first();
                    $requester = $notification->requester;
                    $decliner = $notification->user_id;
                    $notification->resolved = true;
                    $notification->save();
                    $newNote = new Notification;
                    $newNote->type = 'friend request declined';
                    $newNote->user_id = $requester;
                    $newNote->requester = $decliner;
                    $newNote->resolved = false;
                    $newNote->save();
                    return response()->json([
                        'success' => true
                    ]);
                } catch (\Illuminate\Database\QueryException $exception) {
                    $errorInfo = $exception->errorInfo;
                    return response()->json([
                        'error' => $errorInfo
                    ]);
                }
            }
        } else if ($request->input('type') == 'mark as read') {
            $noteID = $request->input('id');
            try {
                $note = Notification::where('id', $noteID)->first();
                $note->resolved = true;
                $note->save();
                return response()->json([
                    'success' => true
                ]);
            } catch (\Illuminate\Database\QueryException $exception) {
                $errorInfo = $exception->errorInfo;
                    return response()->json([
                        'error' => $errorInfo
                    ]);
            }
        }
    }

    public function details() {
        return view('pages.accountdetails');
    }

    public function changeUsername(Request $request) {
        $name = $request->input('username');

        $id = Auth::id();

        $user = User::where('id', $id)->first();

        $user->username = $name;
        
        $user->increment('login_count');

        $user->save();

        return redirect('/home')->with('success', 'Your username has been changed.');
    }
    
    public function incrementLogin() {
        $id = Auth::id();
        $user = User::where('id', $id)->first();
        $user->increment('login_count');
    }
    
    public function timeline(Request $request) {
        $id = Auth::id();
        
        $friends = User::join('friendships', 'users.id', '=', 'friendships.friend2')
                ->where('friendships.friend1', $id)
                ->whereExists(function($query) {
                    $query->select(DB::raw(1))
                    ->from('posts')
                    ->whereRaw('posts.user_id = friendships.friend2');
                })
                ->select('users.username', 'users.id')
                ->get();
        
        if ($request->has('friends')) {
            
            $friendsList = explode(",", $request->input('friends'));
        
            foreach($friends as $friend) {
                if (in_array($friend['id'], $friendsList)) {
                    $friend['show'] = true;
                } else {
                    $friend['show'] = false;
                }
            }
            
            $friend_posts = Post::join('friendships', 'posts.user_id', '=', 'friendships.friend2')
                ->where('friendships.friend1', $id)
                ->whereIn('friendships.friend2', $friendsList)
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->orderBy('posts.created_at', 'desc')
                ->select('posts.id',
                    'users.username',
                    'posts.user_id', 
                    'posts.entry', 
                    'posts.minutes', 
                    'posts.audio', 
                    'posts.shared', 
                    'posts.created_at', 
                    'posts.offset')
                ->get();

            $data = [
                'posts' => $friend_posts,
                'weekMap' => $this->weekMap,
                'friends' => $friends,
            ];
            return view('pages.timeline')->with('data', $data);
        }
        else {
            
            foreach($friends as $friend) {
                $friend['show'] = true;
            }

            $friend_posts = Post::join('friendships', 'posts.user_id', '=', 'friendships.friend2')
                ->where('friendships.friend1', $id)
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->orderBy('posts.created_at', 'desc')
                ->select('posts.id',
                    'users.username',
                    'posts.user_id', 
                    'posts.entry', 
                    'posts.minutes', 
                    'posts.audio', 
                    'posts.shared', 
                    'posts.created_at', 
                    'posts.offset')
                ->get();

            $data = [
                'posts' => $friend_posts,
                'weekMap' => $this->weekMap,
                'friends' => $friends,
            ];

            return view('pages.timeline')->with('data', $data);
        }
        
    }
}
