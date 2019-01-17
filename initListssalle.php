<?php

//permet de metre a jour la liste des salles affectées.
require_once('assets/php/main.php');
$db = get_db();

$bts = $_REQUEST['bts'];

$sql = "SELECT epreuve.idEpreuve, libelleEpreuve FROM epreuve,comporter where epreuve.idEpreuve = comporter.idEpreuve and comporter.idBts = '".$bts."';";
echo '<select id="uneepreuve" onchange="initListsinfo();">';
$res = $db->query($sql);
while ($row = $res->fetch_row()) {
  echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}
echo '</select></div>';
$res->close();
echo '<div id="info"></div>';
?>
<script>

initListsinfo();
function initListsinfo(){
  var data = {};
  data['uneepreuve'] = $('#uneepreuve').val();
  data['bts'] = $('#bts').val();
  $('#info').load('initListsinfo.php', data);
}
</script>
