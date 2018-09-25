// DOM elements
const passwordDiv = document.getElementsByClassName('password-div')[0];

const passwords = passwordDiv.getElementsByTagName('input');
const oldPwd = passwords[0];
const newPwd = passwords[1];

passwordDiv.addEventListener('submit', function(evt) {
    evt.preventDefault();
    if (evt.target.id !== 'change-password-form') {
        return ;
    }
    sendRequestComment(oldPwd, newPwd);
    oldPwd.value = '';
    newPwd.value = '';
})

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

function createResponseDiv(resp_json, elem) {
    currentDiv = document.getElementById('responsePasswordChange');

    if (currentDiv) {
        currentDiv.innerHTML = resp_json['message'];
    } else {
        newDiv = document.createElement('div');
        newDiv.setAttribute("id", "responsePasswordChange");
        newDiv.innerHTML = resp_json['message'];
    
        passwordDiv.appendChild(newDiv);
    }
}

function sendRequestComment(oldPwd, newPwd) {
    let XHR = new XMLHttpRequest()
    let commentData = new FormData();

    commentData.append('oldPwd', oldPwd.value)
    commentData.append('newPwd', newPwd.value)

    XHR.addEventListener("load", function(event) {
        resp_json = JSON.parse(event.target.responseText);

        createResponseDiv(resp_json);
        if (resp_json['success'] == "OK") {
            setTimeout("window.location='/account/settings'", 1500);
        }
    })
    XHR.open("POST", '/account/changePassword');
    XHR.send(commentData)
    return ;
}