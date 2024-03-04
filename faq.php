<?php 
include "functions.php";
headd("Foire Aux Questions");
nav("faq.php");
?>
<div class=" container-fluid textblue text-center policesecond">
	<h4><b class="mediumsize">Intranet</b></h4>
</div>
<div class="container">
	<div class="row">
		<div class="col"><img src="/images/sardine.png" class="img-fluid"></div>
		<div class="col">
			<ol>
				<li>
					<a href="#accueil" onclick="display('accueil');">Accueil</a>
				</li>
				<?php
				if(isset($_SESSION['username'])){
					echo '
				<li>
					<a href="#gestion" onclick="display(\'gestion\');">Gestion</a>
				</li>
				<li>
					<a href="#espace-de-fichiers" onclick="display(\'espace-de-fichiers\');">Espace de fichiers</a>
				</li>';
				}
				?>
				<li>
					<a href="#connexion" onclick="display('connexion');"><div>Se connecter / <br>Se déconnecter</div></a>
				</li>
				<li>
					<a href="#aide" onclick="display('aide');">Aide</a>
				</li>
			</ol>
		</div>
		<div class="col"></div>
	</div>
</div>
<div id="accueil" style="display: none;">
	<hr>
	<p>
		L'accueil de l'intranet ne contient que le logo de Sardines & cie ainsi que un bouton de connexion.
		<br>
		Toutes les autres fonctionnalitées nécessitent d'être connecté (cf <a href="#connexion" onclick="display('connexion-intranet');">Se connecter / Se déconnecter</a>)
	</p>
</div>
<?php
if(isset($_SESSION['username'])){
	echo '
<div id="gestion" style="display: none;">
	<hr>';
	if($_SESSION['role']==$const["USER"]){
		echo '
	<p>
		Dans cette page vous ne trouverez que la liste de tous les salariés. 
		<br>
		Etant donné votre niveau de responsabilité à l\'égard de l\'entreprise, vous ne pouvez voir le mot de passe des autres utilisateurs.
		<br>
		Cependant, vous pouvez modifier votre mot de passe et celui-ci sera effectif immédiatement.
	</p>';
	}else if($_SESSION['role']==$const["MODO"]){
		echo "
	<p>
		En tant que modérateur vous avez accès à toutes les fonctionnalités de l'intranet de Sardines & cie !
		<br>
		Vous avez la possibilité de modérer les utilisateurs ainsi que les modérateurs mais <b>PAS</b> les administrateurs.
		<br>
		Pour cela, différents outils s'offrent à vous:
		<ul>
			<li>Liste des salariés</li>
			<li>Liste des groupes</li>
			<li>Ajouter un groupe</li>
			<li>Liste noire d'IP</li>
			<li>Modification de masse</li>
		</ul>
		<br>
		La liste des salariés permet de modifier les mot de passe individuellement ainsi que de vous donner les informations relatives à chaque salarié.
		<br>
		<br>
		La liste des groupes permet de connaitre l'ensemble des groupes existants ainsi que la possibilité de pouvoir en supprimer un à un.
		<br>
		Lorsque vous supprimez un groupe, celui-ci est automatiquement retiré des salariés.
		<br>
		<br>
		Vous pouvez ajouter un groupe en entrant le nom du groupe souhaité. Il faudra ensuite l'attribuer à chaque utilisateur souhaité.
		<br>
		<br>
		Pour utiliser la modification de masse vous devez suivre les étapes suivantes:
		<ol>
			<li>Sélectionner le type de recherche (nom d'utilisateur, groupes ou rôles)</li>
			<li>Sélectionner les critères de recherche</li>
			<li>Cliquer sur \"Rechercher\"</li>
		</ol>
		Vous pourrez ensuite modifier le champ que vous souhaitez:
		<ul>
			<li>Mot de passe</li>
			<li>Rôle</li>
			<li>Groupes</li>
		</ul>
		Vous pouvez supprimer une IP de la liste noire des IP pour la débannir et ainsi que l'intranet soit joignable depuis cette IP.
	</p>";
	}else if($_SESSION['role']==$const["ADMIN"]){
		echo "
	<p>
		En tant qu'administrateur vous avez accès à toutes les fonctionnalités de l'intranet de Sardines & cie !
		<br>
		Vous avez la possibilité de modérer les utilisateurs, les modérateurs ainsi que les administrateurs.
		<br>
		Pour cela, différents outils s'offrent à vous:
		<ul>
			<li>Liste des salariés</li>
			<li>Liste des groupes</li>
			<li>Ajouter un groupe</li>
			<li>Liste noire d'IP</li>
			<li>Modification de masse</li>
		</ul>
		<br>
		La liste des salariés permet de modifier les mot de passe individuellement ainsi que de vous donner les informations relatives à chaque salarié. 
		<br>
		Du fait de votre rôle d'administrateur, vous pouvez supprimer un salarié, un modérateur ainsi qu'un administrateur (sauf vous-même).
		<br>
		<br>
		La liste des groupes permet de connaitre l'ensemble des groupes existants ainsi que la possibilité de pouvoir en supprimer un à un.
		<br>
		Lorsque vous supprimez un groupe, celui-ci est automatiquement retiré des salariés.
		<br>
		<br>
		Vous pouvez ajouter un groupe en entrant le nom du groupe souhaité. Il faudra ensuite l'attribuer à chaque utilisateur souhaité.
		<br>
		<br>
		Pour utiliser la modification de masse vous devez suivre les étapes suivantes:
		<ol>
			<li>Sélectionner le type de recherche (nom d'utilisateur, groupes ou rôles)</li>
			<li>Sélectionner les critères de recherche</li>
			<li>Cliquer sur \"Rechercher\"</li>
		</ol>
		Vous pourrez ensuite modifier le champ que vous souhaitez:
		<ul>
			<li>Mot de passe</li>
			<li>Rôle</li>
			<li>Groupes</li>
		</ul>
		Vous pouvez supprimer une IP de la liste noire des IP pour la débannir et ainsi que l'intranet soit joignable depuis cette IP.
	</p>";
	}
	echo "
</div>
<div id=\"espace-de-fichiers\" style=\"display: none;\">
	<hr>
	<p>
		La page \"Espace de fichiers\" permet d'échanger des dossiers et des fichiers.
		<br>
		Cet espace permet donc les fonctionnalités suivantes:
		<h5>
			<ul>
				<li>Création d'un répertoire</li>
				<li>Création d'un répetoire partagé</li>
				<li>Téléversement d'un fichier</li>
				<li>Téléchargement d'un fichier</li>
				<li>Choix de l'accès du fichier à téléverser</li>
				<li>Suppression de l'ensemble d'un répertoire partagé</li>
				<li>Suppression d'un fichier en particulier</li>
			</ul>
		</h5>
		Les différents mode de partage sont les suivants:
		<br>
		&emsp;Moi seulement: <small>Seul vous pouvez consulter le document</small>
		<br>
		&emsp;Mes groupes: <small>Seuls les membres possédant au moins un groupe en commun avec vous pouvent consulter le document</small>
		<br>
		&emsp;Tout le monde: <small>Tout le monde peut consulter le document</small>
		<br>
		<br>
		<ul>
			<li>
				<strong>Création d'un répertoire:</strong>
				<ol>
					<li>Rentrer le nom souhaité dans le champ \"Nom du dossier\"</li>
					<li>Sélectionner le mode de partage du dossier (par défaut uniquement vous)</li>
					<li>Cliquer sur \"Créer le dossier\"</li>
				</ol>
			</li>
			<br>
			<li>
				<strong>Publication d'un fichier:</strong>
				<ol>
					<li>Cliquer sur \"Choisir un fichier\"</li>
					<li>Sélectionner le fichier à publier</li>
					<li>Cliquer sur \"Ouvrir\"</li>
					<li>Sélectionner le mode de partage du fichier (par défaut uniquement vous)</li>
					<li>Cliquer sur \"Importer\"</li>
				</ol>
			</li>
			<br>
			<li>
				<strong>Téléchargement d'un fichier:</strong>
				<ol>
					<li>Naviguer jusqu'au fichier</li>
					<li>Cliquer sur le nom du fichier à télécharger</li>
				</ol>
			</li>
			<br>
			<li>
				<strong>Suppression d'un répertoire ou d'un fichier:</strong>
				<ol>
					<li>Naviguer jusqu'au fichier / dossier</li>
					<li>Cliquer sur le bouton \"-\" à gauche du nom du fichier / dossier à supprimer</li>
				</ol>
			</li>
		</ul>
	</p>
</div>";
}
?>
<div id="connexion" style="display: none;">
	<hr>
	<p>
		La page de connexion se divise en deux parties:
		<ul>
			<li>Connexion à un compte existant</li>
			<li>Demande de création d'un compte</li>
		</ul>
		Vous pouvez vous connecter à votre compte en rentrant votre identifiant et votre mot de passe puis en cliquant sur "Se connecter".
		<br>
		Si vous ne possédez pas de compte, vous pouvez demander la création d'un compte slarié en remplissant le formulaire.
		<br>
		<h2>Vous serez <b>banni</b> au bout de <strong>3 essais</strong> infructueux</h2>
		L'intranet ne banni pas le compte mais l'adresse IP utilisée. Demandez alors à un modérateur de débannir l'IP.
	</p>
</div>
<div id="aide" style="display: none;">
	<hr>
	<p>
		La page d'aide est ici pour vous informer de toutes les informations que vous pourrez retrouver sur l'intranet de Sardines & cie. 
		<br>
		Si vous pensez que des informations sont manquantes, n'hésitez pas à contacter un de vos superieurs !
		<br>
		L'équipe techinque se chargera de résoudre votre problème en un temps record !
	</p>
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
	url = url.replace('datahub.com/faq.php','');
	if (url != ""){
		display(url.replace("#",''));
	}
</script>
<br>
<?php
footer();
?>