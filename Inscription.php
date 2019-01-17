 <?php
session_start();
require 'Connexion.php';  //on r√©cup√®re les donn√©es rentr√© dans le fichier "Connexion.php"

if(isset($_POST['forminscription'])) {
   $clt_code = htmlspecialchars($_POST['clt_code']);
   $clt_nom = htmlspecialchars($_POST['clt_nom']);
   $clt_adresse = htmlspecialchars($_POST['clt_adresse']);
   $clt_tel = htmlspecialchars($_POST['clt_tel']);
   $clt_email = htmlspecialchars($_POST['clt_email']);
   $clt_motPasse = htmlspecialchars($_POST['clt_motPasse']);
   
   
   //si l'un des champs ‡ renseignÈ est vide alors un message d'erreur est retournÈ demandant de remplir l'ensemble des champs
   if(!empty($_POST['clt_code']) AND !empty($_POST['clt_nom']) AND !empty($_POST['clt_adresse']) AND !empty($_POST['clt_tel']) AND !empty($_POST['clt_email']) AND !empty($_POST['clt_motPasse'])) {
      
         //vÈrifie si l'adresse mail entrÈe est valide 
            if(filter_var($clt_email, FILTER_VALIDATE_EMAIL)) {
               $reqmel = $bdd->prepare("SELECT * FROM clientconnu WHERE clt_email = ?");
               $reqmel->execute(array($clt_email));
               $melexist = $reqmel->rowCount();
	       $pdpcrypter = md5($clt_motPasse);
               if($melexist == 0) { //vÈrifie si l'adresse mail entrÈe n'existe pas dÈja 
                  
                   //crÈer le compte dans la base de donnÈes en utilisant les informations fournies dans les champs renseignÈs
                     $insertmbr = $bdd->prepare("INSERT INTO clientconnu(clt_code, clt_nom, clt_adresse, clt_tel, clt_email, clt_motPasse) VALUES('$clt_code','$clt_nom','$clt_adresse','$clt_tel','$clt_email','$pdpcrypter')");
                     $insertmbr->execute(array($clt_code, $clt_nom, $clt_adresse, $clt_tel, $clt_email, $clt_motPasse));
                     $erreurchamp = "Votre compte a bien √©t√© cr√©√© ! <a href='Articles.php'> Me connecter</a>";
                     
               } else {
                  $erreurchamp = "Adresse mail d√©j√† utilis√©e !";
               }
            } else {
               $erreurchamp = "Votre adresse mail n'est pas valide !";
            }
      
   } else {
      $erreurchamp = "Tous les champs doivent √™tre compl√©t√©s !";
   }
}
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
        <title>Soci√©t√© Lafleur</title>
        <meta charset="iso-8859-15">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="fleurlogo.png"/>
        <link rel="stylesheet" href="fleur2.css"/>
    </head>
    <body>
    <div id="boitep">
        <div id="boite">
            <div id="boite1"><h1>St√© Lafleur</h1></div> 
        
        <div><h4>6, cloitre St Aignan</h4> <h4>45000 Orl√©ans</h4></div>
    </div>
        <div id="boiteap">
            <div id="boite2"><h4>Nous contacter</h4> 
                <a href="fleurpa.php" <h4>Page d'accueil</h4> </a>
            </div>
        
            
            
            <div id="boite3"><h3><i>Nos produits</i></h3></div>
        <?php  
   while ($donnees = $reponse->fetch()) { ?>

 <a href="Articles.php?cat_code=<?php echo $donnees['cat_code'];?>"> <?php  echo $donnees['cat_libelle']; ?> </a>
 <br />
     </p>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requ√™te
?>
            <p>
		<form name="panier" method="POST" action="Panier.php">
		<input type="submit" name="Panier" value="Voir le panier" class="btForm"/>
		</form>
        </div>
    </div>   
     
    <section id="principal">
 
   
	    
	
		
		
    
	  
   
       
       <div id="baniere"> 
             
      <div align="center" >
	     
		 
         <h1>Inscription</h1>
         <?php
                if(isset($erreurchamp)) {
                     echo '<font color="black">'.$erreurchamp."</font>";
                    }
                ?>
         <form method="POST" action="">
		    <div align="center" >
            <table>
			 <tr>
			  <span class="input" >
					<input type="text" placeholder="Votre code" name="clt_code" value="<?php if(isset($clt_code)) { echo $clt_code; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
			  <span class="input" >
					<input type="text" placeholder="Votre nom" name="clt_nom" value="<?php if(isset($clt_nom)) { echo $clt_nom; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
			  
			  <span class="input" >
					<input type="text" placeholder="Votre adresse" name="clt_adresse" value="<?php if(isset($clt_adresse)) { echo $clt_adresse; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
			  
			  <span class="input" >
					<input type="text" placeholder="Votre telephone" name="clt_tel" value="<?php if(isset($clt_tel)) { echo $clt_tel; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
			  <tr>
			  
			  <span class="input" >
					<input type="text" placeholder="Votre email" name="clt_email" value="<?php if(isset($clt_email)) { echo $clt_email; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
			  
			  <span class="input" >
					<input type="password" placeholder="Votre mot de passe" name="clt_motPasse" value="<?php if(isset($clt_motPasse)) { echo $clt_motPasse; } ?>"  />
				<br />
				</span>
			  </tr>
			  <br />
			  <tr>
				
			  <span class="input" >
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
	   </section>    
    <footer>
        <div id="pied">
            <h2>Copyright Soci√©t√© Lafleur - 06/01/2017</h2>
        </div>
    </footer>
</body>
</html>
   </body>
</html>
