<?php
session_start();
if (!isset($_SESSION['login'])) {
   header ('Location: ConnexionUser.php');
   exit();
}
//permet de mettre a jour les liste des épreuves pour un bts depuis la base de donn�es
require_once('assets/php/main.php');
$db = get_db();

$bts = $_REQUEST['bts'];

$sql = "SELECT epreuve.idEpreuve, libelleEpreuve FROM epreuve,comporter where epreuve.idEpreuve = comporter.idEpreuve and comporter.idBts = '".$bts."';";
echo '<select id="épreuve" >';
$res = $db->query($sql);
while ($row = $res->fetch_row()) {
  echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}
echo '</select>';
$res->close();
?>
