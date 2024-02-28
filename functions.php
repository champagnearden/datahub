<?php
headd("");
chdir($_SERVER['DOCUMENT_ROOT']);
$ips=json_decode(file_get_contents("banned_ip.json"),true);
$ips=($ips == null)? array() : $ips;
foreach($ips as $ip){
	if ($ip['ip'] == $_SERVER['REMOTE_ADDR']){
		unset($_SESSION['tentative']);
		echo "
			<script>
				var str = prompt(\"Non non, vous êtes banni !\\nVous pouvez dire ce que vous voulez vous l'avez cherché !\");
				if (str==null || str==''){str='Partage_à_tes_camarades_sur_webex';}
				window.location.href='/?EasterEgg=\"'+str+'\"';
			</script>";
	}
}
unset($ips);
$const = (new Consts())->get();

class Consts {
	public $consts;
	function __construct() {
		$this -> consts = json_decode(file_get_contents("const.json"), true);
	}
	function get() {
		return $this -> consts;
	}
}

function headd($tpage){
	if (session_status()<2){
		session_start();
	}
	echo <<< HTML
        <!DOCTYPE html>
        <html>
        <head>
            <title>$tpage</title>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
            <link rel='icon' type='image/png' href='/images/cgd.png'>
            <link rel='stylesheet' type='text/css' href='/style.css'/>
            <link rel='preconnect' href='https://fonts.googleapis.com'>
            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
            <link href='https://fonts.googleapis.com/css2?family=Asset&display=swap' rel='stylesheet'>
            <link rel='preconnect' href='https://fonts.googleapis.com'>
            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
            <link href='https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap' rel='stylesheet'>
        </head>
        <body>
    HTML;
}

function nav($page){
	echo "
<script>
	window.addEventListener('scroll', function(){
    let nav = document.querySelector('nav');
    nav.classList.toggle('scrolling-active', window.scrollY > 0);
  });
  window.addEventListener('scroll', function(){
    let nav = document.querySelector('nav');
    nav.classList.toggle('scrolling-desactive', window.scrollY < 1);
  });
 </script>
<nav class='navbar navbar-expand-sm bgmaincolor navbar-dark fixed-top py-3 policesecond' >
	&emsp;
	<a class='navbar-brand' href='/'>
    &emsp;
    <img src='/images/cgd.png' alt='Logo' height='20%' width='20%'>
  </a>
  <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#collapsibleNavbar'>
    <span class='navbar-toggler-icon'></span>
  </button>
	<ul class='navbar-nav collapse navbar-collapse' id='collapsibleNavbar'>
		<li class='nav-item'>
			<a class='nav-link";
	if ($page == "index") {
		echo " active'";
	}else {
		echo "'";
	}
	echo " href='/' title=\"Accueil\">Accueil</a>
		</li>";
	if (isset($_SESSION['username'])){
		echo "
		<li class='nav-item'>
			<a class='nav-link";
		if ($page == "gestion.php") {
			echo " active'";
		}else {
			echo "'";
		}
		echo "href='/gestion.php' title='Page de gestion des utilisateurs \nAnnuaire'>Gestion</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link";

			if ($page == "fichiers.php") {
			echo " active'";
		}else {
			echo "'";
		}
		echo "href='/FTP/' title='-Zone de dépôt\n-Gestion des fichiers partagés\n-Consultation des dossiers personnels'>Espace de fichiers</a>
		</li>";
	}
	echo "
		<li class='nav-item'>
			<a class='nav-link border ";
	if (isset($_SESSION['pren_nom'])){
		echo " traitdroit";
	}
	if ($page == "connexion.php" || $page == "deconnexion.php") {
		echo " active'";
	}else {
		echo "'";
	}
	if (isset($_SESSION['pre_nom'])){
 		echo "title='Page de déconnexion' href='/logout.php' class='btn btn-outline-dark btn-sm'>Se déconnecter</a></li>";
	}else {
		echo"title='Page de connexion\nCréation de compte' href='login.php'>Se connecter</a>
		</li>";
	}	
	echo " 
		<li class='nav-item'>
			<a class='nav-link ";
	if($page=="faq.php"){
		echo "active' href='faq.php";
	} else {
		echo "'href='javascript:window.open(\"/faq.php\",\"\",\"location=no, width=930, height=380, menubar=no, status=no, scrollbars=no, menubar=no\");";
	}
		echo"'>Aide</a>
		</li>
		<li class='nav-item text-white'>";
	if (isset($_SESSION['pre_nom'])){
 		echo "Vous êtes connecté en tant que <b>".$_SESSION['pre_nom']."</b>&nbsp;<sub>(".$_SESSION['role'].")</sub>";
	}
	else {
		echo "Vous n'êtes pas connecté";
	}
	echo "
		</li>
	</ul>
</nav>
</div>
<br><br><br><br><br><br>";
}

//function str_contains($seek, $long){
//    $seek=($seek=="")?" ":$seek;
//    if (strpos($long, $seek) === false) {
//        return false;
//    }else{
//        return true;
//    }
//}

function session_verif($salaries,$second=false){
	$pass=false;
	foreach($salaries as $salarie){
		if($_POST['username'] == $salarie['username']){
			if($_POST['motdepasse'] == $salarie['motdepasse']){
				$_SESSION['pre_nom'] = ucwords(strtolower($salarie['prenom'])) . " " . ucwords(strtolower($salarie['nom']));
				$pass=true;
				break;
			}
		}
	}
	nav("Bienvenue");
	if ($pass) {
		$_SESSION['role'] = $salarie['role'];
		$_SESSION['username'] = $salarie['username'];
		echo "
		<br>
		<div class='text-center mx-auto d-block'>
			<b class='text-center textblue policemain mediumsize'>BIENVENUE</b>
			<br><br>
			<p class='mediumsize policesecond textblue'>Vous êtes bien connecté en tant que <i><b>".$_SESSION['pre_nom']."</b></i></p>
			<div class='text-center'><br>
				<br>
                Vous allez êtreredirigé dans quelques instants...
                <script>document.location.href='/'</script>
				<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = \"/\"'>Continuer</button>
			</div>
		</div>
		";
		$_SESSION['tentative']=0;
	} else {
		isset($_SESSION['tentative']) ? $_SESSION['tentative']++ : $_SESSION['tentative']=1;
		if ($_SESSION['tentative']>=3){
			$ips=json_decode(file_get_contents("banned_ip.json"), true);
			$ips=($ips == null)? array() : $ips;
			$banned=0;
			foreach($ips as $ip){
				if ($ip == $_SERVER['REMOTE_ADDR']){
					$banned=1;
					break;
				}
			}
			if (boolval(!$banned)){
				array_push($ips, array(
					"date" => date("j-n-Y H:i:s"),
					"ip"=>$_SERVER['REMOTE_ADDR'])
				);
				file_put_contents("banned_ip.json", json_encode($ips));
			}
			header('Location: functions.php');
			die();
		}
		echo "
		<br>
		<div class='text-center mx-auto d-block'>
			<b class='text-center textblue policemain mediumsize'>ERREUR DE CONNEXION</b>
			<br><br>
			<p class='mediumsize policesecond textblue'>Votre identifiant ou mot de passe est incorrect.</p>
			<p class='mediumsize policesecond textblue'>Il vous reste <b>".intval(3-$_SESSION['tentative'])."</b> tentative";
			if(intval(3-$_SESSION['tentative'])>1){echo "s";}
			echo "
			</p>
			<p class='mediumsize policesecond textblue'>Attention, au bout de 3 tentatives vous serez banni de l'intranet !</p>
			<div class='text-center'>
				<br><br>
				<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = \"/login.php\"'>Réessayez</button>
			</div>
		</div>
		";
		
	}
}

function footer(){	
	echo '</div><br><br><br><br><footer class="jumbotron bgmaincolor text-center text-white"><br>	
	&copy '.strftime("%Y").' CyberData | <a href="mailto:jbbeck42@gmail.com">jbbeck42@gmail.com</a> | <p id="date">'.date("j-n-Y H:i:s").'
		<script>
			setInterval(function(){
				date = new Date();
				seconds = date.getSeconds();
				minutes = date.getMinutes();
				hours = date.getHours();
				jour = date.getDate();
				mois = date.getMonth();
				annee = date.getFullYear();
				document.getElementById("date").innerHTML = jour+"-"+((mois+1))+"-"+annee+" "+hours+":"+minutes+":"+seconds;
			},1000);
		</script>
	</p> </footer>

	</body>
	</html>
';
}
?>