<?php
defined('SYSPATH') or die('Interdit');

class Table_Core 
{
	protected static $instance;

	protected static $script;

	protected static $css;

	protected static $pager;

	private $display_glob = false;

	private $name_col = false;

	private $display_th = false;

	private $display_row = false;

	private $rows = false;

	private $id_table = false;

	private $limit_pager = false;

	public static function instance()
	{
		if (Table::$instance === NULL)
			return new Table;

		return Table::$instance;
	}
	
	public function __construct()
	{
	}
	
	public function init ( $id = false, $attributes = false )
	{
		$this->display_glob = false;
		
		$this->name_col = false;
		
		$this->display_th = false;
		
		$this->display_row = false;
		
		$this->limit_pager = false;
		
		$this->id_table = $id;
		
		$this->attribut = is_array($attributes) ? html::attributes($attributes) : '';
		
		return $this;
	}
	
	public function th ( $th = false )
	{
		if(!$th || !is_array($th) )
			return $this;
			
		$this->display_th .= '<thead> '."\n";
		$this->display_th .= '<tr>'."\n";
		
		foreach( $th as $a )
		{
			$this->display_th .= '<th>'.$a.'</th>'."\n";
			$this->name_col[] = $a;
		}
		
		$this->display_th .= '</tr>'."\n";
		$this->display_th .= '</thead> '."\n";
		
		return $this;
	}
	
	public function rows ( $rows = false )
	{
		if(!$rows || ( !is_array($rows) && !is_object($rows) ) )
			return $this;
			
		$this->rows = $rows;
		
		$this->display_row .= '<tbody>'."\n";
		
		foreach( $this->rows as $a )
		{
			$this->display_row .= '<tr>'."\n";
			
			$n = 0;
			if(is_object($a))
			{
				foreach( $a as $key => $b )
				{
					$this->display_row .= "\t".'<td class="'.$this->id_table.'_col_'.$n.'">'.$a->$key.'</td>'."\n";
					$n++;
				}
			}
			elseif(is_array($a))
			{
				foreach( $a as $b )
				{
					$this->display_row .= "\t".'<td class="'.$this->id_table.'_col_'.$n.'">'.$b.'</td>'."\n";
					$n++;
				}
			}
			
			$this->display_row .= '</tr>'."\n";
		}
		
		$this->display_row .= '</tbody>'."\n";
		
		return $this;
	}
	
	public function tri( $disable = false, $pager = false, $actif = true )
	{
		$this->limit_pager = $pager;
		
		if( Table::$css === NULL )
		{
			if(is_file(DOCROOT.'css/table.css'))
				$this->display_glob .= html::stylesheet('css/table');
				
			Table::$css = true;
		}
				
		if( $actif !== false && Table::$script === NULL )
		{
			if(is_file(DOCROOT.'js/jquery.table.js'))
				$this->display_glob .= html::script(array('js/jquery.table', 'js/jquery.tablesorter.filer'));
				
			Table::$script = true;
		}
				
		if( $this->limit_pager !== false && Table::$pager === NULL )
		{
			if( is_file(DOCROOT.'js/jquery.table.pager.js') && is_file(DOCROOT.'js/jquery.latest.js'))
				$this->display_glob .= html::script('js/jquery.table.pager');
				
			Table::$pager = true;
		}
						
		if( $actif !== false )
		{
			$this->display_glob .= '<script language="javascript" type="text/javascript">'."\n";
			$this->display_glob .= "\t".'$(document).ready(function() {  $("#'.$this->id_table.'").tablesorter({';
			
			if($disable && is_array($disable))
				$this->display_glob .= 'headers: { '.implode(': { sorter: false  }, ', $disable).': { sorter: false  } } ';

			if($disable && is_array($disable) && $pager)
				$this->display_glob .= ',';
				
			if($this->limit_pager)
				$this->display_glob .= 'widthFixed: true, widgets: [\'zebra\']';

			$this->display_glob .= '})';
				
			if($this->limit_pager)
				$this->display_glob .= '.tablesorterPager({container: $("#pager_'.$this->id_table.'"), size : '.$this->limit_pager.', positionFixed: false})';
			
			$this->display_glob .= '.tablesorterFilter({ filterContainer: $("#search_tri"), filterClearContainer: $("#delete_tri"),
                            filterCaseSensitive: false
 })';
																																		 
			$this->display_glob .= '; } );'."\n";
												
			$this->display_glob .= '</script>'."\n";
		}
		
		return $this;
	}
	
	private function th_auto()
	{
		if(!$this->rows)
			return $this;
			
		foreach( $this->rows as $a )
		{
			foreach( $a as $key => $b )
				$th[] = $key;

			self::th ( $th );
			return $this;
		}
	}
	
	public function get ( $trie = false, $no_recherche = false )
	{		
		if(!$this->display_th)
			self::th_auto();
		
		if(!$this->display_th && !$this->display_row )
			return false;
		
		if(!$no_recherche)
		{
			$this->display_glob .= '<div align="right">Affiner l\'affichage du tableau : <input id="search_tri" value="" maxlength="30" size="30" type="text" class="inputbox" /> ';
			$this->display_glob .= '<a href="javascript:;" id="delete_tri" class="button">supprimer</a></div>';
		}
			
		$this->display_glob .= '<table id="'.$this->id_table.'" '.$this->attribut.' cellpadding="0" cellspacing="1">'."\n";
		$this->display_glob .= $this->display_th;
		$this->display_glob .= $this->display_row;
		$this->display_glob .= '</table>'."\n";
		
    if( $this->limit_pager )
			$this->display_glob .= self::pager();
			
		
		return $this->display_glob;
	}
	
	private function pager( $valeur = false )
	{
		if( !$valeur || !is_array($valeur) )
			$valeur = array( 5 => 5, 10 => 10, 20 => 20, 30 => 30, 50 => 50, 100 => 100 );
		
		$display_pager = '<div class="pager_bloc">';
		$display_pager .= form::open(false, array('id' => 'pager_'.$this->id_table, 'class' => 'pager' ) )."\n";
		$display_pager .= html::image('images/table/first.png', array('class' => 'first', 'align' => 'absmiddle' ))."\n";
		$display_pager .= html::image('images/table/prev.png', array('class' => 'prev', 'align' => 'absmiddle' ))."\n";
		$display_pager .= form::input( array('type'=>'text','class'=>'pagedisplay') )."\n";
		$display_pager .= html::image('images/table/next.png', array('class' => 'next', 'align' => 'absmiddle' ))."\n";
		$display_pager .= html::image('images/table/last.png', array('class' => 'last', 'align' => 'absmiddle' ))."\n";
		$display_pager .= form::dropdown( array('class' => 'pagesize' ),$valeur, $this->limit_pager )."\n";
		
		$s = ( count($this->rows) > 1 ) ? 's' : '';
		
		$display_pager .= ' sur '.count($this->rows). ' r&eacute;sultat'.$s.' au total';
		$display_pager .= form::close()."\n";
		$display_pager .= '</div>';
		
		return $display_pager;
	}
}
?>