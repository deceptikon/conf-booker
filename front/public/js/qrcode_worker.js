self.addEventListener('message', function(e) {
    const input = e.data;

    switch (input.cmd) {
        case 'init':
            init();
            break;
        case 'process':
            process(input);
            break;
        default:
            console.log('Unknown command for QRCode worker.');
            break;
    }
});

function init() {
    self.importScripts(
      'jsqrcode/src/grid.js',
      'jsqrcode/src/version.js',
      'jsqrcode/src/detector.js',
      'jsqrcode/src/formatinf.js',
      'jsqrcode/src/errorlevel.js',
      'jsqrcode/src/bitmat.js',
      'jsqrcode/src/datablock.js',
      'jsqrcode/src/bmparser.js',
      'jsqrcode/src/datamask.js',
      'jsqrcode/src/rsdecoder.js',
      'jsqrcode/src/gf256poly.js',
      'jsqrcode/src/gf256.js',
      'jsqrcode/src/decoder.js',
      'jsqrcode/src/qrcode.js',
      'jsqrcode/src/findpat.js',
      'jsqrcode/src/alignpat.js',
      'jsqrcode/src/databr.js',
    )
}

function process(input) {
    qrcode.width = input.width;
    qrcode.height = input.height;
    qrcode.imagedata = input.imageData;

    let result = false;
    try {
      console.warn("worker qr: ", qrcode);
      result = qrcode.process();
      console.log("worker qr scan res: ", result);
    } catch (e) {
      console.error('worker error: ', e);
    }

    postMessage(result);
}
