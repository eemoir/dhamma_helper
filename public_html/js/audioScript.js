var gumStream
var recorder
var input
var encodeAfterRecord = true
var recordButton = document.querySelector("#recordButton")
var stopButton = document.querySelector("#stopButton")
var submitButton = document.querySelector('#submitButton')
var journalForm = document.querySelector('#journal-form')
var token = document.querySelector('input[name="_token"]').value
var recordingMessage = document.getElementById('recording-message')
var audioContent
var newBlob
var newData

var AudioContext = window.AudioContext
var audioContext

document.addEventListener('DOMContentLoaded', () => {
    if (recordButton) {
        recordButton.addEventListener('click', startRecording)
        stopButton.addEventListener('click', stopRecording)
    }

    if (journalForm) {
        journalForm.addEventListener('submit', submitAudio, true)
    }
    
})

function submitAudio(e) {
    if (document.getElementById('newAudio')) {
        e.preventDefault()
        var file = new File([newBlob], "audioData", {type: 'audio/wav', lastModified: Date.now()})
        //var reader = new FileReader()

        //reader.onloadend = () => {
            //newData = reader.result.slice(22)
            //newFile = new File([newData], "audioData", {type: 'audio/wav', lastModified: Date.now()})
            console.log(file.size)
            var data = new FormData()
            data.append('file', file)
            data.append('id', document.querySelector('#post-id').value)

            fetch('/audioSave', {
                'method': 'POST',
                'body': data,
                'headers': {
                    'X-CSRF-TOKEN': token,
                }
                }).then(response => {
                    journalForm.removeEventListener('submit', submitAudio, true)
                    journalForm.submit()
                })
            }

            //reader.readAsDataURL(file)  
        //}
}

function startRecording() {
    if (document.getElementById('audio') || document.getElementById('audioLI')) {
        if (!confirm('Creating a new recording will delete your previous recording. Are you sure you wish to proceed?')) {
            return false
        }
    }
    navigator.mediaDevices.getUserMedia({audio: true, video: false}).then(stream => {
        recordButton.disabled = true
        stopButton.disabled = false
        recordingMessage.className = 'recording-message-visible'
        audioContext = new AudioContext()
        gumStream = stream
        input = audioContext.createMediaStreamSource(stream)
        recorder = new WebAudioRecorder(input, {
            workerDir: "js/",
            encoding: 'mp3',
        })
        recorder.onComplete = function(recorder, blob) {
            createDownloadLink(blob, recorder.encoding)
            recordButton.disabled = false
            stopButton.disabled = true
            recordingMessage.className = 'recording-message-invisible'
            gumStream.getAudioTracks()[0].stop()
            if (recorder.isRecording()) {
                recorder.finishRecording()
            }
        }
        recorder.setOptions({
            encodeAfterRecord: encodeAfterRecord
        })
        recorder.startRecording()
    }).catch( err => {
        console.log(err)
    })
    
}

function stopRecording() {
    recordButton.disabled = false
    stopButton.disabled = true
    recordingMessage.className = 'recording-message-invisible'
    
    gumStream.getAudioTracks()[0].stop()
    recorder.finishRecording()

}

function createDownloadLink(blob, encoding) {
    if (document.getElementById('audioLI')) {
        document.getElementById('audio-container').removeChild(document.getElementById('audioLI'))
    }
    newBlob = blob
    var url = URL.createObjectURL(blob)
    var au = document.createElement('audio')
    var li = document.createElement('li')
    li.setAttribute('style', 'padding:5px')
    li.id = "audioLI"
    var deleteButton = document.createElement('button')
    deleteButton.setAttribute('class', 'btn btn-danger')
    deleteButton.setAttribute('type', 'button')
    deleteButton.innerHTML = "Delete"
    deleteButton.id = "delete-recording"
    deleteButton.setAttribute('onclick', 'deleteRecording()')
    //var link = document.createElement('a')
    var div = document.getElementById('audio-container')
    var audioUrl = document.getElementById('audio-url')
    
    var audioDiv = document.createElement('div')
    audioDiv.setAttribute('style', 'display:flex;flex-direction:row;align-items:center')

    au.controls = true
    au.src = url
    au.id = 'newAudio'
    
    audioDiv.appendChild(au)
    audioDiv.appendChild(deleteButton)

    //link.href = url
    //link.download = new Date().toISOString() + "." + encoding
    //link.innerHTML = link.download

    audioUrl.value = new Date().toISOString() + "." + encoding

    li.appendChild(audioDiv)
    //li.appendChild(link)
    div.appendChild(li)
}

function deleteRecording() {
    var div = document.getElementById('audio-container')
    while (div.firstChild) {
        div.removeChild(div.firstChild)
    }
}

function deleteAudio() {
    if (!confirm('Are you sure you wish to permanently delete the recording from this entry?')) {
            return false
        }
    var data = new FormData()
    data.append('id', document.querySelector('#post-id').value)
    
    fetch('/audioDelete', {
        'method': 'POST',
        'body': data,
        'headers': {
            'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            let div = document.getElementById('post-audio')
            while (div.firstChild) {
                div.removeChild(div.firstChild)
            }
            document.getElementById('audio-message').innerHTML = "Your audio content has been deleted."
        })
}

function goBack() {
    window.history.back()
}

