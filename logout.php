<?php
include "functions.php";
headd("Deconnexion");
session_unset(); 
session_destroy();
nav("deconnexion.php");
?>
	<br>
	<div class='text-center mx-auto d-block'>
		<b class='text-center textblue policemain mediumsize'>DECONNEXION</b>
		<br><br>
		<p class='mediumsize policesecond textblue'>Vous vous êtes bien déconnecté de l'Intranet Sardines&Cie</p>
		<br>
		<i class='smallsize policesecond textblue'>Pour vous reconnecter, veuillez cliquer sur le bouton suivant : </i>
		<br><br>
		<div class='text-center'>
			<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = "login.php"'>Se connecter</button>
		</div>
	</div>
	<br>
	<div class='text-center'>
		<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = "index.php"'>Retour accueil</button>
	</div>
</div>
<br>

<?php 
footer();
?>