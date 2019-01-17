<?php
session_start();

if(!empty($_REQUEST['data'])){
  $table = $_REQUEST['data'];
}
if($table == 'prof'){
?>
<!-- affichage du menu pour ajouter un prof / changer la regex pour les ç et autre caractère spéciaux -->
<form id="form" onsubmit="ajoutProf(); return false;" method="post">
  <center>
    <label for="nom">Nom</label><br>
    <input class="a_inpt" id="nom" type="text" name="nom"
    pattern="[A-Za-z]*" title="Mettre que des lettres"></br></br>
    <label for="prenom">Prénom</label><br>
    <input class="a_inpt" id="prenom" type="text" name="prenom"
    pattern="[A-Za-z]*" title="Mettre que des lettres"></br></br>
    <input type="hidden" name="data" value="<?php echo $table;?>">
    <button class="bouton" type="submit" value="Submit">Valider</button><br>
    <span id="msg_all"></span>
  </center>
</form>
<?php
}else if($table == 'bts'){
?>
<!-- affichage du menu pour ajouter un bts -->
<form id="form" onsubmit="ajoutProf(); return false;" method="post">
  <center>
    <label for="code">Code (ex: SIO)</label><br>
    <input class="a_inpt" id="code" type="text" name="code"
    pattern="[A-Za-z0-9 ]{4,10}" title="Chiffres et lettres uniquement"></br></br>
    <label for="libelle">Nom du BTS</label><br>
    <input class="a_inpt" id="libelle" type="text" name="libelle"
    pattern="[A-Za-z ]*" title="Mettre que des lettres"></br></br>
    <input type="hidden" name="data" value="<?php echo $table;?>">
    <button class="bouton" type="submit" value="Submit">Valider</button><br>
    <span id="msg_all"></span>
  </center>
</form>
<?php
}elseif ($table == 'salle') {
?>
<!-- affichage du menu pour ajouter une salle -->
<form id="form" onsubmit="ajoutProf(); return false;" method="post">
  <center>
    <label for="numero">Numero(ex: A34)</label><br>
    <input class="a_inpt" id="numero" type="text" name="numero"
    pattern="[A-Za-z0-9]{3}" title="Chiffres et lettres uniquement"></br></br>
    <label for="capacite">Nombre de place</label><br>
    <input class="a_inpt" id="capacite" type="number" name="capacite" min="0" max="200"></br></br>
    <input type="hidden" name="data" value="<?php echo $table;?>">
    <button class="bouton" type="submit" value="Submit">Valider</button><br>
    <span id="msg_all"></span>
  </center>
</form>
<?php
}elseif ($table == 'epreuve'){
?>
<!-- affichage du menu pour ajouter une epreuve -->
<form id="form" onsubmit="ajoutProf(); return false;" method="post">
  <center>
    <label for="cepreuve">Code de l'epreuve</label><br>
    <input class="a_inpt" id="cepreuve" type="text" name="cepreuve"
    pattern="[A-Za-z0-9 ]*" title="Chiffres et lettres uniquement"></br></br>
    <label for="nepreuve">Nom de l'epreuve</label><br>
    <input class="a_inpt" id="nepreuve" type="text" name="nepreuve" pattern="[A-Za-z ]*" title="Mettre de que des lettres"></br></br>
    <input type="hidden" name="data" value="<?php echo $table;?>">
    <button class="bouton" type="submit" value="Submit">Valider</button><br>
    <span id="msg_all"></span>
  </center>
</form>
<!--
<?php
// }elseif ($table == 'epreuve'){
?>
affichage du menu pour ajouter une date
<form id="form" onsubmit="ajoutDate(); return false;" method="post">
  <center>
    <label for="cepreuve">Entrer une date</label><br>
    <input class="a_inpt" id="cepreuve" type="text" name="cepreuve"
    pattern="[A-Za-z0-9 ]*" title="Chiffres et lettres uniquement"></br></br>
    <label for="nepreuve">Créneaux</label><br>
    <input class="a_inpt" id="nepreuve" type="text" name="nepreuve" pattern="[A-Za-z ]*" title="Mettre de que des lettres"></br></br>
    <input type="hidden" name="data" value="<?php echo $table;?>">
    <button type="submit" value="Submit">Valider</button><br>
    <span id="msg_all"></span>
  </center>
</form>-->
<?php
}
?>
