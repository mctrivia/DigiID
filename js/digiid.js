var DigiID=function(config,document,window,undefined) {
	//Handle requests
	xmr.setMax(5);

	//login digiid
	var digiQRmessage=config['digiid'];
	var qrcode=config['qrcode'];
	
	if (digiQRmessage.legnth>127) console.error("Need to shorten uri must be less then 127 bytes currently: " +digiQRmessage.legnth)
	document.getElementById(qrcode['id']).src=DigiQR.id(digiQRmessage,qrcode['size'],qrcode['logo'],1);
	setInterval(function() {
		xmr.getJSON('digiid/ajax.php?nonce='+config['nonce']).then(function(reqData){
            if(reqData!=false) {
				window.location = 'user.php';
            }
        });
    }, config['interval']*1000);
}