<?php
include ("functions.php");
headd("Accueil");
nav("index.php");
?>
<div class='textblue policemain mediumsize text-center bgmaincolor'>
	<br>
	<img src='/images/cgd.png' alt='logo' width='20%' heigth='20%'>
	<br><br>
</div>
<br>
<div class='container textblue policemain mediumsize text-center'>
	Bienvenue sur l'intranet de Sardines&Cie 
	<br><br>
	<i class='policesecond'>
		<?php 
		$d=date('H');
		if (!isset($_SESSION['pre_nom'])){
			echo "Veuillez vous connecter pour accéder au reste de l'intranet";
		} elseif ($d < 6 || $d > 17) {
			echo "Bonsoir ".$_SESSION['pre_nom'];
		}elseif ($d < 13 || $d >= 6) {
			echo "Bonjour ".$_SESSION['pre_nom'];
		}else{
			echo "Bonne après-midi ".$_SESSION['pre_nom'];
		}
		?>
	</i>
	<br><br>
	<a class='btn bgmaincolor text-white policesecond'
	<?php
	if (isset($_SESSION['pre_nom'])){
	 	echo " href='/logout.php' class='btn btn-outline-dark btn-sm'>Se déconnecter</a>";
	}
	else {
			echo" href='/logout.php'>Se connecter</a>";
	}
	echo "
</div> 
<br><br>";
footer();
?>