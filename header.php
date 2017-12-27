<?php
	if(session_id()=="")session_start();

	$stranica=basename($_SERVER["SCRIPT_NAME"]);
	$putanja=$_SERVER['REQUEST_URI'];
	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$aktivni_korisnik_id=0;		

	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
	}
	
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Filip Cogelja IWA_Projekt</title>
  <meta name="autor" value="Filip Cogelja" />
  <meta name="datum" content="10.08.2017" />
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="cogelja.css" title="style" />
  <script type="text/javascript">
  function ValidateForm(forma){
	
		
		var elementi = document.forms[forma];
		var poruka = "";
		var praznih=0;
		
		
		if(forma=="frmvozilo"){
		
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value==""){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";	
				}
				
		
			if(elementi[i].id=="registracija" && elementi[i].value != ""){
						var rega = elementi[i].value;
						var registexp = /^([A-Za-zČŽĆŠ]{2})+\-([0-9])+\-([A-Za-z]{1,2})$/;
						
						if(registexp.test(rega) == false) {
							praznih++;
							poruka+="<br>Krivi format registracije";
							}
							
			}
									
			}
		
		}
		
		
		if(forma=="frmplati"){
		
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value==""){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";
								
				}
				
			if(elementi[i].id=="datum" && elementi[i].value != ""){
					
					var re = /^\d{2}([./-])\d{2}\1\d{4}$/;
					var datum = elementi[i].value;
					

					if(re.test(datum) == false) {
					poruka+="<br>Pogrešan oblik datuma (mora biti dd.mm.yyyy)";					
					praznih++;

					}
					
				}
				
				if(elementi[i].id=="vrijeme" && elementi[i].value != ""){

					var vrijeme = elementi[i].value;
					
					var vrreg = /^([01][1-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
					
					if(vrreg.test(vrijeme) == false) {
						  poruka+="<br>Pogresan oblik vremena (mora biti hh:mm:ss)";						  
						  praznih++;
					}
				}

			}
			
		}
		
		if(forma=="frmprekrsaji"){
			
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value=="" && elementi[i].id!="video"){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";
								
				}
				
				if(elementi[i].id=="datum" && elementi[i].value != ""){
					
					var re = /^\d{2}([.])\d{2}\1\d{4}$/;
					var datum = elementi[i].value;
					
					

					if(re.test(datum) == false) {
					poruka+="<br>Pogrešan oblik datuma (mora biti dd.mm.yyyy)";					
					praznih++;

					}
					
				}
				
				if(elementi[i].id=="vrijeme" && elementi[i].value != ""){

					var vrijeme = elementi[i].value;
					
					var vrreg = /^([01][1-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
					
					if(vrreg.test(vrijeme) == false) {
						  poruka+="<br>Pogresan oblik vremena (mora biti hh:mm:ss)";						  
						  praznih++;
					}
				}
				
			}
			
		}
		
		
		if(forma=="frmkategorija"){
			
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value=="" && elementi[i].id!="video"){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";
								
				}
				
			}
			
		}
		
		
				if(forma=="frmkorisnik"){
			
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value=="" && elementi[i].id!="video"){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";
								
				}
				
			}
			
		}
		
		if(praznih>0){
			document.getElementById("poruka").innerHTML=poruka;
			return false;
		}		
		
	}
	
function PretvoriVelika(){
	
	var reg = document.getElementById("registracija").value;
	
	document.getElementById("registracija").value = reg.toUpperCase();
	
}
  
  </script>
</head>
<body>
	<header>
	<?php include ("menu.php")?>

	</header>