<?php
include ("functions.php");

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require 'PHPMailer/src/Exception.php';
//require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/SMTP.php';
headd("Connexion");
nav("login.php");

if(isset($_SESSION['pre_nom'])){
    header("Location: /");
}
?>


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
        <input type="password" class="form-control" id="motdepasse" placeholder="<?php echo $const['LOGIN']['PASSWORD_PLACEHOLDER']; ?>" name="motdepasse" required>
        <label for="motdepasse"><?php echo $const['LOGIN']['PASSWORD']; ?></label><br>
      </div>
      <button type="submit" class="btn bg-white textblue"><?php echo $const['LOGIN']['LOGIN']; ?></button>
    </form>
  </div>
  <br>
</div>

<br>
<?php 

/*function conf($p,$n,$m,$e){
    $de = $_POST['email'];
    $objet = $const['LOGIN']['CONFIRM_CREATE'];
    $msg = "
    <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
    </head>
            <form action='http://intranet.sar/ajouter_salarie.php' method='post'>
                <input type='hidden' name='prenom' value='$p'>
                <input type='hidden' name='nom' value='$n'>
                <input type='hidden' name='motdepasse' value='$m'>
                <input type='hidden' name='email' value='$e'>
                <button type='submit' class='btn bg-warning'>".$const['LOGIN']['CONFIRM_ADD']."</button><br><br>
            </form>
            ";


    
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $const['conf']['MAIL_HOST'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $const['conf']['MAIL_USERNAME'];                     //SMTP username
        $mail->Password   = $const['conf']['MAIL_PASSWORD'];;                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply'.$const['conf']['MAL_DOMAIN'], $de);
        $mail->addAddress($const['conf']['MAIL_SENDER'], $const['conf']['MAIL_PSEUDO']);     //Add a recipient
        //$mail->addAddress('david.gatel@univ-rennes1.fr', 'dgatel');     //Add a recipient
        //$mail->addAddress('francoisregis.menguy@orange.com', 'fmenguy');     //Add a recipient

        // loop through the admins and add their mails
        $admins = json_decode(file_get_contents("accounts.json"), true);
        foreach($admins as $admin){
            $mail->addCC($admin['email'], ucwords($admin['prenom']));
        }


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $objet;
        $mail->Body    = $msg;
        $mail->AltBody = $msg;

        $mail->send();
        echo $const['LOGIN']['CONFIRM_SENT'];
    } catch (Exception $e) {
        echo $const['LOGIN']['SENT_ERROR']."{$mail->ErrorInfo}";
}*/


if(isset($_POST['motdepasse'])){
    //conf($_POST['prenom'],$_POST['nom'],$_POST['motdepasse'],$_POST['email']);
    unset($_POST['motdepasse']);
}
?>
<hr class="container textblue"><br>
<div class="container textblue policesecond">
    <b class="mediumsize"><?php echo $const['LOGIN']['ASK_CREATE']; ?></b></div><br>
    <div class="bgmaincolor container policesecond">
        <div class="row textblue">

            <div class="col-sm"><br>
                <form action="" method="post">
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