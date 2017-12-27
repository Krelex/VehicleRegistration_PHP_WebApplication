


<!DOCTYPE HTML>
<html>

<head>
  <title>Filip Cogelja IWA_Projekt</title>
  <meta name="autor" value="Filip Cogelja" />
  <meta name="datum" content="10.08.2017" />
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="cogelja.css" title="style" />
</head>
<body>
	<header>
	<?php include ("menu.php")?>

	</header>
	<div id="site_content">
	<div id="content">
	<form action="#" method="post">
          <div class="form_settings">
		  <h1> Dodavanje korisnika : </h1>
		    <p><span>Korisnicko Ime :</span><input class="contact" type="korisnicko_ime" name="korisnicko_ime" id="korisnicko_ime"/></p>
            <p><span>Ime :</span><input class="contact" type="ime" name="ime" id="ime"/></p>
            <p><span>Prezime :</span><input class="contact" type="prezime" name="prezime" id="prezime"/></p>
			<p><span>Lozinka :</span><input class="contact" type="lozinka" name="lozinka" id="lozinka"/></p>
								<p><span>Tip korisnika :</span>
								<td><select name="tip">
									<option value="0" <?php if ($tip == 0) echo "selected='selected'";?>>Administrator</option>
									<option value="1" <?php if ($tip == 1) echo "selected='selected'";?>>Moderator</option>
									<option value="2" <?php if ($tip == 2) echo "selected='selected'";?>>Registrirani korisnik</option>
								</select></td>
			<p><span>Email :</span><input class="contact" type="email" name="email" id="email"/></p>
			<p><span>Slika :</span><input type="file" name="slika" id="slika"/></p>
			<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="Korisnik_submit" value="Unesi" /></p>
	</form>	
	</div>
	</div>
	<div id="footer">
	<a href="o_autoru.html">O autoru stranice.</a>
	</div>
	</body>
</html>