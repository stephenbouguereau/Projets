<h1>MISE A JOUR DES EPREUVES ET AFFECTATIONS DES SALLES</h1>
<br />
    <?php
echo "Selectionner BTS : ";
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
?>
<br /><br />
<?php
echo "Selectionner épreuve : ";
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
?>
<br/>
<?php
echo "Date épreuve : ";

echo "Heure début : ";

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
