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
    header("Location: /index.php");
}
?>


<div class='container container-fluid policemain textblue mediumsize text-center'><br>
  Vous êtes arrivé sur la page de connexion<br> 
  <i class="smallsize policesecond">Veuillez renseigner vos identifiants de connexion</i>
</div> <br>

<div class="item-center text-center bgmaincolor textblue container ">
  <div class="col-md-6 mx-auto d-block">

    <form action="check.php" method="post"><br>
      <div class="form-floating">
        <input type="text" class="form-control" id="username" placeholder="Entrer votre identifiant" name="username" required>
        <label for="username">Identifiant</label><br>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="motdepasse" placeholder="Entrer votre mot de passe" name="motdepasse" required>
        <label for="motdepasse">Mot de passe</label><br>
      </div>
      <button type="submit" class="btn bg-white textblue">Se connecter</button>
    </form>
  </div>
  <br>
</div>

<br>
<?php 

/*function conf($p,$n,$m,$e){
    $de = $_POST['email'];
    $objet = "Confirmation de création de compte";
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
                <button type='submit' class='btn bg-warning'>Confirmer l'ajout</button><br><br>
            </form>
            ";


    
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-relay.sendinblue.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sardines.and.cie@gmail.com';                     //SMTP username
        $mail->Password   = 'chJLY02ADd1X8y9n';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@sardines-and-cie.sar', $de);
        $mail->addAddress('sardines.and.cie@gmail.com', 'sardinesandcie');     //Add a recipient
        //$mail->addAddress('david.gatel@univ-rennes1.fr', 'dgatel');     //Add a recipient
        //$mail->addAddress('francoisregis.menguy@orange.com', 'fmenguy');     //Add a recipient

        //$mail->addCC('dambiellesarah1@gmail.com', 'Sarah');
        //$mail->addCC('jbbeck42@gmail.com', 'JB');
        //$mail->addCC('clement@menweg.net', 'Clem');
        //$mail->addCC('louisperard7@gmail.com', 'Louis');


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $objet;
        $mail->Body    = $msg;
        $mail->AltBody = $msg;

        $mail->send();
        echo 'Le mail à bien été envoyé';
    } catch (Exception $e) {
        echo "Le mail n'a pas été envoyé : {$mail->ErrorInfo}";
}*/


if(isset($_POST['motdepasse'])){
    //conf($_POST['prenom'],$_POST['nom'],$_POST['motdepasse'],$_POST['email']);
    unset($_POST['motdepasse']);
}
?>
<hr class="container textblue"><br>
<div class="container textblue policesecond">
    <b class="mediumsize">Demander la création d'un compte salarié</b></div><br>

    <div class="bgmaincolor container policesecond">
        <div class="row textblue">

            <div class="col-sm"><br>
                <form action="" method="post">
                    <div class="form-floating ">
                      <input type="text" class="form-control" id="prenom" placeholder="Entrer votre prenom" name="prenom" required>
                      <label for="prenom">Prénom</label><br>
                    </div>
            </div>
            <div class="col-sm"><br>
                <div class="form-floating">
                  <input type="text" class="form-control" id="nom" placeholder="Entrer votre nom" name="nom" required>
                  <label for="nom">Nom</label><br>
                </div>
            </div>
            <div class="col-sm"><br>
                <div class="form-floating">
                    <input type="password" class="form-control" id="motdepasse" placeholder="Entrer votre mot de passe" name="motdepasse" required>
                    <label for="motdepasse">Mot de passe</label><br>
                </div>
            </div>
        </div>

        <div class="form-floating input-group mb-4 textblue" >
          <input type="text" class="form-control" id="email" placeholder="Entrer votre email" name="email" required>
          <label for="email">Email</label><br>
          <span class="input-group-text textblue">@sardines-and-cie.sar</span>
        </div>

        <button type="submit" name="ajouter salariés" class="btn bg-white textblue">Ajouter</button><br><br>

                </form>
    </div>
</div>

<br><br>

<?php 
footer();
?>