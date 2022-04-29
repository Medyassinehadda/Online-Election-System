
var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var btnOpenCam = document.getElementById('btnOpenCam');
var snap = document.getElementById("snap");
var TakeAnotherPicture = document.getElementById('TakeAnotherPicture');

TakeAnotherPicture.style.display = "none";
snap.style.display = "none";

TakeAnotherPicture.addEventListener("click", function() {
  startWebcam();
});

function startWebcam(){

  if(video.style.display = "none"){ 
    video.style.display = "block";
  }
  
  if(snap.style.display = "none"){
    snap.style.display = "block";
  }

  if(TakeAnotherPicture.style.display = "block"){ 
    TakeAnotherPicture.style.display = "none";
  }

  if(btnOpenCam.style.display = "block"){
    btnOpenCam.style.display = "none";
  }

  if(canvas.style.display = "block"){
    canvas.style.display = "none";
  }

    navigator.mediaDevices.getUserMedia({
     video: true
   })
   .then(stream => {
     window.localStream = stream;
     video.srcObject = stream;
     console.log("Video On");
   })
   .catch((err) => {
     console.log(err);
   });

};

// Trigger photo take
snap.addEventListener("click", function() {
  const x = context.drawImage(video, 0, 0, 600, 400);
  console.log(x);
  vidOff();
});

function vidOff() {
  localStream.getVideoTracks()[0].stop();
  video.src = '';

  video.style.display = "none";
  snap.style.display = "none";
  canvas.style.display = "block";
  TakeAnotherPicture.style.display = "block";
  console.log("Video off");
};
