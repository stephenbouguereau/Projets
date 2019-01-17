<?php

//permet de metre a jour le planning
require_once('assets/php/main.php');
$db = get_db();
$bts = $_REQUEST['bts'];
 if (is_numeric($bts)) { //si on selectionne un bts
        
    

$sql = "SELECT idBts, codeBts FROM bts where idBts ='".$bts."';";

if($bts>0){  //si on veut voir un bts en particulier
    foreach  ($db->query($sql) as $row) {
        $lecodebts = $row['codeBts'];
     }
	 $nb = 0;
	 $q = "SELECT epreuve.libelleEpreuve,epreuve.idEpreuve FROM epreuve,comporter WHERE epreuve.idEpreuve = comporter.idEpreuve and idBts ='".$bts."';";
	 foreach  ($db->query($q) as $row) {
        $nb = $nb + 1;
     }
	 if($nb>0){
?>
    <table>
        <tr>
            <th>BTS <?php echo $lecodebts ?> </th>
            <?php
            $sql = "SELECT epreuve.libelleEpreuve,epreuve.idEpreuve FROM epreuve,comporter WHERE epreuve.idEpreuve = comporter.idEpreuve and idBts ='".$bts."';";
            foreach  ($db->query($sql) as $row) {  //pour chaque epreuve...
                echo '<th colspan="2">'.$row['libelleEpreuve'].'</th>';
             }
            ?>
        </tr>
        <tr>
            <td></td>
        <?php
        foreach  ($db->query($sql) as $row) {
               echo '<td>créneau 1</td>
                    <td>créneau 2</td>';
        }
        echo'</tr>';
        
        $sql2 = "SELECT nom, prenom,prof.idProf FROM prof,enseigner WHERE prof.idProf = enseigner.idProf and idBts ='".$bts."'";
        $verif = "SELECT idEpreuve,idProf,idSalle,idBts,heureDebut FROM affecter WHERE idBts ='".$bts."' ";
        
        $sql1 = "select * from salle, epreuve, affecter, bts, comporter where salle.idSalle=affecter.idSalle and epreuve.idEpreuve=affecter.idEpreuve and bts.idBts = affecter.idBts and comporter.idBts= affecter.idBts";
        $comp = 1;
        $test = false;
        $res = $db->query($sql1);
        foreach  ($db->query($sql2) as $row) { //pour chaque professeur
            echo '<tr>';
            echo '<td>'.$row['nom'].' '.$row['prenom'].'</td>';
            foreach  ($db->query($sql) as $row2) { //pour chaque epreuve
				$test = false;
                foreach  ($db->query($verif) as $row3) {  //pour chaque elements de la table affecté
				//on compare afin de bien placé les yeux de surveillance
                    if ($row2['idEpreuve']==$row3['idEpreuve'] and $row['idProf']==$row3['idProf']){ 
                            $test = true;
                    }
                }
                if($test){
            
                   foreach  ($db->query($sql1) as $row4) {
                        //permet de donner telle convoc a telle épreuve
                        if($row2['idEpreuve']==$row4['idEpreuve'] and $row['idProf']==$row4['idProf'] and $row3['idBts'] == $row4['idBts']){
							$sqlheured = "SELECT heureDebut FROM affecter WHERE idProf ='".$row['idProf']."' ";
							foreach  ($db->query($sqlheured) as $rowhd) {  //On recupere le créneau pour placé l'oeil de surveillance au bonne endroit
                $heuredebut = $rowhd['heureDebut'];
             }
							if($heuredebut==1){
								echo '<td><img src="assets/img/surveillance-eye-symbol-rouge.png" alt="Eye symbol"/><br/>Date : '.$row4['dateEpreuve'].'<br/>Heure épreuve: '.$row4['heureDebut'].' <br/>Salle : '.$row4['numSalle'].'</td> <td> </td>';  //créneau 1
							}
							else{
								$hdebut = $row4['heureDebut'];
								$date = $hdebut;
								$date = strtotime($date);
								$heure = date('H', $date);
								$minute = date('i', $date);
								$seconde = date('s', $date);
								$heure = $heure + $row4['duree']/2;
								if($heure<10){
									$time = "0".$heure.":".$minute.":".$seconde;
								}
								else{
									$time = $heure.":".$minute.":".$seconde;
								}
                            echo '<td> </td><td><img src="assets/img/surveillance-eye-symbol-rouge.png" alt="Eye symbol"/><br/>Date : '.$row4['dateEpreuve'].'<br/>Heure épreuve: '.$time.' <br/>Salle : '.$row4['numSalle'].'</td> ';   //créneau 2
                        }}
                    } 
                }
                else{
                    echo '<td></td> <td></td>';} 
                }

            echo '</tr>';

        }
	}
}
else{ //si on veut tout voir  
    ?>
    <table>
        <tr>
        <?php
        echo '<th>Professeur</th>';
        echo '<th>BTS</th>';
        echo '<th>Epreuve</th>';
        echo '<th>Date épreuve</th>';
        echo '<th>Heure épreuve</th>';
        echo '<th>Créneau</th>';
        echo '<th>Salle</th>';
        ?>
        </tr>
     <?php
    $sql = "SELECT prof.nom,bts.codeBts,epreuve.codeEpreuve,comporter.dateEpreuve,comporter.heureDebut as 'heureDebut1',comporter.duree,affecter.heureDebut as 'heureDebut2',salle.numSalle from prof,epreuve,bts,salle,affecter,comporter where prof.idProf = affecter.idProf and bts.idBts = affecter.idBts and epreuve.idEpreuve = affecter.idEpreuve and salle.idSalle = affecter.idSalle and comporter.idBts = bts.idBts and comporter.idEpreuve = epreuve.idEpreuve;";

    foreach  ($db->query($sql) as $row) {
        echo '<tr>';
        echo '<td>'.$row['nom'].'</td>';
        echo '<td>'.$row['codeBts'].'</td>';
        echo '<td>'.$row['codeEpreuve'].'</td>';
        echo '<td>'.$row['dateEpreuve'].'</td>';
        if($row['heureDebut2'] =="2"){
            $hdebut = $row['heureDebut1'];
            $date = $hdebut;
            $date = strtotime($date);
            $heure = date('H', $date);
            $minute = date('i', $date);
            $seconde = date('s', $date);
            $heure = $heure + $row['duree']/2;
            if($heure<10){
                $time = "0".$heure.":".$minute.":".$seconde;
            }
            else{
                $time = $heure.":".$minute.":".$seconde;
            }
           
        }
        else{
            $time = $row['heureDebut1'];
        }
        echo '<td>'.$time.'</td>';
        echo '<td>'.$row['heureDebut2'].'</td>';
        echo '<td>'.$row['numSalle'].'</td>';
        echo '</tr>';
     }
     echo '</table>';
}
} else {  //si on selectionne un professeur
        $prof = rtrim($bts, 'prof'); 
		$sqlnom = "SELECT idProf, nom, prenom FROM prof where idProf ='".$prof."';";
		foreach  ($db->query($sqlnom) as $row) {
        $lenom = $row['nom']." ".$row['prenom'];
     }
		?>
    <table>
        <tr>
		<th><?php echo $lenom ?></th>
        <?php 
        
        echo '<th>Epreuve</th>';
        echo '<th>Date Epreuve</th>';
        echo '<th>Heure Epreuve</th>';
        echo '<th>Créneau</th>';
        echo '<th>Salle</th>';
        ?>
        </tr>
     <?php
    $sql = "SELECT bts.codeBts,epreuve.codeEpreuve,affecter.heureDebut,salle.numSalle,comporter.dateEpreuve,comporter.heureDebut as 'heureDebut1',comporter.duree,affecter.heureDebut as 'heureDebut2' from prof,epreuve,bts,salle,affecter,comporter where prof.idProf = affecter.idProf and comporter.idBts = bts.idBts and comporter.idEpreuve = epreuve.idEpreuve and bts.idBts = affecter.idBts and epreuve.idEpreuve = affecter.idEpreuve and salle.idSalle = affecter.idSalle and affecter.idProf ='".$prof."';";

    foreach  ($db->query($sql) as $row) {
        echo '<tr>';
        
        if($row['heureDebut2'] =="2"){
            $hdebut = $row['heureDebut1'];
            $date = $hdebut;
            $date = strtotime($date);
            $heure = date('H', $date);
            $minute = date('i', $date);
            $seconde = date('s', $date);
            $heure = $heure + $row['duree']/2;
            if($heure<10){
                $time = "0".$heure.":".$minute.":".$seconde;
            }
            else{
                $time = $heure.":".$minute.":".$seconde;
            }
           
        }
        else{
            $time = $row['heureDebut1'];
        }
    
        echo '<td>'.$row['codeBts'].'</td>';
        echo '<td>'.$row['codeEpreuve'].'</td>';
        echo '<td>'.$row['dateEpreuve'].'</td>';
        echo '<td>'.$time.'</td>';
        echo '<td>'.$row['heureDebut'].'</td>';
        echo '<td>'.$row['numSalle'].'</td>';
        echo '</tr>';
     }
     echo '</table>';
    }

?>