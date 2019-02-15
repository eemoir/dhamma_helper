var token = document.head.querySelector('meta[name="csrf-token"]').content
const weekMap = {
    0: "Sunday",
    1: "Monday",
    2: "Tuesday",
    3: "Wednesday",
    4: "Thursday",
    5: "Friday",
    6: "Saturday"
}

const monthMap = {
    0: "January",
    1: "February",
    2: "March",
    3: "April",
    4: "May",
    5: "June",
    6: "Saturday",
    7: "July",
    8: "August",
    9: "September",
    10: "October",
    11: "November",
    12: "December"
}

document.addEventListener('DOMContentLoaded', () => {
    let timestamps = document.querySelectorAll('.timestamp')
    timestamps.forEach(timestamp => {
        let stamp = timestamp.innerHTML
        let newStamp = stamp.split(' ')
        let date = newStamp[0]
        let time = newStamp[1]
        let splitDate = date.split('-')
        let splitTime = time.split(':')
        let UTCDate = new Date(Date.UTC(splitDate[0], parseInt(splitDate[1])-1, splitDate[2], splitTime[0], splitTime[1]))
        let weekday = weekMap[UTCDate.getDay()]
        let month = monthMap[UTCDate.getMonth()]
        let day = UTCDate.getDate()
        let year = UTCDate.getFullYear()
        let hour = UTCDate.getHours()
        let minutes = UTCDate.getMinutes()
        let stampString = `${weekday}, ${month} ${day}, ${year} at ${hour}:${minutes}`
        timestamp.innerHTML = stampString
    })
    let accepts = document.querySelectorAll('.accept-button')
    accepts.forEach(button => {
        button.addEventListener('click', (e) => {
            let username = e.target.parentNode.parentNode.querySelector('input[name=username]').value
            resolveFriendRequest(e, 'accept', `You have accepted ${username}'s friend request!`)
            
        })
    })
    let declines = document.querySelectorAll('.decline-button')
    declines.forEach(button => {
        button.addEventListener('click', (e) => {
            let username = e.target.parentNode.parentNode.querySelector('input[name=username]').value
            resolveFriendRequest(e, 'decline', `You have declined ${username}'s friend request.`)
        })
    })
    let oks = document.querySelectorAll('.mark-button')
    oks.forEach(button => {
        button.addEventListener('click', (e) => {
            resolveNotification(e)
        })
    })
})

function resolveNotification(e) {
    let grandparentForm = e.target.parentNode.parentNode
    let errorDiv = grandparentForm.querySelector('.error')
    let requestID = grandparentForm.querySelector('input[name=notification_id').value
    let data = new FormData()
    data.append('id', requestID)
    data.append('type', 'mark as read')
    fetch('/resolve', {
        'method': 'POST',
        'body': data,
        'headers': {
            'X-CSRF-TOKEN': token,
        }
    }).then(response => {
        return response.json()
    }).then(response => {
        if (response['success']) {
            errorDiv.innerHTML = ''
            let greatgrandparentDiv = grandparentForm.parentNode
            setTimeout(() => {removeDiv(greatgrandparentDiv)}, 500)
            decrementNotificationsBadge()
        } else {
            errorDiv.innerHTML = 'There was an error processing your request. Please try again.'
            fadeIn(errorDiv, 500)
        }
    })
}

function resolveFriendRequest(e, action, message) {
    let grandparentForm = e.target.parentNode.parentNode
    let errorDiv = grandparentForm.querySelector('.error')
    let requestID = grandparentForm.querySelector('input[name=notification_id').value
    let data = new FormData()
    data.append('id', requestID)
    data.append('type', 'friend request')
    data.append('action', action)
    fetch('/resolve', {
        'method': 'POST',
        'body': data,
        'headers': {
            'X-CSRF-TOKEN': token,
        }
    }).then(response => {
        return response.json()
    }).then(response => {
        if (response['success']) {
            errorDiv.innerHTML = ''
            let greatgrandparentDiv = grandparentForm.parentNode
            replaceWithMessage(greatgrandparentDiv, message)
            setTimeout(() => {removeDiv(greatgrandparentDiv)}, 1500)
            decrementNotificationsBadge()
        } else {
            errorDiv.innerHTML = 'There was an error processing your request. Please try again.'
            fadeIn(errorDiv, 500)
        }
    })
}

function replaceWithMessage(div, message) {
    while (div.firstChild) {
        div.removeChild(div.firstChild)
    }
    div.innerHTML = message
    fadeIn(div, 500)
}

function removeDiv(div) {
    fadeOut(div, 500)
    setTimeout(() => {
        let parent = div.parentNode
        parent.removeChild(div)   
    }, 500)
}

function fadeIn(el, time) {
  el.style.opacity = 0;

  var last = +new Date();
  var tick = function() {
    el.style.opacity = +el.style.opacity + (new Date() - last) / time;
    last = +new Date();

    if (+el.style.opacity < 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
    }
  };

  tick();
}

function fadeOut(el, time) {
  el.style.opacity = 1;

  var last = +new Date();
  var tick = function() {
    el.style.opacity = +el.style.opacity - (new Date() - last) / time;
    last = +new Date();

    if (+el.style.opacity <= 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
    }
  };

  tick();
}

function decrementNotificationsBadge() {
    let span = document.getElementById('notification-span')
    let num = parseInt(span.innerHTML)
    if (num === 1) {
        span.parentNode.removeChild(span)
    } else {
        num--
        span.innerHTML = num
    }
}