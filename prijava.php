<?php
include("header.php");
include("baza.php");

if(isset($_POST['korime'])){
	
	$korime=$_POST['korime'];
	$sifra=$_POST['sifra'];
	
	if(!empty($korime) && !empty($sifra)){
		
		$veza=spajanjeNaBazu();
		$upit="SELECT korisnik_id,tip_id,ime,prezime FROM korisnik WHERE korisnicko_ime='$korime' AND lozinka='$sifra'";
		$rezultat=upitNaBazi($veza,$upit);
		if($rezultat){
			if(mysqli_num_rows($rezultat)!=0){
					
					list($id,$tip,$ime,$prezime)=mysqli_fetch_array($rezultat);
					$_SESSION['aktivni_korisnik']=$korime;
					$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
					$_SESSION["aktivni_korisnik_id"]=$id;
					$_SESSION['aktivni_korisnik_tip']=$tip;
					
				}
			
		}
		
	}
	header("Location: index.php");
}

?>
	<div id="site_content">
	
	<div id="content">
	<form action="prijava.php" method="POST">
		<div class="form_settings">
            <p><span>Korisničko ime :</span><input class="contact" type="text" name="korime" id="korime" value="" /></p>
            <p><span>Šifra :</span><input class="contact" type="password" name="sifra" id="sifra" value="" /></p>
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="submit" value="submit" /></p>
         </div>	
	</div>
		</div>
<?php
include("footer.php");
?>	