<?php
/*
Copyright 2014 Daniel Esteban

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
require_once(dirname(__DIR__).'/includes/autoload.php');
use DigiByte\DigiID;
use MCTrivia\Database;

$digiid = new DigiID();
$dao = new Database();

$variables = $_POST;
$post_data = json_decode(file_get_contents('php://input'), true);
// SIGNED VIA PHONE WALLET (data is send as payload)
if($post_data!==null) {
    $variables = $post_data;
}

//check if valid signature
if (!$digiid->isMessageSignatureValidSafe(@$variables['address'], @$variables['signature'], @$variables['uri'])) {
	header("HTTP/1.0 400 Bad Request");die();	//lets wallet know things failed
}

//check if nonce is in database
$nonce = $digiid->extractNonce($variables['uri']);
	
//decode address to 20byte hexdec
$address=bin2hex(substr($digiid->base58check_decode($variables['address']),1));
	
//update database
$query='INSERT INTO `users` (`address`, `nonce`) VALUES (unhex(?),unhex(?)) ON DUPLICATE KEY UPDATE `nonce`=unhex(?)';
$stmt=$dao->prepare($query);
$stmt->bind_param("sss",$address,$nonce,$nonce);
$stmt->execute();

//return data to phone
$data = [ 'address' => $variables['address'], 'nonce' => $nonce ];
header('Content-Type: application/json');
echo json_encode($data);
