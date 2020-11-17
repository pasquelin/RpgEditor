<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Elements_Controller extends Template_Controller
{

    private $elements = FALSE;

    public function __construct()
    {
        parent::__construct();
        parent::access('element');

        $this->elements = Map_Model::instance();
    }

    /**
     * Methode : page de listing générale
     */
    public function index()
    {
        $this->script = array('js/lib/jquery.dataTables', 'js/listing');

        $this->template->titre = Kohana::lang('element.all_module');

        $this->template->contenu = new View('elements/list');
    }

    /**
     * Methode : gestion du listing en ajax
     */
    public function resultatAjax()
    {
        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;

        $arrayCol = array('id', 'title', 'module_map', 'region_id', 'x', 'y', 'z');

        $searchAjax = Search_Model::instance();

        $arrayResultat = $searchAjax->indexRecherche($arrayCol, 'map', $this->input, array('module_map !=' => ''));

        $display = false;

        $list_carte = Region_Model::instance()->listing_parent();

        foreach ($arrayResultat as $row) {
            $v[] = '<center>' . $row->id . '</center>';
            $v[] = $row->title ? $row->title : '<strong class="rouge">' . Kohana::lang('form.inconnu') . '</strong>';
            $v[] = '<center>' . $row->module_map . '</center>';
            $v[] = '<center>' . $list_carte[$row->region_id]->name . '</center>';
            $v[] = '<center>' . $row->x . '</center>';
            $v[] = '<center>' . $row->y . '</center>';
            $v[] = '<center>' . $row->z . '</center>';

            $display .= '[' . parent::json($v) . '],';

            unset($v);
        }

        echo $searchAjax->displayRecherche($display, $this->input->get('sEcho'));
    }

    /**
     * Methode :
     */
    public function vignette($img = false)
    {
        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;

        $v = new View('formulaire/vignette');
        $v->images = file::listing_dir(DOCROOT . '../images/modules');
        $v->selected = $img;
        $v->module = 'modules';
        $v->width = 96;
        $v->height = 96;
        $v->render(true);
    }

}

?>