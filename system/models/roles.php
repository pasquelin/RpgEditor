<?php

defined(	'SYSPATH'	)	or	die(	'Access non autoris&eacute;.'	);

/**
	* Permet de connaitre toutes les informations sur un : role.
	*
	* @package Role
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
class	Roles_Model	extends	Model	{

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
				if(	Roles_Model::$instance	===	NULL	)
						return	new	Roles_Model;

				return	Roles_Model::$instance;
		}

		/**
			* Faire une sélection sur la table rôle.
			*
			* @param mixe les valeur du where
			* @return mixe retourne un object sinon false
			*/
		public	function	liste(	$where	=	FALSE	)
		{
				return	parent::model_select(	'roles',	$where	);
		}

		/**
			* Faire une insertion d'une ligne SQL.
			*
			* @param array valeur à insérer
			* @return	 mixe retourne soit  un ID sinon false
			*/
		public	function	insert(	array	$set	)
		{
				return	parent::model_insert(	'roles',	$set	);
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
				return	parent::model_update(	'roles',	$set,	array(	'id'	=>	$id	)	);
		}

		/**
			* Supprimer une ligne.
			*
			* @param integer ID de la ligne
			* @return	 bool retour false ou true
			*/
		public	function	delete(	$id	)
		{
				return	parent::model_delete(	'roles',	array(	'id'	=>	$id	)	);
		}

		/**
			* Rôle(s) attribué à un administrateur.
			*
			* @param integer ID de l'utilisateur
			* @return mixe object ou false
			*/
		public	function	selectUser(	$idUser	=	FALSE	)
		{
				$query	=	$this->db->from(	'roles_users'	)->where(	'user_id',	$idUser	)->get();

				if(	$query->count()	)
				{
						foreach(	$query	as	$val	)
								$result[$val->role_id]	=	TRUE;

						return	$result;
				}

				return	FALSE;
		}

		/**
			* Faire une nsertion d'un rôle à un administrateur
			*
			* @param integer ID de l'utilisateur
			* @param integer ID du rôle
			* @return	 mixe retourne soit  un ID sinon false
			*/
		public	function	insertUser(	$idUser,	$idRole	)
		{
				return	parent::model_insert(	'roles_users',	array(	'user_id'	=>	$idUser,	'role_id'	=>	$idRole	)	);
		}

		/**
			* Supprimer une ligne.
			*
			* @param integer ID de l'utilisateur
			* @param integer ID du rôle
			* @return	 bool retour false ou true
			*/
		public	function	deleteUser(	$idUser,	$idRole	=	FALSE	)
		{
				$array['user_id']	=	$idUser;

				if(	$idRole	)
						$array['role_id']	=	$idRole;

				return	parent::model_delete(	'roles_users',	$array	);
		}

}

?>