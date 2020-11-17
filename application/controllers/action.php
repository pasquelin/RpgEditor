<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Controller public des actions. Souvent extends de toutes les autres actions
 * Cela permet de vérifier que le joueur est au bon endroit.
 * On récupère aussi tout le DATA concernant l'action.
 *
 * @package Action
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Action_Controller extends Map_Controller
{

    /**
     * Permet de faire passer les données du module.
     *
     * @var object protected
     */
    protected $data = FALSE;
    protected $json = TRUE;

    public function __construct()
    {
        parent::__construct();
        parent::login();

        $this->auto_render = FALSE;

        if (!request::is_ajax())
            return FALSE;


        $this->user->x = $this->input->get('x', $this->user->x);
        $this->user->y = $this->input->get('y', $this->user->y);
        $this->user->z = $this->input->get('z', $this->user->z);
        $this->user->region_id = $this->input->get('region', $this->user->region_id);

        if (($this->data = Map_Model::instance()->select(array('region_id' => $this->user->region_id,
            'module_map !=' => '',
            'x' => $this->user->x,
            'y' => $this->user->y,
            'z' => $this->user->z), 1))
            && $this->data->action_map
            && ($this->data->action_map = @unserialize($this->data->action_map))
        ) {
            $this->user->hp = $this->input->get('hp', $this->user->hp);
            $this->user->mp = $this->input->get('mp', $this->user->mp);
            $this->user->xp = $this->input->get('xp', $this->user->xp);
            $this->user->currentdirection_x = $this->input->get('currentdirection_x', $this->user->currentdirection_x);
            $this->user->update();
        } else
            die(Kohana::lang('action.impossible_action'));
    }

}

?>