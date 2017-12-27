<?php
ob_start();
?>
<div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <h1><a href="index.php">Registracija<span class="logo_colour"> vozila</span></a></h1>
		  <h2><a>IWA projekt 2016/2017.</a></h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
		 <li class="selected"><a href="index.php">Home</a></li>
		<?php
		if(session_id()=="")session_start();
		switch($aktivni_korisnik_tip){
		
		case 0:
		?>         
          <li><a href="korisnici.php">Korisnici</a></li>
          <li><a href="vozila.php">Vozila</a></li>
          <li><a href="prekrsaji.php">Prekrsaji</a></li>	  
		<?php
		break;		
		case 1:
		?> 
        <li><a href="prekrsaji.php">Prekrsaji</a></li>  
		<?php
		break;		
		case 2:
		?> 
        <li><a href="vozila.php">Vozila</a></li> 
		<?php		
		break;
		}
		?>  
		  <li><a href="kategorija_prekrsaja.php">Kategorija Prekrsaja</a></li>
		  	<?php
			if(isset($_SESSION['aktivni_korisnik'])){
				echo "<li><a href=\"odjava.php\">Odjava</a></li>";
			}
			else
			{
				echo "<li><a href=\"Prijava.php\">Prijava</a></li>";
			}
			?>
		  
        </ul>
      </div>
    </div>


