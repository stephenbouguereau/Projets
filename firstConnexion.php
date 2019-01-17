<?php
session_start();
require_once('assets/php/main.php');
$db = get_db();
?>
<!-- Page de premiere connexion utilisateur -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Surveillance BTS</title>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
        <link  rel="shortcut icon" href="assets/img/surveillance-eye-symbol.svg">
        <link rel="stylesheet" href="assets/css/jquery-ui.structure.min.css"/>
        <link rel="stylesheet" href="assets/css/jquery-ui.theme.min.css"/>
        <link rel="stylesheet" href="assets/css/main.css"/>
    </head>
    <body id="hpbody">
	    <img id="backgroundImg" src="assets/img/examen.jpg"></img>
        <header id="hpheader">
            <h1 id="hph1"><img id="hpimg" src="assets/img/surveillance-eye-symbol.svg" alt="Eye symbol">Surveillance BTS</h1>
        </header>
		<form method="post" action="firstConnexion_script.php">
			<div id="connexion">
                <!-- revoir les regex -->
                <!-- ajouter toutes les fonctions de testes -->
                <p>Première Connexion Utilisateur</p>
                <label for="nom">Identifiant</label><br/>
                <input class="a_inpt" id="login" name="login"  type="text"><br/>
                <label for="mdp">Mot de passe</label><br/>
                <input class="a_inpt" id="pswd" name="mdp" type="text"><br/>
				<label for="mdp">Retapez votre Mot de passe</label><br/>
                <input class="a_inpt" id="pswd" name="mdp2" type="text"><br/><br/>
				<input class="bouton" type="submit" value="Connexion">
            </div>
        </form>
        <footer id="hpfooter">
        </footer>
    </body>
</html>