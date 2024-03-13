<?php
headd("");
$prefix=$_SERVER['DOCUMENT_ROOT'];
$ip=json_decode(file_get_contents("$prefix/banned_ip.json"),true);
$ip=($ip == null)? array() : $ip;
foreach($ip as $i){
	if ($i['ip'] == $_SERVER['REMOTE_ADDR']){
		unset($_SESSION['tentative']);
		echo "
			<script>
				var str = prompt(".$const['FUNCTIONS']['BAN'].");
				if (str==null || str==''){str='Partage_à_tes_camarades_sur_webex';}
				window.location.href='/?EasterEgg=\"'+str+'\"';
			</script>";
	}
}
unset($ip);
$const = (new Consts()) -> get_lang();

class Consts {
	public $consts;
	function __construct() {
		global $prefix;
		$this -> consts = json_decode(file_get_contents("$prefix/const.json"), true);
	}
	public function get() {
		return $this -> consts;
	}

	public function get_lang() {
		$langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		for ($i=0; $i < sizeof($langs); $i++) {
			$langs[$i] = explode("-",explode(";", $langs[$i])[0])[0];
		}
		$langs = array_unique($langs);
		foreach ($langs as $lang) {
			if (array_key_exists($lang, $this -> consts)){
				$ret = $this -> consts[$lang];
				$ret["roles"] = $this -> consts['roles'];
				$ret["conf"] = $this -> consts['conf'];
				return $ret;
			}
		}
		return $this -> consts['en'];
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
	global $const;
	echo <<< HTML
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
	HTML;
	echo "<a class='nav-link";
	if ($page == "index") {
		echo " active'";
	}else {
		echo "'";
	}
	echo " href='/' title='".$const['FUNCTIONS']['HOME']."'>".$const['FUNCTIONS']['HOME']."</a>
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
		echo "href='/gestion.php' title=".$const['FUNCTIONS']['GESTION_TITLE'].">".$const['FUNCTIONS']['GESTION']."</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link";
			if ($page == "fichiers.php") {
			echo " active'";
		}else {
			echo "'";
		}
		echo "href='/FTP/' title='".$const['FUNCTIONS']['FTP_TITLE']."'>".$const['FUNCTIONS']['FTP']."</a>
		</li>";
	}
	echo "
		<li class='nav-item'>
			<a class='nav-link border ";
	if (isset($_SESSION['pren_nom'])){
		echo " traitdroit";
	}
	if ($page == "login.php" || $page == "logout.php") {
		echo " active'";
	}else {
		echo "'";
	}
	if (isset($_SESSION['pre_nom'])){
 		echo 'title="'.$const["FUNCTIONS"]["LOGOUT_TITLE"].'" href="/logout.php" class="btn btn-outline-dark btn-sm">'.$const["FUNCTIONS"]["LOGOUT"].'</a></li>';
	}else {
		echo "title='".$const['FUNCTIONS']['LOGIN_TITLE']."' href='login.php'>".$const['LOGIN']['LOGIN']."</a>
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
		echo "'>".$const['FUNCTIONS']['HELP']."</a>
		</li>
		<li class='nav-item text-white'>";
	if (isset($_SESSION['pre_nom'])){
 		echo $const['FUNCTIONS']['LOGGED_AS']."<b>".$_SESSION['pre_nom']."</b>&nbsp;<sub>(".$_SESSION['role'].")</sub>";
	}
	else {
		echo $const['FUNCTIONS']['NOT_LOGGED'];
	}
	echo <<< HTML
			</li>
		</ul>
	</nav>
	</div>
	<br><br><br><br><br><br>
	HTML;
}

function session_verif($salaries,$second=false){
	global $const;
	$pass=false;
	foreach($salaries as $salarie){
		if($_POST['username'] == $salarie['username']){
			if( password_verify($_POST['motdepasse'], $salarie['motdepasse']) ) {
				$_SESSION['pre_nom'] = ucwords(strtolower($salarie['prenom'])) . " " . ucwords(strtolower($salarie['nom']));
				$pass=true;
				break;
			}
		}
	}
	nav($const['FUNCTIONS']['WELCOME']);
	if ($pass) {
		$_SESSION['role'] = $salarie['role'];
		$_SESSION['username'] = $salarie['username'];
		echo "
		<br>
		<div class='text-center mx-auto d-block'>
			<b class='text-center textblue policemain mediumsize'>".$const['FUNCTIONS']['WELCOME']."</b>
			<br><br>
			<p class='mediumsize policesecond textblue'>".$const['FUNCTIONS']['LOGGED_AS']."<i><b>".$_SESSION['pre_nom']."</b></i></p>
			<div class='text-center'><br>
				<br>
                ".$const['FUNCTIONS']['REDIRECT']."
                <script>document.location.href='/'</script>
				<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = \"/\"'>".$const['FUNCTIONS']['CONTINUE']."</button>
			</div>
		</div>
		";
		$_SESSION['tentative']=0;
	} else {
		isset($_SESSION['tentative']) ? $_SESSION['tentative']++ : $_SESSION['tentative']=1;
		if ($_SESSION['tentative']>=3){
			$ip=json_decode(file_get_contents("/banned_ip.json"), true);
			$ip=($ip == null)? array() : $ip;
			$banned=0;
			foreach($ip as $i){
				if ($i == $_SERVER['REMOTE_ADDR']){
					$banned=1;
					break;
				}
			}
			if (boolval(!$banned)){
				array_push($ip, array(
					"date" => date("j-n-Y H:i:s"),
					"ip"=>$_SERVER['REMOTE_ADDR'])
				);
				file_put_contents("banned_ip.json", json_encode($ip));
			}
			header('Location: functions.php');
			die();
		}
		echo "
		<br>
		<div class='text-center mx-auto d-block'>
			<b class='text-center textblue policemain mediumsize'>".$const['FUNCTIONS']['LOGIN_ERROR']."</b>
			<br><br>
			<p class='mediumsize policesecond textblue'>".$const['FUNCTIONS']['WRONG_CREDS']."</p>
			<p class='mediumsize policesecond textblue'>".$const['FUNCTIONS']['REMAINS']."<b>".intval(3-$_SESSION['tentative'])."</b>".$const['FUNCTIONS']['ATTEMPT'];
			if(intval(3-$_SESSION['tentative'])>1){echo "s";}
			echo "
			</p>
			<p class='mediumsize policesecond textblue'>".$const['FUNCTIONS']['WARNING']."</p>
			<div class='text-center'>
				<br><br>
				<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = \"/login.php\"'>".$const['FUNCTIONS']['RETRY']."</button>
			</div>
		</div>
		";
		
	}
}

function hash_password(string $password): string {
	return password_hash($password, PASSWORD_BCRYPT);
}

function footer() {	
	echo <<< HTML
	<br><br><br><br>
	<footer class="jumbotron bgmaincolor text-center text-white">
		<br>	
		&copy;&nbsp;
	HTML;
	echo strftime("%Y");
	echo <<< HTML
	CyberData | <a href="mailto:jbbeck42@gmail.com">jbbeck42@gmail.com</a> | <p id="date"></p> 
	</footer>
	<script>
		function applyDate() {
			date = new Date();
			seconds = date.getSeconds();
			minutes = date.getMinutes();
			hours = date.getHours();
			jour = date.getDate();
			mois = date.getMonth();
			annee = date.getFullYear();
			document.getElementById("date").innerHTML = jour+"-"+((mois+1))+"-"+annee+" "+hours+":"+minutes+":"+seconds;
		}
		applyDate();
		setInterval(applyDate(),1000);
	</script>
	</body>
	</html>
	HTML;
}
?>