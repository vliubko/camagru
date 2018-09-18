// DOM elements
const likeButton = document.getElementById('like-but')

// Like button event
likeButton.addEventListener('click', function (e) {
    pressLike()
    e.preventDefault()
})

function pressLike() {
    likeId = 2
    sendRequest(likeId);
}

function sendRequest(likeId) {
    let XHR = new XMLHttpRequest()
    let likeData = new FormData();

    likeData.append('like-id', likeId)

    XHR.addEventListener("load", function(event) {
        console.log("XHR loaded")
        console.log('an = > ', event.target.responseText)
    })
    XHR.open("POST", 'like');
    XHR.send(likeData)
  }