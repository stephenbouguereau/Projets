<?php
session_start();
if (!isset($_SESSION['login'])) {
   header ('Location: ConnexionUser.php');
   exit();
}
require_once('assets/php/main.php');
$db = get_db();

if(!empty($_REQUEST['data'])) {
  $toDelete = $_REQUEST['data'];
  $table = $_REQUEST['table'];
  $cond = $_REQUEST['cond'];
}
//fonction pour supprimer un truc de la base de données mais on ne sait pas quoi précisément
if($db && !empty($toDelete) && !empty($table)) {
  foreach ($toDelete as $key => $value) {
    $sql = 'DELETE FROM '.$table.' WHERE '.$cond.' = "'.$value.'";';
   
    $res = $db->query($sql);
  }
  echo 'end';
}
?>
