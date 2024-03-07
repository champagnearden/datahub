<?php 
include "functions.php";
headd($const['FAQ']['TITLE']);
nav("faq.php");
?>
<div class=" container-fluid textblue text-center policesecond">
	<h4><b class="mediumsize"><?php echo $const['FAQ']['INTRANET']; ?></b></h4>
</div>
<div class="container">
	<div class="row">
		<div class="col"><img src="/images/sardine.png" class="img-fluid"></div>
		<div class="col">
			<ol>
				<li>
					<a href="#accueil" onclick="display('accueil');"><?php echo $const['FUNCTIONS']['HOME']; ?></a>
				</li>
				<?php
				if(isset($_SESSION['username'])){
					echo '
				<li>
					<a href="#gestion" onclick="display(\'gestion\');">'.$const["FUNCTIONS"]['GESTION'].'</a>
				</li>
				<li>
					<a href="#espace-de-fichiers" onclick="display(\'espace-de-fichiers\');">'.$const["FUNCTIONS"]['FTP'].'</a>
				</li>';
				}
				?>
				<li>
					<a href="#connexion" onclick="display('connexion');"><div><?php echo $const['LOGIN']['LOGIN']." / ".$const['FUNCTIONS']['LOGOUT']; ?></div></a>
				</li>
				<li>
					<a href="#aide" onclick="display('aide');"><?php echo $const['FUNCTIONS']['HELP']; ?></a>
				</li>
			</ol>
		</div>
		<div class="col"></div>
	</div>
</div>
<div id="accueil" style="display: none;">
	<hr>
	<p>
		<?php echo $const['FAQ']['HOME']; ?>
		<br>
		<?php echo $const['FAQ']['HOME_2']; ?>
		<a href="#connexion" onclick="display('connexion-intranet');"><?php echo $const['LOGIN']['LOGIN']." / ".$const['FUNCTIONS']['LOGOUT']; ?></a>)
	</p>
</div>
<?php
if(isset($_SESSION['username'])){
	echo '
<div id="gestion" style="display: none;">
	<hr>';
	if($_SESSION['role']==$const['roles']['USER']){
		echo "<p>".$const['FAQ']['GESTION_USER']."</p>";
	}else if($_SESSION['role']==$const['roles']['MODO']){
		echo "<p>".$const['FAQ']['GESTION_MODO']."</p>";
	}else if($_SESSION['role']==$const['roles']['ADMIN']){
		echo "<p>".$const['FAQ']['GESTION_ADMIN']."</p>";
	}
	echo "
</div>
<div id=\"espace-de-fichiers\" style=\"display: none;\">
	<hr>
	<p>".$const['FAQ']['FTP']."</p>
</div>";
}
?>
<div id="connexion" style="display: none;">
	<hr>
	<p><?php echo $const['FAQ']['LOGIN']; ?></p>
</div>
<div id="aide" style="display: none;">
	<hr>
	<p><?php echo $const['FAQ']['HELP']; ?></p>
</div>
<script>
	function display(target){
		const ids= [
			'accueil'
			<?php 
			if(isset($_SESSION['username'])){
				echo ",'gestion',
			'espace-de-fichiers'\n";
			}
			?>,
			'connexion',
			'aide'
		];
		for(let i=0; i<ids.length;i++){
			document.getElementById(ids[i]).style.display='none';
		}
		if (target!=""){
			document.getElementById(target).style.display='block';
		}
	}
	let url = window.location.href;
	url = url.replace('http://','');
	url = url.replace('www.','');
	url = url.replace('<?php echo $const['conf']['DOMAIN']; ?>/faq.php','');
	if (url != ""){
		display(url.replace("#",''));
	}
</script>
<br>
<?php
footer();
?>