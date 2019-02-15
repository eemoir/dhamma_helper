<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Post;
use App\Preference;
use Log;
use Storage;

class MeditationController extends Controller
{
    public function timed(Request $request) {

        $validatedData = $request->validate([
            'minutes' => 'required|numeric|max:120|min:1'
        ]);

        $minutes = $request->input('minutes');

        if (Auth::check()) 
        {
            $id = Auth::id();
            $preference = Preference::where('user_id', $id);

            if ($preference->exists()) {
                $preference->update(['preferred_time' => $minutes]);
            } else {
                $newPreference = new Preference;
                $newPreference->preferred_time = $minutes;
                $newPreference->user_id = $id;
                $newPreference->save();
            }

        }

        if ($minutes < 10) {
            $minutes = "0".$minutes.":00";
        } else {
            $minutes = $minutes.":00";
        }

        return view('pages.timed_counter', [
            'minutes' => $minutes
        ]);
    }

    public function random(Request $request) {

        $lower = $request->input('lower');
        $upper = $request->input('upper');
        $uppermin = strval(intval($lower)+1);
        $random = rand($lower, $upper);

        $this->validate($request, [
            'lower' => 'required|numeric|min:1|max:115',
            'upper' => 'required|numeric|min:'.$uppermin.'|max:120'
        ]);

        if (Auth::check()) 
        {
            $id = Auth::id();
            $preference = Preference::where('user_id', $id);

            if ($preference->exists()) {
                $preference->update(['lower' => $lower, 'upper' => $upper]);
            } else {
                $newPreference = new Preference;
                $newPreference->lower = $lower;
                $newPreference->upper = $upper;
                $newPreference->user_id = $id;
                $newPreference->save();
            }

        }

        if ($random < 10) {
            $random = "0".$random.":00";
        } else {
            $random = $random.":00";
        }

        return view('pages.random_counter', [
            'random' => $random
        ]);
    }

    public function finished(Request $request) {

        $minutes = $request->input('minutes');
        $id = $request->input('id');
        $offset = $request->input('offset');

        $post = new Post;
        $post->user_id = intval($id);
        $post->minutes = intval($minutes);
        $post->offset = intval($offset);
        $post->entry = Null;
        $post->audio = Null;
        $post->save();

        $mostRecent = Post::get()->where('user_id', $id)->max('id');

        return response()->json([
            'minutes' => $minutes,
            'mostRecent' => $mostRecent
        ]);
    }

    public function journal(Request $request) {
        $this->validate($request, [
            'post-id' => 'required',
        ]);
        
        $text = $request->input('entry');
        $postId = $request->input('post-id');
        if ($request->input('share') == 'share') {
            $shared = true;
        }
        else {
            $shared = false;
        }
        
        $post = Post::find($postId);
        $post->entry = $text;
        $post->shared = $shared;

        $post->save();

        return redirect('/log')->with('success', 'Your journal entry has been saved.');
    }

    public function audioSave(Request $request) {
        $newFile = $_FILES['file'];
        $id = $request->input('id');
        if ($newFile['error'] == 0) {
            if (null !== $id) {
                
                $post = Post::find($id);
                $oldAudio = $post->audio;
                
                $date = date("dmYHis");
                $filename = "{$id}{$date}.wav";

                $fileContents = file_get_contents($newFile['tmp_name']);
                Storage::disk('public')->put($filename, $fileContents);
                $url = Storage::url($filename);
                $post->audio = $url;
                $post->save();
                
                Storage::disk('public')->delete(substr($oldAudio, 9));
                
                return response()->json([
                   'success' => true 
                ]);
            } else {
                return redirect('/home')->with('error', 'There was an error saving your recording. Please try again.');
            }
        } else {
            return redirect("/view/{$id}")->with('error', 'There was an error uploading your recording. Please try again.');
        }
    }
    
    public function audioDelete(Request $request) {
        $id = $request->input('id');
        
        $post = Post::find($id);
        
        Storage::disk('public')->delete(substr($post->audio, 9));
        
        $post->audio = null;
        
        $post->save();
        
        return response()->json([
            'success' => true 
        ]);
    }

}
