    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
        <link rel='icon' type='image/png' href='/images/cgd.png'>
        <link rel='stylesheet' type='text/css' href='/style.css'/>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Asset&display=swap' rel='stylesheet'>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap' rel='stylesheet'>
    </head>
    <body>    <!DOCTYPE html>
    <html>
    <head>
        <title>FTP</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
        <link rel='icon' type='image/png' href='/images/cgd.png'>
        <link rel='stylesheet' type='text/css' href='/style.css'/>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Asset&display=swap' rel='stylesheet'>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap' rel='stylesheet'>
    </head>
    <body><script>
	window.addEventListener('scroll', function(){
	let nav = document.querySelector('nav');
	nav.classList.toggle('scrolling-active', window.scrollY > 0);
});
window.addEventListener('scroll', function(){
	let nav = document.querySelector('nav');
	nav.classList.toggle('scrolling-desactive', window.scrollY < 1);
});
</script>
<nav class='navbar navbar-expand-sm bgmaincolor navbar-dark fixed-top py-3 policesecond' >
	&emsp;
	<a class='navbar-brand' href='/'>
	&emsp;
	<img src='/images/cgd.png' alt='Logo' height='20%' width='20%'>
</a>
<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#collapsibleNavbar'>
	<span class='navbar-toggler-icon'></span>
</button>
	<ul class='navbar-nav collapse navbar-collapse' id='collapsibleNavbar'>
		<li class='nav-item'><a class='nav-link' href='/' title='Accueil'>Accueil</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link'href='/gestion.php' title=Page de gestion des utilisateurs 
Annuaire>Gestion</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link active'href='/FTP/' title='-Zone de dépôt
-Gestion des fichiers partagés
-Consultation des dossiers personnels'>Espace de fichiers</a>
		</li>
		<li class='nav-item'>
			<a class='nav-link border 'title="Page de déconnexion" href="/logout.php" class="btn btn-outline-dark btn-sm">Se déconnecter</a></li> 
		<li class='nav-item'>
			<a class='nav-link 'href='javascript:window.open("/faq.php","","location=no, width=930, height=380, menubar=no, status=no, scrollbars=no, menubar=no");'>Aide</a>
		</li>
		<li class='nav-item text-white'>Vous êtes connecté en tant que <b>Jean-baptiste Beck</b>&nbsp;<sub>(utilisateur)</sub>		</li>
	</ul>
</nav>
</div>
<br><br><br><br><br><br>
  <div class='container textblue policesecond mediumsize'>
    <p class='policemain'>Bienvenue dans votre espace de fichiers</p>
    <p>Cliquez sur le lien pour accéder au dossier</p>
    <i>Vous vous trouvez actuellement dans le répertoire FTP/</i>
    <br><br>
    <div class='row'>
      <div class='col-sm-6' style='background-color:lightgray'>
        <b>Mes dossiers</b>
        <div class='raw'>
          <form action='' method='post' class='form-delete' id='form_goto_back'>
            <input type='hidden' name='goto' value='..'>
            <input type='hidden' name='path' value='FTP'>
            <a class='textblue policesecond minisize' onclick='document.getElementById("form_goto_back").submit()' style='cursor: pointer;'>Précédent</a>
          </form>
        </div>
  
    <div class'raw'>
      <form action='' method='post' id='delfolder_3' class='form-delete'>
        <input type='hidden' name='delDir' value='3'>
        <a class='btn bgmaincolor text-white btn-sm' onclick="confirmDelete('Êtes-vous sûre de vouloir supprimer le répertoire everyone', 'delfolder_3');">-</a>
      </form>
      &emsp;
      <form action='' method='post' id='form_goto_3' class='form-delete'>
        <input type='hidden' name='goto' value='3'>
        <a class='textblue policesecond minisize' onclick='document.getElementById("form_goto_3").submit()' style='cursor: pointer;'>everyone</a>
        <sub><small>(cmenweg)</small></sub>
      </form>
    </div>
    <div class'raw'>
      <form action='' method='post' id='delfolder_4' class='form-delete'>
        <input type='hidden' name='delDir' value='4'>
        <a class='btn bgmaincolor text-white btn-sm' onclick="confirmDelete('Êtes-vous sûre de vouloir supprimer le répertoire test', 'delfolder_4');">-</a>
      </form>
      &emsp;
      <form action='' method='post' id='form_goto_4' class='form-delete'>
        <input type='hidden' name='goto' value='4'>
        <a class='textblue policesecond minisize' onclick='document.getElementById("form_goto_4").submit()' style='cursor: pointer;'>test</a>
        <sub><small>(Moi)</small></sub>
      </form>
    </div>
    <br>
  </div>
  <div class='col-sm-6' style='background-color:lightgray'>
    <b>Mes fichiers</b>
    <br>
  
    <div class='raw'>
      <form action='' method='post' id='delfile' class='form-delete'>
        <input type='hidden' name='delFic' value='2'>
        <a class='btn bgmaincolor text-white btn-sm' onclick="confirmDelete('Êtes-vous sûre de vouloir supprimer le fichier everyone', 'delfile');">-</a>
      </form>
      &emsp;
      <a class='textblue policesecond minisize' href='./everyone' download='everyone'>everyone</a> 
      <sub><small>(Moi)</small></sub>
    </div>
    <div class='raw'>
      <form action='' method='post' id='delfile' class='form-delete'>
        <input type='hidden' name='delFic' value='3'>
        <a class='btn bgmaincolor text-white btn-sm' onclick="confirmDelete('Êtes-vous sûre de vouloir supprimer le fichier groupes', 'delfile');">-</a>
      </form>
      &emsp;
      <a class='textblue policesecond minisize' href='./groupes' download='groupes'>groupes</a> 
      <sub><small>(Moi)</small></sub>
    </div>
    <div class='raw'>
      <form action='' method='post' id='delfile' class='form-delete'>
        <input type='hidden' name='delFic' value='4'>
        <a class='btn bgmaincolor text-white btn-sm' onclick="confirmDelete('Êtes-vous sûre de vouloir supprimer le fichier me', 'delfile');">-</a>
      </form>
      &emsp;
      <a class='textblue policesecond minisize' href='./me' download='me'>me</a> 
      <sub><small>(Moi)</small></sub>
    </div>
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
    <small><i>Les guillements et apostrophes seront supprimés !</i></small>
    <br><br>
    <div class='container row'>
      <div class='col-sm-6'>
        <p>&emsp;Créer un dossier</p>
        <div class='textblue'>
          <input class='textblue minisize policesecond' style='border-radius: 2%' type="text" name="AddDoss" placeholder="Nom du dossier" required>
          <p>&emsp;Qui peut y accéder ?</p>
          <select id="role" name="role">
            <option value="me">Moi seulement</option>
            <option value="grp">Mes groupes</option>
            <option value="all">Tout le monde</option>
          </select>
          <br><br>
          <button class='btn text-white smallsize bgmaincolor' type="submit" value='Créer le dossier'>Créer</button>
  </form>
        </div>
      </div>
      <div class='col-sm-6'>
        <p>Importer un fichier</p>
        <form action="./" method="post" enctype="multipart/form-data">
          <input class='textblue minisize policesecond' style='border-radius: 2%' type="file" name="fic">
          <p>&emsp;Qui peut y accéder ?</p>
            <select id="role" name="role">
              <option value="me">Moi seulement</option>
              <option value="grp">Mes groupes</option>
              <option value="all">Tout le monde</option>
            </select>
          <br><br>
          <button class='btn text-white bgmaincolor policesecond' type="submit" value="Importer le fichier">Importer un fichier</button>
        </form>
        <br>
      </div>
    </div>
  </div>
</div>
<br>
<br><br><br><br>
<footer class="jumbotron bgmaincolor text-center text-white">
	<br>	
	&copy;&nbsp;2024CyberData | <a href="mailto:jbbeck42@gmail.com">jbbeck42@gmail.com</a> | <p id="date"></p> 
</footer>
<script>
	function applyDate() {
		date = new Date();
		seconds = date.getSeconds();
		minutes = date.getMinutes();
		hours = date.getHours();
		jour = date.getDate();
		mois = date.getMonth();
		annee = date.getFullYear();
		document.getElementById("date").innerHTML = jour+"-"+((mois+1))+"-"+annee+" "+hours+":"+minutes+":"+seconds;
	}
	applyDate();
	setInterval(applyDate(),1000);
</script>
</body>
</html>