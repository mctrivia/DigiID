<?php

session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: index.php');
	exit();
}
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>DigiID</title>
</head>
<body>

<div class="container">
    <div class="tab-content">
        <div class="tab-pane">
            <div class="spacer40"></div>
            <h3>Hex hash that is recorderd</h3>
            <p><?php echo $_SESSION['user_id']; ?></p>
			<p>*Why hex hash and not DigiByte address?<br>
			DigiByte addresses are made up of 1 byte header, 20 byte public key hash, and 4 byte check sum that is then base58 encoded into an address<br>
			This works well for human readability but is ineficient for DigiID usage since only the 20byte hash is unique.  To save space this library uses the hash instead of the DigiByte Address</p>
            <div class="spacer40"></div>
        </div>
    </div>
</div>

</body>
</html>