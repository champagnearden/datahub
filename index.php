<?php
include ("functions.php");
headd($const["FUNCTIONS"]["HOME"]);
nav("index");
?>
<div class='textblue policemain mediumsize text-center bgmaincolor'>
	<br>
	<img src='/images/cgd.png' alt='logo' width='20%' heigth='20%'>
	<br><br>
</div>
<br>
<div class='container textblue policemain mediumsize text-center'>
	<?php echo $const["INDEX"]["WELCOME"]?>
	<br><br>
	<i class='policesecond'>
		<?php 
		$d=date('H');
		if (!isset($_SESSION['pre_nom'])){
			echo $const["INDEX"]["FORCE_LOGIN"];
		} elseif ($d < 6 || $d > 17) {
			echo $const["INDEX"]["EVENING"].$_SESSION['pre_nom'];
		}elseif ($d < 13 || $d >= 6) {
			echo $const["INDEX"]["MORNING"].$_SESSION['pre_nom'];
		}else{
			echo $const["INDEX"]["AFTERNOON"].$_SESSION['pre_nom'];
		}
		?>
	</i>
	<br><br>
	<a class='btn bgmaincolor text-white policesecond'
	<?php
	if (isset($_SESSION['pre_nom'])){
	 	echo " href='/logout.php' class='btn btn-outline-dark btn-sm'>".$const["FUNCTIONS"]["LOGOUT"]."</a>";
	}
	else {
			echo" href='/logout.php'>".$const["LOGIN"]["LOGIN"]."</a>";
	}
	echo "
</div>";
footer();
?>