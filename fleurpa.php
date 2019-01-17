<?php
session_start();

require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
require 'Fonction.php';

   $reponse = $bdd->query("SELECT * FROM categorie");
   
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Société Lafleur</title>
        <meta charset="iso-8859-15">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="fleurlogo.png"/>
        <link rel="stylesheet" media="screen" type="text/css" title="page_web" href="fleur2.css"/>
    </head>
    <body>

        
    <div id="boitep">
        <div id="boite">
            <div id="boite1"><h1>Sté Lafleur</h1></div> 
        
        <div><h4>6, cloitre St Aignan</h4> <h4>45000 Orléans</h4></div>
    </div>
        <div id="boiteap">
            <div id="boite2"><h4>Nous contacter</h4> 
                <a href="fleurpa.php" <h4>Page d'accueil</h4> </a>
            </div>
        
            
            
            <div id="boite3"><h3><i>Nos produits</i></h3></div>
        <?php  //affiche les cat�gories en fonction du contenu de la base de donn�es
   while ($donnees = $reponse->fetch()) { ?>

 <a href="Articles.php?cat_code=<?php echo $donnees['cat_code'];?>"> <?php  echo $donnees['cat_libelle']; ?> </a> 
 <br />
     </p>
<?php
}
//affiche le bouton si l'utilisateur est un client et non pas un client
$reponse->closeCursor(); // Termine le traitement de la requête
if ( isset($_SESSION['pseudo']) ) {
	if ($_SESSION['pseudo']!='admin') {
?>
            <p>
		<form name="panier" method="POST" action="Inscrption.php">
		<input type="submit" name="Inscrption" value="Voir le panier" class="btForm"/>
		</form>
<?php
}}
    if (! isset($_SESSION['pseudo'])) { ?>
<a href="Panier.php">
            <input type= "submit" value="Se connecter"/>
            </a>
<?php
    } ?>
<?php
    if ( isset($_SESSION['pseudo'])) { 
echo "<h3>M. ".$_SESSION['pseudo']."</h3>"; ?>

<a href="Panier.php?action=terminer">
            <input type= "submit" value="Se déconnecter"/>
            </a>
<?php
    }
	if ( isset($_SESSION['pseudo']) ) {
	if ($_SESSION['pseudo']!='admin') {
 ?>
<br /> <br /> <a href="Inscrption.php">
            <input type= "submit" value="Inscription"/>
			</a>
<?php
    
	}}
 ?>
        </div>
    </div>   
     
    <section id="principal">
        <div id="slogan">
            <H1>"Dites-le avec Lafleur"</H1>
        </div>     
        <aside id="image">
            <img src="accueil.jpg" alt="Une fleur">
        </aside>
    
        <div id="texte1">
            <h2>Constituer votre panier en naviguant, puis cliquer sur le bouton Commander.
            <br>Vous devez etre recense comme client pour pouvoir commander.
            <br>Envoyer un mail en laissant vos coordonnees pour etre contacte par notre service commercial</h2> 
        </div>
    </section>    
    <footer>
        <div id="pied">
            <h2>Copyright Société Lafleur - 06/01/2017</h2>
        </div>
    </footer>
</body>
</html> 
