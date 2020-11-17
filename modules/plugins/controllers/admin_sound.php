<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Changement des sons sur la map.
 *
 * @package Action_article
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Admin_Sound_Controller extends Controller
{

    /**
     * Méthode :
     */
    public function index(&$view)
    {
        $view->sounds = file::listing_dir(DOCROOT . '../audios');
    }

}

?>