function removeElement(elem) {
  return elem.parentNode.removeChild(elem);
}

// preload shutter audio clip
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '/data/sounds/shutter.ogg' : '/data/sounds/shutter.mp3';

const cameraButton = document.getElementById('camera-button');
const cameraButtonTakeSnap = document.getElementById('camera-button-take-snap');
const resultsDiv = document.getElementById('results');

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
  cameraButton.style.visibility = "none";
  cameraButtonTakeSnap.style.visibility = "visible";
}

Webcam.attach( '#my_camera' );

function hide_results() {
  cameraButton.style.visibility = "visible";
  cameraButtonTakeSnap.style.visibility = "none";
}

function take_snapshot() {
  // take snapshot and get image data
  Webcam.snap( function(data_uri) {

    if (resultsDiv.style.display == "none") {
      resultsDiv.style.display = "block";
      resultsDiv.innerHTML = 
      '<img src="'+data_uri+'"/>' +
      '<button class=\"btn blue\">Stickers</button>' +
      '<button class=\"btn green\">Upload now</button>';
    } else {
      resultsDiv.style.display = "none";
      hide_results();
    }
  });

}