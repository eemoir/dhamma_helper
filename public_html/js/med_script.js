var timer = undefined
var originalTime = undefined
var formattedTime = undefined
var time = document.querySelector("#time")
var randomTime = document.querySelector("#random-time")
var reset = undefined
var worker = undefined
var x = 0

if (window.Worker) {
    worker = new Worker('/js/worker.js')
    worker.onmessage = () => {
        if (x < 2) {
            let gong = new Audio('gong1.mp3')
            let playPromise = gong.play()
            if (playPromise !== null) {
                playPromise.catch(() => {gong.play()})
            }
            worker.postMessage('ring gong')
            x++
        }
    }
} 

document.addEventListener('DOMContentLoaded', () => {
    let timedForm = document.querySelector("#timed-form")
    let randomForm = document.querySelector("#random-form")
    //if the user is on the meditation page
    if (time || randomTime) {
        //when the page first loads, save the time meditated so that it can be sent to server...
        if (time) {
            formattedTime = time.innerHTML
            originalTime = unPadNum(formattedTime.slice(0, time.innerHTML.indexOf(":")))
        } else {
            formattedTime = randomTime.value
            originalTime = unPadNum(formattedTime.slice(0, randomTime.value.indexOf(":")))
        }
    }
    //if the user is selecting their meditation time and is not logged in
    if (!document.querySelector("#logged-in")) {
        if (timedForm) {
            //populate the form with saved time, if it exists
            if (localStorage.getItem('minutes')) {
                document.querySelector("#minutes").value = localStorage.getItem('minutes')
            }
            //on submit, save the time to localStorage so that it can repopulate the form later
            timedForm.addEventListener('submit', () => {
                let minutes = document.querySelector("#minutes").value
                localStorage.setItem('minutes', minutes)
            })
        }
        //if the user is selecting a range of times and is not logged in
        if (randomForm) {
            //populate the form with saved times, if they exist
            if (localStorage.getItem('lower')) {
                document.querySelector("#lower").value = localStorage.getItem('lower')
            }
            if (localStorage.getItem('upper')) {
                document.querySelector("#upper").value = localStorage.getItem('upper')
            }
            //on submit, save the times to localStorage
            randomForm.addEventListener('submit', () => {
                let lower = document.querySelector("#lower").value
                let upper = document.querySelector("#upper").value
                localStorage.setItem('lower', lower)
                localStorage.setItem('upper', upper)
            })
        }
    } 
})

function decrementTime() {
    let timeStr
    //set the current time, depending on the type of meditation
    if (time) {
        timeStr = time.innerHTML
    } else {
        timeStr = document.querySelector("#random-time").value
    }
    //determine the minutes and seconds
    let divide = timeStr.indexOf(":")
    let minute = timeStr.slice(0, divide)
    let sec = timeStr.slice(divide+1)
    //if there are still seconds remaining in the current minute...
    if (sec != "00") {
        //..subtract one second, parse the new time, and update the DOM
        let newSec = padNum(parseInt(sec) - 1)
        let newTime = `${minute}:${newSec}`
        if (time) {
            time.innerHTML = newTime
        } else {
            document.querySelector("#random-time").value = newTime
        }
    //if this the the last second of the current minute...
    } else {
        //if there are still minutes left in the meditation...
        if (parseInt(minute) != 0) {
            //..subtract one minute, set the seconds to 59, parse the new time, and update the DOM
            let newMin = padNum(parseInt(minute) - 1)
            let newTime = `${newMin}:59`
            if (time) {
                time.innerHTML = newTime
            } else {
                document.querySelector("#random-time").value = newTime
            }
        //if there are no minutes left, i.e. the meditation is over...
        } else {
            //clear the timer
            clearInterval(timer)
            let gong = new Audio('gong1.mp3')
            let playPromise = gong.play()
            if (playPromise !== null) {
                playPromise.catch(() => {gong.play()})
            }
            if (worker) {
                worker.postMessage('Play gong')
                //play the gong two more times, at interval
                /*let ringing = setInterval(clock, 4000)
                function clock() {
                    let playPromise = gong.play()
                    if (playPromise !== null) {
                        playPromise.catch(() => {gong.play()})
                    }
                    x++
                    if (x >= 2) {
                        clearInterval(ringing)
                    }
                }*/
            } 
            //if the user is not logged in, display a message telling them how long they meditated
            if (!document.querySelector("#logged-in")) {
                finishButton()
                document.querySelector('#finish-button').addEventListener('click', () => {
                    clearTimeout(reset)
                    youMeditatedFor(originalTime)
                })
            //otherwise, send everything to the server
            } else {
                finishButton() 
                document.querySelector('#finish-button').addEventListener('click', () => {
                    clearTimeout(reset)
                    //retrieve the CSRF token and the user id
                    let token = document.querySelector('input[name="_token"]').value
                    let id = document.querySelector("#logged-in").value
                    let offset = new Date().getTimezoneOffset()
                    //send the number of minutes and the user id to the server
                    fetch(`/finished`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({'minutes': originalTime, 'id': id, 'offset': offset})
                    }).then((res) => {
                        return res.json()
                    }).then((json) => {
                        let postId = json['mostRecent']
                        youMeditatedFor(originalTime)
                        document.querySelector('#post-id').value = postId
                        document.querySelector('#journal-form').hidden = false
                    })
                })
            }
        }
    } 
}

function finishButton() {
    if (document.getElementById('random-banner')) {
        document.getElementById('random-banner').innerHTML = "Meditation is finished"
    }
    playButton = document.querySelector("#pause-resume")
    playButton.hidden = true
    button = document.querySelector("#finish-button")
    button.hidden = false
    reset = setTimeout(resetTimer, 60000)
}

function resetTimer() {
    if (document.getElementById('random-banner')) {
        document.getElementById('random-banner').innerHTML = "Click start to begin timer"
    }
    playButton = document.querySelector("#pause-resume")
    playButton.hidden = false
    playButton.innerHTML = "Play"
    playButton.setAttribute('onclick', 'resumeMeditation()')
    button = document.querySelector("#finish-button")
    button.hidden = true
    if (time) {
        time.innerHTML = formattedTime
    } else if (randomTime) {
        randomTime.value = formattedTime
    }
}

//clears container and replaces it with message
function youMeditatedFor(minutes) {
    //empty the container div
    let container = document.querySelector('#counter-container')
    while (container.firstChild) {
        container.removeChild(container.firstChild)
    }
    //update the container informing the user of their number of minutes meditated
    let h1 = document.createElement('h1')
    h1.innerHTML = `You meditated for ${minutes} minute(s)!`
    container.appendChild(h1)
}

//pads single-digit numbers for timer
function padNum(num) {
    if (num.toString().length === 2) {
        return num.toString()
    } else {
        return `0${num}`
    }
}

//unpads single-digit numbers for display on finished page
function unPadNum(num) {
    return parseInt(num).toString()
}

//stops the timer and reconfigures the button to read "resume"
function pauseMeditation() {
    clearInterval(timer)
    if (document.querySelector("#random-banner")) {
        document.querySelector("#random-banner").innerHTML = "Timer is paused"
    }
    document.querySelector("#pause-resume").innerHTML = "Resume"
    document.querySelector("#pause-resume").setAttribute("onclick", "resumeMeditation()")
}

//restarts the timer and reconfigures the button to read "pause"
function resumeMeditation() {
    timer = setInterval(decrementTime, 1000)
    if (document.querySelector("#random-banner")) {
        document.querySelector("#random-banner").innerHTML = "Meditation is ongoing"
    }
    document.querySelector("#pause-resume").innerHTML = "Pause"
    document.querySelector("#pause-resume").setAttribute("onclick", "pauseMeditation()")
}