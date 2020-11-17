<?php

defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);

/**
	* Permet de connaitre toutes les informations sur un : historique user.
	*
	* @package History
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
class	History_Model	extends	Model	{

		/**
			* Permet de créer une instance et donc de ne pas faire des doublons.
			* 
			* @var object protected
			*/
		protected	static	$instance;

		/**
			* Permet de ne pas faire des multi appel d'object
			*
			* @return class return la classe construite
			*/
		public	static	function	instance()
		{
				if(	History_Model::$instance	===	NULL	)
						return	new	History_Model;

				return	History_Model::$instance;
		}

		/**
			* Faire une sélection sur la table history.
			*
			* @param integer ID utilisateur
			* @param integer ID du détail
			* @param integer ID de l'élément
			* @return mixe retourne un object sinon false
			*/
		public	function	select(	$user_id,	$detail_id,	$element_id	=	FALSE,	$type	=	FALSE	)
		{
				if(	$user_id	)
						$this->db->where(	'user_id',	$user_id	);

				if(	$detail_id	)
						$this->db->where(	'detail_id',	$detail_id	);

				if(	$element_id	)
						$this->db->where(	'element_id',	$element_id	);

				if(	$type	)
						$this->db->where(	'type_element',	$type	);

				$query	=	$this->db->from(	'users_history'	)->get();

				return	$query->count()	?	$query	:	FALSE;
		}

		/**
			* Faire une insertion d'une ligne SQL.
			*
			* @param integer ID utilisateur
			* @param integer ID du détail
			* @param integer ID de l'élément
			* @return	 mixe retourne soit  un ID sinon false
			*/
		public	function	user_insert(	$user_id,	$detail_id	=	FALSE,	$element_id	=	FALSE,	$type	=	FALSE	)
		{
				return	parent::model_insert(	'users_history',	array(	'user_id'	=>	$user_id,	'detail_id'	=>	$detail_id,	'element_id'	=>	$element_id,	'date'	=>	date::NOW()	, 'type_element' => $type)	);
		}

}

?>
