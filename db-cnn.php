<?php

$error = false ;

try {
	$db = new PDO('mysql:host=localhost;dbname=********', '*********' , '*********' );
	
} catch ( PDOException $e) {
	$error = true ;
	echo 'waaaa no me has conectado e.e';
}
