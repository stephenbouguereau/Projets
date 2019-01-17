<?php
    session_start();
        require 'Connexion.php';  //on récupère les données rentré dans le fichier "Connexion.php"
		require 'Fonction.php';  //on récupère les données rentré dans le fichier "Fonction.php"  
        $reponse = $bdd->query("SELECT * FROM categorie"); 
        $obtenirmel = strval($_GET['cat_code']);
        $requser = $bdd->prepare("SELECT * FROM produit,categorie where categorie.cat_code=produit.pdt_categorie and cat_code= '$obtenirmel' "); //requete sql pour obtenir tous les elements ayant le "cat_code" indiqué en "get" 
        $requser->execute(array($obtenirmel));
        $rep = $bdd->prepare("SELECT * FROM produit,categorie where categorie.cat_code=produit.pdt_categorie and cat_code= '$obtenirmel' ");  
        $rep->execute(array($obtenirmel));
        $repertoire = "fleur/";

            if (isset($_GET['selec']))   //si le nom d'un article est selectionné en "get" :
                {
                    $selec = $_REQUEST['selec'];  //on rentre la valeur de l'article dans une variable "selec"
                }

            if (isset($_GET['qtite']))
                {
                    $qtite = htmlspecialchars($_GET['qtite']); //on rentre la quantité dans une variable "qtite"
                    $qtite = $_REQUEST['qtite'];
                }

        class LigneProduit //on ouvre une class "LigneProduit"
            {
                public $nom ;
      	        public $qte ;

    	        function __construct($nom) //permet d'obtenir le nom de l'article et sa quantité
                    {
                        $this->nom = $nom;
    		 
                        if (isset($_GET['qtite']))
                            {
                                $qtite = htmlspecialchars($_GET['qtite']);
                                $qtite = $_REQUEST['qtite'];
                                $this->qte = $qtite; 
                            }  
    	            }
            }
	

?>

<?php 
    if( ! empty ( $_GET["action"] ) AND ! empty ( $_GET["selec"] ) )  //si il n'y a ni action donner , ni article selectionné :
        {
            $action = $_GET["action"];
            $selec = $_GET["selec"];  
          
/* on veut ajouter un nouveau produit */

            if ($action == "ajouter")
                {
                    $qte = ajouterProduit($selec) ;      
                } 
        }
    else 
        {
        /* si on ne veut ni ajouter, ni supprimer, 
        soit on veut consulter le panier, soit on veut terminer la session */
          
        //on veut terminer
            if ( ! empty ( $_GET["action"] ) ) 
                {
                    terminerSession();
                }
        }  
?>  

<!DOCTYPE html>
    <html>

        <head>
            <title>Société Lafleur</title>
            <meta charset="iso-8859-15">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" href="fleurlogo.png"/>
            <link rel="stylesheet" media="screen" type="text/css" title="page_web" href="fleur3.css"/>   
     
        <style type="text/css">
            table {border-collapse: collapse;}
            td,th {border: 1px solid black;}
            td {width: 10%;}
            .titre {background-color: #BA55D3;}
            .couleur {background-color: #FF7600;}
        </style>
        </head>

        <body>
            <div id="boitep">
            <div id="boite">
            <div id="boite1"><h1>Sté Lafleur</h1></div> 
            <div><h4>6, cloitre St Aignan</h4> <h4>45000 Orléans</h4></div></div>
    <?php   
	if ( isset($_SESSION['pseudo']) and $_SESSION['pseudo']=='admin') {  //si l'on est connecté en tant qu'Administrateur (Backoffice des produits)

	?>
	
	  

	<div id="boiteap">
            <div id="boite2"><a href="Backoffice.php"> <input type= "submit" value="Ajouter une catégorie" name='sup'/> </a></div>
			<br />
			<?php
    while ($donnees = $reponse->fetch())   //boucle pour voir tous les articles
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
                        if(isset($_GET['modifcateg'])) {  //Pour modifier la catégorie
	if (isset($_GET['ref'])) 
                {
                    
                    $ref = $_REQUEST['ref']; 
                }
				
	if (isset($_GET['modifnom'])) 
                {
                    
                    $modifnom = $_REQUEST['modifnom']; 
                }
				$modif1 = $bdd->prepare("UPDATE `categorie` SET `cat_libelle`='$modifnom' WHERE cat_code='$ref'"); //Modification du nom de catégorie
				$modif1->execute(array($modifnom,$ref));
				header('Location: Backoffice.php');	//Permet l'actualisation
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
<?php
            

    $reponse->closeCursor(); // Termine le traitement de la requête
	
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
	
	if(isset($_GET['ajo'])) {  //si l'on clique sur le bouton qui a pour name 'ajo'
	if (isset($_GET['ajoutcode'])) 
                {
                    
                    $ajoutcode = $_REQUEST['ajoutcode']; 
                }
				
	if (isset($_GET['ajoutlibelle'])) 
                {
                    
                    $ajoutlibelle = $_REQUEST['ajoutlibelle']; 
                }
				
				
	$ajo1 = $bdd->prepare("INSERT INTO `categorie`(`cat_code`, `cat_libelle`) VALUES ('$ajoutcode','$ajoutlibelle')");
    $ajo1->execute(array($ajoutcode,$ajoutlibelle));
header('Location: Backoffice.php');	
	}
	
	//les commandes suivantes vont être activé par des boutons "submit" qui arriverons par la suite. elles vont permet l'ajout , la modifications et la suppression d'article par des requêtes sql
	
	if(isset($_GET['modifprix'])) {
	if (isset($_GET['modifprixnom'])) 
                {
                    
                    $modifprix = $_REQUEST['modifprixnom']; 
                }
	$ref = $_GET['ref'] ;			
	
	$prix1 = $bdd->prepare("UPDATE `produit` SET `pdt_prix`='$modifprix' WHERE pdt_ref='$ref'");
    $prix1->execute(array($modifprix,$ref));
header('Location: Backoffice.php');	
	}
	
	if(isset($_GET['modifdesig'])) {
		
	if (isset($_GET['modifnom'])) 
	
                {
                    
                    $modifdes = $_REQUEST['modifnom']; 
                }
	$ref = $_GET['ref'] ;			
	
	$des1 = $bdd->prepare("UPDATE produit SET pdt_designation='$modifdes' WHERE pdt_ref='$ref'");
    $des1->execute(array($modifdes,$ref));
header('Location: Backoffice.php');	
	}
	
	if(isset($_GET['supprligne'])) {
		
	if (isset($_GET['ref'])) 
	
                {
                    
                    $ref = $_REQUEST['ref']; 
                }
                

                		
	
	$supp3 = $bdd->prepare("DELETE FROM produit where pdt_ref='$ref'");
    $supp3->execute(array($ref));
header('Location: Backoffice.php');	
	}
        
                if(isset($_GET['changenom'])) {
            
            if(isset($_GET['imageafficher'])){
                $changeimage=$_REQUEST['imageafficher'];
                $changeimage=$name = substr( $changeimage, 0, strpos( $changeimage, '.' ) );
              
            }
            
            if (isset($_GET['ref'])) 
	   
                {
                    
                    $ref = $_REQUEST['ref']; 
                }
                
            $changerimage = $bdd->prepare("UPDATE produit SET pdt_image='$changeimage' WHERE pdt_ref='$ref'");
    $changerimage->execute(array($changeimage,$ref));
    header('Location: Backoffice.php');
        }
	
	if(isset($_GET['ajoutligne'])) {
					
					if(isset($_GET['entrerref'])) {
                    $entrerref = $_REQUEST['entrerref']; }
					if(isset($_GET['nomimage'])) {
					$nomimage = $_REQUEST['nomimage'];	}	
					if(isset($_GET['entrerdesignation'])) {
					$entrerdesignation = $_REQUEST['entrerdesignation']; }
					if(isset($_GET['entrerprix'])) {
					$entrerprix = $_REQUEST['entrerprix']; }
					if (isset($_GET['cat'])) {	
					$cat = $_GET['cat']; }
			
	
	$supp3 = $bdd->prepare("INSERT INTO `produit`(`pdt_ref`, `pdt_designation`, `pdt_prix`, `pdt_image`, `pdt_categorie`) VALUES ('$entrerref','$entrerdesignation','$entrerprix','$nomimage','$cat')");
    $supp3->execute(array($cat,$entrerdesignation,$entrerprix,$nomimage,$entrerref));

	header('Location: Backoffice.php');	
	}
	
		//fin des commandes pour le create/update/delete des articles .
	
?>



    </div>
    </div>
	
    <section id="principal">
<h1>Administration :</h1>

			<br /> <br /> 

    <table class="container">
	<thead>
		<tr>
			<th><h1></h1></th>
			<th><h1>Référence</h1></th>
			<th><h1>Désignation</h1></th>
			<th><h1>Prix</h1></th>
			<th><h1>Ajouter/Supprimer</h1></th>
		</tr>
	</thead>

<?php 
    while ($donnees = $rep->fetch())  //boucle
        { 
?>

	<tbody>
		<tr>
			<td><img src="<?php echo $repertoire.$donnees['pdt_image']; ?>.jpg" width=75% align-center=auto alt="photo"/> <br />
                        <form action="" value="get">
                            <input type= "file" id="modifier" name="imageafficher"/>
                            <input type=hidden name=ref value=<?php echo $donnees['pdt_ref']; ?> />
                            <input type=submit value="+" name="changenom" />
                         <br />   
                        </form>
                      	<td><?php echo $donnees['pdt_ref']; ?> <br /> <br /> 
			<td><?php echo $donnees['pdt_designation']; ?> <br /> <br /> 
			<form action=" " method=get >    
			
				
				<div id="slogan">
				
				
				<input  type="text" Value=""  placeholder=<?php echo $donnees['pdt_designation']?> name="modifnom"/>
				<input type=hidden name=ref value=<?php echo $donnees['pdt_ref']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modifdesig" />
				</div>		
			</form>
			
			<td><?php echo $donnees['pdt_prix']; ?>€  <br /> <br /> 
			<form action="" method=get >    
			
				
				<div id="slogan">
				
				
				<input  type="text" Value=""  placeholder=<?php echo $donnees['pdt_prix']?> name="modifprixnom"/>
				<input type=hidden name=ref value=<?php echo $donnees['pdt_ref']; ?> />
				<br /><br />
				<input type=submit value="Modifier" name="modifprix" />
				</div>	
				</form>
				<td>
				
				<form action="" method=get >    
			
				
				
				
				
				<input type=hidden name=ref value=<?php echo $donnees['pdt_ref']; ?> />
				
				<input type=submit value="X" name="supprligne" />
				
					
			</form>

			
			
			
		</tr>
		<?php
	    }
?>
		<tr> <form action="" method=get >  
			<input type=hidden name=cat value=<?php echo $obtenirmel; ?> />
			<td> <input  type="text" Value=""  placeholder="Nom Image" name="nomimage"/> </td>
			<td> <input  type="text" Value=""  placeholder="Réference" name="entrerref"/> </td>
			<td> <input  type="text" Value=""  placeholder="Désignation" name="entrerdesignation"/>  </td>
			<td> <input  type="text" Value=""  placeholder="Prix" name="entrerprix"/>  </td>
			<td> <input type=submit value="+" name="ajoutligne" /> </td>
				
				
				
					
			</form>
			
			
			
		</tr>
		
	</tbody>




    </table>
	</section>
<?php	
	}
	
 
else {  //pour un client connecté ou non
	?>
	<div id="boiteap">
            <div id="boite2"><h4>Nous contacter</h4> <a href="fleurpa.php"<h4>Page d'accueil</h4></div></a>
            <div id="boite3"><h3><i>Nos produits</i></h3></div>
	<?php
    while ($donnees = $reponse->fetch())  
        { 
?>
            <a href="Articles.php?cat_code=<?php echo $donnees['cat_code'];?>"> <?php  echo $donnees['cat_libelle']; ?> </a>  
            <br />
            </p>
<?php
        }

    $reponse->closeCursor(); // Termine le traitement de la requête
	
?>
    <div id="bouton">		
	<a href="Panier.php">
    <input type= "submit" value="Voir le panier"/>
	</a>
    <br /><br />
    <a href="Panier.php?action=terminer">
    <input type= "submit" value="Vider le panier"/>
	</a>
    </div>
	
    </div>
    </div>


    
	
    <section id="principal">
    <table class="container">
	<thead>
		<tr>
			<th><h1></h1></th>
			<th><h1>Référence</h1></th>
			<th><h1>Désignation</h1></th>
			<th><h1>Prix</h1></th>
		</tr>
	</thead>

<?php 
    while ($donnees = $rep->fetch()) //boucle pour afficher les informations des articles 
        { 
?>

	<tbody>
		<tr>
			<td><img src="<?php echo $repertoire.$donnees['pdt_image']; ?>.jpg" width=75% align-center=auto alt="photo"/></td>
			<td><?php echo $donnees['pdt_ref']; ?></td> 
			<td><?php echo $donnees['pdt_designation']; ?></td> 
			<td><?php echo $donnees['pdt_prix']; ?>€</td> 
		</tr>
	</tbody>

<?php
	    }
?>

    </table>
    <br />
    <div id="quantite">			  
    <form action=Articles.php method=get > 
    <input type=hidden name=cat_code value=<?php echo $obtenirmel; ?> />
    <input type=hidden name=action value=ajouter />
    <select placeholder="votre fleur" id="selec" name="selec">
  
<?php   
    while ($donnees = $requser->fetch()) 
        {       
?>
    <option value="<?php echo $donnees['pdt_ref']; ?>"> <?php echo $donnees['pdt_designation']; ?></option>

<?php
        }
// Termine le traitement de la requête
?>

    </select>
    <br /><br />
    Quantite
	<input  type="text" Value="1" size="19" placeholder="Quantité" name="qtite"/>
    <br /><br />
	<input type=submit value=" Ajouter au panier " />
    </div>		
    </form>
    </section>
	
	<?php 

    } ?>
    <footer>
        <div id="pied">
            <h2>Copyright Ste Lafleur - 06/01/2017</h2>
        </div>
    </footer>

    </body>

</html> 
