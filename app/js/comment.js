// DOM elements
const commentDiv = document.getElementsByClassName('comment_div');

let form = commentDiv[0].getElementsByTagName("form");

form[0].addEventListener('submit', function(evt){
    console.log(evt.target.id.substr(0, 12));
    
    if (evt.target.id.substr(0, 12) !== 'comment_form') {
        console.log("RETURN OK");
        return ;
    }
    evt.preventDefault();
    let test = form[0].getElementsByClassName('comment_text')[0]
    
    if (test.value == '') {
        return ;
    }
    let error = sendRequestComment(test);
    test.value = '';
    if (error == '') {
        createNewDivComment();
    } else {
        window.location="/account/login"
    }

    // console.log(form[0]);
    // console.log("form submitted!");
})

function createNewDivComment() {
    newDiv = document.createElement('div');
    newDiv.innerHTML = 'New Comment Will be Here';
    commentDiv[0].appendChild(newDiv);
}

function sendRequestComment(elem) {
    let XHR = new XMLHttpRequest()
    let commentData = new FormData();

    var fulllId = elem.getAttribute('id');
    var photoId = fulllId.substr(13);

    // console.log(elem);
    // console.log("photoid:", photoId);
    // console.log(elem.value);

    let message = elem.value

    commentData.append('photo-id', photoId)
    commentData.append('comment', message)

    XHR.addEventListener("load", function(event) {
        // console.log("XHR loaded")
        // console.log("Like id is:", photoId)
        console.log('answer = > ', event.target.responseText)
        if (event.target.responseText != '') {
            return "error"
        }
        // resp_json = JSON.parse(event.target.responseText);
        // checkLikeIsPressed(resp_json, elem);
    })
    XHR.open("POST", '/comment');
    XHR.send(commentData)
}


// for (i=0; i<likeButton.length; i++) {
//     commentButton[i].addEventListener('click', function (e) {
//         if (e.target.className === 'like-img' || e.target.className === 'img-photo') {
//             sendRequest(this)
//         }
//         e.preventDefault()
//     })
// };



// function checkLikeIsPressed (resp_json, elem) {
//     let status = resp_json['like-pressed'];
//     let like_img = elem.getElementsByClassName('like-img')[0];


//     let number_likes = elem.getElementsByClassName('number-likes')[0]
//     let int_number = parseInt(number_likes.innerHTML)
//     let new_number

//     if (status === "true") {
//         new_number = int_number - 1
//         like_img.src = "/data/images/like.png"
//     } else {
//         new_number = int_number + 1
//         like_img.src = "/data/images/like_full.png"
//     }

//     number_likes.innerHTML = new_number.toString()
// }