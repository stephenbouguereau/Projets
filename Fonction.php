<?php 

/* fermeture de la session */
	function terminerSession() {   //fonction pour enlever totalement la session ouverte
       unset($_SESSION);
       session_destroy();
	}
	
	
	
/* on ajoute un produit au panier */

        function ajouterProduit($selec)
            {
	           $qte = 0;
	   
	            if ( !isset($_SESSION[$selec]) )                         //produit n'est pas encore au panier
                    {
                        $_SESSION[$selec] = new LigneProduit($selec);
                        $qte = $_SESSION[$selec]->qte ;                 //on recupere la quantite
                    }

                else                                                    //on avait deja ajoute ce selec, augmenter alors sa quantite 
                    {  
                        $objet = $_SESSION[$selec] ;
                        //$objet->qte = $objet->qte + 1;

                            if (isset($_GET['qtite']))
                                {
                                    $qtite = htmlspecialchars($_GET['qtite']);
                                    $qtite = $_REQUEST['qtite'];
                                    $objet->qte = $objet->qte + $qtite;
                                }

                        $qte = $objet->qte ;                            //on recupere la quantite
                    }
                return $qte;
	        }	
	
	
	
	
	
	
	
	

	
?>

	<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'fr', includedLanguages: 'en,fr', layout: google.translate.TranslateElement.FloatPosition.TOP_RIGHT}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
