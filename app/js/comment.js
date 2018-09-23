// DOM elements
const newCommentDiv = document.getElementsByClassName('new_comment_div');

for (i=0; i<newCommentDiv.length; i++) {
    newCommentDiv[i].addEventListener('submit', function(evt){
        if (evt.target.id.substr(0, 12) !== 'comment_form') {
            return ;
        }
        evt.preventDefault();
        
        let form = this.getElementsByTagName("form");
        let commentText = form[0].getElementsByClassName('comment_text')[0]
        if (commentText.value == '') {
            return ;
        }
        sendRequestComment(commentText, this);
        commentText.value = '';
    })
}

function createNewDivComment(author, message, photoId) {
    newDiv = document.createElement('div');
    newDiv.innerHTML = author + ' ' + message;

    fullId = 'comments_div_' + photoId;
    commentsDiv = document.getElementById(fullId)
    commentsDiv.appendChild(newDiv);
}

function sendRequestComment(elem) {
    let XHR = new XMLHttpRequest()
    let commentData = new FormData();


    var fulllId = elem.getAttribute('id');
    var photoId = fulllId.substr(13);

    let message = elem.value

    commentData.append('photo-id', photoId)
    commentData.append('comment', message)

    XHR.addEventListener("load", function(event) {
        // console.log(event.target.responseText);
        resp_json = JSON.parse(event.target.responseText);
        if (resp_json['error']) {
            window.location="/account/login"
        } else {
            createNewDivComment(resp_json['username'], message, photoId);
        }
    })
    XHR.open("POST", '/comment');
    XHR.send(commentData)
    return ;
}