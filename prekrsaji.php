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
	 <h4><a href="prekrsajiedit.php?novo=1"> DODAJ PREKRŠAJ </a></h4>
	 </div>
	<div id="content">
	<?php
	
	$veza=spajanjeNaBazu();
	
	
	
	if(isset($_GET['pogledaj']) || isset($_GET['prekrsaji']) || $_SERVER['QUERY_STRING']==""){
		$ind=0;
		$_SESSION['url']=$_SERVER['REQUEST_URI'];
		
		if(isset($_GET['pogledaj'])){
			$idvoz = $_GET['pogledaj'];
			$ind=1;
		}
		
		if(isset($_GET['prekrsaji'])){
			$idkat = $_GET['prekrsaji'];
			$ind=2;
		}
		
		if($ind==1){
		echo "<h1>Popis prekršaja po autu</h1>";	
		}
		elseif($ind==2){
			echo "<h1>Popis prekršaja po kategoriji</h1>";
		}
		else
		{
			echo "<h1>Popis svih prekršaja";
				if($aktivni_korisnik_tip==1 && $_SERVER['QUERY_STRING']==""){
					echo " iz mojih kategorija";
				}
			echo "</h1>";
		}
		
		$upit = "select
		kt.naziv,
		p.prekrsaj_id,
		p.naziv,
		p.`status`,
		p.novcana_kazna,
		p.datum_prekrsaja,
		p.vrijeme_prekrsaja,
		p.datum_placanja,
		p.vrijeme_placanja,
		p.slika,
		v.registracija,
		ko.korisnicko_ime
		from kategorija kt
		join prekrsaj p
		on kt.kategorija_id = p.kategorija_id
		join vozilo v
		on p.vozilo_id = v.vozilo_id
		join korisnik ko
		on v.korisnik_id = ko.korisnik_id";
		
		
		if($aktivni_korisnik_tip == 2){
			
			$upit.=" where v.vozilo_id = ".$idvoz;
		}
		
		if($aktivni_korisnik_tip == 1 && $_SERVER['QUERY_STRING']!=""){
			
			$upit.=" where kt.kategorija_id = ".$idkat;
		}
		if($aktivni_korisnik_tip == 1 && $_SERVER['QUERY_STRING']=="")
		{
			$upit.=" where kt.kategorija_id in (select kategorija_id from kategorija where moderator_id = ".$aktivni_korisnik_id.")";
		}
		
		$upit.=" order by p.status";
		$rezultat=upitNaBazi($veza,$upit);
		
		echo "<table border='1'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Kategorija</th><th>Prekršaj</th><th>Registracija</th><th>Datum prekršaja</th><th>Vrijeme prekršaja</th><th>Kazna</th><th>Status</th>";
		if($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip == 0){
			
			echo "<th>Administracija</th>";
		}
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		while(list($kategorija,$prek_id,$prekrsaj,$status,$kazna,$datprek,$vrprek,$datpl,$vrpl,$slika,$reg,$vlasnik) = mysqli_fetch_array($rezultat))
		{
			$datprek=date("d.m.Y",strtotime($datprek));
			$placanje="<a href='prekrsaji.php?plati=$prek_id&prekrsaj=$prekrsaj&kazna=$kazna'>Plati</a>";
			// $prekrsaji="<a href='prekrsaji.php?pogledaj=$idvoz'>Pogledaj</a>";
			echo "<tr>";
			echo "<td>".$kategorija."</td>";
			echo "<td>".$prekrsaj."</td>";
			echo "<td>".$reg."</td>";
			echo "<td>".$datprek."</td>";
			echo "<td>".$vrprek."</td>";
			echo "<td>".$kazna."</td>";
			echo "<td>".$status;
			if($status=='N'){
				echo "(".$placanje.")";
			}
			echo "</td>";
			if($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip == 0){			
			echo "<td><a href='prekrsajiedit.php?azuriraj=$prek_id'>Ažuriraj</a></td>";
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		
	}
	
	if(isset($_POST['Plati_submit'])){
		
		$idprek = $_POST['idprek'];
		$datum = date("Y-m-d",strtotime($_POST['datum']));
		$vrijeme = $_POST['vrijeme'];
		
		$upit = "update prekrsaj set status = 'P', datum_placanja='$datum', vrijeme_placanja='$vrijeme' where prekrsaj_id = ".$idprek;
		$rezultat=upitNaBazi($veza,$upit);
		
		header("Location: ".$_SESSION['url']);
	}
	
	
	if(isset($_GET['plati'])){
		
		$idprek = $_GET['plati'];
		$prekrsaj = $_GET['prekrsaj'];
		$kazna = $_GET['kazna'];
		
		?>
		
				  <div class="form_settings">
		   <form action="prekrsaji.php" method="POST" id="frmplati" onsubmit="return ValidateForm('frmplati')">
            <h3 class="title">Plaćanje "<?php echo $prekrsaj; ?>" prekršaja</h3>
			<input type="hidden" name="idprek" id="idprek" value="<?php echo $idprek;?>">
            <p><span>Datum:</span><input class="contact" type="text" name="datum" id="datum" value="<?php echo date("d.m.Y");?>"/></p>
            <p><span>Vrijeme:</span><input class="contact" type="text" name="vrijeme" id="vrijeme" value="<?php echo date("H:i:s");?>"/></p>
            <p><span>Kazna:</span><input class="contact" type="text" name="kazna" id="kazna" value="<?php echo $kazna;?>" disabled="disabled"/></p>
			<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="Plati_submit" value="Plati" /></p>
			</form>	
			<label id="poruka"></label>
	        </div>		
		
		<?php
	}
	
	prekidVeze($veza);
					?>
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	