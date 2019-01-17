<?php
	session_start();
	

require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
require 'Fonction.php';  //on récupère les données rentré dans le fichier "Fonction.php"    

if(isset($_POST['formconnexion'])) {   //Lorsque que l'on appuie sur le bouton "se connecter"
		
    $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);   //nom du client
    $passconnect = htmlspecialchars($_POST['passconnect']);  //mot de passe
    $verif = md5($passconnect);   //md5 permet le cryptage
    if(!empty($pseudoconnect) AND !empty($passconnect)) {   //si le pseudo et le mot de passe sont bien renseignés
	   
	
        $requser = $bdd->prepare("SELECT * FROM clientconnu where clt_nom = '$pseudoconnect' AND clt_motPasse = '$verif'");  
        $requser->execute(array($pseudoconnect, $passconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {  //si le client existe bien avec le bon mot de passe

           $userinfo = $requser->fetch();

           $_SESSION['pseudo'] = $userinfo['clt_nom'];  //on entre une session à partir de son nom

           header("Location: Panier.php"); //on actualise
        } else {
           $erreur = "Mauvais pseudo ou mot de passe !";
        }
    } else {
       $erreur = "Tous les champs doivent être complétés !";
    }
}




  $total = 0;
 
	class LigneProduit {  //on ouvre la classe "LigneProduit"
	   public $nom ;
	   public $qte ;
	
	   function __construct($nom) {
	     $this->nom = $nom;
	     $this->qte = 1; 
	   }
	}	
?>

<?php
   if ( isset($_SESSION['pseudo']) ) {   //Si on se connecte en tant qu'administrateur, on est renvoyé directement sur la page Backoffice.php
	if ($_SESSION['pseudo']=='admin') {
   		header("Location: Backoffice.php"); 
        }
   }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="fleurlogo.png"/>
        <link rel="stylesheet" media="screen" type="text/css" title="page_web" href="fleur2.css"/>
        
        <style type="text/css">
                    table {border-collapse: collapse;}
                    td,th {border: 1px solid black;}
                   
                    .couleur {background-color: #FF7600;}
                </style>
    </head>
    <body>
    <div id="boitep">
        <div id="boite">
            <div id="boite1"><h1>Société Lafleur</h1></div> 
        
        <div><h4>6, cloitre St Aignan</h4> <h4>45000 Orléans</h4></div>
    </div>
        <div id="boiteap">
            <div id="boite2"><h4>Nous contacter</h4> <a href="fleurpa.php"<h4>Page d'accueil</h4></div></a>
        
            <div id="boite3"><h3><i>Nos produits</i></h3></div>
        
 <a href="Articles.php?cat_code=bul"> Bulbes </a>
 <br />
     </p>

 <a href="Articles.php?cat_code=mas"> Plantes a massif </a>
 <br />
     </p>

 <a href="Articles.php?cat_code=ros"> Rosiers </a>
 <br />
     </p>
            <div id="bouton">
			<a href="Panier.php?action=terminer">
            <input type= "submit" value="Vider le panier"/>
			</a>
<br /> 
<?php
    if ( isset($_SESSION['pseudo'])) {  //afficher si une personne est connecté 
 ?>

<a href="Panier.php?action=terminer">
            <input type= "submit" value="Se déconnecter"/>
            </a>
<?php
    } 
?>
<br /> <a href="Inscription.php">
            <input type= "submit" value="Inscription"/>
       </a>
            <p>
        </div>
    </div>   
     
<section id="principal">
       
<form method="post" action="">
    <div>
            <div>
    <br /><br />
    <?php
    if (! isset($_SESSION['pseudo'])) {  //afficher si une personne n'est pas connecté
?>
                    <input name="pseudoconnect" type="text" size="19" placeholder="Nom Client"/>
                </div>
                <div id="Mot de Passe">
                    <input  type="text" name="passconnect" size="19" placeholder="Mot de Passe"/>
                </div>
                <div id="Valider">
                        <input type= "submit" size="19" name="formconnexion" value="Se connecter"/>
                </div>
<?php 
    }

    if ( isset($_SESSION['pseudo']) ) {    //afficher si une personne est pas connecté

    	echo "<h2>Bonjour M. ".$_SESSION['pseudo']."</h2>";  
?>
<br /><br /><br />
<form method="post" action="">    
<div id="Valider">
                        <input type= "submit" size="19" name="fourmi" value="Valider la Commande"/>
                    </div>    
</form> 
<?php
if(isset($_POST['fourmi'])) {    //si l'on clique sur le bouton "valider la commande" 
	$nom = $_SESSION['pseudo'];
	$r = $bdd->query("SELECT * FROM clientconnu where clt_nom = '$nom' ");  //on selectionne les informations du client afin de creer par la suite sa commande
        $r->execute(array($nom));
        $u = $r->fetch();
	$codefixe = $u['clt_code'];
	$insertmbr = $bdd->prepare("INSERT INTO commande VALUES (UNIX_TIMESTAMP(),'$codefixe',Now())");  //UNIX_TIMESTAMP permet de selectionné le moment de la comande
        $insertmbr->execute(array($codefixe));
	  				  
	foreach($_SESSION as $objet) {  //Pour chaque articles de la commande ,nous allons rentrer son nom et sa quantité (avec le moment et le code du client) dans la base de données par la suite.
		if ($_SESSION['pseudo']!=$objet){
			$s = $bdd->query("SELECT * FROM produit where pdt_ref= '$objet->nom' ");  
         		$s->execute(array($objet->nom));
          		$v = $s->fetch();
		  	$quant = $objet->qte;
			$ref = $v['pdt_ref'];
			echo "Commande Validé !";
			$insertmbr = $bdd->prepare("INSERT INTO contenir(cde_moment, cde_client, produit, quantite) VALUES (UNIX_TIMESTAMP(),'$codefixe','$ref','$quant')");
			$insertmbr->execute(array($codefixe , $ref, $quant));}}
		}
	?>
<p>            
	<?php
	}
?>
    </div>
</form>       
   

<br />    <br />  <br />   
<section> 
    <article>
    <?php 
        
		   

            
            if ( ! empty ( $_GET["action"] ) ) {  //si on termine la session (qu'il n'y a plus "d'action")
                terminerSession();

                        ?>
                <table width="540" height="210" border="1" align="center" cellapading="0" cellspacing="0">

                              <tr>
                  <td id="Vide">Panier Vide</td>
              </tr>

                      </table>		 

                <?php
                header('Location: fleurpa.php');

            }
            else {  //si il y a bien une commande en cours 

               
				
	require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"	
	 

if ( !isset($_SESSION['pseudo']) ) {  //si il n'y a pas d'article
 $compteur = count($_SESSION);

}
if ( isset($_SESSION['pseudo']) ) { 
$compteur = count($_SESSION)-1; }  //Pour calculer le nombre d'articles moins un pour ne pas compter le fait que nous sommes connecté .


 if ( $compteur>0 ) { ?>
    <table width="540" height="210" border="1" align="center" cellapading="0" cellspacing="0">
    <tr class="titre">
    <th>Reference</th>
    <th>Designation</th>
    <th>Prix Unitaire</th>
    <th>Quantite</th>
    <th>Montant</th>
    </tr>

    <?php  
	
                
} ?>			 
             
		  <?php 
	   $total = 0;
       foreach($_SESSION as $objet) {  //boucle pour chaque article
	if ( isset($_SESSION['pseudo']) ) { 	  
         if ($_SESSION['pseudo']!=$objet){   //pour chaque article nous allons par la suite entrer dans un tableaux ses informations
		  
		  $r = $bdd->query("SELECT * FROM produit where pdt_ref= '$objet->nom' ");  
          $r->execute(array($objet->nom));
          $u = $r->fetch();
		  $mont = $u['pdt_prix'] * $objet->qte;
		  
		  $total = $total + $mont;   //calcul du total de la commande
                  
                  $ref = $u['pdt_ref'];
                  $desig = $u['pdt_designation'];
                  $prix = $u['pdt_prix'];
                  
                  
                   
                  

		  ?>
		  
                     
					 
                    <tr>
                    <td><?php echo $u['pdt_ref']; ?></td>
                    <td><?php echo $u['pdt_designation']; ?></td>
                    <td><?php echo $u['pdt_prix']; ?></td>
                    <td><?php echo $objet->qte; ?></td>
                    <td><?php echo $mont ?></td>
                </tr>
				
		  <?php
		  
          
       } }
       
       else { 	  //affichage même si la personne nes pas connecté
         
		  
		  $r = $bdd->query("SELECT * FROM produit where pdt_ref= '$objet->nom' ");  
          $r->execute(array($objet->nom));
          $u = $r->fetch();
		  $mont = $u['pdt_prix'] * $objet->qte;
		  
		  $total = $total + $mont; //calcul du total de la commande
		  ?>
		  
                     
					 
                    <tr>
                    <td><?php echo $u['pdt_ref']; ?></td>
                    <td><?php echo $u['pdt_designation']; ?></td>
                    <td><?php echo $u['pdt_prix']; ?></td>
                    <td><?php echo $objet->qte; ?></td>
                    <td><?php echo $mont ?></td>
                </tr>
				
		  <?php
		  
          
        }
       
         }
		
		?>
		<tr>
                    <td colspan="4" class="titre"> Le panier contient <?php echo $compteur; ?> produits <br /> Total :</td>
                    <td><?php echo $total ?></td>
                </tr>  
                </table>
		<?php

		
        }
	
            
        
   ?>      
   </article> 
</section>
</section>
    <footer>
        <div id="pied">
            <h2>Copyright Société Lafleur - 06/01/2017</h2>
        </div>
        
        
    </footer>
</body>
</html> 
