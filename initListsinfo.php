<?php

//permet de metre a jour les liste des salles affectées et des professeur affectés
require_once('assets/php/main.php');
$db = get_db();

$uneepreuve = $_REQUEST['uneepreuve'];
$bts = $_REQUEST['bts'];
$date =  null;
$sqltime = "select dateEpreuve,heureDebut,duree from comporter where idBts = '".$bts."' and idEpreuve = '".$uneepreuve."';";
$res = $db->query($sqltime);
while ($row = $res->fetch_row()) {   //on récupère les dates et heures des épreuves si elles existent
  $date = $row[0];
  $heure = $row[1];
  $duree = $row[2];
}
?>
<?php if (isset($duree)){ echo "Durée : ".$duree." heures" ; }?>
<br/>
<h2>Date épreuve : </h2>
<?php if ($date != null){ ?>
<input type="date" value=<?php echo $date ?> name="date" id="date" /> <?php }
else{ //on met une valeur par défault si une date et heure n'a pas déjà été rentrée.
?>
	<input type="date" value="2000-01-01" name="date" id="date" /> <?php
} ?>

<h2>Heure Début : </h2>
<?php if ($date != null){ ?>
<input type="time" name="duree" value=<?php echo $heure ?> id="duree"/> <?php }
else{ //on met une valeur par défault si une date et heure n'a pas déjà été rentrée.
?>
<input type="time" name="duree" value="08:00" id="duree"> <?php
} 

$sqlbts = "SELECT idBts, codeBts FROM bts where idBts = '".$bts."';";
$res = $db->query($sqlbts);
      while ($row = $res->fetch_row()) {  
        $lebts = $row[1];
      }
?>



    <div id="profs">
	
	<h2>Professeur ( BTS <?php echo $lebts ?> ) :</h2>
    <?php


$sql1 = "select * from salle, epreuve, bts,occuper,comporter where salle.idSalle=occuper.idSalle and epreuve.idEpreuve=occuper.idEpreuve and bts.idBts = occuper.idBts and comporter.idBts=bts.idBts and epreuve.idEpreuve=comporter.idEpreuve and bts.idBts = '".$bts."' ";
  echo'<select id="uneSalle">';
        $res = $db->query($sql1);
while ($row = $res->fetch_row()) {   //on affiche les salles affectés à une épreuve d'un BTS
  echo '<option value="'.$row[0]."/".$row[3]."/".$row[6]."/".$row[13]."/".$row[14].'">'.$row[1]." (".$row[5].")"." (".$row[7].")"." (".$row[13].")".'</option>';
}
echo '</select>';



$sql = "SELECT prof.idProf, nom, prenom FROM prof,enseigner WHERE prof.idProf = enseigner.idProf and enseigner.idBts = '".$bts."' ;";
echo '<select id="unprof">';
$res = $db->query($sql);
while ($row = $res->fetch_row()) {   //pour chaque professeur...
  echo '<option value="'.$row[0].'">'.$row[1]." ".$row[2].'</option>';
}
echo '</select>';
$res->close();
?>
<br/>
<br>
<form id="radio">
  <input type="radio" name="gender" value="1" checked="true"> Créneau 1<br>
  <input type="radio" name="gender" value="2"> Créneau 2<br></form>
  <br/><input class="bouton" type="submit" value="Valider" id="clique" onClick="validerProf()" class="linkedSort">
  </div>



<?php


echo '<br/><div class="carreebleu2"><h2>Affecter les salles à cette épreuve:</h2>';

$sql = "SELECT salle.idSalle, numSalle ,capacite FROM salle WHERE salle.idSalle NOT IN (SELECT salle.idSalle FROM salle, occuper WHERE occuper.idSalle=salle.idSalle  AND idBts = '".$bts."' AND idEpreuve = '".$uneepreuve."');";
echo '<ul id="notAssigned" class="linkedSort">';
$res = $db->query($sql);
while ($row = $res->fetch_row()) {  //on affiche chaque salle avec sa capacité
  echo '<li class="ui-state-default" id="nonaffect" value="'.$row[0].'">'."Salle : ".$row[1]." - Capacité : ".$row[2].'</li>';
}
echo '</ul>';
$res->close();

$sql = "SELECT salle.idSalle, numSalle, capacite FROM salle, occuper WHERE occuper.idSalle=salle.idSalle AND idBts = '".$bts."' AND idEpreuve = '".$uneepreuve."';";
echo '<ul id="assigned" class="linkedSort">';
$res = $db->query($sql);
while ($row = $res->fetch_row()) { //on affiche chaque salle affecté à l'epreuve selectionné avec sa capacité
  echo '<li class="ui-state-highlight" id="affect" value="'.$row[0].'">'."Salle : ".$row[1]." - Capacité : ".$row[2].'</li>';
}
echo '</ul>';

$res->close();
echo '<br/><input class="bouton" type="submit" value="Valider" id="clique" onClick="valider()" class="linkedSort"></div>';

?>
  <br/>
<div id="legende">
  <h4>Légende :</h4>
  <p>•Les cases de couleur blanches sont non affectées<br/>•Les cases de couleur jaunes sont affectées</p>
</div>
<script>
lasalle = 0;

var listlasalle = [];
var backsalle = [];

$( function() {

  $( "#notAssigned, #assigned" ).sortable({
    connectWith: ".linkedSort",
    revert: true
  }).disableSelection();
} );

$( "#assigned" ).on( "sortreceive", function( event, ui ) {  //salles affectées
	
  var data = {};

  data['salle'] = ui.item[0].attributes['value'].value;

  data['bts'] = $('#bts').val();
  data['épreuve'] = $('#uneepreuve').val();
  data['date'] = $('#date').val();
  data['duree'] = $('#duree').val();
  
  
 
  listlasalle.push(ui.item[0].attributes['value'].value)
 



});

$( "#notAssigned" ).on( "sortreceive", function( event, ui ) {  //salles non-affectées
  var data = {};
  data['salle'] = ui.item[0].attributes['value'].value;

  data['bts'] = $('#bts').val();
  data['épreuve'] = $('#uneepreuve').val();
  
  backsalle.push(ui.item[0].attributes['value'].value)

 
});



function valider(){  //si l'on clique sur le bouton valider des affectations salles...
  var data = {};
//on récupère les données dont nous avons besoins.
  data['bts'] = $('#bts').val();

  data['épreuve'] = $('#uneepreuve').val();
  data['date'] = $('#date').val();
  data['duree'] = $('#duree').val()+":00";
 

if($('#uneepreuve').val() === null){   //pas d'épreuve
    alert("Aucune épreuve n'existe pour ce BTS !");
}
else{
if((listlasalle.length == 0 && backsalle.length == 0) && $('#affect').val() === undefined){  //salle non selectionnée
    alert("Aucune salle n'est sélectionnée !");
}
else{
	
 data['salle'] = listlasalle;
 

data['backsalle'] = backsalle; 
data['unprof'] = $('#unprof').val();


console.log(data);
  $.ajax({
    url: 'addSalletoEpreuve.php',
    type: 'POST',
    data: data
  })
  .always(function(e) {
    console.log(e);
  });
  $('#hpform').load('planning.php');
  alert("Données enregistrées"); //tout est bon , on enregistre les données
}
}
}

function validerProf(){  //si l'on clique sur le bouton valider des affectations professeurs...
  var data = {};
 
 var radio =$('input[name=gender]:checked').val() ;  //on récupère la valeur de l'input radio
if($('#uneSalle').val()==null){  //pas de salle affectée pour ce bts
alert("Vous devez dans un premier temps affecter une salle à une épreuve pour ce bts");

}
var mot =$('#uneSalle').val();
var test = 0;
var varsalle = "";
var varmatiere = "";
var varbts="";
var vardate="";
var varheure="";
var varduree="";
for(var i =0; i<mot.length;i++){   //On selectionne chaque partie de la variable "mot" afin d'avoir les informations necessaires.
    
    if (mot[i]=="/"){
        test++;
        
    }
    else if(test==0){
          varsalle = varsalle + mot[i];
      }  
    else if (test==1){
           varmatiere = varmatiere + mot[i]; 
        }
     else if (test==2){
           varbts = varbts + mot[i]; 
        } 
	else if (test==3){
           varheure = varheure + mot[i]; 
        }  	
	else if (test==4){
           varduree = varduree + mot[i]; 
        }  		
    
}


  //data['salle'] = ui.item[0].attributes['value'].value;

data['unCreneau']= radio;
data['uneSalle']= varsalle;
data['uneMatiere']= varmatiere;
data['unBts']= varbts;
data['unProf'] = $('#unprof').val();

if($('#unprof').val()==null){  //pas de prof pour ce bts
alert("Aucun professeur n'enseigne dans ce bts");

}
else{

console.log(data);
  $.ajax({
    url: 'addProfToSalle.php',
    type: 'POST',
    data: data
  })
  .always(function(e) {
    console.log(e);
  });
  alert("Professeur affecté");  //tout est bon, professeur affecté.
}
}
</script>
