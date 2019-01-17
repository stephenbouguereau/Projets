

<?php
//ajout d'une épreuve avec sa durée à la table comporter
header('Location: index.php');
require_once('assets/php/main.php');
$db = get_db();
$epreuve = $_REQUEST['epreuve'];
$bts = $_REQUEST['bts'];
$duree = $_REQUEST['duree'];
$sql = "INSERT INTO comporter (duree, idBts, idEpreuve) VALUES ('".$duree."','".$bts."','".$epreuve."');";
$db->query($sql);
?>







