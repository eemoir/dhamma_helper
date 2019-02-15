onmessage = () => {
    setTimeout(post, 4000)
}

function post() {
    postMessage('message received')
}