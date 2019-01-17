
<?php

//fonction pour ajouter affecter un prof à une salle avec son créneau
require_once('assets/php/main.php');


$db = get_db();
$salle = $_REQUEST['uneSalle'];
$bts = $_REQUEST['unBts'];
$epreuve = $_REQUEST['uneMatiere'];
$unCreneau = $_REQUEST['unCreneau'];
$prof = $_REQUEST['unProf'];


$etat = 1;

$sql3 = "INSERT INTO affecter VALUES ('".$prof."','".$bts."','".$epreuve."','".$unCreneau."','".$etat."','".$salle."');";
$db->query($sql3);

  



echo "done";
?>
