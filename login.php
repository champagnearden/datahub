<?php
include "./functions.php";

headd($const["LOGIN"]["LOGIN"]);
nav("login.php");

if(isset($_SESSION['pre_nom'])){
    header("Location: /");
}

?>

<script>
        function display(self) {
            self.type='text';
        }
        function hide(self) {
            self.type='password';
        }
    </script>
<div class='container container-fluid policemain textblue mediumsize text-center'><br>
  <?php echo $const['LOGIN']['HOME']; ?>
  <br> 
  <i class="smallsize policesecond"><?php echo $const['LOGIN']['ENTER_LOGIN_ID']; ?></i>
</div> <br>

<div class="item-center text-center bgmaincolor textblue container ">
  <div class="col-md-6 mx-auto d-block">

    <form action="check.php" method="post"><br>
      <div class="form-floating">
        <input type="text" class="form-control" id="username" placeholder="<?php echo $const['LOGIN']['ID_PLACEHOLDER']; ?>" name="username" required>
        <label for="username"><?php echo $const['LOGIN']['ID']; ?></label><br>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="motdepasse" placeholder="<?php echo $const['LOGIN']['PASSWORD_PLACEHOLDER']; ?>" name="motdepasse" onmouseenter="display(this)" onmouseleave="hide(this)" required>
        <label for="motdepasse"><?php echo $const['LOGIN']['PASSWORD']; ?></label><br>
      </div>
      <button type="submit" class="btn bg-white textblue"><?php echo $const['LOGIN']['LOGIN']; ?></button>
      <a href='#forgot_username' class='btn bg-white textblue'><?php echo $const['LOGIN']['FORGOT_PASSWORD']; ?></a>
    </form>
  </div>
  <br>
</div>
<br>
<hr class="container textblue"><br>
<div class="container textblue policesecond">
    <b class="mediumsize"><?php echo $const['LOGIN']['FORGOT_PASSWORD']; ?></b></div><br>
    <div class="bgmaincolor container policesecond">
      <form action="forgot_password.php" method="post" class="inline">
        <div class="row textblue">
          <div class="col-sm"><br>
            <div class="form-floating">
              <input type="text" class="form-control" id="forgot_username" placeholder="<?php echo $const['GESTION']['USERNAME_PLACEHOLDER']; ?>" name="username" required>
              <label for="forgot_username"><?php echo $const['GESTION']['USERNAME']; ?></label>
            </div>
          </div>
        </div>
        <br>
        <div class="row textblue">
          <div class="col-sm">
            <div class="input-group mb-4">
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="email" placeholder="<?php echo $const['LOGIN']['EMAIL_PLACEHOLDER']; ?>" name="email" required>
                <label for="email"><?php echo $const['LOGIN']['EMAIL']; ?></label>
              </div>
              <span class="input-group-text textblue"><?php echo $const['conf']['MAIL_DOMAIN']; ?></span>
            </div>
          </div>
        </div>
        <br>
        <button type="submit" class="btn bg-white textblue"><?php echo $const['LOGIN']['ADD']; ?></button><br><br>
      </form>
    </div>
</div>

<br><br>

<?php 
footer();
?>