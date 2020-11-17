<?php
define( '_ACCES', 1 );

if( file_exists( '../modules/global/config/database.php' ) && filesize( '../modules/global/config/database.php' ) > 1 )
{
		header( "Location: ../index.php" );
		exit();
}

require_once 'common.php';

$DBhostname = GetParam( $_POST, 'DBhostname', 'localhost' );
$DBuserName = GetParam( $_POST, 'DBuserName', 'root' );
$DBpassword = GetParam( $_POST, 'DBpassword', 'root' );
$DBname = GetParam( $_POST, 'DBname', 'cmj_jeu' );

$etape = 3;

require_once 'header.php';
?>
<form action="install2.php" method="post" name="form" id="form" onsubmit="return check();">
		<h1>Configuration de la base de données MySQL</h1>
		<hr/>
		<p>Veuillez entrer le nom du serveur (hostname) sur lequel le jeu va être installé. Par défaut celui-ci est <b>localhost</b></p>
		<p>Entrez le <b>nom d'utilisateur</b>, le <b>mot de passe</b> et le <b>nom de la BDD MySQL</b> que vous allez utiliser avec Mon RPG.</p>
		<table class="list_table">
				<tr>
						<td>Nom du serveur <br/>
								<input name="DBhostname" type="text" class="inputbox" value="<?php echo "$DBhostname"; ?>" size="50" />
								<br />
								<em>Habituellement 'localhost'</em></td>
				</tr>
				<tr>
						<td>Nom d'utilisateur <br/>
								<input name="DBuserName" id="DBuserName" type="text" class="inputbox" value="<?php echo "$DBuserName"; ?>" size="50" />
								<br />
								<em>Soit 'root' ou un nom d'utilisateur fourni par l'hébergeur</em></td>
				</tr>
				<tr>
						<td>Mot de passe <br/>
								<input name="DBpassword" type="password" class="inputbox" value="<?php echo "$DBpassword"; ?>" size="50" />
								<br />
								<em>Pour la sécurité du site l'utilisation d'un mot de passe est obligatoire pour le compte MySQL</em></td>
				</tr>
				<tr>
						<td>Nom de la base de données <br/>
								<input name="DBname" type="text" class="inputbox" value="<?php echo "$DBname"; ?>" size="50" />
								<br />
								<em>Certains hébergements limitent le nombre de noms de BDD par site. </em></td>
				</tr>
		</table>
		<h1>Configuration de votre système</h1>
		<hr/>
		<p>Veuillez entrer l'URL que vous souhaitez utiliser pour la partie jeu et administration</p>
		<table class="list_table">
				<tr>
						<td>URL du jeu (sans le http://)<br/>
								<input name="site_domain" type="text" class="inputbox" value="<?php echo $_SERVER['HTTP_HOST']; ?>" size="50" />
								<br />
								<em>si vous utiliser localhost voici un exemple : localhost/MonRPG. </em></td>
				</tr>
		</table>
		<h1>Configuration de votre jeu</h1>
		<hr/>
		<p>Veuillez entrer le nom de votre jeu</p>
		<table class="list_table">
				<tr>
						<td>Nom du jeu <br/>
								<input name="name" type="text" class="inputbox" value="Créer mon jeu" size="50" /></td>
				</tr>
				<tr>
						<td>E-mail principal de votre jeu <br/>
								<input name="from" type="text" class="inputbox" value="contact@monsite.com" size="50" /></td>
				</tr>
		</table>
		<div class="block_button">
				<input name="Button2" type="button" class="submit" value="Précédent" onclick="window.location='license.php';" />
				<input class="submit" type="submit" name="next" value="Suivant"/>
		</div>
</form>

<script type="text/javascript">
		document.getElementById('DBuserName').focus();

		function check() 
		{
				var formValid=false;
				var f = document.form;
				if ( f.DBhostname.value == '' ) 
				{
						alert('Veuillez saisir un nom de serveur');
						f.DBhostname.focus();
						formValid=false;
				} 
				else if ( f.DBuserName.value == '' ) 
				{
						alert('Veuillez saisir le nom d\'utilisateur de la base de données');
						f.DBuserName.focus();
						formValid=false;
				} 
				else if ( f.DBpassword.value == '' ) 
				{
						alert('Veuillez saisir le mot de passe de la base de données');
						f.DBpassword.focus();
						formValid=false;
				} 
				else if ( f.DBname.value == '' ) 
				{
						alert('Veuillez saisir le nom de la base de données');
						f.DBname.focus();
						formValid=false;
				} 
				else if ( confirm('Etes vous certain que ces paramètres sont corrects?')) 
						formValid=true;

				return formValid;
		}
</script>

<?php
require_once 'footer.php';
?>