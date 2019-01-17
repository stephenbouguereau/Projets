<?php
//if (!isset($_SESSION['login'])) {
   //header ('Location: ConnexionUser.php');
   //exit();
//}?>
<form class="carreebleu" method="GET" action="addEpreuve.php" onsubmit="return verifForm(this)">
     <script src="assets/js/main.js"></script>
<?php
require_once('assets/php/main.php');
$db = get_db();

//Fait une liste déroulante de chaque bts existant dans la base de données
?> <h2>Selectionner un BTS:</h2><?php
$sql = "SELECT idBts, codeBts FROM bts"; //requête sql
echo '<select name="bts" id="bts" >'; //selection des bts grâce à la fonction initLists()
$res = $db->query($sql);

while ($row = $res->fetch_row()) {
  ?><option id="bts1" value="<?php echo $row[0] ?>"><?php echo $row[1]?></option>;<?php //affichage de chaque bts dans le tableau de la base de données
}
echo '</select>';
$res->close();
echo '<div id="sorts"></div>';

//Fait une liste déroulante de chaque épreuve existante dans la base de données
?><h2>Selectionner une epreuve</h2> <?php
$sql = "SELECT idEpreuve, codeEpreuve FROM epreuve"; //requête sql
echo '<select name="epreuve" id="epreuve">';//selection des épreuves grâce à la fonction initLists()
$res = $db->query($sql);

while ($row = $res->fetch_row()) {
  ?><option id="epreuve1" value="<?php echo $row[0] ?>"><?php echo $row[1]?></option>;<?php  //affichage de chaque épreuve dans le tableau de la base de données
}
echo '</select>';
$res->close();
echo '<div id="sorts"></div>';
?>

<!-- Affichage d'un inpute pour la duree de l'épreuve || à compléter || -->
<h2>Duree de l'epreuve</h2>
<input type="text" name="duree" id="duree" pattern="^[1-5]$" title="Temps d'épreuve invalide" onblur="verifEpreuve(this)">h <br> <label id="dureeEp" style="visibility:hidden">Temps d'épreuve invalide</label> <br>
<br>
<input class="bouton" type="submit" name="affecter" value="Affecter">
</form>
