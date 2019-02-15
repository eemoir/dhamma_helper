var token = document.head.querySelector('meta[name="csrf-token"]').content
var submit = document.getElementById('submit')
var error = document.getElementById('error')

document.addEventListener('DOMContentLoaded', () => {
    let name = document.querySelector("input[name='username']")
    
    if (name) {
        var oldName = name.value
        name.addEventListener('input', (e) => {
            let newName = name.value
            if (newName == oldName) {
                submit.disabled = true
                error.innerHTML = ''
            } else {
                let data = new FormData()
                data.append('name', newName)
                fetch('/checkForUsername', {
                    'method': 'POST',
                    'body': data,
                    'headers': {
                        'X-CSRF-TOKEN': token,
                    }
                }).then(response => {
                    return response.json()
                }).then(response => {
                    console.log(response)
                    if (response['success']) {
                        if (/[^a-zA-Z0-9]/.test(newName)) {
                            errorWithMessage("Usernames may not contain special charaters")
                        } else if (newName === '') {
                            errorWithMessage("Please enter a valid username")
                        } else {
                            error.innerHTML = ''
                            submit.disabled = false
                            error.style = "color:black"
                            error.innerHTML = "That username is available!"
                            fadeIn(error, 500)
                        } 
                    } else {
                        errorWithMessage("That username is taken")
                    }
                })
            }
            
        })
    
        
    }
})

function errorWithMessage(message) {
    error.innerHTML = ''
    submit.disabled = true
    error.style = "color:red"
    error.innerHTML = message
    fadeIn(error, 500)
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