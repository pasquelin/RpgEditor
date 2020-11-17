<?php

defined( '_ACCES' ) or die( 'Acces interdit' );

class database 
{
	/** @var string */
	public $_sql = '';
	/** @var int */
	public $_errorNum = 0;
	/** @var string */
	public $_errorMsg = '';
	/** @var string */
	public $_table_prefix	= '';
	/** @var Internal */
	public $_resource = '';
	/** @var Internal */
	public $_cursor = null;
	/** @var boolean */
	public $_debug = 0;
	/** @var int */
	public $_limit = 0;
	/** @var int */
	public $_offset = 0;
	/** @var int */
	public $_ticker = 0;
	/** @var array */
	public $_log = null;
	/** @var string */
	public $_nullDate = '0000-00-00 00:00:00';
	/** @var string */
	public $_nameQuote = '`';

	/**
	* Methode : Constructeur
	*/
	public function __construct ( $host='localhost', $user, $pass, $dbSelect='', $table_prefix='' ) 
	{
		if( !function_exists( 'mysql_connect' ) ) 
			$SystemError = 1;
		else
		{	
			if( phpversion() < '4.2.0' && !( $this->_resource = mysql_connect( $host, $user, $pass ) ) ) 
					$SystemError = 2;
			elseif(!($this->_resource = @mysql_connect( $host, $user, $pass, true )))
					$SystemError = 2;
			
			if($dbSelect != '' && !mysql_select_db( $dbSelect, $this->_resource ))
				$SystemError = 3;
		}
		$this->_table_prefix = $table_prefix;
		$this->_ticker = 0;
		$this->_log = array();
	}
	
	/**
	* Methode : pour le debuguage
	*/
	public function debug ( $level ) 
	{
		$this->_debug = intval( $level );
	}
	
	/**
	* Methode : numero de l'erreur
	*/
	public function getErrorNum ( ) 
	{
		return $this->_errorNum;
	}
	
	/**
	* Methode : message d'erreur
	*/
	public function getErrorMsg ( ) 
	{
		return str_replace( array( "\n", "'" ), array( '\n', "\'" ), $this->_errorMsg );
	}
	
	/**
	* Methode : quote selon la version php
	*/
	public function getEscaped ( $text, $extra = false ) 
	{
		if( version_compare( phpversion(), '4.3.0', '<' ) )
			$string = mysql_escape_string( $text );
		else
			$string = mysql_real_escape_string( $text, $this->_resource );

		if( $extra )
			$string = addcslashes( $string, '%_' );
		return $string;
	}
	
	/**
	* Methode : ajouter les quote
	*/
	public function Quote ( $text, $escaped = true )
	{
		if( is_numeric( $text ) )
			return ( $escaped ? $this->getEscaped( $text ) : $text );
		else
			return '\''.( $escaped ? $this->getEscaped( $text ) : $text ).'\'';
	}
	
	/**
	* Methode : nom de chaque quote
	*/
	public function NameQuote ( $s ) 
	{
		$q = $this->_nameQuote;
		if( strlen( $q ) == 1 )
			return $q . $s . $q;
		else
			return $q{0} . $s . $q{1};
	}
	
	/**
	* Methode : prefix de la table
	*/
	public function getPrefix ( ) 
	{
		return $this->_table_prefix;
	}
	
	/**
	* Methode :
	*/
	public function getNullDate ( ) 
	{
		return $this->_nullDate;
	}
	
	/**
	* Methode : selection query
	*/
	public function setQuery ( $sql, $offset = 0, $limit = 0, $prefix='#__' ) 
	{
		$this->_sql = $this->replacePrefix( $sql, $prefix );
		$this->_limit = intval( $limit );
		$this->_offset = intval( $offset );	
	}

	/**
	* Methode : on remplace le prefix de la requete
	*/
	public function replacePrefix ( $sql, $prefix='#__' ) 
	{
		$sql = trim( $sql );

		$escaped = false;
		$quoteChar = '';

		$n = strlen( $sql );

		$startPos = 0;
		$literal = '';
		while( $startPos < $n ) 
		{
			$ip = strpos( $sql, $prefix, $startPos );
			if( $ip === false )
				break;

			$j = strpos( $sql, "'", $startPos );
			$k = strpos( $sql, '"', $startPos );
			if( ( $k !== false ) && ( ( $k < $j ) || ( $j === false ) ) ) 
			{
				$quoteChar = '"';
				$j = $k;
			} else
				$quoteChar = "'";

			if( $j === false )
				$j = $n;

			$literal .= str_replace( $prefix, $this->_table_prefix, substr( $sql, $startPos, $j - $startPos ) );
			$startPos = $j;

			$j = $startPos + 1;

			if( $j >= $n )
				break;

			while( true ) 
			{
				$k = strpos( $sql, $quoteChar, $j );
				$escaped = false;
				if( $k === false )
					break;

				$l = $k - 1;
				while( $l >= 0 && $sql{$l} == '\\' ) 
				{
					$l--;
					$escaped = !$escaped;
				}
				if($escaped) 
				{
					$j	= $k+1;
					continue;
				}
				break;
			}
			if( $k === false ) 
				break;

			$literal .= substr( $sql, $startPos, $k - $startPos + 1 );
			$startPos = $k+1;
		}
		if( $startPos < $n )
			$literal .= substr( $sql, $startPos, $n - $startPos );

		return $literal;
	}
	
	/**
	* Methode : on affiche la requete sql
	*/
	public function getQuery ( ) 
	{
		return '<pre>' . htmlspecialchars( $this->_sql ) . '</pre>';
	}
	
	/**
	* Methode : on envois/recois la requete SQL
	*/
	public function query ( ) 
	{
		if( $this->_limit > 0 && $this->_offset == 0 ) 
			$this->_sql .= ' LIMIT '.$this->_limit;
		elseif( $this->_limit > 0 || $this->_offset > 0 )
			$this->_sql .= ' LIMIT '.$this->_offset.', '.$this->_limit;

		if( $this->_debug ) 
		{
			$this->_ticker++;
	  	$this->_log[] = $this->_sql;
		}
		$this->_errorNum = 0;
		$this->_errorMsg = '';
		$this->_cursor = mysql_query( $this->_sql, $this->_resource );
		if( !$this->_cursor ) 
		{
			$this->_errorNum = mysql_errno( $this->_resource );
			$this->_errorMsg = mysql_error( $this->_resource ).' SQL = '.$this->_sql;
			if( $this->_debug ) 
			{
				trigger_error( mysql_error( $this->_resource ), E_USER_NOTICE );
				if( function_exists( 'debug_backtrace' ) ) 
				{
					foreach( debug_backtrace() as $back ) 
					{
						if( @$back['file'] )
							echo '<br />'.$back['file'].':'.$back['line'];
					}
				}
			}
			return false;
		}
		return $this->_cursor;
	}

	/**
	* Methode : le nombre de ligne
	*/
	public function getAffectedRows ( ) 
	{
		return mysql_affected_rows( $this->_resource );
	}

	/**
	* Methode : query batch
	*/
	public function query_batch ( $abort_on_error=true, $p_transaction_safe = false ) 
	{
		$this->_errorNum = 0;
		$this->_errorMsg = '';
		if( $p_transaction_safe ) 
		{
			$si = mysql_get_server_info( $this->_resource );
			preg_match_all( "/(\d+)\.(\d+)\.(\d+)/i", $si, $m );
			
			if( $m[1] >= 4 )
				$this->_sql = 'START TRANSACTION;' . $this->_sql . '; COMMIT;';
			elseif( $m[2] >= 23 && $m[3] >= 19 )
				$this->_sql = 'BEGIN WORK;' . $this->_sql . '; COMMIT;';
			elseif( $m[2] >= 23 && $m[3] >= 17 )
				$this->_sql = 'BEGIN;' . $this->_sql . '; COMMIT;';
		}
		$query_split = preg_split( "/[;]+/", $this->_sql );
		$error = 0;
		foreach( $query_split as $command_line ) 
		{
			$command_line = trim( $command_line );
			if( $command_line != '' ) 
			{
				$this->_cursor = mysql_query( $command_line, $this->_resource );
				if( !$this->_cursor ) 
				{
					$error = 1;
					$this->_errorNum .= mysql_errno( $this->_resource ) . ' ';
					$this->_errorMsg .= mysql_error( $this->_resource ) . ' SQL = ' . $command_line . '<br />';
					if($abort_on_error)
						return $this->_cursor;
				}
			}
		}
		return $error ? false : true;
	}

	/**
	* Methode : mysql_num_rows
	*/
	public function getNumRows ( $cur=null ) 
	{
		return mysql_num_rows( $cur ? $cur : $this->_cursor );
	}

	/**
	* Methode : mysql_fetch_row
	*/
	public function loadResult ( ) 
	{
		if( !( $cur = $this->query() ) ) 
			return null;

		$ret = null;
		if($row = mysql_fetch_row( $cur ))
			$ret = $row[0];

		mysql_free_result( $cur );
		return $ret;
	}
	
	/**
	* Methode : mysql_fetch_row
	*/
	public function loadResultArray ( $numinarray = 0 ) 
	{
		if( !( $cur = $this->query() ) )
			return null;

		$array = array();
		while( $row = mysql_fetch_row( $cur ))
			$array[] = $row[$numinarray];

		mysql_free_result( $cur );
		return $array;
	}
	
	/**
	* Methode :mysql_fetch_assoc
	*/
	public function loadAssocList ( $key='' ) 
	{
		if( !( $cur = $this->query() ) )
			return null;

		$array = array();
		while( $row = mysql_fetch_assoc( $cur ) ) 
		{
			if( $key )
				$array[$row[$key]] = $row;
			else
				$array[] = $row;
		}
		mysql_free_result( $cur );
		return $array;
	}
	
	/**
	* Methode : On transforme le resultat MySQL en objet
	*/
	public function loadObject ( &$object ) 
	{
		if( $object != null ) 
		{
			if( !( $cur = $this->query() ) )
				return false;

			if( $array = mysql_fetch_assoc( $cur ) ) 
			{
				mysql_free_result( $cur );
				BindArrayToObject( $array, $object, null, null, false );
				return true;
			} 
			else
				return false;
		} 
		else 
		{
			if( $cur = $this->query() ) 
			{
				if($object = mysql_fetch_object( $cur )) 
				{
					mysql_free_result( $cur );
					return true;
				} 
				else 
				{
					$object = null;
					return false;
				}
			} 
			else 
				return false;
		}
	}
	
	/**
	* Methode : mysql_fetch_object
	*/
	public function loadObjectList ( $key='' ) 
	{
		if( !( $cur = $this->query() ) )
			return null;

		$array = array();
		while($row = mysql_fetch_object( $cur )) 
		{
			if( $key )
				$array[$row->$key] = $row;
			else
				$array[] = $row;
		}
		mysql_free_result( $cur );
		return $array;
	}
	
	/**
	* Methode : mysql_fetch_row
	*/
	public function loadRow ( ) 
	{
		if( !( $cur = $this->query() ) )
			return null;

		$ret = null;
		if( $row = mysql_fetch_row( $cur ) )
			$ret = $row;

		mysql_free_result( $cur );
		return $ret;
	}
	
	/**
	* Methode : loadRowList
	*/
	public function loadRowList ( $key=null ) 
	{
		if( !( $cur = $this->query() ) )
			return null;

		$array = array();
		while( $row = mysql_fetch_row( $cur ) ) 
		{
			if( !is_null( $key ) )
				$array[$row[$key]] = $row;
			else
				$array[] = $row;
		}
		mysql_free_result( $cur );
		return $array;
	}
	
	/**
	* Methode : insert une ligne
	*/
	public function insertObject ( $table, &$object, $keyName = NULL, $verbose=false ) 
	{
		$fmtsql = "INSERT INTO `".$table."` ( %s ) VALUES ( %s ) ";
		$fields = array();
		foreach( get_object_vars( $object ) as $k => $v ) 
		{
			if( is_array($v) || is_object($v) || $v === NULL )
				continue;

			if( $k[0] == '_' )
				continue;

			$fields[] = $this->NameQuote( $k );
			$values[] = $this->Quote( $v );
		}
		$this->setQuery( sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) ) );
		($verbose) && print $sql.'<br />';
		if(!$this->query())
			return false;

		$id = mysql_insert_id( $this->_resource );
		( $verbose ) && print 'id=['.$id.']<br />';
		if( $keyName && $id )
			$object->$keyName = $id;

		return true;
	}

	/**
	* Methode : mise a jour d'une ligne update
	*/
	public function updateObject ( $table, &$object, $keyName, $updateNulls = true, $limit = 0 ) 
	{
		$fmtsql = "UPDATE `".$table."` SET %s WHERE %s";
		$tmp = array();
		foreach( get_object_vars( $object ) as $k => $v ) 
		{
			if( is_array($v) || is_object($v) || $k[0] == '_' ) 
				continue;

			if( $k == $keyName ) 
			{
				$where = '`'.$keyName . '` = ' . $this->Quote( $v );
				continue;
			}
			if( $v === NULL && !$updateNulls )
				continue;

			if( $v == '' )
				$val = "''";
			else
				$val = $this->Quote( $v );

			$tmp[] = $this->NameQuote( $k ) . ' = ' . $val;
		}
		$this->setQuery( sprintf( $fmtsql, implode( ", ", $tmp ) , $where ), 0, $limit );

		return $this->query();
	}

	/**
	* Methode : retourne la ligne sql erroné avec couleur
	*/
	public function stderr ( $showSQL = false ) 
	{
		return _RPG_DB_ERREUR .$this->_errorNum.' <br /><font color="red">'.$this->_errorMsg.'</font>'.($showSQL ? '<br /> SQL = <pre>'.$this->_sql.'</pre>' : '');
	}

	/**
	* Methode : inserer un id 
	*/
	public function insertid ( ) 
	{
		return mysql_insert_id( $this->_resource );
	}

	/**
	* Methode : recuperer la version server
	*/
	public function getVersion() 
	{
		return mysql_get_server_info( $this->_resource );
	}

	/**
	* Methode : liste des tables
	*/
	public function getTableList ( ) 
	{
		$this->setQuery( 'SHOW TABLES' );
		return $this->loadResultArray();
	}
	
	/**
	* Methode : SHOW CREATE table
	*/
	public function getTableCreate( $tables ) 
	{
		$result = array();

		foreach ($tables as $tblval) 
		{
			$this->setQuery( 'SHOW CREATE table ' . $this->getEscaped( $tblval ) );
			$rows = $this->loadRowList();
			foreach ($rows as $row) 
				$result[$tblval] = $row[1];
		}

		return $result;
	}
	
	/**
	* Methode : SHOW FIELDS FROM table
	*/
	public function getTableFields ( $tables ) 
	{
		$result = array();

		foreach( $tables as $tblval ) 
		{
			$this->setQuery( 'SHOW FIELDS FROM ' . $tblval );
			$fields = $this->loadObjectList();
			foreach( $fields as $field )
				$result[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type );
		}

		return $result;
	}

	/**
	* Methode : return 0
	*/
	public function GenID ( $foo1=null, $foo2=null ) 
	{
		return '0';
	}

	/**
	* Methode : mettre en gras lors de l affichage des requete methode ci dessous
	*/
	private function BoldValeur ( $text ) 
	{
		$text = str_replace('INNER JOIN', '<b>INNER JOIN</b>', $text );
		$text = str_replace('RIGHT JOIN', '<b>RIGHT JOIN</b>', $text );
		$text = str_replace('LEFT JOIN', '<b>LEFT JOIN</b>', $text );
		$text = str_replace('JOIN', '<b>JOIN</b>', $text );
		$text = str_replace('SELECT', '<b>SELECT</b>', $text );
		$text = str_replace('REGEXP', '<b>REGEXP</b>', $text );
		$text = str_replace('UPDATE', '<b>UPDATE</b>', $text );
		$text = str_replace('DELETE', '<b>DELETE</b>', $text );
		$text = str_replace('WHERE', '<b>WHERE</b>', $text );
		$text = str_replace('LIMIT', '<b>LIMIT</b>', $text );
		$text = str_replace('ORDER', '<b>ORDER</b>', $text );
		$text = str_replace('COUNT', '<b>COUNT</b>', $text );
		$text = str_replace('FROM', '<b>FROM</b>', $text );
		$text = str_replace('LIKE', '<b>LIKE</b>', $text );
		$text = str_replace('DESC', '<b>DESC</b>', $text );
		$text = str_replace('NULL', '<b>NULL</b>', $text );
		$text = str_replace('null', '<b>NULL</b>', $text );
		$text = str_replace('ASC', '<b>ASC</b>', $text );
		$text = str_replace('NOT', '<b>NOT</b>', $text );
		$text = str_replace('SET', '<b>SET</b>', $text );
		$text = str_replace('AND', '<b>AND</b>', $text );
		$text = str_replace('ON', '<b>ON</b>', $text );
		$text = str_replace('OR', '<b>OR</b>', $text );
		$text = str_replace('BY', '<b>BY</b>', $text );
		$text = str_replace('IS', '<b>IS</b>', $text );
		$text = str_replace('(', '<b>(</b>', $text );
		$text = str_replace(')', '<b>)</b>', $text );
		$text = str_replace('*', '<small>*</small>', $text );
		return $text;
	}
	
	/**
	* Methode : affiche toutes les requetes SQL
	*/
	public function AfficheRequet ( $delaiChargement = false ) 
	{
		echo '<div class="debugguage">';
		echo '<h2>' . _RPG_ADMIN_TEMPLATE_TITREDEBUG . '</h2>';
		
		if( $delaiChargement )
			echo '<p><b>' . _RPG_DBCONTROL_TEMPS . ' ' . number_format( $delaiChargement, 3 ) . ' s</b></p>';
		
		if( $this->_errorNum )
		{
			echo '<p><b>' . $this->_errorNum . ' ' . _RPG_DBCONTROL_NBRERROR .'</b></p>';
			echo '<p>' . $this->_errorMsg . '</p>';
		}
			
		echo '<p><b>' . _RPG_DBCONTROL_NBRDEBUG . ' ' . $this->_ticker . '</b></p>';
		
		foreach( $this->_log as $k => $sql )
			echo '<b>' . ($k+1) . "</b>\n" . $this->BoldValeur( $sql ) . '<hr />';
		
		echo '</div>';
	}
}

class DBTable 
{
	/** @var string */
	public $_tbl 		= '';
	/** @var string */
	public $_tbl_key 	= '';
	/** @var string */
	public $_error 	= '';
	/** @var db */
	public $_db 		= null;

	/**
	* Methode : Constructeur
	*/
	public function DBTable ( $table, $key, &$db ) 
	{
		$this->_tbl = $table;
		$this->_tbl_key = $key;
		$this->_db =& $db;
	}

	/**
	* Methode :
	*/
	public function getPublicProperties ( ) 
	{
		static $cache = null;
		if(is_null( $cache )) 
		{
			$cache = array();
			foreach( get_class_vars( get_class( $this ) ) as $key=>$val ) 
			{
				if( substr( $key, 0, 1 ) != '_' )
					$cache[] = $key;
			}
		}
		return $cache;
	}
	
	/**
	* Methode : filtre
	*/
	public function filter ( $ignoreList=null ) 
	{
		$ignore = is_array( $ignoreList );

		$iFilter = new InputFilter();
		foreach ($this->getPublicProperties() as $k) 
		{
			if($ignore && in_array( $k, $ignoreList ) )
				continue;
			$this->$k = $iFilter->process( $this->$k );
		}
	}
	
	/**
	* Methode :
	*/
	public function get ( $_property ) 
	{
		if(isset( $this->$_property ))
			return $this->$_property;
		else 
			return null;
	}

	/**
	* Methode :
	*/
	public function set ( $_property, $_value ) 
	{
		$this->$_property = $_value;
	}

	/**
	* Methode :
	*/
	public function reset ( $value=null ) 
	{
		$keys = $this->getPublicProperties();
		foreach( $keys as $k )
			$this->$k = $value;
	}

	/**
	* Methode : charger une requete SQL
	*/
	public function load ( $oid=null , $limit = 0 ) 
	{
		$k = $this->_tbl_key;

		if( $oid !== null )
			$this->$k = $oid;

		$oid = $this->$k;

		if( $oid === null )
			return false;
			
		$class_vars = get_class_vars( get_class( $this ) );
		foreach( $class_vars as $name => $value ) 
		{
			if( ( $name != $k ) and ( $name != "_db" ) and ( $name != "_tbl" ) and ( $name != "_tbl_key" ) )
				$this->$name = $value;
		}

		$this->reset();
		$this->_db->setQuery( "SELECT * FROM `".$this->_tbl."` WHERE `".$this->_tbl_key."` = " . $this->_db->Quote( $oid ), 0 , $limit );

		return $this->_db->loadObject( $this );
	}

	/**
	* Methode : selectionner une ligne selon son id
	*/
	public function selectKey ( $oid=null, $limite = 0 ) 
	{
		$k = $this->_tbl_key;

		if( $oid !== null )
			$this->$k = $oid;

		$oid = $this->$k;

		if( $oid === null )
			return false;
	
		$this->_db->setQuery( "SELECT * FROM `".$this->_tbl."` WHERE `".$this->_tbl_key."` = " . $this->_db->Quote( $oid ), 0 , $limite );
		
		return $this->_db->loadObjectList();
	}
	
	/**
	* Methode : effacer la ligne selon son id
	*/
	public function delete ( $oid=null ) 
	{
		$k = $this->_tbl_key;
		if( $oid ) 
			$this->$k = intval( $oid );

		$this->_db->setQuery( "DELETE FROM `".$this->_tbl."` WHERE `".$this->_tbl_key."` = " . $this->_db->Quote( $this->$k ) );

		if( $this->_db->query() )
			return true;
		else 
		{
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}
	
	/**
	* Methode : supprimer une ligne selon la clef et sa valeur
	*/
	public function deleteCan ( $key, $valeur, $limit = 0 ) 
	{		
		$this->_db->setQuery( "DELETE FROM `".$this->_tbl."` WHERE `".$key."` = '" . $valeur . "'" , 0 , $limit );

		if( $this->_db->query() )
			return true;
		else 
		{
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}
	
	/**
	* Methode : affiche les erreur SQL
	*/
	public function getError() 
	{
		return $this->_error;
	}
}
?>
