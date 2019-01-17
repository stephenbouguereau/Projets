<?php
session_start();

require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
require 'Fonction.php';

   $reponse = $bdd->query("SELECT * FROM categorie");
   $commande = $bdd->query("SELECT * FROM commande");
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
        <link rel="stylesheet" media="screen" type="text/css" title="page_web" href="fleur3.css"/>
    </head>
    <body>
            <div id="boitep">
            <div id="boite">
            <div id="boite1"><h1>Sté Lafleur</h1></div> 
            <div><h4>6, cloitre St Aignan</h4> <h4>45000 Orléans</h4></div></div>
   
	
	  

	<div id="boiteap">
            <div id="boite2"><a href="Backoffice.php"> <input type= "submit" value="Ajouter une catégorie" name='sup'/> </a></div>
			<br />
			<?php
    while ($donnees = $reponse->fetch()) 
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
document.location.replace("commandeclient.php");
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
document.location.replace("commandeclient.php");
// -->
	</script>'; }
						
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
	
	<br /><br />
	<a href="Panier.php?action=terminer">
            <input type= "submit" value="Se déconnecter"/>
            </a>
        </div>
    </div> 
	<?php

$reponse->closeCursor(); // Termine le traitement de la requête

	
	
	if(isset($_GET['supprligne'])) {  //si l'on supprime une commande
		
	if (isset($_GET['mom'])) 
	
                {
                    
                    $mom = $_REQUEST['mom']; 
                }
                

                		
	
	$supp1 = $bdd->prepare("DELETE FROM commande where cde_moment='$mom'");  //suppression par le moment
    $supp1->execute(array($mom));
header('Location: commandeclient.php');	
	}
 ?>


<?php // update du moment de la commande
if(isset($_GET['modifmoment'])) {
	if (isset($_GET['modifpmoment'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpmoment']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `commande` SET `cde_moment`='$modifprix' WHERE cde_moment='$ref'");
    $prix1->execute(array($modifprix,$ref));
echo '<script language="Javascript">
<!--
document.location.replace("commandeclient.php");
// -->
</script>';	
	}
?>

<?php // update du num�ro de client
if(isset($_GET['modifclient'])) {
	if (isset($_GET['modifpclient'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpclient']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `commande` SET `cde_client`='$modifprix' WHERE cde_moment='$ref'");
    $prix1->execute(array($modifprix,$ref));
echo '<script language="Javascript">
<!--
document.location.replace("commandeclient.php");
// -->
</script>';	
	}
?>

<?php // update de la date des commandes
if(isset($_GET['modifdate'])) {
	if (isset($_GET['modifpdate'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpdate']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `commande` SET `cde_date`='$modifprix' WHERE cde_moment='$ref'");
    $prix1->execute(array($modifprix,$ref));	
	echo '<script language="Javascript">
<!--
document.location.replace("commandeclient.php");
// -->
</script>';
	}
?>
        </div>
    </div>  
<section id="principal">	
    <table class="container">
	<thead>
		<tr>
			<th><h1>code Moment</h1></th>
			<th><h1>code client</h1></th>
			<th><h1>code date</h1></th>
			<th><h1>Ajouter/Supprimer</h1></th>
		</tr>
	</thead> 
    
	
		  
    <?php  
   while ($com = $commande->fetch()) { ?>
   
   
<tbody>
       <tr>
  <td><?php  echo $com['cde_moment']; ?> 
      <form>
    <input  type="text" Value=""  placeholder=<?php echo $com['cde_moment']?> name="modifpmoment"/>
    <input type=hidden name=ref value=<?php echo $com['cde_moment']; ?> />
    <br /><br />
    <input type=submit value="Modifier" name="modifmoment" />
    </form>
  </td>
  
  <td><?php  echo $com['cde_client']; ?>
    <form>
    <input  type="text" Value=""  placeholder=<?php echo $com['cde_client']?> name="modifpclient"/>
    <input type=hidden name=ref value=<?php echo $com['cde_moment']; ?> />
    <br /><br />
    <input type=submit value="Modifier" name="modifclient" />
    </form>
  </td>
  
  <td><?php  echo $com['cde_date']; ?>
    <form>
    <input  type="text" Value=""  placeholder=<?php echo $com['cde_date']?> name="modifpdate"/>
    <input type=hidden name=ref value=<?php echo $com['cde_moment']; ?> />
    <br /><br />
    <input type=submit value="Modifier" name="modifdate" />
    </form>
  </td>
  
  <td>
				
				<form action="" method=get >    
			
				
				
				
				
				<input type=hidden name=mom value=<?php echo $com['cde_moment']; ?> />
				
				<input type=submit value="X" name="supprligne" />
				
					
			</form>
			</td>
  <br />
  </tr>
 
  </tbody>
  
  <?php } ?>
  
  <tr> <form action="" method=get >  
			
			<td> <input  type="text" Value=""  placeholder="code moment" name="codemoment"/> </td>
			<td> <input  type="text" Value=""  placeholder="code client" name="codeclient"/> </td>
			<td> <input  type="text" Value=""  placeholder="code date" name="date"/>  </td>
			<td> <input type=submit value="+" name="ajoutligne" /> </td>
				
				
				
					
			</form>
			
			
			
		</tr>
<?php

if(isset($_GET['ajoutligne'])) { //si on ajoute manuellement une commande
	
	
					if(isset($_GET['codemoment'])) {
					$codemoment = $_REQUEST['codemoment'];	}	
					if(isset($_GET['codeclient'])) {
                    $codeclient = $_REQUEST['codeclient']; }
					if(isset($_GET['date'])) {
					$date = $_REQUEST['date']; }
					
			
	
	$ajocom = $bdd->prepare("INSERT INTO `commande` VALUES ('$codemoment','$codeclient','$date')");  //on insert les 3 valeurs
    $ajocom->execute(array($codemoment,$codeclient,$date));
	
	echo '<script language="Javascript">
<!--
document.location.replace("commandeclient.php");
// -->
</script>';
	} ?> 
  </table>
  </section>
 <br />  
    
        
       
    <footer>
        <div id="pied">
            <h2>Copyright Société Lafleur - 06/01/2017</h2>
        </div>
    </footer>
</body>
</html> 
