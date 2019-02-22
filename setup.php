<?php
require_once(__DIR__.'/includes/autoload.php');

use MCTrivia\Database;

try {
	$db = new Database();
	$db->query("CREATE TABLE `users` (
	  `address` binary(20) NOT NULL,
	  `nonce` binary(16) DEFAULT NULL,
	  `lastSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$db->query("ALTER TABLE `users`
	  ADD PRIMARY KEY (`address`),
	  ADD UNIQUE KEY `hash` (`address`);");
	echo "Delete setup.php";
} catch (\Exception $e) {
	echo "Must setup /includes/config/MCTrivia_Database.php";
}
