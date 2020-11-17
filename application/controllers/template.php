<?php

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Controller public du template. cette class est l'extends de tous
 * les controllers qui souhaitent afficher le template du jeu.
 *
 * @package Template
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 * @version 2.0.0
 */
abstract class Template_Controller extends Authentic_Controller
{

    /**
     * Permet de faire passer l'object template qui sera la vue finale.
     *
     * @var object protected
     */
    protected $template = FALSE;

    /**
     * Permet d'afficher ou non le template.
     *
     * @var bool protected
     */
    protected $auto_render = TRUE;

    /**
     * listing des fichiers JS à charger dans le template propre au systeme.
     *
     * @var array protected
     */
    protected $script = FALSE;

    /**
     * listing des fichiers JS à charger dans le template propre à l'utilisateur.
     *
     * @var array protected
     */
    protected $my_script = FALSE;

    /**
     * listing des fichiers CSS à charger dans le template mais qui ne seront pas compressés.
     *
     * @var array protected
     */
    protected $script_no_compress = FALSE;

    /**
     * listing des fichiers CSS à charger dans le template.
     *
     * @var array protected
     */
    protected $css = FALSE;

    public function __construct()
    {
        parent::__construct();

        $this->template = new View('template/global');

        $this->template->css = FALSE;

        $this->template->script = FALSE;

        Event::add('system.post_controller', array($this, '_render'));
    }

    /**
     * Traitement du template après le chargement de toutes les méthodes (page).
     *
     * @return  void
     */
    public function _render()
    {
        if ($this->auto_render === FALSE)
            return FALSE;

        $this->meta_link();

        $this->template->login = $this->user ? TRUE : FALSE;

        $this->template->admin = isset($this->role->name) && (in_array('admin', $this->role->name) || in_array('modo', $this->role->name)) ? TRUE : FALSE;

        $this->template->render(TRUE);
    }

    /**
     * Methode : compresse les donnée en JSON
     *
     * @return JSON
     */
    protected function json(array $txtArray)
    {
        foreach ($txtArray as $txt)
            $display[] = json_encode($txt);

        return implode(',', $display);
    }

    /**
     * Gestion des JS/CSS du jeu.
     *
     * @return  void
     */
    private function meta_link()
    {
        if (!$this->user)
            $script = array();
        else
            $script = array(
                'js/lib/jquery',
                'js/lib/three',
                'js/lib/detector',
                'js/lib/stats',
                'js/lib/tools',
                'index.php/js_phpjs');

        if ($this->script && is_array($this->script))
            $script = array_merge($script, $this->script);

        $script = array_unique($script);

        $this->template->script .= html::script($script);

        $this->template->css = html::stylesheet($this->css);
    }

}

?>
