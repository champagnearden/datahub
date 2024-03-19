<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
include "./functions.php";

headd($const["LOGIN"]["LOGIN"]);
nav("login.php");

if(isset($_SESSION['pre_nom'])){
    header("Location: /");
}

if(isset($_POST['motdepasse'])){
  conf($_POST['prenom'],$_POST['nom'],hash_password($_POST['motdepasse']),$_POST['email']);
  unset($_POST['motdepasse']);
}

function conf($prenom, $nom, $password, $email){
  global $const;
  $objet = $const['LOGIN']['CONFIRM_CREATE'];
  $email .= $const['conf']['MAIL_DOMAIN'];
  $msg = "<html>
    <head>
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
    </head>
    <body>
      <form action='https://".$const['conf']['DOMAIN']."/add_user.php' method='post'>
        <div class='row'>
          <div class='col-sm'><br>
            <div class='form-floating'>
              <input type='text' class='form-control' id='prenom' placeholder='".$const['LOGIN']['PRENOM_PLACEHOLDER']."' name='prenom' value='$prenom' required>
              <label for='prenom'>".$const['LOGIN']['PRENOM']."</label><br>
            </div>
          </div>
          <div class='col-sm'><br>
            <div class='form-floating'>
              <input type='text' class='form-control' id='nom' placeholder='".$const['LOGIN']['NOM_PLACEHOLDER']."' name='nom' value='$nom' required>
              <label for='nom'>".$const['LOGIN']['NOM']."</label><br>
            </div>
          </div>
          <div class='col-sm'><br>
            <div class='form-floating'>
              <input type='text' class='form-control' id='username' placeholder='".$const['LOGIN']['ID_PLACEHOLDER']."' name='username' value='".$prenom[0].$nom."' required>
              <label for='username'>".$const['LOGIN']['ID']."</label><br>
              <input type='hidden' name='hash_motdepasse' value='$password' required>
            </div>
          </div>
        </div>
        <div class='form-floating input-group mb-4'>
          <input type='text' class='form-control' id='email' placeholder='".$const['LOGIN']['EMAIL_PLACEHOLDER']."' name='email' value='$email' required>
          <label for='email'>".$const['LOGIN']['EMAIL']."</label><br>
          <span class='input-group-text'>".$const['conf']['MAIL_DOMAIN']."</span>
        </div>
        <button type='submit' class='btn bg-white'>".$const['LOGIN']['CONFIRM_ADD']."</button><br><br>
      </form>
    </body>
  </html>";
  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = $const['conf']['MAIL_HOST'];                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = $const['conf']['MAIL_USERNAME'];                     //SMTP username
      $mail->Password   = $const['conf']['MAIL_PASSWORD'];                               //SMTP password
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $objet;
      $mail->Body    = $msg;
      $mail->AltBody = $msg;

      //Recipients
      $mail->setFrom($const['conf']['MAIL_SENDER'], $email);
      $mail->addAddress($const['conf']['MAIL_SENDER'], $const['conf']['MAIL_PSEUDO']);     //Add a recipient
      //$mail->addAddress('david.gatel@univ-rennes1.fr', 'dgatel');     //Add a recipient
      //$mail->addAddress('francoisregis.menguy@orange.com', 'fmenguy');     //Add a recipient

      // loop through the admins and add their mails
      $admins = json_decode(file_get_contents("accounts.json"), true);
      $admins = array_filter($admins, function($admins) {
        global $const;
        return $admins['role'] == $const['roles']['ADMIN'];
      });
      foreach($admins as $admin){
        $mail->addCC($admin['email'], ucwords($admin['prenom']));
      }

      $mail->send();
      echo($const['LOGIN']['CONFIRM_SENT']);
  } catch (Exception $e) {
      echo($const['LOGIN']['SENT_ERROR']."{$mail->ErrorInfo}");
  }
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
    </form>
  </div>
  <br>
</div>
<br>
<hr class="container textblue"><br>
<div class="container textblue policesecond">
    <b class="mediumsize"><?php echo $const['LOGIN']['ASK_CREATE']; ?></b></div><br>
    <div class="bgmaincolor container policesecond">
      <form action="" method="post" class="inline">
        <div class="row textblue">
          <div class="col-sm"><br>
            <div class="form-floating ">
              <input type="text" class="form-control" id="prenom" placeholder="<?php echo $const['LOGIN']['PRENOM_PLACEHOLDER']; ?>" name="prenom" required>
              <label for="prenom"><?php echo $const['LOGIN']['PRENOM']; ?></label><br>
            </div>
          </div>
          <div class="col-sm"><br>
            <div class="form-floating">
              <input type="text" class="form-control" id="nom" placeholder="<?php echo $const['LOGIN']['NOM_PLACEHOLDER']; ?>" name="nom" required>
              <label for="nom"><?php echo $const['LOGIN']['NOM']; ?></label><br>
            </div>
          </div>
          <div class="col-sm"><br>
            <div class="form-floating">
              <input type="password" class="form-control" id="motdepasse" placeholder="<?php echo $const['LOGIN']['PASSWORD_PLACEHOLDER']; ?>" name="motdepasse" required>
              <label for="motdepasse"><?php echo $const['LOGIN']['PASSWORD']; ?></label><br>
            </div>
          </div>
        </div>
        <div class="form-floating input-group mb-4 textblue" >
          <input type="text" class="form-control" id="email" placeholder="<?php echo $const['LOGIN']['EMAIL_PLACEHOLDER']; ?>" name="email" required>
          <label for="email"><?php echo $const['LOGIN']['EMAIL']; ?></label><br>
          <span class="input-group-text textblue"><?php echo $const['conf']['MAIL_DOMAIN']; ?></span>
        </div>
        <button type="submit" class="btn bg-white textblue"><?php echo $const['LOGIN']['ADD']; ?></button><br><br>
      </form>
    </div>
</div>

<br><br>

<?php 
footer();
?>