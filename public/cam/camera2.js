const OpenCamRe = document.getElementById("pushBtn")
const snapInput = document.getElementById("snapInput2")
const RepeatPic = document.getElementById('RepeatPic2')
const results = document.getElementById("results2")
const my_camera = document.getElementById("my_camera2")
const PicCap = document.getElementById("PicCap2")
const avatarProfile = document.getElementById("avatarProfile")
const nextBtn = document.getElementById("nextBtn")
const avatarVoter = document.getElementById("avatarVoter")

function Rep_snapshot2() {
    RepeatPic.style.display = "none";
    results.style.display = "none";
    snapInput.style.display = "block";
    my_camera.style.display = "block";
    startWebcam();
}

OpenCamRe.addEventListener("click", function() {
    RepeatPic.style.display = "none"
    results.style.display = "none"
    avatarProfile.style.display = "none"
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

function take_snapshot2() {
   Webcam.snap( function(data_uri) {
       PicCap.src = data_uri
       console.log(PicCap.src)
       avatarVoter.value = data_uri
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
            alert("You are already vote");
            avatarVoter.value = "";
        }
        else if (detections.length>1){
            alert("More than one face detect, Please repeat another picture");
            avatarVoter.value = "";
        }
        else{
            RepeatPic.style.display = "none";
            alert("Identity confirm Successfully");
            avatarVoter.value = PicCap.src;
        }

        
        // results.forEach((result, i) => {
        // const box = resizedDetections[i].detection.box
        // const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
        // drawBox.draw(canvas)
        // })
    })

}

// function loadLabeledImages() {
    
//     return Promise.all(
//         avatarss.map(async avatar => {
//             const descriptions = []
//             for (let i = 0; i <= 1; i++) {
//                 const img = await faceapi.fetchImage(avatarProfile.src)
//                 const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
//                 descriptions.push(detections.descriptor)
//             }

//             return new faceapi.LabeledFaceDescriptors(avatarProfile.src, descriptions)
//         })
//     )
// }
function loadLabeledImages() {
    
    return Promise.all(
        avatarsVoters.map(async avatarsVoter => {
            const descriptions = []
            for (let i = 0; i <= avatarsVoters.length; i++) {
                const img = await faceapi.fetchImage(`avatarVoter/${avatarsVoter}`)
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                descriptions.push(detections.descriptor)
            }

            return new faceapi.LabeledFaceDescriptors(avatarsVoter, descriptions)
        })
    )
}