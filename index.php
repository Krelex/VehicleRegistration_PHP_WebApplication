<?php
include("header.php");
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
	
	if($aktivni_korisnik_tip==1){
		header("Location: kategorija_prekrsaja.php");
	}
	?>
        
		
	 </div>
	<div id="content">	
          
		  <div class="form_settings">
		   
            <h3 class="title">Anonimni/neregistrirani korisnik</h3>
            <p> Anonimni/neregistrirani korisnik može samo vidjeti naziv kategorije prekršaja te odabirom kategorije prekršaja vidi broj postojećih prekršaja za kategoriju po godinama. </p>
			
			<h3 class="title">Registrirani korisnik</h3>
            <p> Registrirani korisnik uz svoje funkcionalnosti ima i sve funkcionalnosti kao i anonimni/neprijavljeni korisnik, te unosi/ažurira/pregledava svoja motorna vozila. Prilikom unosa mora unijeti registraciju, marku vozila (VW, …) i tip vozila (Golf 3, …). Također vidi popis svojih trenutnih i prošlih prekršajnih prijava po motornom vozilu. Prekršajna prijava sadrži obavezno sliku te opcionalno video. Registrirani korisnik odabirom na prekršajnu prijavu koja ima status neplaćena (N) može istu platiti pri čemu se automatski predlaže datum i vrijeme plaćanja (koje je moguće izmijeniti) te ažurira status prekršaja u plaćen (P). </p>
			
			<h3 class="title">Moderator</h3>
            <p> Moderator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i registrirani korisnik te uz to može, dodavati, pregledavati i ažurirati prekršajne prijave za dodijeljene kategorije. Moderator nakon prijave vidi popis svojih kategorija i odabirom kategorije popis kaznenih prijava korisnika. Prilikom unosa prekršaja mora odabrati kategoriju (Brzina, Alkohol, …), odabrati motorno vozilo (registraciju) i unijeti naziv (Prekoračenje brzine do 10 km/h, Udio alkohola do 0,50 promila…), opis prekršaja, iznos kazne (HRK), datum i vrijeme prekršaja, url do slike na webu (slika kazne) te opcionalno url do nekog videa na webu (snimka prekršaja). Nakon unosa status prekršaja automatski se postavlja u status neplaćen (N). Moderator uz to može vidjeti ukupan broj plaćenih i neplaćenih prekršaja korisnika. </p>
			
			<h3 class="title">Administrator</h3>
            <p> Administrator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i moderator. Uz to administrator unosi, ažurira i pregledava korisnike sustava te definira i ažurira njihove tipove. Administrator definira, pregledava i ažurira kategorije (Brzina, Alkohol, …), te bira moderatora za pojedinu kategoriju između korisnika koji imaju tip moderator. Jedan moderator može upravljati sa više kategorija. Administrator vidi ukupan broj prekršaja u odabranom razdoblju, te top 20 korisnika sa najviše kazni u odabranom razdoblju. </p>
        </div>		
	</div>
	</div>
<?php
include("footer.php");
?>	