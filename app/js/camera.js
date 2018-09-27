function removeElement(elem) {
  return elem.parentNode.removeChild(elem);
}

// preload shutter audio clip
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '/data/sounds/shutter.ogg' : '/data/sounds/shutter.mp3';

const cameraButton = document.getElementById('open-camera-button');
const cameraButtonTakeSnap = document.getElementById('camera-button-take-snap');
const resultsDiv = document.getElementById('results');
const spinner = document.getElementById('spinner');
const stickersDiv = document.getElementById('stickers-div');

var base64imgstring;

Webcam.set({
  // live preview size
  width: 480,
  height: 360,
  
  // // device capture size
  // dest_width: 640,
  // dest_height: 480,
  
  // final cropped size
  crop_width: 360,
  crop_height: 360,
  
  // format and quality
  image_format: 'jpeg',
  jpeg_quality: 100
});

function attach_cam() {
  spinner.style.display = "block";
  setTimeout( function() { 
    spinner.style.display = "none";
    cameraButtonTakeSnap.setAttribute('onClick', 'take_snapshot()');
    cameraButtonTakeSnap.removeAttribute('formmethod');
    cameraButtonTakeSnap.removeAttribute('href');
  } , 900);
  Webcam.attach( '#my_camera' );
  cameraButtonTakeSnap.innerHTML = "Take snapshot";
  removeElement(cameraButton);
}

function take_snapshot() {
  // take snapshot and get image data
  Webcam.snap( function(data_uri) {

    // snapshot taken
    if (resultsDiv.style.display == "none") {
      cameraButtonTakeSnap.innerHTML = "Reload cam";
      resultsDiv.style.display = "block";
      base64imgstring = data_uri;
      resultsDiv.innerHTML = 
      '<img src="'+data_uri+'"/>' +
      '<button class=\"btn blue\" onClick=\"show_stickers_div()\" id="stickers_button">Stickers</button>' +
      '<button id="upload_photo_button" class=\"btn green\" onClick=\"sendRequestUploadFromCamera(base64imgstring)\">Upload now</button>';
    } else 
    // camera reloaded
    {
      hide_stickers_div();
      resultsDiv.style.display = "none";
      cameraButtonTakeSnap.innerHTML = "Take snapshot";
    }
  });
}

function hide_stickers_div() {
  stickersDiv.style.visibility = "hidden";
}

function show_stickers_div() {
    stickersButton = document.getElementById('stickers_button');
    stickersDiv.style.visibility = "visible";
}

function sendRequestUploadFromCamera(base64img) {
  let XHR = new XMLHttpRequest()
  let fileData = new FormData();

  fileData.append('base64img', base64img)

  XHR.addEventListener("load", function(event) {
      // console.log("XHR loaded")
      // console.log("Like id is:", photoId)
      console.log('answer = > ', event.target.responseText)
      
      if (event.target.responseText === "error") {
          alert("Something goes ne tak.");
          return;
      }
      newDiv = document.createElement('div');
      newDiv.setAttribute('id', 'message_div_from_cam');
      newDiv.innerHTML = "Photo uploaded!";
      resultsDiv.appendChild(newDiv)
      document.getElementById('upload_photo_button').removeAttribute('onClick');

      setTimeout(function(){
        location = ''
      },1000)

      // resp_json = JSON.parse(event.target.responseText);
  })
  XHR.open("POST", '/photo/upload/');
  XHR.send(fileData)
}