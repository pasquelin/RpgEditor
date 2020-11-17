<?php

defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);

/**
	* Permet de connaitre toutes les informations sur un : article.
	*
	* @package Article
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
class	Article_Model	extends	Model	{

		/**
			* Permet de créer une instance et donc de ne pas faire des doublons.
			* 
			* @var object protected
			*/
		protected	static	$instance;

		/**
			* Permet de ne pas faire des multi appel d'object.
			*
			* @return class return la classe construite
			*/
		public	static	function	instance()
		{
				if(	Article_Model::$instance	===	NULL	)
						return	new	Article_Model;

				return	Article_Model::$instance;
		}

		/**
			* Faire une sélection sur la table article.
			*
			* @param mixe les valeur du where
			* @param bool current ou non
			* @param integer limit de la requête
			* @return mixe retourne un object sinon false
			*/
		public	function	select(	$where	=	FALSE,	$current	=	FALSE,	$limit	=	FALSE	)
		{
				if(	$where	)
						$this->db->where(	$where	);

				if(	$limit	)
						$this->db->limit(	$limit	);

				$query	=	$this->db->from(	'articles'	)
								->join(	'articles_category',	'articles_category.id_article_category',	'articles.article_category_id'	)
								->get();

				return	$query->count()	?	(	$current	?	$query->current()	:	$query	)	:	FALSE;
		}

		/**
			* Faire une insertion d'une ligne SQL.
			*
			* @param array valeur à insérer
			* @return	 mixe retourne soit  un ID sinon false
			*/
		public	function	insert(	array	$set	)
		{
				return	parent::model_insert(	'articles',	$set	);
		}

		/**
			* Faire une mise à jour d'une ligne.
			*
			* @param array valeur à mettre à jour
			* @param integer ID de la ligne
			* @return mixe retourne un object sinon false
			*/
		public	function	update(	array	$set,	$id	)
		{
				return	parent::model_update(	'articles',	$set,	array(	'id_article'	=>	$id	)	);
		}

		/**
			* Supprimer une ligne.
			*
			* @param integer ID de la ligne
			* @return	 bool retour false ou true
			*/
		public	function	delete(	$id	)
		{
				return	parent::model_delete(	'articles',	array(	'id_article'	=>	$id	)	);
		}

		/**
			* Lister les catégories articles.
			*
			* @return mixe retourne un object sinon false
			*/
		public	function	selectListeCategories()
		{
				return	parent::model_select(	'articles_category'	);
		}

}

?>
