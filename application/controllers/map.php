<?php

defined('SYSPATH') or die('No direct access allowed.');
/**
 * Controller public de la map. Pour afficher la map.
 *
 * @package     Map
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Map_Controller extends Authentic_Controller
{

    private $region = FALSE;
    private $botFixe;

    public function __construct()
    {
        parent::__construct();
        parent::login();

        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;
    }

    /**
     * Générer un JSON
     *
     * @return void
     */
    public function index($render = TRUE)
    {
        $json = new View('map/json');
        $json->my = $this->user;

        if (!($this->region = Region_Model::instance()->select(array('id' => $this->user->region_id), 1)))
            return FALSE;

        $json->items = Item_Model::instance()->select();


        $elements = $modules = $items = FALSE;

        if (($rows = Map_Model::instance()->select(array(
            'region_id' => $this->region->id), FALSE)) !== FALSE
        ) {
            $prenoms = Name_Model::instance()->select();

            $listName = array();
            foreach ($prenoms as $prenom)
                $listName[] = ucfirst(mb_strtolower($prenom->prenom));

            $images = file::listing_dir(DOCROOT . 'images/character');

            foreach ($rows as $row) {
                if (!$row->module_map && !$row->bot)
                    $elements[] = '{"x" : ' . $row->x . ', "z" : ' . $row->z . ', "y" : ' . $row->y . ', "subX" : ' . $row->subX . ', "subZ" : ' . $row->subZ . ', "subY" : ' . $row->subY . ', "materials" : [ "' . $row->background_px . '", "' . $row->background_nx . '", "' . $row->background_py . '", "' . $row->background_ny . '", "' . $row->background_pz . '", "' . $row->background_nz . '"	] }';
                else {
                    $data = @unserialize($row->action_map);
                    $action = json_encode($data);

                    if ($row->module_map == 'article') {
                        $article = Article_Model::instance()->select(array(
                            'id_article' => $data->id_article,
                            'article_category_id' => 2,
                            'status' => 1), 1);
                        $modules[] = '{"x" : ' . $row->x . ', "z" : ' . $row->z . ', "y" : ' . $row->y . ', "subX" : ' . $row->subX . ', "subZ" : ' . $row->subZ . ', "subY" : ' . $row->subY . ', "data" : ' . $action . ', "article" : ' . json_encode($article->article) . ' }';
                    } elseif ($row->bot) {

                        $v = new stdClass;
                        $v->id = 0;
                        $v->name = $row->bot ? $row->title : $listName[array_rand($listName)];
                        $v->x = $row->x;
                        $v->y = $row->y;
                        $v->z = $row->z;
                        $v->region_id = $row->region_id;
                        $v->user_id = $this->user->id;

                        if ($row->bot == 2)
                            $v->image = 'animals/bears.png';
                        elseif ($row->bot == 3)
                            $v->image = 'animals/dog.png'; else
                            $v->image = 'character/' . $images[array_rand($images)];

                        $v->hp_max = 100;
                        $v->hp = 100;
                        $v->leak = 0;
                        $v->type = $row->bot;
                        $v->fixe = $row->bot && !$row->module_map ? 0 : 1;
                        $v->argent = 1000;
                        $v->xp = 10;
                        $v->niveau = 0;

                        $this->botFixe[] = $v;

                        if ($row->module_map == 'quete')
                            $modules[] = '{"x" : ' . ($row->x) . ', "z" : ' . ($row->z) . ', "y" : ' . ($row->y - 1) . ', "subX" : ' . $row->subX . ', "subZ" : ' . $row->subZ . ', "subY" : ' . $row->subY . ', "data" : ' . $action . ', "article" : "" }';

                    } else
                        $modules[] = '{"x" : ' . ($row->x) . ', "z" : ' . ($row->z) . ', "y" : ' . ($row->y - 1) . ', "subX" : ' . $row->subX . ', "subZ" : ' . $row->subZ . ', "subY" : ' . $row->subY . ', "data" : ' . $action . ', "article" : "" }';
                }
            }
        }

        $articles = Article_Model::instance()->select(array(
            'region_id' => $this->region->id,
            'article_category_id' => 2,
            'status' => 1));

        $articlesList = null;
        if ($articles)
            foreach ($articles as $row)
                $articlesList[] = json_encode($row->reponse ? $row->article . '<div class="reponse">' . $row->reponse . '</div>' : $row->article);


        $this->region->map = new stdClass;
        $this->region->map->region = $this->region;
        $this->region->map->elements = $elements ? implode(',', $elements) : FALSE;
        $this->region->map->modules = $modules ? implode(',', $modules) : FALSE;
        $this->region->map->articles = $articlesList ? implode(',', $articlesList) : FALSE;
        $this->region->map->region->bots = $this->botFixe;

        $json->region = $this->region;


        $sounds = file::listing_dir(DOCROOT . 'audios', array('home.mp3'));

        $json->sounds = $sounds ? json_encode($sounds) : FALSE;

        return $json->render($render);
    }

}

?>