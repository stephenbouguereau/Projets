<?php
session_start();
if (!isset($_SESSION['login'])) {
   header ('Location: ConnexionUser.php');
   exit();
}
//suppression de salles affectées dans la base de données
require_once('assets/php/main.php');
$db = get_db();
$salle = $_REQUEST['salle'];
$bts = $_REQUEST['bts'];
$épreuve = $_REQUEST['épreuve'];
$date = $_REQUEST['date'];
$duree = $_REQUEST['duree'];
$sql = "DELETE FROM occuper WHERE idSalle = '".$salle."' AND idBts = '".$bts."' AND idEpreuve = '".$épreuve."';";
$db->query($sql);
$sql2 = "UPDATE comporter set dateEpreuve = null,heureDebut = null where idBts = '".$bts."' and idEpreuve = '".$épreuve."';";
$db->query($sql2);
echo "done";
?>
