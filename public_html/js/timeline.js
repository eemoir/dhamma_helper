var token = document.querySelector('input[name="_token"]').value

function toggleFriend(e) {
    friends = document.getElementsByName('friend')
    let queryString = 'https://dhammahelper.com/timeline?friends='
    friends.forEach(node => {
        if (node.checked) {
            queryString+=`${node.value},`
        }
    })
    let query = queryString.slice(0, queryString.length-1)
    console.log(query)
    window.location.replace(query)
}