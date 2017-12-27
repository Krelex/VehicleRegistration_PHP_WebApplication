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
        <h4>  <a href="novoVozilo.php?novo=1"> > DODAJ VOZILO </a></h4>
	 </div>
	<div id="content">
	<?php
	
	$veza=spajanjeNaBazu();
	
	$upit = "select * from vozilo";
	
	if($aktivni_korisnik_tip==2){
		
		$upit.=" where korisnik_id = ".$aktivni_korisnik_id;
	}

	$rezultat=upitNaBazi($veza,$upit);
	
	if($rezultat)
	{ 
	echo "<h1>POPIS VOZILA : </h1>";
	
	echo "<table border='1'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Registracija</th><th>Marka</th><th>Tip</th>";
	if($aktivni_korisnik_tip==2){
	echo "<th>Ažuriranje</th><th>Prekršaji</th>";	
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
		while(list($idvoz,$idkor,$reg,$marka,$tip) = mysqli_fetch_array($rezultat))
		{
			$azuriranje="<a href='novoVozilo.php?azuriraj=$idvoz'>Ažuriraj</a>";
			$prekrsaji="<a href='prekrsaji.php?pogledaj=$idvoz'>Pogledaj</a>";
			echo "<tr>";
			echo "<td>".$reg."</td>";
			echo "<td>".$marka."</td>";
			echo "<td>".$tip."</td>";
			if($aktivni_korisnik_tip==2){
			echo "<td>$azuriranje</td><td>$prekrsaji</td>";	
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
	else{
		echo "Greška";
	}
	prekidVeze($veza);
					?>
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	