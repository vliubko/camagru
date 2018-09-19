// DOM elements
const likeButton = document.getElementsByClassName('likes');

//

for (i=0; i<likeButton.length; i++) {
    likeButton[i].addEventListener('click', function (e) {
        var likeFullId = this.getAttribute('id');
        var likeId = likeFullId.substr(9);
        // pressLike(likeId)
        sendRequest(this)
        e.preventDefault()
    })
};

// function pressLike(likeId) {
//     sendRequest(likeId);
// }

function sendRequest(elem) {
    let XHR = new XMLHttpRequest()
    let likeData = new FormData();

    var likeFullId = elem.getAttribute('id');
    var likeId = likeFullId.substr(9);

    likeData.append('like-id', likeId)

    XHR.addEventListener("load", function(event) {
        console.log("XHR loaded")
        console.log("Like id is:", likeId)
        console.log('answer = > ', event.target.responseText)
        elem.src = "/data/images/like_full.png"
    })
    XHR.open("POST", 'like');
    XHR.send(likeData)
  }