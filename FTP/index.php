<?php
  include "../functions.php";
  session_start();
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
      foreach($dossiers as $d) {
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
    $str = $_POST['AddDoss'];
    $visi = $_POST['role'];
    if (
      $visi == 'grp' ||
      $visi == 'users' 
    ) {
      $visi = $_POST['groups'];
      array_unshift($visi, $_POST['role']);
    }
    array_push($dossiers, array(
      "id" => uniqid(),
      "nom" => $str, 
      "path" => $path,
      "visibility" => $visi,
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
    $visi = $_POST['role'];
    if (
      $visi == 'grp' ||
      $visi == 'users' 
    ) {
      $visi = $_POST['groups'];
      array_unshift($visi, $_POST['role']);
    }
    array_push($fichiers, array(
      "id" => uniqid(),
      "nom" => $str, 
      "path" => $path,
      "visibility" => $visi, 
      "owner" => $_SESSION['username']
    ));
    file_put_contents("../fichiers.json", json_encode($fichiers));
    unset($_FILES['fic']);
  }
  if(isset($_POST['delFic'])){
    $i = array_search($_POST["delFic"], array_column($fichiers, 'id'));
    if 
    (
      $fichiers[$i]['owner'] == $_SESSION['username'] ||
      $fichiers[$i]['visibility'] == "all" ||
      $path == $_SESSION['path'] &&
      is_array($fichiers[$i]['visibility']) &&
      (
        $fichiers[$i]['visibility'][0] == "users" &&
        in_array($_SESSION['username'], $fichiers[$i]['visibiity']) ||
        $fichiers[$i]['visibility'][0] == "grp" &&
        in_array($_SESSION['group'], $fichiers[$i]['visibility'])
      ) 
    ) {
      unset($fichiers[$i]);
      file_put_contents("../fichiers.json", json_encode(array_values($fichiers)));
    }
  }
  if
  ( isset($_POST['delDir'])) {
    $i = array_search($_POST["delDir"], array_column($dossiers, 'id'));
    if 
    (
      $dossiers[$i]['owner'] == $_SESSION['username'] ||
      $dossiers[$i]['visibility'] == "all" ||
      is_array($dossiers[$i]['visibility']) &&
      (
        $dossiers[$i]['visibility'][0] == "users" &&
        in_array($_SESSION['username'], $dossiers[$i]['visibiity']) ||
        $dossiers[$i]['visibility'][0] == "grp" &&
        in_array($_SESSION['group'], $dossiers[$i]['visibility'])
      ) 
    ) {
      unset($dossiers[$i]);
      file_put_contents("../dossiers.json", json_encode(array_values($dossiers)));
    }
  }
  echo "
  <div class='container textblue policesecond mediumsize'>
    <p class='policemain'>".$const['FTP']['WELCOME']."</p>
    <p>".$const['FTP']['ACCESS_REPO']."</p>
    <i>".$const['FTP']['CURRENTLY_IN']." </i>
    <pre class='inline'>$path/</pre>
    <br>
    <a class='btn btn-sm bgmaincolor text-white material-icons' href='./'>refresh</a>
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
      if ($d['owner'] == $_SESSION['username']) {
        dispDir($d);
        continue;
      }
      switch ($d['visibility']) {
        case 'me':
          if ($d['owner']==$_SESSION['username']){
            dispDir($d);
          }
          break;
        case 'all':
          dispDir($d);
          break;
        default:
          if ($d['visibility'][0] == "grp") {
            $common = array_intersect($d['visibility'], $salarie[$current_user]['groupe']);
          } else if ($d['visibility'][0] == "users" ) {
            $common = array_intersect(array_slice($d['visibility'], 1), array($_SESSION['username']));
          }
          if(sizeof($common) > 0){
            dispDir($d);
          }
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
    $vis="<pre class='inline'  title='".$const['FTP']['WHO']."\n";
    switch ($dir['visibility']) {
      case 'me':
        $vis .= $const['FTP']['ME']."'>-</pre>";
        break;
      case 'all':
        $vis .= $const['FTP']['ALL']."'>+</pre>";
        break;
      default:
        if ($dir['visibility'][0] == "grp") {
          $vis .= $const['FTP']['GROUPS'];
        } else if ($dir['visibility'][0] == "users") {
          $vis .= $const['FTP']['USERS'];
        }
        $vis .= ":";
        for ($i=1; $i < sizeof($dir['visibility']); $i++) {
          $vis .= "\n  -".$dir['visibility'][$i];
        }
        $vis .= "'>#</pre>";
        break;
    }

    $condition = $const['FTP']['CONFIRM_FOLDER'];
    echo "
    <div class'raw'>
      <form action='' method='post' id='delfolder_".$dir['id']."' class='inline'>
        <input type='hidden' name='delDir' value='".$dir['id']."'>
        <a class='btn bgmaincolor text-white btn-sm material-icons' onclick=\"confirmDelete('$condition', 'delfolder_".$dir['id']."');\">close</a>
      </form>
      $vis
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
    $vis="<pre class='inline'  title='".$const['FTP']['WHO']."\n";
    switch ($file['visibility']) {
      case 'me':
        $vis = "<pre class='inline' title='".$const['FTP']['WHO']."\n".$const['FTP']['ME']."'>-</pre>";
        break;
      case 'all':
        $vis = "<pre class='inline' title='".$const['FTP']['WHO']."\n".$const['FTP']['ALL']."'>+</pre>";
        break;
      default:
        if ( $file['visibility'][0] == "grp" ) {
          $vis .= $const['FTP']['GROUPS'];
        } else if ( $file['visibility'][0] == "users" ) {
          $vis .= $const['FTP']['USERS'];
        }
        $vis .= ":";
        for ($i=1; $i < sizeof($file['visibility']); $i++) {
          $vis .= "\n  -".$file['visibility'][$i];
        }
        $vis .= "'>#</pre>";
        break;
    }
    $condition = $const['FTP']['CONFIRM_FILE'];
    $name = $file['nom'];
    echo "
    <div class='raw'>
      <form action='' method='post' id='delfile_".$file['id']."' class='inline'>
        <input type='hidden' name='delFic' value='".$file['id']."'>
        <a class='btn bgmaincolor text-white btn-sm material-icons' onclick='confirmDelete(\"$condition\", \"delfile_".$file['id']."\");'>close</a>
      </form>
      $vis
      <a class='textblue policesecond minisize' href='./".$name."' download='".$name."'>".$file['nom']."</a> 
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
      if ($f['owner'] == $_SESSION['username']) {
        dispFile($f);
        continue;
      }
      switch ($f['visibility']) {
        case 'me':
          if ($f['owner']==$_SESSION['username']) {
            dispFile($f);
          }
          break;
        case 'all':
          dispFile($f);
          break;
        default:
          if ($f['visibility'][0] == "grp") {
            $common = array_intersect($f['visibility'], $salarie[$current_user]['groupe']);
          } else if ($f['visibility'][0] == "users" ) {
            $common = array_intersect(array_slice($f['visibility'], 1), array($_SESSION['username']));
          }
          if(sizeof($common) > 0){
            dispFile($f);
          }
        break;
      }
    }
  }
?>
    <br>
    </div>
    <script>
      function confirmDelete(condition, formId) {
        if (confirm(condition)) {
          document.getElementById(formId).submit();
        }
      }
    </script>
</div><br>
<hr class='container textblue'><br>
<div class='mx-auto d-block textblue '>
  <small><i><?php echo $const['FTP']['NO_QUOTES']; ?></i></small>
  <br><br>
  <div class='container row'>
    <div class='col-sm-6'>
      <p>&emsp;<?php echo $const['FTP']['CREATE_FOLDER']; ?></p>
      <div class='textblue'>
        <form action="" method="post">
          <input class='textblue minisize policesecond' style='border-radius: 2%' type="text" name="AddDoss" placeholder="<?php echo $const['FTP']['FOLDER_NAME']; ?>" required>
          <p>&emsp;<?php echo $const['FTP']['WHO']; ?></p>
          <select id="role_dir" name="role" onchange="revealGroups(this, 'dir')">
            <option value="me"><?php echo $const['FTP']['ONLY_ME']; ?></option>
            <option value="users"><?php echo $const['FTP']['USERS']; ?></option>
            <option value="grp"><?php echo $const['FTP']['GROUPS']; ?></option>
            <option value="all"><?php echo $const['FTP']['ALL']; ?></option>
          </select>
          <br>
          <span id='groups_dir_span'></span>
          <br>
          <button class='btn text-white smallsize bgmaincolor' type="submit" value='Créer le dossier'><?php echo $const['FTP']['CREATE']; ?></button>
        </form>
      </div>
    </div>
    <div class='col-sm-6'>
      <p><?php echo $const['FTP']['UPLOAD']; ?></p>
      <form action="./" method="post" enctype="multipart/form-data">
        <input class='textblue minisize policesecond' style='border-radius: 2%' type="file" name="fic">
        <p>&emsp;<?php echo $const['FTP']['WHO']; ?></p>
        <select id="role_fic" name="role" onchange="revealGroups(this, 'fic')">
          <option value="me"><?php echo $const['FTP']['ONLY_ME']; ?></option>
          <option value="users"><?php echo $const['FTP']['USERS']; ?></option>
          <option value="grp"><?php echo $const['FTP']['GROUPS']; ?></option>
          <option value="all"><?php echo $const['FTP']['ALL']; ?></option>
        </select>
        <br>
        <span id="groups_fic_span"></span>
        <br>
        <button class='btn text-white bgmaincolor policesecond' type="submit" value="Importer le fichier"><?php echo $const['FTP']['UPLOAD']; ?></button>
      </form>
      <script>
        function revealGroups(self, id) {
          const selects = document.getElementById('groups_' + id);
          if (selects) {
            selects.remove();
          }
          const span = document.getElementById('groups_' + id + '_span');
          const select = document.createElement('select');
          const width =  self.getBoundingClientRect()['width'] + 'px';
          span.style.width = width ;
          select.style.width = width;
          select.multiple = true;
          select.name = 'groups[]';
          select.id = 'groups_' + id;
          if (self.value == 'grp') {
            <?php
              $current_user = array_search($_SESSION["username"], array_column($salarie, 'username'));
              foreach ($salarie[$current_user]['groupe'] as $g) {
                echo "select.options.add(new Option('$g', '$g', false, true));";
              }
            ?>
            span.appendChild(select);
          } else if (self.value == 'users') {
            <?php
              foreach (array_column($salarie, 'username') as $g) {
                echo "select.options.add(new Option('$g', '$g', false, true));";
              }
            ?>
            span.appendChild(select);
          }
        } 
      </script>
      <br>
      </div>
    </div>
  </div>
</div>
<br>
<?php footer();?>