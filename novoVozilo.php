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
	
	if(isset($_POST["Vozilo_submit"])){
		
		$idvoz=$_POST['idvoz'];
		$reg=$_POST['registracija'];
		$marka=$_POST['marka'];
		$tip=$_POST['tip'];
		
		if($idvoz==0){
			$upit = "insert into vozilo (korisnik_id,registracija,marka_vozila,tip_vozila) values ('$aktivni_korisnik_id','$reg','$marka','$tip')";
		}
		else
		{
			$upit = "update vozilo set registracija='$reg', marka_vozila='$marka', tip_vozila='$tip' where vozilo_id=".$idvoz;
		}
		
		$rezultat=upitNaBazi($veza,$upit);
		
		header("Location: vozila.php");
		
	}
	
	
	?>
        
		
	 </div>
	<div id="content">	
          
		  <?php
		  if(isset($_GET['azuriraj']) || isset($_GET['novo'])){
			  
			  if(isset($_GET['azuriraj'])){
				  $idvoz = $_GET['azuriraj'];
				  
				  $upit = "select * from vozilo where vozilo_id = ".$idvoz;
				  $rezultat=upitNaBazi($veza,$upit);
				  
				  list($idvoz,$idkor,$reg,$marka,$tip) = mysqli_fetch_array($rezultat);
				  
			  }
			  else
			  {
				  $idvoz=0;
				  $reg="";
				  $marka="";
				  $tip="";
			  }
			  
			  
		  }
		  
		  ?>
		  
		  <div class="form_settings">
		   <form action="novoVozilo.php" method="POST" id="frmvozilo" onsubmit="return ValidateForm('frmvozilo')">
            <h3 class="title">Administracija <?php if(isset($_GET['azuriraj'])){ echo "(ažuriranje)";}else{ echo"(unos)";}?> vozila</h3>
			<input type="hidden" name="idvoz" id="idvoz" value="<?php echo $idvoz;?>">
		    <p><span>Registracija :</span><input class="contact" type="registracija" name="registracija" id="registracija" onkeyup="PretvoriVelika()" value="<?php echo $reg;?>" placeholder="ZG-2399-ND"/></p>
            <p><span>Marka:</span><input class="contact" type="marka" name="marka" id="marka" value="<?php echo $marka;?>" placeholder="BMW"/></p>
            <p><span>Tip :</span><input class="contact" type="tip" name="tip" id="tip" value="<?php echo $tip;?>" placeholder="M3"/></p>
			<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="Vozilo_submit" value="Unesi" /></p>
			</form>	
			<label id="poruka"></label>
	        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	