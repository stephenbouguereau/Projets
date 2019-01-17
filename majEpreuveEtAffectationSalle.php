<div id="carreebleu">
    <div id="carrbts">
      <h2>Selectionner BTS : </h2>

      <?php
      require_once('assets/php/main.php');
      $db = get_db();
      $sql = "SELECT idBts, codeBts FROM bts";
      echo '<select id="bts" onchange="initListsepreuve();">';
      $res = $db->query($sql);
      while ($row = $res->fetch_row()) {
        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
      }
      echo '</select>';
      $res->close();

      ?>
      <br/>
      <h2>Selectionner épreuve : </h2>

      <?php
      echo '<div id="lepreuve" onchange="initListslasalle();"></div>';
      echo '<div id="salle"></div>';
      ?>

      <script>
      initListsepreuve();
      function initListsepreuve() { //lorsque l'on change de bts...

        var data = {};
        data['bts'] = $('#bts').val();
  
        var data = {};
        data['bts'] = $('#bts').val();
        data['date'] = "";
        data['duree'] = "";
        $('#salle').load('initListssalle.php', data);  //on met a jour les salles
      }

      initListslasalle();

      function initListslasalle() {

       
        var data = {};
        data['bts'] = $('#bts').val();
        data['date'] = "";
        data['duree'] = "";
        $('#salle').load('initListssalle.php', data);  //affectation des salles
      }

      initListssalle();

      function initListssalle() {

        console.log("initLists()");
        var data = {};
        data['bts'] = $('#bts').val();
        data['date'] = $('#date').val();
        data['duree'] = $('#duree').val();

        $('#salle').load('initListssalle.php', data); //affectation des salles
      }
      </script>
      <div id="legende">
        <h2>Légende :</h2>
        <p>•Les cases de couleur blanches sont non affectées<br/>•Les cases de couleur jaunes sont affectées</p>
      </div>
    </div>
</div>
