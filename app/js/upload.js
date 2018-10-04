const defaultFileUploadButton = document.getElementById('default_upload_file_button');
const fileUploadButton = document.getElementById('upload_file_button');
const sendFileButton = document.getElementById('send_file_button');
const form = document.getElementById('upload_form');
var base64img;

fileUploadButton.onclick = function() {
    defaultFileUploadButton.click();
};

function createNewDivMessage(message) {
    if (document.getElementById('message_div')) {
        document.getElementById('message_div').innerHTML = message;
    } else {
        newDiv = document.createElement('div');
        newDiv.setAttribute('id', 'message_div');
        newDiv.innerHTML = message;
        form.appendChild(newDiv);
    }
}

sendFileButton.addEventListener('click', function (e) {
    e.preventDefault();
    if (defaultFileUploadButton.value == '') {
        createNewDivMessage("No file selected");
        return ;
    }

    file = defaultFileUploadButton.files[0];

    // Check the file type.
    if (!file.type.match('image.*')) {
        createNewDivMessage(file.name + ' => file is not an image!');
        return ;
    }
    sendFileButton.setAttribute('value', ". . .");
    sendFileButton.setAttribute('class', "btn blue");

    encodeImageFileAsURL(file);
    
    setTimeout( function () {
        sendFileButton.setAttribute('value', "Send");
        sendFileButton.setAttribute('class', "btn green");
        createNewDivMessage("Sent succesfully!");
        setTimeout("window.location='/photo/'", 1500);
    }, 2000);
    defaultFileUploadButton.value = "";
})

function encodeImageFileAsURL(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    
    reader.onloadend = function() {
        base64img = reader.result;
        sendRequestUpload(file);
    }
}

function sendRequestUpload(file) {
    let XHR = new XMLHttpRequest()
    let fileData = new FormData();

    createNewDivMessage(file.name);
    fileData.append('base64img', base64img)

    XHR.addEventListener("load", function(event) {
        // console.log("XHR loaded")
        // console.log("Like id is:", photoId)
        console.log('answer = > ', event.target.responseText)
        
        if (event.target.responseText === "error") {
            alert("Something goes ne tak.");
            window.location="/photo";
            return;
        }

        // resp_json = JSON.parse(event.target.responseText);
    })
    XHR.open("POST", '/photo/upload/');
    XHR.send(fileData)
  }
