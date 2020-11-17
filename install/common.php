<?php

defined( '_ACCES' ) or die( 'Acces interdit' );


error_reporting( E_ALL );

header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

define( '_NOTRIM', 0x0001 );
define( '_ALLOWHTML', 0x0002 );

$etape = 1;

function GetParam( &$arr, $name, $def=null, $mask=0 )
{
		$return = null;
		if( isset( $arr[$name] ) )
		{
				if( is_string( $arr[$name] ) )
				{
						if( !($mask & _NOTRIM) )
								$arr[$name] = trim( $arr[$name] );

						if( !($mask & _ALLOWHTML) )
								$arr[$name] = strip_tags( $arr[$name] );

						if( !get_magic_quotes_gpc() )
								$arr[$name] = addslashes( $arr[$name] );
				}
				return $arr[$name];
		}
		else
				return $def;
}

function MakePassword( $length )
{
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen( $salt );
		$makepass = '';
		mt_srand( 10000000 * (double) microtime() );
		for( $i = 0; $i < $length; $i++ )
				$makepass .= $salt[mt_rand( 0, $len - 1 )];
		return $makepass;
}

function ChmodRecursive( $path, $filemode=NULL, $dirmode=NULL )
{
		$ret = TRUE;
		if( is_dir( $path ) )
		{
				$dh = opendir( $path );
				while( $file = readdir( $dh ) )
				{
						if( $file != '.' && $file != '..' )
						{
								$fullpath = $path.'/'.$file;
								if( is_dir( $fullpath ) )
								{
										if( !ChmodRecursive( $fullpath, $filemode, $dirmode ) )
												$ret = FALSE;
								}
								else
								{
										if( isset( $filemode ) && !@chmod( $fullpath, $filemode ) )
												$ret = FALSE;
								}
						}
				}
				closedir( $dh );
				if( isset( $dirmode ) && !@chmod( $path, $dirmode ) )
						$ret = FALSE;
		}
		else
		{
				if( isset( $filemode ) )
						$ret = @chmod( $path, $filemode );
		}
		return $ret;
}

function get_php_setting( $val )
{
		$r = (ini_get( $val ) == '1' ? 1 : 0);
		return $r ? 'ON' : 'OFF';
}

function writableCell( $folder, $relative=1, $text='' )
{
		$writeable = '<b><font color="green">Modifiable</font></b>';
		$unwriteable = '<b><font color="red">Non-modifiable</font></b>';

		echo '<tr>';
		echo '<td>sudo chmod 777 '.$folder.'</td>';
		echo '<td class="right">';

		if( $relative )
				echo is_writable( "../$folder" ) ? $writeable : $unwriteable;
		else
				echo is_writable( $folder ) ? $writeable : $unwriteable;

		echo '</td>';
		echo '</tr>';
}

function getMemoryUsage()
{

		if( function_exists( 'memory_get_usage' ) )
				return memory_get_usage();

		if( substr( PHP_OS, 0, 3 ) == 'WIN' )
		{

				$resultRow = 8;
				$resultRowItemStartPosition = 34;
				$resultRowItemLength = 8;

				$output = array( );
				exec( 'pslist -m '.getmypid(), $output );

				return trim( substr( $output[$resultRow], $resultRowItemStartPosition, $resultRowItemLength ) ).' KB';
		}
}

?>