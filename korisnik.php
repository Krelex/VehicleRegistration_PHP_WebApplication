<?php
include("header.php");
include("baza.php");
?>
	<div id="site_content">
	<div class="sidebar">
	<?php
	if(isset($_SESSION['aktivni_korisnik'])){
		echo "<h3>Vi ste: ".$_SESSION['aktivni_korisnik']."</h3>";
	}
	else
	{
	echo "<h3>Niste prijavljeni!</h3>";
	}
	?>
        
		
	 </div>
	<div id="content">	
          
		  <div class="form_settings">
		   
            <h3 class="title">Popis kategorija</h3>
            
			<?php
	  $veza=spajanjeNaBazu();

	if(isset($_POST['kor_ime'])) {
		if (isset($_POST['tip'])) {
			$tip = $_POST['tip'];
		} else  {
			$tip = 2;
		}	
		
		$kor_ime = $_POST['kor_ime'];
		
		
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$lozinka = $_POST['lozinka'];		
		$email = $_POST['email'];
	
		$slika = $_POST['slika'];
		
		
		$id = $_POST['novi'];
		
		if ($id == 0) {
		
			$upit = "INSERT INTO korisnik 
			(tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
			VALUES
			($tip, '$kor_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika');
			";
		} else {
			$upit = "UPDATE korisnik SET 				 
				ime='$ime',
				prezime='$prezime',
				lozinka='$lozinka',
				email = '$email',
				slika = '$slika'
				WHERE korisnik_id = '$id'
			";
		}		

		
		
		$rezultat=upitNaBazi($veza,$upit);
		header("Location: korisnici.php");
		
	}
	
	if(isset($_GET['korisnik'])) {
		$id = $_GET['korisnik'];
		if ($aktivni_korisnik_tip==2) {
			$id = $_SESSION["aktivni_korisnik_id"]; 
		}
		$upit = "SELECT * FROM korisnik WHERE korisnik_id='$id'";
		
		$rezultat=upitNaBazi($veza,$upit);
		list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_array($rezultat);
		
		
	} else {
		$kor_ime = "";
		$ime = "";
		$tip = 2;
		$prezime = "";
		$lozinka = "";
		$email = "";
		$slika = "";
	}
	?>

		<h2>Uređivanje korisnika</h2>
		<div class="form_settings">
		<form method="post" action="korisnik.php" id="frmkorisnik" onsubmit="return ValidateForm('frmkorisnik')">
			<input type="hidden" name="novi" value="<?php echo $id?>"/>
			
			<p><span>Korisničko ime:</span><input  class="contact" type="text" name="kor_ime" id="kor_ime"
						<?php 
							if (isset($id)) {
								echo "readonly='readonly'";
							}	
						?>
						value="<?php echo $kor_ime;?>"/></p>
<p><span>Ime:</span><input class="contact" type="text" name="ime" id="ime" value="<?php echo $ime?>"/></p>
<p><span>Prezime:</span><input class="contact" type="text" name="prezime" id="prezime" value="<?php echo $prezime?>"/></p>
<p><span>Lozinka:</span><input class="contact" type="text" name="lozinka" id="lozinka" value="<?php echo $lozinka?>"/>		</p>	
				<?php 
					if($_SESSION['aktivni_korisnik_tip'] == 0) {
						?>
						<p><span>Tip korisnika:</span>
<select name="tip">
									<option value="0" <?php if ($tip == 0) echo "selected='selected'";?>>Administrator</option>
									<option value="1" <?php if ($tip == 1) echo "selected='selected'";?>>Moderator</option>
									<option value="2" <?php if ($tip == 2) echo "selected='selected'";?>>Korisnik</option>
								</select>
						<?php
					}
					?>
</p>
<p><span>email:</span><input class="contact" type="text" name="email" id="email" value="<?php echo $email?>"/></p>
<p><span>Slika:</span><input class="contact" type="text" name="slika" id="slika" value="<?php echo $slika?>"/></p>
<p style="padding-top: 15px"><span>&nbsp;</span><input class="contact" type="submit" value="Pošalji"/></p>
</form>	
			<label id="poruka"></label>
	        </div>			
<?php

prekidVeze ($veza);
?>
			
			
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>