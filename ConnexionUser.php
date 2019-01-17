<?php
require_once('assets/php/main.php');
$db = get_db();
// on teste si le visiteur a soumis le formulaire de connexion
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
   if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

      // on teste si une entrée de la base contient ce login
      $sql = 'SELECT * FROM administrateur WHERE login = "'.$_POST['login'].'"';
      $res = $db->query($sql);
      
      $resultat = $res->fetch_row();	
      // si on obtient pas de réponse = connexion
      if (password_verify($_POST['pass'],$resultat['1'])) {	  echo($resultat['1']." ");	echo ($_POST['pass']);
        session_start();
        $_SESSION['id'] = $resultat['2'];
        $_SESSION['login'] = $resultat['0'];
        header('Location: index.php');
        exit();
      }
      // sinon, le membre est inviter a retenter la connexion
      elseif (!$resultat) {
        $erreur= 'Erreur base de données';
      }
      else{
        $erreur= 'Mauvais identifiant ou mot de passe !';
      }
   }
   else {
      $erreur = 'Au moins un des champs est vide.';
   }
}
?>
<!-- Page de connexion utilisateur -->
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
	<form class="carreebleu" method="post" action="ConnexionUser.php">
            <div id="connexion">
                <p>Connexion Utilisateur</p>
                <label for="nom">Identifiant</label><br/>
                <input class="a_inpt" id="login" name="login"  type="text" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"><br/>
                <label for="pass">Mot de passe</label><br/>
                <input class="a_inpt"type="password" id="pass" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"><br/><br/>
                <input type="submit" class="bouton" name="connexion" value="Connexion">
            </div>
            <?php
              if (isset($erreur)) echo '<br/>',$erreur;
            ?>
        </form>

        <footer id="hpfooter">
        </footer>
    </body>
</html>
