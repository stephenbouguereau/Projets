<?php
session_start();
?>
<div id="carreebleuPROFBTS">
<?php

//Affiche les bts existants de la base de données dans une liste déroulante
require_once('assets/php/main.php');
$db = get_db();
$sql = "SELECT idBts, codeBts FROM bts";
echo '<select id="bts" onchange="initLists();">';
$res = $db->query($sql);
while ($row = $res->fetch_row()) {
  echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}
echo '</select>';
$res->close();
echo '<div id="sorts"></div>';
?>

<script>
initLists();

function initLists() {
  console.log("initLists()");
  var data = {};
  data['bts'] = $('#bts').val();
  $('#sorts').load('initLists.php', data);
}
</script>
<div id="legende2">
  <h4>Légende :</h4>
  <p>•Les cases de couleur blanches sont non affectées<br/>•Les cases de couleur jaunes sont affectées</p>
</div>
</div>
