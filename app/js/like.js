// DOM elements
const likeButton = document.getElementsByClassName('photo');

for (i=0; i<likeButton.length; i++) {
    likeButton[i].addEventListener('click', function (e) {
        if (e.target.className === 'like-img' || e.target.className === 'img-photo') {
            sendRequest(this)
        }
        e.preventDefault()
    })
};


function sendRequest(elem) {
    let XHR = new XMLHttpRequest()
    let likeData = new FormData();

    var likeFullId = elem.getAttribute('id');
    var photoId = likeFullId.substr(6);

    likeData.append('photo-id', photoId)

    XHR.addEventListener("load", function(event) {
        // console.log("XHR loaded")
        // console.log("Like id is:", photoId)
        // console.log('answer = > ', event.target.responseText)
        if (event.target.responseText === "") {
            window.location="/account/login"
            return;
        }
        resp_json = JSON.parse(event.target.responseText);
        checkLikeIsPressed(resp_json, elem);
    })
    XHR.open("POST", 'like');
    XHR.send(likeData)
  }

function checkLikeIsPressed (resp_json, elem) {
    let status = resp_json['like-pressed'];
    let like_img = elem.getElementsByClassName('like-img')[0];


    let number_likes = elem.getElementsByClassName('number-likes')[0]
    let int_number = parseInt(number_likes.innerHTML)
    let new_number

    if (status === "true") {
        new_number = int_number - 1
        like_img.src = "/data/images/like.png"
    } else {
        new_number = int_number + 1
        like_img.src = "/data/images/like_full.png"
    }

    number_likes.innerHTML = new_number.toString()
}