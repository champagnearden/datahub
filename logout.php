<?php
include "functions.php";
headd($const['LOGOUT']['LOGOUT']);
session_unset(); 
session_destroy();
nav("logout.php");
?>
	<br>
	<div class='text-center mx-auto d-block'>
		<b class='text-center textblue policemain mediumsize'><?php echo $const['LOGOUT']['LOGOUT']; ?></b>
		<br><br>
		<p class='mediumsize policesecond textblue'><?php echo $const['LOGOUT']['SUCCESSFULL_LOGOUT']; ?></p>
		<br>
		<i class='smallsize policesecond textblue'><?php echo $const['LOGOUT']['RECONNECT']; ?></i>
		<br><br>
		<div class='text-center'>
			<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = "login.php"'><?php echo $const['LOGIN']['LOGIN']; ?></button>
		</div>
	</div>
	<br>
	<div class='text-center'>
		<button type='button' class='btn bgmaincolor text-white center-block' onclick = 'location.href = "/"'><?php echo $const['LOGOUT']['BACK']; ?></button>
	</div>
</div>
<br>

<?php 
footer();
?>