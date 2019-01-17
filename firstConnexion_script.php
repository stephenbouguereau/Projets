<?php
require_once('assets/php/main.php');
$db = get_db();
//ajout d'un utilisateur
// Vérification de la validité des informations
// Hachage du mot de passe
$login = $_POST['login'];
$psswrd = $_POST['mdp'];
// $pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
// Insertion
$sql = 'INSERT INTO administrateur(login, password) Values ("'.$login.'","'.password_hash($psswrd,PASSWORD_BCRYPT).'");';
$db->query($sql);
echo "bienvenue ".$login;
header('Location: ConnexionUser.php');
