<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Affiche et gère les quête sur la map.
 *
 * @package Action_quête
 * @author Pasquelin Alban
 * @copyright (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Plugin_Quete_Controller extends Action_Controller
{

    /**
     * permet de faire passer l'object quete sur toutes les méthodes.
     *
     * @var object private class quete
     * @return  void
     */
    private $quete;

    public function __construct()
    {
        parent::__construct();
        $this->quete = Quete_Model::instance();
    }

    /**
     * Affiche l'alerte de présentation d'une quête (si on souhaite ou non).
     *
     * @return  void
     */
    public function index()
    {
        $this->auto_render = FALSE;

        //if( !request::is_ajax() )
        //	return FALSE;

        $list_user_quete = self::list_user();

        $row_quete = FALSE;

        if (($rows = $this->quete->select(array('element_detail_id_stop' => $this->data->id, 'status' => 1))) !== FALSE)
            foreach ($rows as $row)
                if (isset($list_user_quete[$row->id_quete]->status) && $list_user_quete[$row->id_quete]->status == 1) {
                    $row->valid = 2;
                    $row_quete['end'] = $row;
                }

        if (($rows = $this->quete->select(array('element_detail_id_start' => $this->data->id, 'status' => 1))))
            foreach ($rows as $row) {
                if (!isset($list_user_quete[$row->id_quete]) && (!$row->quete_id_parent || isset($list_user_quete[$row->quete_id_parent]) && $list_user_quete[$row->quete_id_parent])) {
                    $row->valid = 0;
                    $row_quete['start'][$row->id_quete] = $row;
                } elseif (!isset($row_quete['end'][$row->id_quete]) && isset($list_user_quete[$row->id_quete]) && $list_user_quete[$row->id_quete]->status == 1) {
                    $row->valid = 1;
                    $row_quete['action'][$row->id_quete] = $row;
                }
            }

        if (!$row_quete)
            return FALSE;
        elseif (isset($row_quete['end']))
            $row = $row_quete['end']; elseif (isset($row_quete['start']))
            $row = $row_quete['start']; elseif (isset($row_quete['action']))
            $row = $row_quete['action'];

        if (isset($row->valid) && $row->valid == 2) {
            $this->valid($row->id_quete);
            return;
        }

        $v = new View('quete/plugin');
        $v->data = $this->data;
        $v->list_quete = $row[array_rand($row)];
        $v->admin = in_array('admin', $this->role->name);
        $v->render(TRUE);
    }

    /**
     * Affiche la page qui présente la quête.
     *
     * @param integer ID quête
     * @return  void
     */
    public function show($id_quete)
    {
        $list_user_quete = self::list_user();

        if (!$quete = $this->quete->select(array('id_quete' => $id_quete, 'status' => 1), 1))
            return FALSE;

        $quete->info_stop = $quete->region = $article = FALSE;

        if (!isset($list_user_quete[$quete->id_quete]) && (!$quete->quete_id_parent || (isset($list_user_quete[$quete->quete_id_parent]) && $list_user_quete[$quete->quete_id_parent]))) {
            $quete->valid = 0;
            $quete->article = $quete->article_start;
            $quete->audio = $quete->audio_start;
        } elseif (isset($list_user_quete[$quete->id_quete]) && $list_user_quete[$quete->id_quete]->status == 2 && $quete->element_detail_id_stop == $this->data->id_module) {
            $quete->valid = 2;
            $quete->article = $quete->article_stop;
            $quete->audio = $quete->audio_stop;
        } elseif (isset($list_user_quete[$quete->id_quete]) && $list_user_quete[$quete->id_quete]->status == 1) {
            $quete->valid = 1;
            $quete->article = $quete->article_help;
            $quete->audio = null;
        } else
            return;

        if ($quete->audio) {
            $currentCookie = explode('||', cookie::get('sounds'));
            if (in_array($quete->audio, $currentCookie))
                $quete->audio = null;
            else {
                $currentCookie[] = $quete->audio;
                $quete->article = null;

            }

            cookie::set('sounds', implode('||', $currentCookie));
        }

        if (isset($quete->article))
            $quete->article = str_replace('{{joueur}}', $this->user->username, $quete->article);

        $this->auto_render = FALSE;

        $v = new View('quete/plugin_show');
        $v->data = $quete;
        $v->username = $this->user->username;
        $v->admin = in_array('admin', $this->role->name);
        $v->render(TRUE);
    }

    /**
     * Ajouter une quête à un utilisateur en status 1 (en cours).
     *
     * @params integer ID quête
     * @return  void
     */
    public function add($id_quete)
    {
        $this->auto_render = FALSE;

        if (!$this->quete->select(array('id_quete' => $id_quete, 'status' => 1, 'element_detail_id_start' => $this->data->id), 1))
            return FALSE;

        if ($this->quete->quete_insert($this->user->id, $id_quete) !== FALSE)
            $txt = Kohana::lang('quete.ok_start');
        else
            $txt = Kohana::lang('quete.error');

        self::show($id_quete);
    }

    /**
     * Annuler une quête utilisateur.
     *
     * @param integer ID quête
     * @return  void
     */
    public function annul($id_quete)
    {
        $this->auto_render = FALSE;

        if ($this->quete->quete_delete($this->user->id, $id_quete))
            $txt = Kohana::lang('quete.kill_quete');
        else
            $txt = Kohana::lang('quete.error');

        History_Model::instance()->user_insert($this->user->id, $this->data->id, $id_quete, 'quete_annul');

        self::show($id_quete);
    }

    /**
     * Valider une quete utilisateur.
     *
     * @param integer ID quête
     * @return  void
     */
    public function valid($id_quete)
    {
        $this->auto_render = FALSE;

        $list_user_quete = self::list_user();

        $txt = '';

        if (!$quete = $this->quete->select(array('id_quete' => $id_quete, 'status' => 1), 1))
            echo Kohana::lang('quete.no_access');

        if (isset($list_user_quete[$quete->id_quete]) && $list_user_quete[$quete->id_quete]->status == 1 && $quete->element_detail_id_stop == $this->data->id) {
            $txt = Kohana::lang('quete.ok_stop');

            if ($this->user->niveau > $quete->niveau) {
                $ratio = $this->user->niveau - $quete->niveau;
                $quete->xp = round($quete->xp / $ratio);
                $quete->argent = round($quete->argent / $ratio);
            }

            $this->user->xp += $quete->xp;
            $this->user->argent += $quete->argent;

            if ($quete->fonction)
                eval('?>' . $quete->fonction . '<?php');

            $this->user->update();
            $this->quete->quete_update(array('status' => 2), $this->user->id, $quete->id_quete);

            if ($quete->argent) {
                $txt .= '<br />+ ' . $quete->argent . ' pt' . ($quete->argent > 1 ? 's' : '');
                echo '<script>app.sound.effect(\''.$quete->audio_stop.'\');</script>';
            }
            History_Model::instance()->user_insert($this->user->id, $this->data->id, $id_quete, 'quete_valide');

            echo str_replace('{{joueur}}', $this->user->username, $quete->article_stop);
        } else
            echo Kohana::lang('quete.no_valide_now');


        echo '<script>';
        echo 'app.messages.push("' . $txt . '");';
        echo 'app.hero.xp = ' . $this->user->xp . ';';
        echo 'app.hero.niveau = ' . $this->user->niveau . ';';
        echo 'app.hero.argent = ' . $this->user->argent . ';';
        echo '</script>';

        $this->index();
    }

    /**
     * Liste les quête en rapport avec un utilisateur.
     *
     * @return array liste quête(s)
     */
    private function list_user()
    {
        $list_user_quete = FALSE;

        if (($quete_user = $this->quete->quete_user($this->user->id)) !== FALSE)
            foreach ($quete_user as $row)
                $list_user_quete[$row->quete_id] = $row;

        return $list_user_quete;
    }
}

?>