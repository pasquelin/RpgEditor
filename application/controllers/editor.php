<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Editor_Controller extends Template_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::login();
    }

    /**
     * Méthode : pour empêcher un utilisateur d'accéder directement à ce controller
     */
    public function index()
    {
        $regionManager = Region_Model::instance();
        if (!($region = $regionManager->select(array('id' => $this->user->id), 1))) {
            $insert = array('name' => $this->user->username, 'id' => $this->user->id, 'x' => 50, 'y' => 50, 'z' => 50, 'background_color' => '0x8fa2ff');
            $regionManager->insert($insert);
            $region = $regionManager->select(array('id' => $this->user->id), 1);
        }

        $elements = FALSE;

        if (($rows = Map_Model::instance()->select(array('region_id' => $this->user->id))) !== FALSE) {
            foreach ($rows as $row)
                $listOptimise[$row->x][$row->y][$row->z] = true;

            foreach ($rows as $row)
                if (!isset($listOptimise[$row->x + 1][$row->y][$row->z])
                    || !isset($listOptimise[$row->x - 1][$row->y][$row->z])
                    || !isset($listOptimise[$row->x][$row->y + 1][$row->z])
                    || !isset($listOptimise[$row->x][$row->y - 1][$row->z])
                    || !isset($listOptimise[$row->x][$row->y][$row->z + 1])
                    || !isset($listOptimise[$row->x][$row->y][$row->z - 1])
                )
                    $elements[] = '{"x" : "' . $row->x . '", "z" : "' . $row->z . '", "y" : "' . $row->y . '", "materials" : [ "' . $row->background_px . '", "' . $row->background_nx . '", "' . $row->background_py . '", "' . $row->background_ny . '", "' . $row->background_pz . '", "' . $row->background_nz . '"	] }';
                else
                    Map_Model::instance()->delete((array)$row);
        }

        $this->script = array('js/lib/three.control', 'js/lib/jquery.facebox', 'js/editor');

        $this->css = array('css/core', 'css/editor', 'css/facebox');

        $this->template->content = new View('editor/index');
        $this->template->content->region = json_encode($region);
        $this->template->content->elements = $elements ? implode(',' . "\n", $elements) : FALSE;
    }

    /**
     * Page qui affiche les choix pour le material
     *
     * @return  void
     */
    public function listing_material()
    {
        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;

        $v = new View('editor/material');
        $v->material = file::listing_dir(DOCROOT . 'images/background/');
        $v->render(TRUE);
    }

    /**
     * Gestion add bloc
     *
     * @return  void
     */
    public function add()
    {
        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;

        $value = $this->input->post();
        $value['background_px'] = $value['materials'][0];
        $value['background_nx'] = $value['materials'][1];
        $value['background_py'] = $value['materials'][2];
        $value['background_ny'] = $value['materials'][3];
        $value['background_pz'] = $value['materials'][4];
        $value['background_nz'] = $value['materials'][5];
        unset($value['materials']);

        Map_Model::instance()->insert($value);
    }

    /**
     * Gestion remove bloc
     *
     * @return  void
     */
    public function remove()
    {
        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;

        $value = $this->input->post();
        unset($value['materials']);

        Map_Model::instance()->delete($value);
    }
}

?>