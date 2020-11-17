<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Graphisme_Core
{

    /**
     * Methode : barre graphique represente valeur X
     */
    public function BarreGraphique($valeur = 0, $max_valeur = 0, $taille = 180, $title = false, $id = null)
    {
        return '<div id="ConteneurGraphique_'.$id.'" ' . ($taille ? 'style="width:' . $taille . 'px"' : '') . '>'
            . ($title ? '<div id="infoGraphique_'.$id.'">' . ($title !== false ? $title . ' : <span id="valueMoyenneGraph_'.$id.'">' . $valeur . '</span>/<span id="valueMaxGraph_'.$id.'">' . $max_valeur . '</span>' : '') . '</div>' : false)
            . '<div id="ContenuGraphique_'.$id.'" style="width:' . round(100 - (($max_valeur - $valeur) / $max_valeur * 100)) . '%">'
            . '</div>'
            . '</div>';
    }

}