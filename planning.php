<div id="carreebleuPROFBTS">
    <h2>Selectionner BTS ou Professeur : </h2>
    <?php
    require_once('assets/php/main.php');
    $db = get_db();
    $sql = "SELECT idBts, codeBts FROM bts";
	$sql2 = "SELECT idProf, nom,prenom FROM prof";
    echo '<select id="bts" onchange="initListsprof();">';
    echo '<option value="0">TOUT AFFICHER</option>';
    $res = $db->query($sql);
    while ($row = $res->fetch_row()) {
      echo '<option value="'.$row[0].'">'.$row[1].'</option>';
    }
	$res2 = $db->query($sql2);
	while ($row = $res2->fetch_row()) {
      echo '<option value="'.$row[0]."prof".'">'."Professeur : ".$row[1]." ".$row[2].'</option>';
    }
    echo '</select>';
    $res->close();
    ?>
</div>
<div id="prof"></div>
    <script>
    initListsprof();

    function initListsprof() {  //lorsque l'on change l'element selectionné...

      var data = {};
      data['bts'] = $('#bts').val();
      $('#prof').load('initListsprof.php', data);
    }
    </script>