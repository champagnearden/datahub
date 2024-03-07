<?php
  $p=explode("\\",getcwd());
  $i=0;
  $s="";
  while ($p[$i] !== "FTP") {
    $s="$s".$p[$i]."/";
    $i++;
  }
  include($s."functions.php");
  headd("FTP");
  
  if(!isset($_SESSION['username'])){
    header("Location: ".$s."login.php");
    die();
  }
  nav("fichiers.php");
  $path=getcwd()."/";
  $salarie=json_decode(file_get_contents($s."accounts.json"), true);
  $dossiers=json_decode(file_get_contents($s."dossiers.json"), true);
  $dossiers = ($dossiers == null) ? array() : $dossiers ;
  $fichiers=json_decode(file_get_contents($s."fichiers.json"), true);
  $fichiers = ($fichiers == null) ? array() : $fichiers ;
  if(isset($_POST['AddDoss'])){
    $str=$_POST['AddDoss'];
    $str=str_replace("'","",$str);
    $str=str_replace('"','',$str);
    $str=trim($str);
    $validity=1;
    foreach($dossiers as $dos){
      if($dos['path'].$dos['nom'] == $path.$str){
        unset($validity);
        break;
      }
    }
    $lvl=0700;
    if (isset($validity) && $str!==""){
      switch ($_POST['role']) {
        case 'grp':
          $lvl=0770;
          break;
        case 'all':
          $lvl=0777;
          break;
        case 'me':
          $lvl=0700;
          break;
      }
      array_push($dossiers, array(
        "nom" => $str, 
        "path" => $path,
        "visibility" => $_POST['role'], 
        "owner" => $_SESSION['username'], 
      ));
      file_put_contents($s."dossiers.json", json_encode($dossiers));
    }else{
      echo "<script> alert('".$const['FTP']['FILE_FAILED']."');</script>";
    }
    unset($_POST['AddDoss']);
  }
  if(isset($_FILES['fic']['tmp_name']) && $_FILES['fic']['name']!="" && $_FILES['fic']['error']==0){
    $str=str_replace('%22','',$_FILES['fic']['name']);
    $str=str_replace("'","",$str);
    $str="file:$str";
    move_uploaded_file($_FILES['fic']['tmp_name'],getcwd()."/$str");
    foreach($salarie as $s){
        if($s['username'] == $_SESSION['username']){
          $grps=$s['groupe'];
          break;
        }
      }
      array_push($fichiers, array(
        "nom" => $str, 
        "path" => $path,
        "visibility" => $_POST['role'], 
        "owner" => $_SESSION['username'], 
        "groupes" => $grps
      ));
      file_put_contents($s."fichiers.json", json_encode($fichiers));
    unset($_FILES['fic']);
  }
  $size=sizeof($fichiers);
  //J'utilise un GET parceque je demande la confirmation, impossible avec un form...
  if(isset($_GET['DelFic'])){
    for($i=0;$i<$size;$i++){
      if($fichiers[$i]['nom']==$_GET['DelFic']){
        array_splice($fichiers, $i,1);
      }
    }
    file_put_contents($s."fichiers.json", json_encode($fichiers));
    header("Location: ./");
  }
  if(isset($_GET['DelDoss'])){
    $sd=sizeof($dossiers);
    for($i=0;$i<$sd;$i++){
      if($dossiers[$i]['nom']==$_GET['DelDoss']){
        array_splice($dossiers, $i,1);
      }
    }
    file_put_contents($s."dossiers.json", json_encode($dossiers));
    header("Location: ./");
  }
  if(!isset($_SESSION['pre_nom'])){
    header("Location: ".$s."login.php");
  }
  $path=substr(getcwd(),strlen($s), strlen(getcwd()));
    echo "<div class='container textblue policesecond mediumsize'> <p class='policemain'>".$const['FTP']['WELCOME']."</p>
    <p>".$const['FTP']['ACCESS_REPO']."</p> <i>".$const['FTP']['CURRENTLY_IN']." $path</i><br><br>";
  $s=sizeof($a);
  echo "<div class='row'><div class='col-sm-6' style='background-color:lightgray'><b>".$const['FTP']['MY_REPO']."</b><div class='raw'><a class='textblue policesecond minisize' href='..'>".$const['FTP']['BACK']."</a></div>";
  for($i=2;$i<$s;$i++){
    if ($b[$i+1][0] == "d"){
      foreach ($dossiers as $d) {
        $pass=0;
        if($d['nom']==$a[$i]){
          switch ($d['visibility']) {
            case 'me':
              if ($d['owner']==$_SESSION['username']){
                $pass=1;
              }
              break;
            case 'grp':
              $grps="";
              $k=array_keys($salarie);
              $c=0;
              foreach($salarie as $salar){
                if($salar['username'] == $_SESSION['username']){
                  $grps=explode(" | ", $salar['groupe']);
                  $sg=sizeof($grps);
                  break;
                }
                $c++;
              }
              for($j=0;$j<$sg;$j++){
                if(str_contains($grps[$j],$salarie[$k[$c]]['groupe'])){
                  $pass=1;
                  break;
                }
              }
              break;
            case 'all':
              $pass=1;
              break;
          }
        }
        if($_SESSION['username']==$d['owner']){
          $sub="<sub><small>(".$const['FTP']['ME'].")</small></sub>";
        }else{
          $sub="<sub><small>(".$d['owner'].")</small></sub>";
        }
        if (boolval($pass)) {
          break;
        }
      }
      if(boolval($pass)){
        echo "<div class'raw'>
        <button class='btn bgmaincolor text-white btn-sm' onclick='if(confirm(\"".$const['FTP']['CONFIRM_FOLDER'].$a[$i]." ?\")){window.location.href=\"./?DelDoss=".$a[$i]."\"}'>-</button>&emsp;<a class='textblue policesecond minisize' href='".$a[$i]."'>".ucwords(strtolower($a[$i]))."</a> $sub</div>";
      }
    }
  }
  echo "<br></div><div class='col-sm-6' style='background-color:lightgray'><b>".$const['FTP']['MY_FILES']."</b><br>";
  for($i=0;$i<$s;$i++){
    if ($b[$i+1][0] == "-" && $a[$i]!="index.php"){
      foreach ($fichiers as $f) {
        $pass=0;
        if($f['nom']==$a[$i]){
          switch ($f['visibility']) {
            case 'me':
              if ($f['owner']==$_SESSION['username']){
                $pass=1;
              }
              break;
            case 'grp':
              foreach($salarie as $salar){
                if($salar['username'] == $_SESSION['username']){
                  $grps=explode(" | ", $salar['groupe']);
                  $sg=sizeof($grps);
                  break;
                }
              }
              for($j=1;$j<$sg;$j++){
                if(str_contains($grps[$j],$f['groupes'])){
                  $pass=1;
                  break;
                }
              }
              break;
            case 'all':
              $pass=1;
              break;
          }
        }
        if($_SESSION['username']==$f['owner']){
          $sub="<sub><small>(".$const['FTP']['ME'].")</small></sub>";
        }else{
          $sub="<sub><small>(".$f['owner'].")</small></sub>";
        }
        if (boolval($pass)) {
          break;
        }
      }
      if(boolval($pass)){
        $f=str_replace("file:", "", $a[$i]);
        echo "<div class='raw'>
          <button class='btn bgmaincolor text-white btn-sm' onclick='if(confirm(\"".$const['FTP']['CONFIRM_FILE'].$f." ?\")){window.location.href=\"./?DelFic=".$a[$i]."\"}'>-</button>&emsp;
          <a class='textblue policesecond minisize' href='./".$a[$i]."' download='$f'>".ucwords(strtolower($f))."</a> $sub</div>";
      }
    }
  }
  echo "</div>";
?>
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