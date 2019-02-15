<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Charts\Meditations;
use App\User;
use Carbon\Carbon;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::id();
        $friends = User::join('friendships', 'users.id', '=', 'friendships.friend2')
            ->where('friendships.friend1', $id)
            ->select('users.username')
            ->get();
        
        $posts = Post::where('user_id', $id)->get();

        if (count($posts) > 0) {
            $nostats = false;
        } else {
            $nostats = true;
        }

        $user = User::find($id);

        if ($user->login_count == 0) {
            $modal = true;
        } else {
            $modal = false;
        }

        $data = [
            'friends' => $friends,
            'nostats' => $nostats,
            'modal' => $modal
        ];
        
        return view('home')->with('data', $data);
    }

    public function loadChart(Request $request) {
        $offset = $request->input('offset');
        $currentTime = Carbon::now()->addMinutes(-$offset);
        $currentDay = $currentTime->dayOfWeek;
        $weekBeginning = Carbon::createMidnightDate($currentTime->year, $currentTime->month, $currentTime->day)->addDays(-$currentDay)->addMinutes($offset);
        $id = Auth::id();
        $posts = Post::where('user_id', $id)->get();
        $leastRecent = Post::where('user_id', $id)->orderBy('created_at', 'asc')->first()->created_at;
        $chartData = $this->createChart($weekBeginning);
        $max = $this->getMaxMinutes($offset);
        return response()->json([
            'chartData' => $chartData,
            'weekBeginning' => $weekBeginning,
            'earliest' => $leastRecent,
            'max' => $max
        ]);
        
    }

    public function reloadChart(Request $request) {
        $offset = $request->input('offset');
        $month = $request->input('month')+1;
        $day = $request->input('day');
        $year = $request->input('year');
        $weekBeginning = Carbon::createMidnightDate($year, $month, $day)->addMinutes($offset);
        $chartData = $this->createChart($weekBeginning);
        $max = $this->getMaxMinutes($offset);
        Log::info($weekBeginning);
        return response()->json([
            'chartData' => $chartData,
            'max' => $max
        ]);
    }

    public function getMaxMinutes($offset) {
        $mins = $this->makeDayMap($offset);
        $max = max(array_values($mins));
        return $max;
    }

    public function createChart($weekBeginning) {
        $id = Auth::id();
        $posts = Post::where('user_id', $id)->get();
        $weekEnd = $weekBeginning->copy();
        $weekEnd->addDays(7);
        $times = Array();
        $year = Carbon::now()->year;
        $day = $weekBeginning->copy();
        while ($day < $weekEnd) {
            $dayYear = $day->year;
            if ($dayYear == $year) {
                $string = $day->copy()->format('m/d');
                array_push($times, $string);
                $times[$string] = 0;
                foreach ($posts as $post) {
                    if ($post->created_at >= $day) {
                        if ($post->created_at < $day->copy()->addDays(1)) {
                            $times[$string] = $times[$string] + $post->minutes;
                        }
                    }
                }
            } else {
                $string = $day->copy()->format('m/d/y');
                array_push($times, $string);
                $times[$string] = 0;
                foreach ($posts as $post) {
                    if ($post->created_at >= $day) {
                        if ($post->created_at < $day->copy()->addDays(1)) {
                            $times[$string] = $times[$string] + $post->minutes;
                        }
                    }
                }
            }
            $day->addDays(1);
        } 
        
        $chart = new Meditations;
        $chart->labels(array_keys($times));
        $chart->dataset('Minutes', 'bar', array_values($times));

        return $chart->api();
    }

    public function averageMeditationLength() {
        $id = Auth::id();
        $average = Post::where('user_id', $id)->avg('minutes');
        if (!isset($average)) {
            $average = 0;
        }
        return response()->json([
            'average' => $average
        ]);
    }

    public function averageMinutesPerDay(Request $request) {
        $offset = $request->input('offset');

        $meditations = $this->makeDayMap($offset);
         $average = array_sum(array_values($meditations))/count(array_values($meditations));

        return response()->json([
            "average" => $average
        ]);
    }

    public function longestRun(Request $request) {
        $offset = $request->input('offset');
        $meditations = $this->makeDayMap($offset);
        $longest = 0;
        $counter = 0;
        foreach($meditations as $day => $minutes) {
            if ($counter > $longest) {
                $longest = $counter;
            }
            if ($minutes > 0) {
                $counter = $counter + 1;
            } else {
                $counter = 0;
            }
        }
        return response()->json([
            'longest' => $longest
        ]);
    }

    public function currentRun(Request $request) {
        $offset = $request->input('offset');
        $meditations = array_reverse($this->makeDayMap($offset));

        $run = 0;

        if (count(array_values($meditations)) != 0) {
            
            for ($x = 0; $x < count(array_values($meditations)); $x++) {
                if (array_values($meditations)[$x] > 0) {
                    $run++;
                } else {
                    break;
                }
            }
        
        }

        return response()->json([
            'current' => $run,
        ]);
    }

    public function makeDayMap($offset) {
        $id = Auth::id();
        $posts = Post::where('user_id', $id)->get();
        $leastRecent = Post::where('user_id', $id)->orderBy('created_at', 'asc')->first();
        $pastoffset = $leastRecent->offset;
        $leastRecentTime = $leastRecent->created_at->addMinutes(-$pastoffset);
        //the time at which it was the midnight where the user was before the least recent data point:
        $midnightTime = Carbon::createMidnightDate($leastRecentTime->year, $leastRecentTime->month, $leastRecentTime->day)->addMinutes($pastoffset);
        $currentTime = Carbon::now()->addMinutes(-$offset);
        //the time at which it was midnight where the user was most recently
        $midnightNow = Carbon::createMidnightDate($currentTime->year, $currentTime->month, $currentTime->day)->addMinutes($offset);

        $meditations = Array();

        while ($midnightTime <= $midnightNow) {
            $string = $midnightTime->copy()->format('m/d/y');
            $meditations[$string] = 0;
            foreach ($posts as $post) {
                if ($post->created_at > $midnightTime) {
                    $midnightPlusOne = $midnightTime->copy()->addDays(1);
                    if ($post->created_at < $midnightPlusOne) {
                        $meditations[$string] = $meditations[$string] + $post->minutes;
                    }
                }
            }
            $midnightTime->addDays(1);
        }

        return $meditations;
    }
    
    public function checkForUsername(Request $request) {
        $name = $request->input('name');

        if (User::where('username', $name)->exists()) {
            return response()->json([
                'success' => false
            ]);
        } 
        return response()->json([
            'success' => true
        ]);
    }
}
