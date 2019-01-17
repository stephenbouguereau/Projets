
<?php

//fonction pour ajouter une salle ajoutée à une épreuve dans la table occuper et comporter
require_once('assets/php/main.php');


$db = get_db();
$salle = $_REQUEST['salle'];
$backsalle = $_REQUEST['backsalle'];
$bts = $_REQUEST['bts'];
$epreuve = $_REQUEST['épreuve'];
$date = $_REQUEST['date'];
$duree = $_REQUEST['duree'];
$prof = $_REQUEST['unprof'];

$creneau = 1;
$etat = null;

for($i=0;$i<count($backsalle);$i++){   //On supprime chaque salle déselectionnée
	
	
	  $sql2 = "DELETE FROM occuper where idBts = '".$bts."' and idEpreuve = '".$epreuve."' and idSalle = '".$backsalle[$i]."'";
	$db->query($sql2);

  }
//on met à jour la table comporter
$sql = "UPDATE comporter set dateEpreuve = '".$date."',heureDebut = '".$duree."' where idBts = '".$bts."' and idEpreuve = '".$epreuve."';";
$db->query($sql);

for($i=0;$i<count($salle);$i++){
	//on ajout chaque salle selectionnée
	
	  $sql2 = "INSERT INTO occuper(idBts, idEpreuve, idSalle) VALUES ('".$bts."','".$epreuve."','".$salle[$i]."');";
	$db->query($sql2);
  }

  



echo "done";
?>
