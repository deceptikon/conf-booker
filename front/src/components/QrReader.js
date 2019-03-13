import React from 'react';
import LinearProgress from '@material-ui/core/LinearProgress';


const styles = {
  container: {
    maxWidth: '600px',
    margin: '0 auto',
    position: 'relative',
  },
  camera: {
    /*  position: 'fixed',
    top: '50%',
    left: '50%',
    minWidth: '100%',
    minHeight: '100%',
    width: 'auto',
    height: 'auto',
    zIndex: '-100',
    transform: 'translateX(-50%) translateY(-50%)',*/
    width: '100%',
  },
  overlay: {
    position: 'absolute',
    top: '50%',
    left: '50%',
    width: '200px',
    height: '200px',
    transform: 'translateX(-50%) translateY(-50%)',
    textAlign: 'center',
    border: '2px solid crimson',
    background: '#000',
    opacity: '0.2',
  },
  snapshot: {
    display: 'none',
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
  timer = null;

  componentDidMount() {
    this.init();
  }

  componentWillUnmount(){
    clearTimeout(this.timer);
    this.stopStream();
  }

  init = () => {
    if (!('mediaDevices' in navigator &&
      'getUserMedia' in navigator.mediaDevices &&
      'Worker' in window)) {
      alert('Sorry, your browser is not compatible with this app.');
      alert(navigator.mediaDevices);
    }
    this.initVideoStream();
    this.snapshotContext = this.snapshotCanvas.getContext('2d');
    this.qrcodeWorker = new Worker("./js/qrcode_worker.js");
    this.qrcodeWorker.postMessage({cmd: 'init'});
    this.qrcodeWorker.addEventListener('message', this.showResult);
  }

  showResult = (e) => {
      console.log("showResult: ", e);
      const resultData = e.data;
      // open a dialog with the result if found
      if (resultData !== false) {
          navigator.vibrate(200); // vibration is not supported on Edge, IE, Opera and Safari
        //disableUI();
        console.warn("RESULT", resultData);
        this.props.successHandler(resultData);
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
    this.timer = setTimeout(() => {
      // capture current snapshot
      try {
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
        this.qrcodeWorker.postMessage({
          cmd: 'process',
          width: this.snapshotSquare.size,
          height: this.snapshotSquare.size,
          imageData: imageData
        });
      } catch(e) {
        console.error("---> scanCode error: ", e);
      }
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
      this.video.srcObject = stream;
      this.video.oncanplay = () => {
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
        <LinearProgress variant="query" color="secondary" />
        <video id="camera" style={styles.camera} autoPlay ref={ref => this.video = ref}>
          You need a camera in order to use this app.
        </video>
        <div id="snapshotLimitOverlay" style={styles.overlay} ref={ ref => this.overlay = ref }></div>
        <canvas id="snapshot" style={styles.snapshot} ref={ref => this.snapshotCanvas = ref}></canvas>
      </div>
    ); 
  }
}

export default QrReader;
