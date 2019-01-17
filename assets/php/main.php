<?php
//connexion a la basse de données
	function get_db() {
		$host='localhost';
		$uname = 'root';
		$pword = '';
		$database = 'bdvillay';
		$db = new mysqli($host,$uname,$pword,$database);
		if(mysqli_connect_error()) {
			die('Connection error no ('.mysqli_connect_errno().')'.mysqli_connect_errno());
		};
    $db->query("SET NAMES 'utf8'");
		return $db;
	}
?>
