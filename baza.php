<?php 
define ("HOST","localhost");
define ("BAZA","iwa_2016_zb_projekt");
define ("BAZA_KORISNIK","iwa_2016");
define ("BAZA_SIFRA","foi2016");

$vel_str = 5;
$vel_str_video = 20;

function spajanjeNaBazu () {
$veza = mysqli_connect(HOST,BAZA_KORISNIK,BAZA_SIFRA);

if (!$veza) {
	echo "GRESKA : prilikom spajanja na bazu";
}

mysqli_select_db($veza,BAZA);

if (mysqli_error ($veza) !==''){
	echo "GRESKA : problemi sa odabirom baze!".mysqli_error($veza);}

mysqli_set_charset($veza,"utf8");

if (mysqli_error ($veza) !==''){
	echo "GRESKA : problemi sa odabirom baze!".mysqli_error($veza);}
	
return $veza;
}

function upitNaBazi ($veza , $upit) {
	$rezultat = mysqli_query($veza , $upit);
	
	if(!$rezultat) {
		die('Greška u upitu! ' . mysqli_error($veza));
	}
	
	return $rezultat;
}

function prekidVeze ($veza) {
mysqli_close ($veza);
}
?>