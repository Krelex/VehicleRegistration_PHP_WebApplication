<?php
include("baza.php");
$veza=spajanjeNaBazu();
if(isset($_POST['FrmAdministracijaKategorije'])) {
		$id = $_POST['novi'];
		$moderator = $_POST['moderator'];
		$naziv = $_POST['naziv'];
		$opis = $_POST['opis'];
		
		if ($id == 0) {
		
			$upit = "INSERT INTO kategorija values ('','$moderator', '$naziv', '$opis')";
		} else {
			$upit = "UPDATE kategorija SET 				 
				moderator_id='$moderator',
				naziv='$naziv',
				opis='$opis'
				WHERE kategorija_id = '$id'
			";
		}
		$rezultat=upitNaBazi($veza,$upit);
		header("Location: kategorija_prekrsaja.php");		
			
	}   

?>