<?php
session_start();

require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
require 'Fonction.php';	  //on récupère les données rentré dans le fichier "Fonction.php"

   $reponse = $bdd->query("SELECT * FROM categorie");  	// on selection tous les élements de la table catégorie
   
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
	<link rel="stylesheet" media="screen" type="text/css" title="page_web" href="fleur3.css"/>
    </head>
    <body>
            <div id="boitep">
            <div id="boite">
            <div id="boite1"><h1>StÃ© Lafleur</h1></div> 
            <div><h4>6, cloitre St Aignan</h4> <h4>45000 OrlÃ©ans</h4></div></div>
   
	
	  

	<div id="boiteap">
            
			
			<?php
    while ($donnees = $reponse->fetch())   //boucle pour afficher chaque catégorie
        { 
?>
            <a href="Articles.php?cat_code=<?php echo $donnees['cat_code'];?>"> <?php  echo $donnees['cat_libelle']; ?> </a>  
            <br />
			<form action=" " method=get >    
			
				
				<div id="slogan2">
				
				
				<input  type="text" Value=""  placeholder=<?php echo $donnees['cat_libelle']?> name="modifnom"  id="modtextid" />
				<input type=hidden name="ref" value=<?php echo $donnees['cat_code']; ?> />
				
				<input type=submit value="Modifier" name="modifcateg" id="modsubmitid" />
				</div>		
			</form>
			<?php 
                        if(isset($_GET['modifcateg'])) {  //si l'on appuie sur "Modifier" pour une catégorie
	if (isset($_GET['ref'])) 
                {
                    
                    $ref = $_REQUEST['ref']; 
                }
				
	if (isset($_GET['modifnom'])) 
                {
                    
                    $modifnom = $_REQUEST['modifnom']; 
                }
				$modif1 = $bdd->prepare("UPDATE `categorie` SET `cat_libelle`='$modifnom' WHERE cat_code='$ref'");  //Modifie simplement le nom de la catégorie
				$modif1->execute(array($modifnom,$ref));  
				echo '<script language="Javascript">
<!--
document.location.replace("Backoffice.php");
// -->
</script>';	//Permet d'actualiser la page
	}
	
	if(isset($_GET['sup'])) {  //si l'on clique sur le bouton qui a pour name 'sup'
		
	if (isset($_GET['cat'])) {	 
	$cat = $_GET['cat'] ;
	
	}
	$sup1 = $bdd->prepare("DELETE FROM produit where pdt_categorie='$cat'");
    $sup1->execute(array($cat));
	$sup2 = $bdd->prepare("DELETE FROM categorie where cat_code='$cat'");
    $sup2->execute(array($cat));	
	echo '<script language="Javascript">
<!--
document.location.replace("Backoffice.php");
// -->
</script>';
	}
						
			?>
			 <form method="get" action="">
			  <?php
                /* Variables */
                $cat_lib = $donnees['cat_libelle'];
                $cat_code = $donnees['cat_code'];
				
				
               
                ?>
			 
			    <input type=hidden name=cat value=<?php echo $cat_code; ?> />
    			<input type= "submit" value="Supprimer" name='sup'/>
				
               
				
                </form>
                 <br />
                <div id="trait"> </div>              			
			
<?php
        }
?>
                        <p>
        <a href="clientconnu.php">
            <input type= "submit" value="Liste des clients"/>
	</a>
	<a href="commandeclient.php">
            <input type= "submit" value="Liste des commandes"/>
	</a>
	<br /><br />
	<a href="Panier.php?action=terminer">
            <input type= "submit" value="Se déconnecter"/>
            </a>
        </div>
    </div>   
     
    <section id="principal">
	<?php
        if(isset($_GET['ajo'])) {   //si l'on clique sur le bouton "Ajouter" qui est ecrit par la suite dans le code :
	if (isset($_GET['ajoutcode'])) 
                {
                    
                    $ajoutcode = $_REQUEST['ajoutcode']; 
                }
				
	if (isset($_GET['ajoutlibelle'])) 
                {
                    
                    $ajoutlibelle = $_REQUEST['ajoutlibelle']; 
                }
	$ajo1 = $bdd->prepare("INSERT INTO `categorie`(`cat_code`, `cat_libelle`) VALUES ('$ajoutcode','$ajoutlibelle')");  //On va ajouter une catégorie avec les 2 informations rentrées . Le code catégorie doit contenir 3 caractères.
    $ajo1->execute(array($ajoutcode,$ajoutlibelle));
echo '<script language="Javascript">
<!--
document.location.replace("Backoffice.php");
// -->
</script>';	//on actualise
	}

	
?>

<form action="" method=get >    
			
				<br /><br />
				<div id="slogan">
				<h3> Ajouter une catÃ©gorie : </h3>
				
				<input  type="text" Value=""  placeholder="Code" name="ajoutcode"/>
				<input  type="text" Value=""  placeholder="Libellé catégorie" name="ajoutlibelle"/>
				<br /><br />
				<input type=submit value="Ajouter" name="ajo" />
				</div>		
			</form>
    </section>    
    <footer>
        <div id="pied">
            <h2>Copyright Societe Lafleur - 06/01/2017</h2>
        </div>
    </footer>
</body>
</html> 
