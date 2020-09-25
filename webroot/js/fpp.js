function uploadVideo(chunks) {
	let videoBlob = new Blob(chunks, {type: 'video/webm'});
	let formData = new FormData();
	formData.append("video", videoBlob);

	let request = new XMLHttpRequest();
	request.onreadystatechange = () => {
		if (request.readyState === 4) {
			console.log(request.response);
		}
	};
	request.open("POST", "/foi_proctoring_project/users/upload");
	request.send(formData);
}

window.onload = () => {

	const btnRecord = document.getElementById("record-button");
	const btnStop = document.getElementById("stop-button");
	const video = document.getElementById("video");
	
	let mediaRecorder = null;
	let chunks = [];
	
	
	var displayMediaOptions = {
		video: {
			cursor: "always",
			displaySurface: "browser"
		},
		audio: false
	};
	
	btnRecord.addEventListener("click", () => {
		navigator.mediaDevices.getDisplayMedia(displayMediaOptions)
			.then(stream => {
				video.srcObject = stream;
				mediaRecorder = new MediaRecorder(stream, { mimeType: "video/webm" });
				
				mediaRecorder.ondataavailable = (e) => {
					chunks.push(e.data);
				};
				
				mediaRecorder.onstop = () => {
					uploadVideo(chunks);
					chunks = [];
				};
				
				mediaRecorder.start();
			})
			.catch(error => console.log(`Error: ${error}`));
	});
	
	btnStop.addEventListener("click", () => {
		let tracks = video.srcObject.getTracks();
		tracks.forEach(track => track.stop());
		video.srcObject = null;
		if (mediaRecorder !== null) {
			mediaRecorder.stop();
		}
	});

};