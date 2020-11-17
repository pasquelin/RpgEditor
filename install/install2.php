<?php
define( '_ACCES', 1 );

if( file_exists( '../modules/global/config/database.php' ) && filesize( '../modules/global/config/database.php' ) > 1 )
{
		header( "Location: ../index.php" );
		exit();
}

require_once( 'common.php' );
require_once( 'db.class.php' );

$DBhostname = GetParam( $_POST, 'DBhostname', '' );
$DBuserName = GetParam( $_POST, 'DBuserName', '' );
$DBpassword = GetParam( $_POST, 'DBpassword', '' );
$DBname = GetParam( $_POST, 'DBname', '' );
$DBPrefix = '';

$database = null;
$errors = array( );

if( !$DBhostname || !$DBuserName || !$DBname )
		db_err( "stepBack3", "Les paramètres de connexion à la base de données sont incorrects ou manquants." );

$database = new database( $DBhostname, $DBuserName, $DBpassword, '', '', false );
$test = $database->getErrorMsg();

if( !$database->_resource )
		db_err( 'stepBack2', 'Le mot de passe et le nom d\'utilisateur sont incorrects.' );

$configArray['DBhostname'] = $DBhostname;
$configArray['DBuserName'] = $DBuserName;
$configArray['DBpassword'] = $DBpassword;
$configArray['DBname'] = $DBname;

$sql = "CREATE DATABASE `$DBname`";
$database->setQuery( $sql );
$database->query();
$test = $database->getErrorNum();

if( $test != 0 && $test != 1007 )
		db_err( 'stepBack', 'Erreur de base de données : '.$database->getErrorMsg() );

$database = new database( $DBhostname, $DBuserName, $DBpassword, $DBname, $DBPrefix );

populate_db( $database );

function db_err( $step, $alert )
{
		global $DBhostname, $DBuserName, $DBpassword, $DBDel, $DBname;

		echo "<form name=\"$step\" method=\"post\" action=\"install1.php\">
	<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\">
	<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\">
	<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\">
	</form>\n";
		echo "<script type=\"text/javascript\">alert(\"$alert\"); document.location.href='install1.php';</script>";
		exit();
}

function populate_db( &$database, $sqlfile='creermonjeu.sql' )
{
		global $errors;

		$mqr = @get_magic_quotes_runtime();
		@set_magic_quotes_runtime( 0 );
		$query = fread( fopen( 'sql/'.$sqlfile, 'r' ), filesize( 'sql/'.$sqlfile ) );
		@set_magic_quotes_runtime( $mqr );
		$pieces = split_sql( $query );

		for( $i = 0; $i < count( $pieces ); $i++ )
		{
				$pieces[$i] = trim( $pieces[$i] );
				if( !empty( $pieces[$i] ) && $pieces[$i] != "#" )
				{
						$database->setQuery( $pieces[$i] );
						if( !$database->query() )
								$errors[] = array( $database->getErrorMsg(), $pieces[$i] );
				}
		}
}

function split_sql( $sql )
{
		$sql = trim( $sql );
		$sql = preg_replace( "/\n#[^\n]*\n/", "\n", $sql );

		$buffer = array( );
		$ret = array( );
		$in_string = false;

		for( $i = 0; $i < strlen( $sql ) - 1; $i++ )
		{
				if( $sql[$i] == ";" && !$in_string )
				{
						$ret[] = substr( $sql, 0, $i );
						$sql = substr( $sql, $i + 1 );
						$i = 0;
				}

				if( $in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\" )
						$in_string = false;
				elseif( !$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset( $buffer[0] ) || $buffer[0] != "\\") )
						$in_string = $sql[$i];

				if( isset( $buffer[1] ) )
						$buffer[0] = $buffer[1];

				$buffer[1] = $sql[$i];
		}

		if( !empty( $sql ) )
				$ret[] = $sql;

		return($ret);
}

$isErr = intval( count( $errors ) );


require_once 'fopen.php';

$etape = 4;

require_once 'header.php';
?>

<h1>Base de donnée et fichier de configuration</h1>
<hr/>
<?php if( $isErr )
{ ?>
		<h2><img src="./images/error.png" alt="alert" /> Il y a eu des problèmes lors de l'insertion des données</h2>
		<p>Il y eu eu une erreur SQL, voici ci-dessous l'erreur retourné par MySQL et continuer l'installation manuellement.</p>
		<?php
		echo '<div class="center">';
		echo '<textarea rows="15" cols="80">';

		foreach( $errors as $error )
				echo 'SQL='.stripslashes( $error[0] ).":\n- - - - - - - - - -\n".stripslashes( $error[1] )."\n= = = = = = = = = =\n\n";

		echo '</textarea>';
		echo "</div>\n";
}
else
{
		?>
		<h2><img src="./images/ok.png" alt="alert" /> L'installation de la base de données a été correctement effectué</h2>
<?php } ?>

<?php if( !$canWrite_database )
{ ?>
		<h2><img src="./images/error.png" alt="alert" /> Il y a eu des problèmes lors de la création de la base de donnée</h2>
		<p> Le fichier de configuration ou le répertoire <font color="red">n'est pas modifiable</font>, ou il y a eu un problème à la création du fichier du fichier de connexion MySQL.<br/>Vous devrez créer un fichier <b>/modules/global/config/database.php</b> et y copier le code suivant, puis l'uploader à la racine de votre site. </p>
		<div class="center"><textarea rows="15" cols="80" name="configcode" onclick="javascript:this.form.configcode.focus();this.form.configcode.select();" ><?php echo htmlspecialchars( $config_database ); ?></textarea></div>
<?php
}
else
{
		?>
		<h2><img src="./images/ok.png" alt="alert" /> L'installation du fichier de configuration a été correctement effectué</h2>
<?php } ?>

<?php if( !$canWrite_game || !$canWrite_email )
{ ?>
		<h2><img src="./images/error.png" alt="alert" /> Il y a eu des problèmes lors de la configuration du jeu</h2>
		<p> Le fichier de configuration ou le répertoire <font color="red">n'est pas modifiable</font>.<br/>Vous devrez modifier manuellement le fichier <b>/modules/global/config/email.php</b> et <b>/modules/global/config/game.php</b></p>
<?php
}
else
{
		?>
		<h2><img src="./images/ok.png" alt="alert" /> L'installation du fichier de configuration a été correctement effectué</h2>
<?php } ?>

<?php if( !$canWrite_config_admin || !$canWrite_config )
{ ?>
		<h2><img src="./images/error.png" alt="alert" /> Il y a eu des problèmes lors de la configuration du système</h2>
		<p> Le fichier de configuration ou le répertoire <font color="red">n'est pas modifiable</font>.<br/>Vous devrez modifier manuellement le fichier <b>/application/config/config.php</b> et <b>/admin/application/config/config.php</b></p>
<?php
}
else
{
		?>
		<h2><img src="./images/ok.png" alt="alert" /> L'installation du fichier de configuration a été correctement effectué</h2>
<?php } ?>

<h1>Félicitations! Votre installation a réussi</h1>
<hr/>
<p>Pensez à modifier votre mot de passe dans l'administration car celui ci est par défaut sur tous les jeux</p>
<table class="list_table">
		<tr>
				<td align="center"><b>Détails de connexion à l'administration et au jeu</b></td>
		</tr>
		<tr>
				<td align="center" class="login"><b>Nom d'utilisateur : <font color="green">admin</font></b></td>
		</tr>
		<tr>
				<td align="center" class="login"><b>Mot de passe : <font color="green">admin</font></b></td>
		</tr>
</table>
<p>Veuillez pensez à bien vérifier vos fichiers de configuration pour que le fonctionnement du script soit complètement fonctionnel.</p>
<p>Si vous avez modifier le nom du dossier racine ou que vous passer par un htaccess... Veuillez vous rendre dans ces différents dossiers :</p>
<pre>/system/config</pre>
<pre>/application/config</pre>
<pre>/admin/application/config</pre>

<div class="block_button">
		<input name="Button2" type="button" class="submit" value="Précédent" onclick="window.location='install1.php';" />
		<input class="submit" type="button" value="Accéder au jeu" onclick="window.location.href='../'"/>
</div>

<?php
require_once 'footer.php';
?>