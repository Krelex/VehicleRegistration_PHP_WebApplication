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
	echo "<h4>  <a href='korisnik.php'> Dodaj novog korisnika </a></h4>";
	?>
        
		
	 </div>
	<div id="content">	
          
		  <div class="form_settings">
		   
            <h3 class="title">Popis kategorija</h3>
            
			<?php
	  $veza=spajanjeNaBazu();
	 
	 $kolone = 5;
	$upit = "SELECT count(*) FROM korisnik";

	$rezultat=upitNaBazi($veza,$upit);
	$red = mysqli_fetch_array($rezultat);
	$broj_redaka = $red[0];
	
	$broj_stranica = ceil($broj_redaka / $vel_str);
	
	
	
	$upit = "SELECT * FROM korisnik";

	$upit.=" order by korisnik_id LIMIT " . $vel_str;
	
	if (isset($_GET['stranica'])){
		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str);
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}
	

	$rezultat=upitNaBazi($veza,$upit);
	echo "<h2>Popis korisnika</h2>";
	echo "<table border='1'>";
	echo "<thead>";
	echo "<tr>
		<th>Korisničko ime</th>
		<th>Ime</th>";
	echo "<th>Prezime</th>
		<th>E-mail</th>
		<th>Akcija</th>
	</tr>";
	echo "</thead>";
	echo "<tbody>";
	while(list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_array($rezultat)) {

		
		
		echo "<tr>
			<td>$kor_ime</td>
			<td>$ime</td>";
		
			
		
		echo "<td>" .  (empty($prezime) ? "&nbsp;" : "$prezime") . "</td>
			<td>" .  (empty($email) ? "&nbsp;" : "$email") . "</td>";
		if ($aktivni_korisnik_tip==0) {
			echo "<td><a class='link' href='korisnik.php?korisnik=$id'>UREDI</a></td>";
		}
		echo	"</tr>";
	}

		echo "<tr>";
			echo "<td colspan='$kolone'>Stranice: ";
			if ($aktivna != 1) { 
			$prethodna = $aktivna - 1;
			echo "<a href=\"korisnici.php?stranica=" .$prethodna . "\">&lt;</a>";	
			}
			for ($i = 1; $i <= $broj_stranica; $i++) {
			echo "<a ";
			if ($aktivna == $i) {
				$glavnastr="<strong>$i</strong>";
			}
			else
			{
				$glavnastr = $i;
			}
			echo "' href=\"korisnici.php?stranica=" .$i . "\"> $glavnastr </a>";
			}
			if ($aktivna < $broj_stranica) {
			$sljedeca = $aktivna + 1;
			echo "<a href=\"korisnici.php?stranica=" .$sljedeca . "\">&gt;</a>";	
			}
			echo "</td>";
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
	
	if ($aktivni_korisnik_tip==0) {
		echo '<a class="link" href="korisnik.php">Dodaj korisnika</a>';
	} else if(isset($_SESSION["aktivni_korisnik_id"])) {
		echo '<a class="link" href="korisnik.php?korisnik=' . $_SESSION["aktivni_korisnik_id"] . '">Uredi moje podatke</a>';
	}
prekidVeze ($veza);
?>
			
			
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>