<?php
//fonction pour ajouter un profs qui enseigne un bts dans la table enseigner
session_start();

require_once('assets/php/main.php');
$db = get_db();
$prof = $_REQUEST['prof'];
$bts = $_REQUEST['bts'];
$sql = "INSERT INTO enseigner (idProf, idBts) VALUES ('".$prof."','".$bts."');";
$db->query($sql);
echo "done";
?>
