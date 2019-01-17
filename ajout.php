<?php
session_start();
if (!isset($_SESSION['login'])) {
   header ('Location: ConnexionUser.php');
   exit();
}
//ajouter un prof dans la base de données
require_once('assets/php/main.php');
$db = get_db();
$choix = $_REQUEST['data'];
if ($choix =='prof') {
  if(!empty($_REQUEST['data']) && !empty($_REQUEST['nom']) && !empty($_REQUEST['prenom'])){
    $table = $_REQUEST['data'];
    $nom = $_REQUEST['nom'];
    $prenom = $_REQUEST['prenom'];
    $sql = 'INSERT INTO '.$table.' (nom,prenom) Values ("'.$nom.'","'.$prenom.'");';
    $db->query($sql);
  }

}
//ajouter un bts dans la base de données
//rendre le code d'un bts Unique : ne pas ajouter deux bts ayant le même code faire de même avec les épreuves
elseif ($choix =='bts') {
  if(!empty($_REQUEST['data']) && !empty($_REQUEST['code']) && !empty($_REQUEST['libelle'])){
    $table = $_REQUEST['data'];
    $code = $_REQUEST['code'];
    $libelle = $_REQUEST['libelle'];
    $sqltest='Select codeBts From bts;';
    //$bool passe a true s'il n'y a pas de code identique
    $bool = true;
    //tentative guilhem : comparer tous les codes bts existant dans la bdd avec celui a ajouter; pour l'instant sa marche
    foreach  ($db->query($sqltest) as $row) {
        if ($code == $row['codeBts']){
            $bool = false;
        }
    }
    if ($bool==true){
        $sql = 'INSERT INTO '.$table.'(codeBts,libelleBts) Values ("'.$code.'","'.$libelle.'");';
        $db->query($sql);
    }
    else{
        //renvoyer une erreur
    }
  }
  
}
//ajouter une salle dans la base de données
else if ($choix =='salle'){
  if(!empty($_REQUEST['data']) && !empty($_REQUEST['numero']) && !empty($_REQUEST['capacite'])){
    $table = $_REQUEST['data'];
    $numero = $_REQUEST['numero'];
    $capacite = $_REQUEST['capacite'];
    $sql = 'INSERT INTO '.$table.'(numSalle,capacite) Values ("'.$numero.'","'.$capacite.'");';
    $db->query($sql);
  }

}
//ajouter une epreuve dans la base de données
//rendre le code d'une épreuve Unique : ne pas ajouter deux épreuves ayant le même code faire de même avec les bts
else if ($choix =='epreuve'){
  if(!empty($_REQUEST['data']) && !empty($_REQUEST['cepreuve']) && !empty($_REQUEST['nepreuve'])){
    $table = $_REQUEST['data'];
    $ecode = $_REQUEST['cepreuve'];
    $enom = $_REQUEST['nepreuve'];
    $sqltest='Select codeEpreuve From epreuve;';

    $bool = true;
    //tentative guilhem : même technique que pour les code bts
    foreach  ($db->query($sqltest) as $row) {
        if ($ecode == $row['codeEpreuve']){
            $bool = false;
        }
    }
    if ($bool==true){
        $sql = 'INSERT INTO '.$table.'(codeEpreuve,libelleEpreuve) Values ("'.$ecode.'","'.$enom.'");';
        $db->query($sql);
    }
    else{
        //renvoyer une erreur
    }
  }
}
?>