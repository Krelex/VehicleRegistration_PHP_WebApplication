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

if(isset($_GET['kategorija_id']) || isset($_GET['novi'])) {
	
		if(isset($_GET['kategorija_id'])){
		$id = $_GET['kategorija_id'];

		$upit = "SELECT * FROM kategorija WHERE kategorija_id=$id";
		
		$rezultat=upitNaBazi($veza,$upit);
		list($kategid,$moderatorid,$naziv,$opis) = 
		mysqli_fetch_array($rezultat);
		
		
	} else {
		$id=0;
		$moderatorid="";
		$naziv="";
		$opis="";
	}

	?>

  <h2>Uređivanje kategorije</h2>
  <div class="form_settings">
		<form method="post" action="uredikategoriju.php" enctype="multipart/form-data" id="frmkategorija" onsubmit="return ValidateForm('frmkategorija')">
			<input  class="contact" type="hidden" name="novi" value="<?php echo $id?>"/>
			<p><span>Moderator:</span>
					<select  class="contact" name="moderator" id="moderator">
					<?php
					$upit = "SELECT korisnik_id, concat(ime,' ',prezime) FROM korisnik WHERE tip_id = 1";
					$rezultat=upitNaBazi($veza,$upit);
					while(list($idmod,$nazivmod)=mysqli_fetch_array($rezultat)){
						echo "<option value='$idmod'";
						if($idmod==$moderatorid){
							echo " selected";
						}
						echo ">$nazivmod</option>";
					}
					?>
					
					</select></p>
					<p><span>Naziv:</span><input type="text"  class="contact" name="naziv" id="naziv" value="<?php echo $naziv; ?>"/></p>
					<p><span>Opis:</span>
					<textarea name="opis"  class="contact" id="opis"><?php echo $opis?></textarea></p>
					<p style="padding-top: 15px"><span>&nbsp;</span><input type="submit"  class="contact" name="FrmAdministracijaKategorije" id="FrmAdministracijaKategorije" value="Unesi"/>
		</form>
<label id="poruka"></label>
	        </div>			
<?php
}
prekidVeze ($veza);
?>
			
			
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>