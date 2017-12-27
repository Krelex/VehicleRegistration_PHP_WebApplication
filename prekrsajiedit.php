<?php
include("header.php");
include("baza.php");
?>
	<div id="site_content">
	<div class="sidebar">
	<?php
	$veza=spajanjeNaBazu();
	
	if(isset($_SESSION['aktivni_korisnik'])){
		echo "<h3>Vi ste: ".$_SESSION['aktivni_korisnik']."</h3>";
	}
	else
	{
	echo "<h3>Niste prijavljeni!</h3>";
	}
	
	if(isset($_POST["Prekrsaj_submit"])){
		
		$idprek=$_POST['idprek'];
		$kategorija=$_POST['kategorija'];
		$vozilo=$_POST['registracija'];
		$naziv=$_POST['naziv'];
		$opis=$_POST['opis'];
		$iznos=$_POST['iznos'];
		$datum=date("Y-m-d",strtotime($_POST['datum']));
		$vrijeme=$_POST['vrijeme'];
		$slika=$_POST['slika'];
		$video=$_POST['video'];
		
		if($idprek==0){
			$upit = "insert into prekrsaj values ('','$kategorija','$vozilo','$naziv','$opis','N','$iznos','$datum','$vrijeme','0000-00-00','00:00:00','$slika','$video')";
		}
		else
		{
			$upit = "update prekrsaj set kategorija_id='$kategorija',vozilo_id='$vozilo',naziv='$naziv',opis='$opis',novcana_kazna='$iznos',datum_prekrsaja='$datum',vrijeme_prekrsaja='$vrijeme', slika='$slika', video='$video' where prekrsaj_id=".$idprek;
		}
		
		$rezultat=upitNaBazi($veza,$upit);
		
		header("Location: prekrsaji.php?prekrsaji=1");
		
	}
	
	
	?>
        
		
	 </div>
	<div id="content">	
          
		  <?php
		  if(isset($_GET['azuriraj']) || isset($_GET['novo'])){
			  
			  if(isset($_GET['azuriraj'])){
				  $idprek = $_GET['azuriraj'];
				  
				  $upit = "select * from prekrsaj where prekrsaj_id = ".$idprek;
				  $rezultat=upitNaBazi($veza,$upit);
				  
				  list($prekid,$kat_id,$voz_id,$naziv,$opis,$status,$kazna,$datumprek,$vrijemeprek,$datumpl,$vrijemepl,$slika,$video) = mysqli_fetch_array($rezultat);
				  $datumprek=date("d.m.Y",strtotime($datumprek));
			  }
			  else
			  {
				  $idprek=0;
				  $kat_id=0;
				  $voz_id=0;
				  $naziv="";
				  $opis="";
				  $kazna="";
				  $datumprek="";
				  $vrijemeprek="";
				  $slika="";
				  $video="";
			  }
			  
			  
		  }
		  
		  ?>
		  
		  <div class="form_settings">
		   <form action="prekrsajiedit.php" method="POST" id="frmprekrsaji" onsubmit="return ValidateForm('frmprekrsaji')">
            <h3 class="title">Administracija <?php if(isset($_GET['azuriraj'])){ echo "(ažuriranje)";}else{ echo"(unos)";}?> prekršaja</h3>
			<input type="hidden" name="idprek" id="idprek" value="<?php echo $idprek;?>">
			<p><span>Kategorija :</span>
			<select name="kategorija" id="kategorija" class="contact">
			<?php
			$upit = "select kategorija_id, naziv from kategorija where moderator_id = ".$aktivni_korisnik_id;
			$rezultat = upitNaBazi($veza,$upit);
			while(list($katid,$katnaziv)=mysqli_fetch_array($rezultat)){
				echo "<option value='$katid'";
				if($kat_id==$katid){
					echo " selected";
				}
				echo ">$katnaziv</option>";
			}
			?>			
			</select>
			</p>
		    <p><span>Registracija :</span>
			<select name="registracija" id="registracija" class="contact">
			<?php
			$upit = "select vozilo_id, registracija from vozilo";
			$rezultat = upitNaBazi($veza,$upit);
			while(list($vozid,$vozreg)=mysqli_fetch_array($rezultat)){
				echo "<option value='$vozid'";
				if($voz_id==$vozid){
					echo " selected";
				}
				echo ">$vozreg</option>";
			}
			?>			
			</select>
			</p>
            <p><span>Naziv:</span><input class="contact" type="text" name="naziv" id="naziv" value="<?php echo $naziv;?>" placeholder="Prekršaj..."/></p>
            <p><span>Opis:</span><textarea class="contact" name="opis" id="opis" rows="4" cols="8"/><?php echo $opis;?></textarea></p>
			<p><span>Iznos kazne:</span><input class="contact" type="text" name="iznos" id="iznos" value="<?php echo $kazna;?>" placeholder="500.00"/></p>
			<p><span>Datum:</span><input class="contact" type="text" name="datum" id="datum" value="<?php echo $datumprek;?>"/></p>
            <p><span>Vrijeme:</span><input class="contact" type="text" name="vrijeme" id="vrijeme" value="<?php echo $vrijemeprek;?>"/></p>
            <p><span>Slika:</span><input class="contact" type="text" name="slika" id="slika" value="<?php echo $slika;?>"/></p>
            <p><span>Video:</span><input class="contact" type="text" name="video" id="video" value="<?php echo $video;?>"/></p>
			<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="Prekrsaj_submit" value="Unesi" /></p>
			</form>	
			<label id="poruka"></label>
	        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	