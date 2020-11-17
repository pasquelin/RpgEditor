<?php

defined( 'SYSPATH' ) or die( 'Access non autoris&eacute;.' );

class Ftp_Controller extends Template_Controller {

		public function __construct()
		{
				parent::__construct();
				parent::access( 'ftp' );
		}

		/**
		 * Methode : 
		 */
		public function index( $no_html = false )
		{
				$html = 'ftp/conteneur';
				$folders = self::recursive_listdir( DOCROOT.'..' );
				$listdir = $this->input->get( 'dir', false );

				if( $no_html )
				{
						$this->auto_render = false;

						$view = new View( $html );
						$view->folders = $folders;
						$view->no_html = true;
						$view->listdir = $listdir;
						$view->render( TRUE );
				}
				else
				{
						//On donne un titre à la page
						$this->template->titre = Kohana::lang( 'ftp.title' );

						//On appel les css pour la page
						$this->css = array( 'ftp', 'form' );

						$this->template->contenu = new View( $html );
						$this->template->contenu->folders = $folders;
						$this->template->contenu->listdir = $listdir;
				}
		}

		/**
		 * Methode : 
		 */
		public function detail()
		{
				$this->auto_render = false;

				$dossier = $this->input->get( 'dir' );

				$listing = self::listing( $dossier );

				if( $listing['images'] )
				{
						$pagination = new Pagination( array( 'total_items' => count( $listing['images'] ), 'style' => 'classic', 'items_per_page' => 27 ) );

						$listing['images'] = array_slice( $listing['images'], $pagination->sql_offset, 27 );
				}

				$v = new View( 'ftp/fichiers' );
				$v->images = $listing['images'];
				$v->folders = $listing['folders'];
				$v->docs = $listing['docs'];
				$v->dossier = $dossier;
				$v->pagination = isset( $pagination ) ? $pagination : FALSE;

				$v->render( true );
		}

		/**
		 * Methode : 
		 */
		public function envois()
		{
				$dir = $this->input->post( 'list_dossier' );
				$dossier_crea = $this->input->post( 'foldername' );

				$dossier = $dir != url::base() ? DOCROOT.'../'.$dir : DOCROOT.'../';

				if( is_writable( $dossier ) )
				{
						if( $dossier_crea )
						{
								if( strlen( $dossier_crea ) > 0 )
								{
										if( preg_match( "/[^0-9a-zA-Z_]/", $dossier_crea ) )
												return;

										$folder = $dossier.'/'.$dossier_crea;

										if( !is_dir( $folder ) && !is_file( $folder ) )
										{
												mkdir( $folder, 0777 );
												$fp = fopen( $folder."/index.html", "w" );
												fwrite( $fp, "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>" );
												fclose( $fp );
										}
								}
						}
						elseif( isset( $_FILES['upload'] ) )
						{
								$uploadfile = trim( basename( $_FILES['upload']['name'] ) );

								@move_uploaded_file( $_FILES['upload']['tmp_name'], $dossier.'/'.$uploadfile );
						}
				}
				else
						$dir .= '&msg='.urlencode( Kohana::lang( 'ftp.error_chmod' ) );

				return url::redirect( 'ftp?dir='.$dir );
		}

		/**
		 * Methode : 
		 */
		private function listing( $listdir = false )
		{
				$dir = DOCROOT.'../';
				$images = array( );
				$folders = array( );
				$docs = array( );
				$allowable = '\.xcf$|\.odg$|\.gif$|\.jpg$|\.png$|\.bmp$';

				if( $listdir )
						$dir .= '/';

				if( is_dir( $dir.$listdir ) )
				{
						if( ($d = dir( $dir.$listdir )) !== FALSE )
						{
								while( false !== ( $entry = $d->read() ) )
								{
										$img_file = $entry;

										if( is_file( $dir.$listdir.'/'.$img_file ) && substr( $entry, 0, 1 ) != '.' && strtolower( $entry ) !== 'index.html' )
										{
												if( preg_match( "/$allowable/", mb_strtolower( $img_file ) ) )
												{
														$image_info = @getimagesize( $dir.$listdir.'/'.$img_file );
														$file_details['file'] = url::base().'../'.$listdir.'/'.$img_file;
														$file_details['img_info'] = $image_info;
														$file_details['size'] = filesize( $dir.$listdir."/".$img_file );
														$images[$entry] = $file_details;
												}
												else
												{
														$file_details['size'] = filesize( $dir.$listdir."/".$img_file );
														$file_details['file'] = url::base().'../'.$listdir.'/'.$img_file;
														$docs[$entry] = $file_details;
												}
										}
										else if( is_dir( $dir.$listdir.'/'.$img_file ) && substr( $entry, 0, 1 ) != '.' && strtolower( $entry ) !== 'cvs' )
												$folders[$entry] = $img_file;
								}
								$d->close();
						}
				}
				return array( 'images' => $images,
						'folders' => $folders,
						'docs' => $docs );
		}

		public function delete( $type )
		{
				$this->auto_render = false;

				$element = $this->input->get( 'dir' );
				$dir = DOCROOT.'../'.$element;
				$error = FALSE;

				if( is_dir( $dir ) )
						self::rm_all_dir( $dir );
				elseif( is_file( $dir ) )
						unlink( $dir );
				else
						$error = TRUE;

				$dir = explode( '/', $element );

				if( ( $nb = count( $dir ) ) && $nb > 0 )
						unset( $dir[count( $dir ) - 1] );

				$dir = implode( '/', $dir );

				if( $error )
						$dir .= '&msg='.urlencode( Kohana::lang( 'ftp.error_chmod' ) );

				return url::redirect( 'ftp?dir='.$dir );
		}

		/**
		 * Methode : 
		 */
		private function rm_all_dir( $dir )
		{
				if( is_dir( $dir ) )
				{
						$d = @dir( $dir );

						while( false !== ( $entry = $d->read() ) )
						{
								if( $entry != '.' && $entry != '..' )
								{
										$node = $dir.'/'.$entry;
										if( is_file( $node ) )
												unlink( $node );
										elseif( is_dir( $node ) )
												self::rm_all_dir( $node );
								}
						}
						$d->close();

						rmdir( $dir );
				}
		}

		/**
		 * Methode : 
		 */
		private function recursive_listdir( $base )
		{
				static $filelist = array( );
				static $dirlist = array( );

				if( is_dir( $base ) )
				{
						$dh = opendir( $base );
						while( false !== ($dir = readdir( $dh )) )
						{
								if( $dir !== '.' && $dir !== '..' && is_dir( $base.'/'.$dir ) && strtolower( $dir ) !== 'cvs' && strtolower( $dir ) !== '.svn' )
								{
										$subbase = $base.'/'.$dir;
										$dirlist[] = $subbase;
										$subdirlist = self::recursive_listdir( $subbase );
								}
						}
						closedir( $dh );
				}
				return $dirlist;
		}

}

?>