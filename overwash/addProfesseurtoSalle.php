<?php

//fonction pour ajouter une salle ajoutée à une épreuve dans la table occuper et comporter
require_once('assets/php/main.php');


$db = get_db();
$salle = $_REQUEST['salle'];
$bts = $_REQUEST['bts'];
$epreuve = $_REQUEST['épreuve'];
$date = $_REQUEST['date'];
$duree = $_REQUEST['duree'];

$creneau = 1;
$etat = null;




$sql2 = "INSERT INTO occuper(idBts, idEpreuve, idSalle) VALUES ('".$bts."','".$epreuve."','".$salle."');";
$db->query($sql2);

$sql3 = "INSERT INTO affecter VALUES ('null','".$bts."','".$epreuve."','".$creneau."','".$etat."','".$salle."');";
$db->query($sql3);
echo "done";
?>
