<?php

//fonction pour ajouter une salle ajoutée à une épreuve dans la table occuper et comporter
require_once('assets/php/main.php');


$db = get_db();
$uneSalle=$_REQUEST['uneSalle'];
$uneMatiere=$_REQUEST['uneMatiere'];
$unprof=$_REQUEST['unprof'];
$unBts=$_REQUEST['unBts'];
$heure=$_REQUEST['heure'];

if($heure>=4){
   $heure=$heure/2;
}


$sql3 = "INSERT INTO affecter VALUES ('".$unprof."','".$unBts."','".$uneMatiere."','".$heure."','".$etat."','".$uneSalle."');";
$db->query($sql3);