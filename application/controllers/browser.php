<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Controller public de la page browser.
 *
 * @package     Home
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Browser_Controller extends Template_Controller
{

    /**
     * Page par qui explique les browser autorisé
     *
     * @param bool Afficher directement ou return la vue
     * @return  void
     */
    public function index()
    {
        $this->css = 'css/browser';
        $this->template->content = new View('browser/index');
    }

}

?>