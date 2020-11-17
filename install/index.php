<?php
define( '_ACCES', 1 );

if( file_exists( '../modules/global/config/database.php' ) && filesize( '../modules/global/config/database.php' ) > 1 )
{
		header( "Location: ../index.php" );
		exit();
}

require_once 'common.php';

$sp = ini_get( 'session.save_patd' );

require_once 'header.php';
?>

<h1>Permissions des répertoires</h1>
<hr/>
<h2>Explications via le terminal</h2>
<p>Certains répertoires doivent être accessibles en lecture et écriture.<br/>Si certains des répertoires listés co-contre sont dans l'état <b><font color="red">Non modifiable</font></b>, alors vous devrez changer les CHMOD pour les rendre <b><font color="green">Modifiables</font></b>. <br/> Pour faire au plus simple, ouvrez votre terminale, puis tapez ceci : </p>
<pre>cd <?php $kohana_pathinfo = pathinfo( __FILE__ );
echo str_replace( 'install', '', $kohana_pathinfo['dirname'] ); ?></pre>
<p>Ensuite il vous suffit de faire un chmod 777 de chaque dossier.<br/> Exemple qui montre comment le faire d'un seul coup : </p>
<pre>sudo chmod 777 cache logs css js images system/config application/config admin/application/config modules/plugins/controllers modules/plugins/views modules/plugins/i18n images/background images/articles images/character images/items images/sorts</pre>
<h2>Capture écran</h2>
<div class="center"><img src="./images/term.png" alt="Terminal"/></div>
<h2>Etat des dossiers</h2>
<table class="list_table">
		<?php
		writableCell( 'cache' );
		writableCell( 'logs' );
		writableCell( 'css' );
		writableCell( 'js' );
		writableCell( 'images' );
		writableCell( 'system/config' );
		writableCell( 'application/config' );
		writableCell( 'admin/application/config' );
		writableCell( 'modules/plugins/controllers' );
		writableCell( 'modules/plugins/views' );
		writableCell( 'modules/plugins/i18n' );
		writableCell( 'images/background' );
		writableCell( 'images/articles' );
		writableCell( 'images/character' );
		writableCell( 'images/items' );
		writableCell( 'images/sorts' );
		?>
</table>

<h1> Vérification des paramètres nécessaires</h1>
<hr/>
<p> Si certains éléments sont écrits en <font color="red">rouge</font>, alors veuillez prendre les mesures nécessaires pour les corriger. </p>
<table class="list_table">
		<tr>
				<td class="item"> PHP version &gt;= 5.2 </td>
				<td align="left"><?php
		$vs = @phpversion();
		echo $vs < 5.2 ? '<b><font color="red">Non ('.$vs.')</font></b>' : '<b><font color="green">Oui ('.$vs.')</font></b>';
		?></td>
		</tr>
		<tr>
				<td valign="top"><a href="http://www.php.net/gd" target="_blank">Support GD</a> </td>
				<td align="left"><?php echo @extension_loaded( 'gd' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>'; ?></td>
		</tr>
		<tr>
				<td><a href="http://www.php.net/getimagesize" target="_blank">Getimagesize</a> </td>
				<td align="left"><?php echo @function_exists( 'getimagesize' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>'; ?></td>
		</tr>
		<tr>
				<td><a href="http://www.php.net/zlib" target="_blank">Compression ZLIB</a> </td>
				<td align="left"><?php echo @extension_loaded( 'zlib' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>'; ?></td>
		</tr>
		<tr>
				<td><a href="http://www.php.net/xml" target="_blank">Support XML</a> </td>
				<td align="left"><?php echo @extension_loaded( 'xml' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>'; ?></td>
		</tr>
		<tr>
				<td><a href="http://www.php.net/mysql" target="_blank">Support MySQL</a> </td>
				<td align="left"><?php echo @function_exists( 'mysql_connect' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>'; ?></td>
		</tr>
		<?php if( @function_exists( 'php_ini_loaded_file' ) )
		{ ?>
				<tr>
						<td>Chemin du fichier php.ini</td>
						<td align="left"><?php
		$inipatd = php_ini_loaded_file();

		if( $inipatd )
				echo '<b><font color="green">'.$inipatd.'</font></b>';
				?></td>
				</tr>
		<?php } ?>
		<tr>
				<td>PCRE UTF-8</td>
				<?php if( !function_exists( 'preg_match' ) ): ?>
						<td class="fail"><a href="http://php.net/pcre">PCRE</a> <b><font color="green">Non</font></b></td>
				<?php elseif( !@preg_match( '/^.$/u', 'ñ' ) ): ?>
						<td class="fail"><a href="http://php.net/pcre">PCRE</a> <b><font color="red">Non</font></b></td>
				<?php elseif( !@preg_match( '/^\pL$/u', 'ñ' ) ): ?>
						<td class="fail"><a href="http://php.net/pcre">PCRE</a> <b><font color="red">Non</font></b></td>
				<?php else : ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php endif ?>
		</tr>
		<tr>
				<td>Reflection Enabled</td>
				<?php if( class_exists( 'ReflectionClass' ) ): ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php else : ?>
						<td class="fail"> PHP <a href="http://www.php.net/reflection">reflection</a> <b><font color="red">Non</font></b></td>
				<?php endif ?>
		</tr>
		<tr>
				<td>Filters Enabled</td>
				<?php if( function_exists( 'filter_list' ) ): ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php else : ?>
						<td class="fail"> tde <a href="http://www.php.net/filter">filter</a> <b><font color="red">Non</font></b></td>
				<?php endif ?>
		</tr>
		<tr>
				<td>Iconv Extension Loaded</td>
				<?php if( extension_loaded( 'iconv' ) ): ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php else : ?>
						<td class="fail"> tde <a href="http://php.net/iconv">iconv</a> <b><font color="red">Non</font></b></td>
				<?php endif ?>
		</tr>
		<tr>
				<td>SPL Enabled</td>
				<?php if( function_exists( 'spl_autoload_register' ) ): ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php else : ?>
						<td class="fail"><a href="http://php.net/spl">SPL</a> <b><font color="red">Non</font></b></td>
				<?php endif ?>
		</tr>
		<tr>
				<td>Multibyte String Enabled</td>
				<?php if( extension_loaded( 'mbstring' ) ): ?>
						<td><b><font color="green">Oui</font></b></td>
				<?php else: ?>
						<td class="fail">tde <a href="http://php.net/mbstring">mbstring</a> <b><font color="red">Non</font></b></td>
				<?php endif ?>
		</tr>
		<?php if( extension_loaded( 'mbstring' ) ): ?>
				<tr>
						<td>Mbstring Not Overloaded</td>
						<?php if( ini_get( 'mbstring.func_overload' ) & MB_OVERLOAD_STRING ): ?>
								<td class="fail"> tde <a href="http://php.net/mbstring">mbstring</a> <b><font color="red">Non</font></b></td>
						<?php else : ?>
								<td><b><font color="green">Oui</font></b></td>
						<?php endif ?>
				</tr>
		<?php endif ?>
</table>	


<?php
$wrongSettingsTexts = array( );

if( @ini_get( 'magic_quotes_gpc' ) == '1' )
		$wrongSettingsTexts[] = 'Paramètre PHP magic_quotes_gpc est sur `ON` au lieu de `OFF`';

if( @ini_get( 'register_globals' ) == '1' )
		$wrongSettingsTexts[] = 'Paramètre PHP register_globals est sur `ON` au lieu de `OFF`';

if( count( $wrongSettingsTexts ) )
{
		?>
		<h1> Vérification de la sécurité</h1>
		<hr/>
		<p>Les paramètres PHP Serveur suivants ne sont pas optimum pour la <strong>Sécurité</strong> de votre site, il vous est recommandé de les modifier: </p>
		<table class="list_table">
				<tr>
						<td class="item"><ul style="margin: 0px; padding: 0px; padding-left: 5px; text-align: left; padding-bottom: 0px; list-style: none;">
										<?php
										foreach( $wrongSettingsTexts as $txt )
										{
												?>
												<li style="min-height: 25px; padding-bottom: 5px; padding-left: 25px; color: red; font-weight: bold;" >
														<?php
														echo $txt;
														?>
												</li>
												<?php
										}
										?>
								</ul></td>
				</tr>
		</table>		

		<?php
}
?>
<h1>Configuration recommandée</h1>
<hr/>
<p> Ces paramètres PHP sont recommandés afin d'assurer  une pleine compatibilité avec le script. <br/>Toutefois cela fonctionne correctement s'ils ne sont pas activés.</p>
<table class="list_table">
		<tr>
				<th> Directive </th>
				<th> Recommandé </th>
				<th> Actuel </th>
		</tr>
		<?php
		$php_recommended_settings = array( array( 'Safe Mode', 'safe_mode', 'OFF' ),
				array( 'Display Errors', 'display_errors', 'ON' ),
				array( 'File Uploads', 'file_uploads', 'ON' ),
				array( 'Magic Quotes GPC', 'magic_quotes_gpc', 'OFF' ),
				array( 'Magic Quotes Runtime', 'magic_quotes_runtime', 'OFF' ),
				array( 'Register Globals', 'register_globals', 'OFF' ),
				array( 'Output Buffering', 'output_buffering', 'OFF' ),
				array( 'Session auto start', 'session.auto_start', 'OFF' ),
		);

		foreach( $php_recommended_settings as $phprec )
		{
				?>
				<tr>
						<td><?php echo $phprec[0]; ?>: </td>
						<td><?php echo $phprec[2]; ?>: </td>
						<td><b>
										<?php
										if( get_php_setting( $phprec[1] ) == $phprec[2] )
										{
												?>
												<font color="green">
												<?php
										}
										else
										{
												?>
												<font color="red">
												<?php
										}
										echo get_php_setting( $phprec[1] );
										?>
										</font> </b>
						</td>
				</tr>
				<?php
		}
		?>
</table>	
<p>* <b><font color="red">ATTENTION</font></b> : si un élément est en rouge, le fonctionnement du script ne peut pas être assuré et des erreurs peuvent apparaitre.</p>
<div class="block_button">
		<input type="button" class="submit" value="Vérifier à nouveau" onclick="window.location=window.location" />
		<input name="Button2" type="button" class="submit" value="Suivant" onclick="window.location='license.php';" />
</div>
<?php
require_once 'footer.php';
?>