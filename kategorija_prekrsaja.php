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
	
	if($aktivni_korisnik_tip==0){
		echo "<h4>  <a href='uredjivanjekategorije.php?novi=1'> Dodaj novu kategoriju </a></h4>";
		echo "<h4>  <a href='kategorija_prekrsaja.php?ukupan=1'> Ukupan broj prekrsaja </a></h4>";
		echo "<h4>  <a href='kategorija_prekrsaja.php?top=1'> Top 20 s najviše prekršaja </a></h4>";
	}
	?>
        
		
	 </div>
	<div id="content">	
          
		  <div class="form_settings">
		   
            <h3 class="title">Popis kategorija</h3>
            
			<?php
	  $veza=spajanjeNaBazu();
	

	
	$kolone=2;
	$upit = "SELECT count(*) FROM kategorija";
	
	$rezultat=upitNaBazi($veza,$upit);
	$row = mysqli_fetch_array($rezultat);
	$broj_redaka = $row[0];

	$broj_stranica = ceil($broj_redaka / $vel_str);
	
	$upit="SELECT * FROM kategorija ORDER BY kategorija_id  limit ".$vel_str;
	
	if (isset($_GET['stranica'])){
		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str);
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}
	
	$rezultat=upitNaBazi($veza,$upit);
	
	echo "<table border=\"1\">";
	echo "<thead>";
	echo "<tr>
		<th>Naziv</th>
		<th>Prekršaji po godinama</th>";
		if($aktivni_korisnik_tip==0){
			$kolone=3;
			echo "<th>Akcije</th>";
		}
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	while(list($kategorijaid,$moderatorid,$naziv,$opis)=mysqli_fetch_array($rezultat)){

		$dodatno = "";

		
		$link = "<a href='kategorija_prekrsaja.php?kategorija_id=$kategorijaid'>Pogledaj</a>";
		if($aktivni_korisnik_tip==1 && $dodatno != ""){
		
		}
		
		echo "<tr>
			<td> $naziv $dodatno</td>
			<td> $link ";
			if($moderatorid==$aktivni_korisnik_id){
			echo "<a href='prekrsaji.php?prekrsaji=$kategorijaid'>Kazneni prekršaji</a>";
			}
			echo "</td>"; 
       if($aktivni_korisnik_tip==0)
       echo "<td> <a href='uredjivanjekategorije.php?kategorija_id=$kategorijaid'>UREDI</a> </td>";
   } 
   
  
   echo "<tr>";
			echo "<td colspan='$kolone'>Stranice: ";
			if ($aktivna != 1) { 
			$prethodna = $aktivna - 1;
			echo "<a href=\"kategorija_prekrsaja.php?stranica=" .$prethodna . "\">&lt;</a>";	
			}
			for ($i = 1; $i <= $broj_stranica; $i++) {
			echo "<a ";
			if ($aktivna == $i) {
				$glavnastr="<span>$i</span>";
			}
			else
			{
				$glavnastr = $i;
			}
			echo "' href=\"kategorija_prekrsaja.php?stranica=" .$i . "\"> $glavnastr </a>";
			}
			if ($aktivna < $broj_stranica) {
			$sljedeca = $aktivna + 1;
			echo "<a href=\"kategorija_prekrsaja.php?stranica=" .$sljedeca . "\">&gt;</a>";	
			}
			echo "</td>";
			echo "</tr>";
   echo "</tbody>";
   echo "</table>";
   
   if(isset($_GET['kategorija_id'])){
	   $kategorija_id=$_GET['kategorija_id'];
	   $upit = "select
			year(p.datum_prekrsaja) as 'godina',
			count(year(p.datum_prekrsaja))
			from kategorija kt
			 join prekrsaj p
			on kt.kategorija_id = p.kategorija_id where kt.kategorija_id = ".$kategorija_id." 
			group by year(p.datum_prekrsaja)";
			
		$rezultat=upitNaBazi($veza,$upit);	
			if(mysqli_num_rows($rezultat)!=0){
			
			echo "<table border=\"1\">";
			echo "<thead>";
			echo "<tr>
				<th>Godina</th>
				<th>Broj prekršaja u godini</th>";
			echo "</tr>";		
			echo "</thead>";
			
			echo "<tbody>";	
		    while(list($godina,$broj_prek)=mysqli_fetch_array($rezultat)){
				echo "<tr>";
				echo "<td>$godina</td><td>$broj_prek</td>";
				echo "</tr>";
			}
		   echo "</tbody>";
		   echo "</table>";	
			}
			else
			{
				echo "<br>Nema podataka za traženu kategoriju!";
			}
   }
   
   
   if(isset($_GET['placneplac'])){
	   
	   echo "<h3 class='title'>Plaćeni i neplaćeni prekršaji po korisniku</h3>";
	   
	   $upit = "select
			distinct
			kor.korisnik_id,
			concat(kor.ime,' ',kor.prezime) as 'Korisnik',
			(select count(*) from prekrsaj p join vozilo vz on p.vozilo_id = vz.vozilo_id where vz.korisnik_id = kor.korisnik_id and p.`status`='P') as 'Placenih',
			(select count(*) from prekrsaj p join vozilo vz on p.vozilo_id = vz.vozilo_id where vz.korisnik_id = kor.korisnik_id and p.`status`='N') as 'Neplacenih'
			from prekrsaj pr
			join vozilo v
			on pr.vozilo_id = v.vozilo_id
			join korisnik kor
			on v.korisnik_id = kor.korisnik_id
			where pr.kategorija_id in (select kategorija_id from kategorija where moderator_id=2)
			order by kor.korisnik_id";
			$rezultat=upitNaBazi($veza,$upit);
			
			
			echo "<table border=\"1\">";
			echo "<thead>";
			echo "<tr>
				<th>Korisnik</th>
				<th>Placenih</th>
				<th>Neplacenih</th>";
			echo "</tr>";		
			echo "</thead>";
			
			echo "<tbody>";	
		    while(list($korid,$korisnik,$placenih,$neplacenih)=mysqli_fetch_array($rezultat)){
				echo "<tr>";
				echo "<td>$korisnik</td><td>$placenih</td><td>$neplacenih</td>";
				echo "</tr>";
			}
		   echo "</tbody>";
		   echo "</table>";	
   }
   
   
   if(isset($_GET['PretragaUkupno'])){
			
			$DatumOd = $_GET['DatumOd'];
			$DatumDo = $_GET['DatumDo'];
			
			$DatumOd = date("Y-m-d",strtotime($DatumOd));
			$DatumDo = date("Y-m-d",strtotime($DatumDo));
			
			$upit="SELECT COUNT(*)
			FROM prekrsaj pr
			WHERE pr.datum_prekrsaja BETWEEN '$DatumOd' and '$DatumDo'";

	$rezultat=upitNaBazi($veza,$upit);
	
	
	$red=mysqli_fetch_array($rezultat);
	$broj_redaka=$red[0];
	
	echo "Ukupno prekršaja: ".$broj_redaka;
	
   }
   
   if(isset($_GET['ukupan'])){
	   
	   ?>
	   
	   	<h2>Pregraga prekršaja po datumu</h2>
		<div class="form_settings">
		<form name="pretraga" id="pretraga" method="GET" action="kategorija_prekrsaja.php" enctype="multipart/form-data">
		<p><span>Datum od:</span><input class="contact"  type="text" name="DatumOd" id="DatumOd"/></p>
		<p><span>Datum do:</span><input  class="contact" type="text" name="DatumDo"  id="DatumDo"/></p>
		<p style="padding-top: 15px"><span>&nbsp;</span><input class="contact"  type="submit" name="PretragaUkupno" id="PretragaUkupno" value="Pretraži"/></p>
		</form>
		<label id="poruka"></label>
	    </div>		
	   
	   <?php
	   
   }
   
   
   if(isset($_GET['PretragaTop'])){
			
			$DatumOd = $_GET['DatumOd'];
			$DatumDo = $_GET['DatumDo'];
			
			$DatumOd = date("Y-m-d",strtotime($DatumOd));
			$DatumDo = date("Y-m-d",strtotime($DatumDo));
			
			$upit="SELECT
			CONCAT(kor.ime,' ',kor.prezime) AS 'naziv_korisnik',
			COUNT(kor.korisnik_id) AS 'brojka'
			FROM prekrsaj pr
			JOIN vozilo voz
			ON pr.vozilo_id = voz.vozilo_id
			JOIN korisnik kor 
			ON voz.korisnik_id = kor.korisnik_id
			WHERE pr.datum_prekrsaja BETWEEN '$DatumOd' AND '$DatumDo'
			GROUP BY kor.korisnik_id 
			ORDER BY COUNT(kor.korisnik_id)  desc limit 20";

	
	$rezultat=upitNaBazi($veza,$upit);
	echo "<h2>Top 20 s najviše prekršaja</h2>";
	echo "<table border=\"1\">";
	echo "<thead><tr>
		<th>Korisnik </th>
		<th>Broj prekršaja</th>";
	echo "</tr></thead>";
	
	echo "<tbody>";
	while(list($korisnik,$brojka)=mysqli_fetch_array($rezultat)){
		
		echo "<tr>
			<td> $korisnik </td>
			<td align=\"center\"> $brojka </td>";
		echo "</tr>";
		
	}
	
	echo "</tbody>";
	echo "</table>";
			
		}
   
      if(isset($_GET['top'])){
	   
	   ?>
	   
	   	<h2>Top 20 prekršaja</h2>
		<div class="form_settings">
		<form name="pretraga" id="pretraga" method="GET" action="kategorija_prekrsaja.php" enctype="multipart/form-data">
		<p><span>Datum od:</span><input class="contact"  type="text" name="DatumOd" id="DatumOd"/></p>
		<p><span>Datum do:</span><input  class="contact" type="text" name="DatumDo"  id="DatumDo"/></p>
		<p style="padding-top: 15px"><span>&nbsp;</span><input class="contact"  type="submit" name="PretragaTop" id="PretragaTop" value="Pretraži"/></p>
		</form>
		<label id="poruka"></label>
	    </div>		
	   
	   <?php
	   
   }
   
   
	
	if($aktivni_korisnik_tip==0 || $aktivni_korisnik_tip==1){
	   echo "<p><a href='kategorija_prekrsaja.php?placneplac=1'>Popis plaćenih/neplaćenih kazni po korisniku</a></p>";
   }

   
   echo "<br>";
   prekidVeze ($veza);
?>
			
			
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	