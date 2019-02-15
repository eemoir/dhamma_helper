<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use App\User;
use App\Friendship;
use App\Notification;


class FriendsController extends Controller
{
    public function search(Request $request) {

        $term = $request->input('friend');
        $user = User::whereUsername($term)->get();
        if ($user->isEmpty()) {
            $user = User::whereEmail($term)->get();
            if ($user->isEmpty()) {
                $user = User::where('full_name', ucwords(strtolower($term)))->get();
                if ($user->isEmpty()) {
                    return response()->json([
                        'error' => 'User does not exist.'
                    ]);
                }
            } 
        }
        Log::info('user found');
        $jsonData = Array();

        foreach ($user as $person) {
            $id = Auth::id();
            if ($person->id != $id) {
                $entry = [
                    'name' => $person->full_name,
                    'username' => $person->username,
                    'email' => $person->email
                ];
                array_push($jsonData, $entry);
            }
        }

        if (count($jsonData) == 0) {
            return response()->json([
                'error' => 'You may not add yourself as a friend!'
            ]);
        }

        return response()->json($jsonData);
    }

    public function sendInvite(Request $request) {
        $senderID = Auth::id();
        $friendName = $request->input('username');
        $friendID = User::where('username', $friendName)->first()->id;
        /*$alreadyFriends = Friendship::where([['friend1', $senderID], ['friend2', $friendID]])->get();
        if (!$alreadyFriends->isEmpty()) {
            return response()->json([
                'already' => true
            ]);
        }*/
        if (Friendship::where([['friend1', $senderID], ['friend2', $friendID]])->exists()) {
            return response()->json([
                'already' => true
            ]);
        }
        $alreadySent = Notification::where([
            ['requester', $friendID],
            ['user_id', $senderID],
            ['type', 'friend request'],
            ['resolved', false]
        ])->get();
        if (!$alreadySent->isEmpty()) {
            return response()->json([
                'already sent' => true
            ]);
        }
        $duplicate = Notification::where([
            ['requester', $senderID],
            ['user_id', $friendID],
            ['type', 'friend request'],
            ['resolved', false]
        ])->get();
        if (!$duplicate->isEmpty()) {
            return response()->json([
                'multiple' => true
            ]);
        }
        $notification = new Notification;
        $notification->user_id = intval($friendID);
        $notification->requester = intval($senderID);
        $notification->type = 'friend request';
        $notification->resolved = false;
        try {
            $notification->save();
            return response()->json([
                'success' => 'success'
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => $errorInfo
            ]);
        }
        
    }
}
