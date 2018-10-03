// DOM elements
const newCommentDiv = document.getElementsByClassName('new_comment_div');
var nCount = 0;

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

function htmlspecialchars(str) {
    if (typeof(str) == "string") {
     str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
     str = str.replace(/"/g, "\"");
     str = str.replace(/'/g, "&#039;");
     str = str.replace(/</g, "<");
     str = str.replace(/>/g, ">");
     }
    return str;
}

function createNewDivComment(author, message, photoId) {
    newDiv = document.createElement('div');
    newDiv.innerHTML = author + ' ' + message;

    fullId = 'comments_div_' + photoId;
    commentsDiv = document.getElementById(fullId)
    commentsDiv.appendChild(newDiv);
}

function createDivViewAllComments(photoId) {
    if (nCount > 2) {
        return ;
    }
    let newDiv = document.createElement('div');

    var a = document.createElement('a');
    var linkText = document.createTextNode("View all comments");

    a.appendChild(linkText);
    a.title = "View all comments";
    a.href = "/photo/" + photoId;

    newDiv.appendChild(a);

    fullId = 'comments_div_' + photoId;
    commentsDiv = document.getElementById(fullId)
    
    commentsDiv.appendChild(newDiv);
}

function sendRequestComment(elem) {
    let XHR = new XMLHttpRequest()
    let commentData = new FormData();


    var fulllId = elem.getAttribute('id');
    var photoId = fulllId.substr(14);

    let message = htmlspecialchars(elem.value)

    let viewAllComments = document.getElementsByClassName("viewAllComments-div-" + photoId)[0];

    commentData.append('photo-id', photoId)
    commentData.append('comment', message)

    XHR.addEventListener("load", function(event) {
        console.log(event.target.responseText);
        resp_json = JSON.parse(event.target.responseText);
        if (resp_json['error']) {
            window.location="/account/login"
        } else if (nCount > 1) {
            createDivViewAllComments(photoId);
            nCount += 1;
        } else if (viewAllComments) {
            return ;
        } else {
            nCount += 1;
            createNewDivComment(resp_json['username'], message, photoId);
        }
        setTimeout(window.location.reload.bind(window.location), 2000);
    })
    XHR.open("POST", '/comment');
    XHR.send(commentData)
    return ;
}