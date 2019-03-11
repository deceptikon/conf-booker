import React from 'react';
import LinearProgress from '@material-ui/core/LinearProgress';


const styles = {
  container: {
    maxWidth: '600px',
    margin: '0 auto',
  },
  video: {
    width: '100%',
  }
};

class QrReader extends React.Component {

  currentDeviceId = null;
  snapshotSquare = null;
  snapshotCanvas = null;
  snapshotContext = null;
  qrcodeWorker = null;
  video = null;
  overlay = null;

  componentDidMount() {
    this.init();
  }

  init = () => {
    if (!('mediaDevices' in navigator &&
      'getUserMedia' in navigator.mediaDevices &&
      'Worker' in window)) {
      alert('Sorry, your browser is not compatible with this app.');
      alert(navigator.mediaDevices);
    }
    console.log("Init Success", this.snapshotCanvas);
    this.initVideoStream();
    this.snapshotContext = this.snapshotCanvas.getContext('2d');
    console.log(">>>", this.snapshotContext);
    this.qrcodeWorker = new Worker("./js/qrcode_worker.js");
    this.qrcodeWorker.postMessage({cmd: 'init'});
    this.qrcodeWorker.addEventListener('message', this.showResult);
  }

  showResult = (e) => {
      const resultData = e.data;
      // open a dialog with the result if found
      if (resultData !== false) {
          navigator.vibrate(200); // vibration is not supported on Edge, IE, Opera and Safari
        //disableUI();
        console.warn("RESUULT", resultData);

        //     try {
        //         url = new URL(resultData);
        //         let linkToResult = document.createElement('a');
        //         linkToResult.href = url;
        //         linkToResult.innerText = resultData;
        //         resultContainer.appendChild(linkToResult);

        //         resultSearchGo.href = url;
        //         resultSearchGo.innerText = "Go";
        //     } catch (e) {
        //         resultContainer.innerText = resultData;

        //         resultSearchGo.href = "https://www.google.com/search?q=" + encodeURIComponent(resultData);
        //         resultSearchGo.innerText = "Search";
        //     }

        //     resultDialog.showModal();
      } else {
          // if not found, retry
          this.scanCode();
      }
  }

  calculateSquare = () => {
    // get square of snapshot in the video
    let snapshotSize = this.overlay.offsetWidth;
    this.snapshotSquare = {
      'x': ~~((this.video.videoWidth - snapshotSize)/2),
      'y': ~~((this.video.videoHeight - snapshotSize)/2),
      'size': ~~(snapshotSize)
    };

    this.snapshotCanvas.width = this.snapshotSquare.size;
    this.snapshotCanvas.height = this.snapshotSquare.size;
  }

  scanCode = (wasSuccess) => {
    setTimeout(() => {
      console.log("scanCode: ");
          // if (flipCameraButton.disabled) {
          //     // terminate this loop
          //     loadingElement.style.display = "none";
          //     return;
          // }

            // show loading
          //loadingElement.style.display = "block";

            // capture current snapshot
          this.snapshotContext.drawImage(
            this.video, 
            this.snapshotSquare.x, 
            this.snapshotSquare.y, 
            this.snapshotSquare.size, 
            this.snapshotSquare.size,
            0, 
            0, 
            this.snapshotSquare.size, 
            this.snapshotSquare.size
          );
          const imageData = this.snapshotContext.getImageData(
            0, 
            0, 
            this.snapshotSquare.size, 
            this.snapshotSquare.size
          );

            // scan for QRCode
          console.error("SCAN:", imageData);
          this.qrcodeWorker.postMessage({
            cmd: 'process',
            width: this.snapshotSquare.size,
            height: this.snapshotSquare.size,
            imageData: imageData
          });
        }, wasSuccess ? 2000 : 120);
    }

  initVideoStream = () => {
      let config = {
          audio: false,
          video: {}
      };
      config.video = this.currentDeviceId ? {deviceId: this.currentDeviceId} : {facingMode: "environment"};

      this.stopStream();

    navigator.mediaDevices.getUserMedia(config).then(stream => {
      console.warn("!!!!", this);
      this.video.srcObject = stream;
      this.video.oncanplay = () => {
          console.warn("WORK", this);
          //flipCameraButton.disabled = false;
          this.calculateSquare();
          this.scanCode();
        };
    }).catch(function (error) {
        alert(error.name + ": " + error.message);
    });
  }

  stopStream = () => {
    // disableUI();

    if (this.video && this.video.srcObject) {
        this.video.srcObject.getTracks()[0].stop();
    }
  }

  render() {
    return (
      <div className="qr-reader" style={styles.container}>
        <LinearProgress variant="query" />
        <video id="camera" autoPlay ref={ref => this.video = ref} style={styles.video}>
          You need a camera in order to use this app.
        </video>
        <div id="snapshotLimitOverlay" ref={ ref => this.overlay = ref }>
        <div id="about">
            <h4>QR Code Scanner</h4>
            <p>
                This is a lightweight progressive web app for scanning QR Codes offline.<br />
                You'll need at least a camera and a compatible browser.<br />
                Source code is available on GitHub (Minishlink/pwa-qr-code-scanner), click the <strong>About</strong> button.
            </p>
        </div>
    </div>
    <canvas id="snapshot" ref={ref => this.snapshotCanvas = ref}></canvas>
    <button id="flipCamera" type="button" className="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Flip Camera</button>
    <a id="aboutButton" type="button" href="https://github.com/Minishlink/pwa-qr-code-scanner" className="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">About</a>

      
      </div>
    ); 
  }
}

export default QrReader;
