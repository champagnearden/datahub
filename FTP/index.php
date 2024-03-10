<?php
  include "../functions.php";

  if(!isset($_SESSION['pre_nom'])){
    header("Location: /login.php");
    die();
  }
  headd("FTP");
  nav("fichiers.php");
  $salarie = json_decode(file_get_contents("../accounts.json"), true);
  $dossiers = json_decode(file_get_contents("../dossiers.json"), true);
  $dossiers = ($dossiers == null) ? array() : $dossiers ;
  $fichiers=json_decode(file_get_contents("../fichiers.json"), true);
  $fichiers = ($fichiers == null) ? array() : $fichiers ;
  if (!isset($_SESSION['path'])) {
    $_SESSION['path'] = "";
  }
  $path = "";
  if (isset($_POST['goto'])) {
    if ( $_POST['goto'] == ".." ) {
      $ex = explode("/", $_SESSION['path']);
      array_pop($ex);
      $path = join("/", $ex);
    } else {
      foreach($dossiers as $d){
        if($d['id']==$_POST['goto']){
          $path = $d['path']."/".$d["nom"];
          break;
        }
      }
    }
  } else {
    $path = $_SESSION["path"];
  }
  $_SESSION['path'] = $path;
  if(isset($_POST['AddDoss'])){
    $str=$_POST['AddDoss'];
    array_push($dossiers, array(
      "id" => uniqid(),
      "nom" => $str, 
      "path" => $path,
      "visibility" => $_POST['role'], 
      "owner" => $_SESSION['username'], 
    ));
      file_put_contents("../dossiers.json", json_encode($dossiers));
    unset($_POST['AddDoss']);
  }
  if (
    isset($_FILES['fic']['tmp_name']) && 
    $_FILES['fic']['name'] != "" && 
    $_FILES['fic']['error'] == 0
  ){
    $str = str_replace('%22','',$_FILES['fic']['name']);
    $str = str_replace("'","",$str);
    move_uploaded_file($_FILES['fic']['tmp_name'],"./files/$str");
    array_push($fichiers, array(
      "id" => uniqid(),
      "nom" => $str, 
      "path" => $path,
      "visibility" => $_POST['role'], 
      "owner" => $_SESSION['username']
    ));
    file_put_contents("../fichiers.json", json_encode($fichiers));
    unset($_FILES['fic']);
  }
  if(isset($_POST['delFic'])){
    $size=sizeof($fichiers);
    for($i=0;$i<$size;$i++){
      if($fichiers[$i]['id']==$_POST['delFic']){
        unset($fichiers[$i]);
      }
    }
    file_put_contents("../fichiers.json", json_encode($fichiers));
  }
  if(isset($_POST['delDir'])){
    $sd=sizeof($dossiers);
    for($i=0;$i<$sd;$i++){
      if($dossiers[$i]['id']==$_POST['delDir']){
        unset($dossiers[$i]);
        break;
      }
    }
    file_put_contents("../dossiers.json", json_encode($dossiers));
  }
  echo "
  <div class='container textblue policesecond mediumsize'>
    <p class='policemain'>".$const['FTP']['WELCOME']."</p>
    <p>".$const['FTP']['ACCESS_REPO']."</p>
    <i>".$const['FTP']['CURRENTLY_IN']." </i><pre class='inline'>$path/</pre>
    <br>
  ";
  if ( $path != "") {
    echo "
    <form action='' method='post' class='inline' id='form_goto_back'>
      <input type='hidden' name='goto' value='..'>
      <a class='textblue policesecond minisize' onclick='document.getElementById(\"form_goto_back\").submit()' style='cursor: pointer;'>".$const['FTP']['BACK']."</a>
    </form>
    ";
  }
  echo "
  <br>
    <div class='row'>
      <div class='col-sm-6' style='background-color:lightgray'>
        <b>".$const['FTP']['MY_REPO']."</b>
  ";
  
  $current_user = array_search($_SESSION["username"], array_column($salarie, 'username'));
  foreach ($dossiers as $d) {
    if ($d['path'] == $path) {
      switch ($d['visibility']) {
        case 'me':
          if ($d['owner']==$_SESSION['username']){
            dispDir($d);
          }
          break;
        case 'grp':
          $owner = array_search($d['owner'], array_column($salarie, 'username'));
          $common = array_intersect($salarie[$owner]['groupe'], $salarie[$current_user]['groupe']);
          if(sizeof($common) > 0){
            dispDir($d);
          }
          break;
        case 'all':
          dispDir($d);
          break;
      }
    }
  }
  function dispDir($dir){
    global $const;
    if($_SESSION['username']==$dir['owner']) {
      $sub = "<sub><small>(".$const['FTP']['ME'].")</small></sub>";
    } else {
      $sub = "<sub><small>(".$dir['owner'].")</small></sub>";
    }
    $condition = $const['FTP']['CONFIRM_FOLDER'].$dir['nom'];
    echo "
    <div class'raw'>
      <form action='' method='post' id='delfolder_".$dir['id']."' class='inline'>
        <input type='hidden' name='delDir' value='".$dir['id']."'>
        <a class='btn bgmaincolor text-white btn-sm' onclick=\"confirmDelete('$condition', 'delfolder_".$dir['id']."');\">-</a>
      </form>
      &emsp;
      <form action='' method='post' id='form_goto_".$dir['id']."' class='inline'>
        <input type='hidden' name='goto' value='".$dir['id']."'>
        <a class='textblue policesecond minisize' onclick='document.getElementById(\"form_goto_".$dir['id']."\").submit()' style='cursor: pointer;'>".$dir['nom']."</a>
        $sub
      </form>
    </div>";
  }

  function dispFile($file) {
    global $const;
    if($_SESSION['username']==$file['owner']) {
      $sub = "<sub><small>(".$const['FTP']['ME'].")</small></sub>";
    } else {
      $sub = "<sub><small>(".$file['owner'].")</small></sub>";
    }
    $condition = $const['FTP']['CONFIRM_FILE'].$file['nom'];
    echo "
    <div class='raw'>
      <form action='' method='post' id='delfile' class='inline'>
        <input type='hidden' name='delFic' value='".$file['id']."'>
        <a class='btn bgmaincolor text-white btn-sm' onclick=\"confirmDelete('$condition', 'delfile');\">-</a>
      </form>
      &emsp;
      <a class='textblue policesecond minisize' href='./".$file['nom']."' download='".$file['nom']."'>".$file['nom']."</a> 
      $sub
    </div>";
  }

  echo "
    <br>
  </div>
  <div class='col-sm-6' style='background-color:lightgray'>
    <b>".$const['FTP']['MY_FILES']."</b>
    <br>
  ";
  foreach ($fichiers as $f) {
    if ($f ['path'] == $path) {
      switch ($f['visibility']) {
        case 'me':
          if ($f['owner']==$_SESSION['username']) {
            dispFile($f);
          }
          break;
        case 'grp':
          $owner = array_search($f['owner'], array_column($salarie, 'username'));
          $common = array_intersect($salarie[$owner]['groupe'], $salarie[$current_user]['groupe']);
          if(sizeof($common) > 0){
            dispFile($f);
          }
          break;
        case 'all':
          dispFile($f);
          break;
      }
    }
  }
?>
    <br>
    </div>
    <script>
      function confirmDelete(condition, formId) {
        if (confirm(condition + ' ?')) {
          document.getElementById(formId).submit();
        }
      }
    </script>
</div><br>
<hr class='container textblue'><br>
<div class='mx-auto d-block textblue '>
  <form action="" method="post">
    <small><i><?php echo $const['FTP']['NO_QUOTES']; ?></i></small>
    <br><br>
    <div class='container row'>
      <div class='col-sm-6'>
        <p>&emsp;<?php echo $const['FTP']['CREATE_FOLDER']; ?></p>
        <div class='textblue'>
          <input class='textblue minisize policesecond' style='border-radius: 2%' type="text" name="AddDoss" placeholder="<?php echo $const['FTP']['FOLDER_NAME']; ?>" required>
          <p>&emsp;<?php echo $const['FTP']['WHO']; ?></p>
          <select id="role" name="role">
            <option value="me"><?php echo $const['FTP']['ONLY_ME']; ?></option>
            <option value="grp"><?php echo $const['FTP']['GROUPS']; ?></option>
            <option value="all"><?php echo $const['FTP']['ALL']; ?></option>
          </select>
          <br><br>
          <button class='btn text-white smallsize bgmaincolor' type="submit" value='Créer le dossier'><?php echo $const['FTP']['CREATE']; ?></button>
  </form>
        </div>
      </div>
      <div class='col-sm-6'>
        <p><?php echo $const['FTP']['UPLOAD']; ?></p>
        <form action="./" method="post" enctype="multipart/form-data">
          <input class='textblue minisize policesecond' style='border-radius: 2%' type="file" name="fic">
          <p>&emsp;<?php echo $const['FTP']['WHO']; ?></p>
            <select id="role" name="role">
              <option value="me"><?php echo $const['FTP']['ONLY_ME']; ?></option>
              <option value="grp"><?php echo $const['FTP']['GROUPS']; ?></option>
              <option value="all"><?php echo $const['FTP']['ALL']; ?></option>
            </select>
          <br><br>
          <button class='btn text-white bgmaincolor policesecond' type="submit" value="Importer le fichier"><?php echo $const['FTP']['UPLOAD']; ?></button>
        </form>
        <br>
      </div>
    </div>
  </div>
</div>
<br>
<?php footer();?>