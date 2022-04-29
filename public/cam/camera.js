const OpenCamRe = document.getElementById("OpenCamRe")
const snapInput = document.getElementById("snapInput")
const RepeatPic = document.getElementById('RepeatPic')
const results = document.getElementById("results")
const my_camera = document.getElementById("my_camera")
const avatar = document.getElementById("avatar")
const registerModal =document.getElementById("registerModal")
const PicCap = document.getElementById("PicCap")


function Rep_snapshot() {
    RepeatPic.style.display = "none";
    results.style.display = "none";
    snapInput.style.display = "block";
    my_camera.style.display = "block";
    startWebcam();
}

OpenCamRe.addEventListener("click", function() {
    RepeatPic.style.display = "none"
    results.style.display = "none"
    startWebcam()
});

function startWebcam(){
    Webcam.set({
        width: 380,
        height: 285,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( my_camera );
}


function take_snapshot() {
   Webcam.snap( function(data_uri) {
       PicCap.src = data_uri
       console.log(PicCap.src)
    } );
    Webcam.reset()
    my_camera.style.display = "none"
    snapInput.style.display = "none"
    results.style.display = "block"
    RepeatPic.style.display = "block"
}

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('cam/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('cam/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('cam/models')
]).then(start)

async function start() {
    
    console.log("loaded")

    const labeledFaceDescriptors = await loadLabeledImages()
    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
    
    let canvas

    snapInput.addEventListener('click', async () => {

        // image = await faceapi.bufferToImage(imageUpload)
        
        canvas = faceapi.createCanvasFromMedia(PicCap)

        const displaySize = { width: PicCap.width, height: PicCap.height }

        faceapi.matchDimensions(canvas, displaySize)

        const detections = await faceapi.detectAllFaces(PicCap).withFaceLandmarks().withFaceDescriptors()
        
        const resizedDetections = faceapi.resizeResults(detections, displaySize)

        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
        
        console.log(results)
        console.log(results[0]._distance)

        if(results[0]._distance<0.6){
            avatar.value = "";
            alert("You are already registered");
        }
        else if (detections.length>1){
            avatar.value = "";
            alert("More than one face detect, Please repeat another picture");
        }
        else{
            avatar.value = PicCap.src ;
            alert("Picture taken successfully");
            console.log(avatar.value);
        }

        
        // results.forEach((result, i) => {
        // const box = resizedDetections[i].detection.box
        // const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
        // drawBox.draw(canvas)
        // })
    })

}

function loadLabeledImages() {
    
    return Promise.all(
        avatarss.map(async avatar => {
            const descriptions = []
            for (let i = 0; i <= avatarss.length; i++) {
                const img = await faceapi.fetchImage(`avatar/${avatar}`)
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                descriptions.push(detections.descriptor)
            }

            return new faceapi.LabeledFaceDescriptors(avatar, descriptions)
        })
    )
}