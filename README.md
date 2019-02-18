## Dhamma Helper Meditation Timer and Diary


### Hosting

This application is hosted through inmotion at the following address: <a href="https://dhammahelper.com">https://dhammahelper.com</a>. It is configured to always direct to https, since <a href="https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia">MediaDevices.getUserMedia</a> (which WebAudioRecorder relies on to get microphone input) only works in a secure context. 


### Features/How to Use

#### Login

You don't need to register and log in to use the meditation timer, but you will need to do so to use the rest of the application's features. Registration and login uses Laravel's standard Auth package. You may also register and login with Google or Facebook, if you prefer. 

#### Meditation Timer

There are two different meditation timers available: a timer in which the user specifies the number of minutes she would like to meditate, and which displays the minutes and seconds as they count down to zero, and a timer in which the user specifies a window of acceptable times, for example 15 to 30 minutes. The app then selects a random number of minutes within this window and begins the countdown, with the exact meditation time not revealed to the user until the end of the meditation. I have found this technique to be useful in reducing impatience and distraction during my meditations. 

If the user is logged in, their preference for the number of minutes they would like to meditate, or the upper and lower values of the time window, is stored on the server. If they are not logged in, these preferences are stored in LocalStorage.

#### Meditation Journal

At the end of every meditation, the number of minutes meditated is logged to the server. The user can then add a written journal entry to be associated with this sit. She can also make an audio diary recording of up to two minutes. The entry can be added or edited and/or the audio diary entry can be added, deleted, or overwritten for up to 24 hours after a meditation, at which point the entry becomes fixed. Old entries can be viewed or listened to at any time in the user's meditation log. If the "Share this entry with friends" checkbox at the bottom of the form remains checked, any of the user's friends will be able to view the entry and listen to the recording in their friend timeline. (Even if the entry is not shared, friends will still be able to see the number of minutes the user meditated.)

#### Account Metrics

At the bottom of the home page, the app displays the user's: average length of meditation, average number of minutes meditated per day since joining, highest number of days in a row meditated, and current number of days in a row meditated. It also displays the number of minutes meditated per day in bar graph form. The page automatically displays the graph for the current week, but the user can toggle back to previous weeks, as well.

#### Friends and Sharing

The app uses event listeners to send a friend request from Erin (that's me) to every new registrant. To add other friends, simply search by username, name, or email address under the "Friends" heading on the homepage and send a friend request to anyone you would like to add. By clicking on the "Friend Timeline" button, you can view the combined logs of all of your friends' shared entries. You can also toggle friends on and off if you would only like to see the entries of a few selected friends. 

#### Notifications

Whenever a user receives a friend request or has a friend request accepted or denied, a message appears in that user's notifications. The badge next to the notifications tab in the navigation bar displays the current number of unresolved notifications.


### Framework and Libraries

This is a Laravel project. As such, it relies heavily on Bootstrap and MySQL. I made use of the Storage facade in storing user-recorded audio files. I also used the Laravel Socialite package to implement OAuth2 Facebook and Google logins. I used Laravel Collective's Form and HTML package to create forms in the blade-templated views.

On the front end, I used higuma's <a href="https://github.com/higuma/web-audio-recorder-js">WebAudioRecorder.js</a> to record and encode audio input from the user. I adapted it to only encode to MP3, since WAV files are too large to be sent to the server, although in the future I intend to add an Ogg encoding option for browsers that don't support MP3. 

The graph of minutes meditated per day displayed on the home page is created with <a href="https://www.chartjs.org/">Chart.js</a>.

I used a <a href="https://www.w3schools.com/html/html5_webworkers.asp">Web Worker</a> to sound the gong three times at the end of each meditation, since the gong chimes are spaced several seconds apart and the thread was blocking other features.


### Other Credits

Traversy Media's <a href="https://www.youtube.com/playlist?list=PLillGF-RfqbYhQsN5WMXy6VsDMKGadrJ-">Laravel from Scratch</a> series was extremely helpful for me when I was first setting up and configuring the app.

The loading circle that displays while account metrics are loading was inspired by this <a href="https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_loader5">example</a> from W3 Schools.

The animated dots that indicate a recording is in progress were adapted from this <a href="https://codepen.io/chrisnager/pen/yfwgE">CodePen</a>.

The FadeIn/FadeOut effects I use were adapted from this <a href="http://jsfiddle.net/TH2dn/606/">JSFiddle</a>.

