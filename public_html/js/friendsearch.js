var token = document.head.querySelector('meta[name="csrf-token"]').content

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('friend-search-form').addEventListener('submit', (e) => {
        e.preventDefault()
        document.getElementById('ul-label').innerHTML = ''
        let ul = document.getElementById("friend-invites");
        while (ul.firstChild) {
            ul.removeChild(ul.firstChild);
        }
        document.getElementById('search-error').innerHTML = ''
        let searchTerm = document.getElementById('friend').value
        let data = new FormData
        data.append('friend', searchTerm)
        fetch('/friendsearch', {
            'method': 'POST',
            'body': data,
            'headers': {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            return response.json()
        }).then(response => {
            if (response['error']) {
                document.getElementById('search-error').innerHTML = response['error']
                fadeIn(document.getElementById('search-error'), 500)
            } else {
                createFriendForm(response)
            }
        })
    })
    document.getElementById('friend').addEventListener('input', (e) => {
        if (e.target.value !== '') {
            document.getElementById('friend-search-submit').disabled = false
        } else {
            document.getElementById('friend-search-submit').disabled = true
        }
    })
})

function createFriendForm(array) {
    let ul = document.getElementById('friend-invites')
    while (ul.firstChild) {
        ul.removeChild(ul.firstChild)
    }
    document.getElementById('ul-label').innerHTML = "Friends found:"
    array.forEach(friend => {
        let li = document.createElement('li')
        let f = document.createElement('form')
        f.setAttribute('style', 'display:flex;flex-direction:row;align-items:center;justify-content:flex-start')
        let p = document.createElement('p')
        p.innerHTML = friend['username']
        p.style="margin:0"
        f.appendChild(p)
        let button = document.createElement('button')
        button.setAttribute('style', 'margin-left:10px')
        button.className = 'invite-button btn btn-default'
        button.setAttribute('type', 'submit')
        button.innerHTML = "Send friend invitation"
        f.addEventListener('submit', (e) => {
            e.preventDefault()
            sendFriendInvite(e)
        })
        f.appendChild(button)
        li.appendChild(f)
        ul.appendChild(li)
        fadeIn(ul, 500)
    })
}

function sendFriendInvite(e) {
    let username = e.target.firstChild.innerHTML
    let data = new FormData()
    data.append('username', username)
    fetch('/sendInvite', {
        'method': 'POST',
        'headers': {
            'X-CSRF-TOKEN': token,
        },
        'body': data
    }).then(response => {
        return response.json()
    }).then(response => {
        if (response['success']) {
            document.getElementById('search-error').innerHTML = ""
            let grandparentNode = e.target.parentNode.parentNode
            while (grandparentNode.firstChild) {
                grandparentNode.removeChild(grandparentNode.firstChild)
            }
            grandparentNode.innerHTML = `Invitation sent to ${username}!`
            fadeIn(grandparentNode, 500)
        } else if (response['multiple']) {
            document.getElementById('search-error').innerHTML = `You have already sent ${username} a friend request.`
            fadeIn(document.getElementById('search-error'), 500)
        } else if (response['already']) {
            document.getElementById('search-error').innerHTML = `You are already friends with ${username}.`
            fadeIn(document.getElementById('search-error'), 500)
        } else if (response['already sent']) {
            document.getElementById('search-error').innerHTML = `${username} has already sent you a friend request. To accept, go to your notifications page.`
            fadeIn(document.getElementById('search-error'), 500)
        }
        else {
            document.getElementById('search-error').innerHTML = "There was an error sending your invitation."
            fadeIn(document.getElementById('search-error'), 500)
        }
    })
}

function fadeIn(el, time) {
  el.style.opacity = 0;

  var last = new Date();
  var tick = function() {
    el.style.opacity = +el.style.opacity + (new Date() - last) / time;
    last = +new Date();

    if (+el.style.opacity < 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
    }
  };

  tick();
}