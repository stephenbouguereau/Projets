<?php
session_start();

require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
require 'Fonction.php';

   $reponse = $bdd->query("SELECT * FROM categorie");
   $cli = $bdd->query("select* from clientconnu");
   
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
document.location.replace("clientconnu.php");
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
document.location.replace("clientconnu.php");
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
        
	<a href="commandeclient.php">
            <input type= "submit" value="Liste des commandes"/>
	</a>
	<br /><br />
	<a href="Panier.php?action=terminer">
            <input type= "submit" value="Se déconnecter"/>
            </a>
        </div>
    </div> 
<?php
$reponse->closeCursor(); // Termine le traitement de la requête

 ?>
        </div>
    </div>   
     
    <section id="principal">
        <table class="container">
	<thead>
		<tr>
                        <th><h1>Code client</h1></th>
			<th><h1>Nom</h1></th>
			<th><h1>Adresse</h1></th>
			<th><h1>Telephone</h1></th>
			<th><h1>Email</h1></th>
			<th><h1>Mot de Passe</h1></th>
                        <th><h1>Supprimer<h1></th>
		</tr>
	</thead>

<?php 
    while ($client = $cli->fetch()) 
        { 
?>

	<tbody>
		<tr>
                        <td><?php echo $client['clt_code'];?>
                            
                            
			<td><?php echo $client['clt_nom'];?>
                            <form action="" value="get">
                                <input  type="text" Value=""  placeholder=<?php echo $client['clt_nom']?> name="modifpnom"/>
				<input type=hidden name=ref value=<?php echo $client['clt_nom']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modifnom" />
                            </form>
                        <br /> <br />
                        <td><?php echo $client['clt_adresse']; ?>
                            
                            <form action="" value="get">
                            <input  type="text" Value=""  placeholder=<?php echo $client['clt_adresse']?> name="modifpadresse"/>
				<input type=hidden name=ref value=<?php echo $client['clt_nom']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modif" />
                            </form>
                         <br /><br /> 
                         
			<td><?php echo $client['clt_tel']; ?>
                            <form action="" value="get">
                            <input  type="text" Value=""  placeholder=<?php echo $client['clt_tel']?> name="modifptel"/>
				<input type=hidden name=ref value=<?php echo $client['clt_tel']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modiftel" />
                            </form>
			<br /><br />
                        
                        <td><?php echo $client['clt_email']; ?>
                            <form action="" value="get">
                            <input  type="text" Value=""  placeholder=<?php echo $client['clt_email']?> name="modifpemail"/>
				<input type=hidden name=ref value=<?php echo $client['clt_email']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modifemail" />
                            </form>
                       <br /><br />
			<td> <?php echo "****"; ?>

			
			 <td>
                            <form action="" method=get >    
                                <input type=hidden name=code value=<?php echo $client['clt_code']; ?> />
                                <input type=submit value="X" name="supprligne" />
		
                            </form>
                </tr>
                
		<?php
	    }
?>
<tr> <form action="" method=get >  
			
			<td> <input  type="text" Value=""  placeholder="Code client" name="codeclient"/> </td>
			<td> <input  type="text" Value=""  placeholder="Nom" name="nom"/> </td>
			<td> <input  type="text" Value=""  placeholder="Adresse" name="adresse"/>  </td>
			<td> <input  type="text" Value=""  placeholder="Telephone" name="telephone"/>  </td>
			<td> <input  type="text" Value=""  placeholder="Email" name="email"/>  </td>
			<td> <input  type="text" Value=""  placeholder="Mot de passe" name="mdp"/>  </td>
			<td> <input type=submit value="+" name="ajoutligne" /> </td>
				
				
				
					
			</form>
			
			
			
		</tr>
<?php

if(isset($_GET['ajoutligne'])) {  //ajouter manuellement un client
					
					if(isset($_GET['codeclient'])) {
                    $codeclient = $_REQUEST['codeclient']; }
					if(isset($_GET['nom'])) {
					$nom = $_REQUEST['nom'];	}	
					if(isset($_GET['adresse'])) {
					$adresse = $_REQUEST['adresse']; }
					if(isset($_GET['telephone'])) {
					$telephone = $_REQUEST['telephone']; }
					if (isset($_GET['email'])) {	
					$email = $_GET['email']; }
					if (isset($_GET['mdp'])) {	
					$mdpfaux = $_GET['mdp'];
					$mdp= md5($mdpfaux);
					}
			
	
	$ajocli = $bdd->prepare("INSERT INTO `clientconnu` VALUES ('$codeclient','$nom','$adresse','$telephone','$email','$mdp')"); //requêtes pour les informations du client
    $ajocli->execute(array($codeclient,$nom,$adresse,$telephone,$email,$mdp));
	
	echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';

	
	}
	
	if(isset($_GET['supprligne'])) {  //si on supprime un client
		
	if (isset($_GET['code'])) 
	
                {
                    
                    $code = $_REQUEST['code']; 
                }
                

                		
	
	$supp3 = $bdd->prepare("DELETE FROM clientconnu where clt_code='$code'");
    $supp3->execute(array($code));	
	echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';
	}
	
	
?>
                
<?php  
//pour modifier les informations d'un client voici les differentes commandes suivante :
if(isset($_GET['modifnom'])) {   //son nom
	if (isset($_GET['modifpnom'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpnom']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `clientconnu` SET `clt_nom`='$modifprix' WHERE clt_nom='$ref'");
    $prix1->execute(array($modifprix,$ref));
echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';	
	}
	
?> 
                
<?php
if(isset($_GET['modif'])) {  //son adresse
	if (isset($_GET['modifpadresse'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpadresse']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `clientconnu` SET `clt_adresse`='$modifprix' WHERE clt_nom='$ref'");
    $prix1->execute(array($modifprix,$ref));	
	echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';
	}
?>
                
<?php
if(isset($_GET['modiftel'])) {  //son tel
	if (isset($_GET['modifptel'])) 
                {
                    
                    $modifprix = $_REQUEST['modifptel']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `clientconnu` SET `clt_tel`='$modifprix' WHERE clt_tel='$ref'");
    $prix1->execute(array($modifprix,$ref));	
	echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';
	}
?>
                
<?php
if(isset($_GET['modifemail'])) {  // son email
	if (isset($_GET['modifpemail'])) 
                {
                    
                    $modifprix = $_REQUEST['modifpemail']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `clientconnu` SET `clt_email`='$modifprix' WHERE clt_email='$ref'");
    $prix1->execute(array($modifprix,$ref));	
	echo '<script language="Javascript">
<!--
document.location.replace("clientconnu.php");
// -->
</script>';
	}
?>
</tbody>





    </table>   

    
        <div id="texte1">
        </div>
    </section>    
    <footer>
        <div id="pied">
            <h2>Copyright Société Lafleur - 06/01/2017</h2>
        </div>