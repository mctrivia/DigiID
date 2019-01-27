<?php
require_once(__DIR__.'/includes/autoload.php');

use DigiByte\DigiID;


$digiid=new DigiID();
$nonce = $digiid->generateNonce();
$digiid_uri = $digiid->buildURI('https://your_domain/digiid/callback.php', $nonce);

?>	
<html>
<body>
	<div id="login">
		<img id="login_digiid"></img>
	</div>
	
	
	
	<script src="js/xmr.min.js"></script>
	<script src="js/digiQR.min.js"></script>
	<script src="js/digiid.js"></script>
	<script>
	DigiID(<?php echo json_encode(array(
		//site defined variables
		"qrcode"=>	array(
			"id"=>	'login_digiid',	//id of img tag for login qr code
			"size"=>300,			//QR code dimensions in pixels
			"logo"=>6				//DigiQR logo style
		),
		"interval"=>5,				//number of seconds between rechecks
		
		//DigiID login variables do not alter
		"digiid"=>	$digiid_uri,
		"nonce"=>	$nonce
	));?>,document,window);
	</script>
</body>
</html>