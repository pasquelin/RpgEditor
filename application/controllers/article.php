<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Controller public des article pour afficher des articles.
 *
 * @package Article
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Article_Controller extends Template_Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::login();
    }

    /**
     * Afficher un article sur le jeu.
     *
     * @param integer ID de l'article (status doit etre = 1)
     * @return  void
     */
    public function index($idArticle = FALSE)
    {
        if (!$idArticle || !($article = Article_Model::instance()->select(array('id_article' => base64_decode($idArticle), 'status' => 1), 1)))
            return FALSE;

        $this->template->content = new View('article/index');
        $this->template->content->titre = $article->title;
        $this->template->content->article = $article->article;
        $this->template->content->referer = $this->input->get('referer');
        $this->template->content->username = $this->user ? $this->user->username : FALSE;
    }

}

?>