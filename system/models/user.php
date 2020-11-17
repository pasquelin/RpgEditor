<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 /**
	* Permet de connaitre toutes les informations sur un : user.
	*
	* @package User
	* @author Pasquelin Alban
	* @copyright (c) 2011
	* @license http://www.openrpg.fr/license.html
	* @version 2.0.0
	*/
 class User_Model extends Auth_User_Model {

	 /**
		* Sélection SQL selon des paramètres donnés.
		*
		* @param mixe condition dexecution array/string
		* @param bool current pour gérer une seule ligne
		* @param integer nombre de ligne à retourner (limit)
		* @param array select de la requete
		* @return	 object informations de/des ligne(s) trouvée(s)
		*/
	 public function select( $array = FALSE, $current = FALSE, $limit = FALSE, $select = FALSE )
	 {
		 if( $array )
			 $this->db->where( $array );

		 if( $select )
			 $this->db->select( $select );

		 if( $limit )
			 $this->db->limit( $limit );

		 $query = $this->db->from( 'users' )->get();

		 return $query->count() ? $current ? $query->current() : $query  : FALSE;
	 }

	 /**
		* Faire une insertion d'une ligne SQL.
		*
		* @param array valeur à insérer
		* @return	 mixe retourne soit  un ID sinon false
		*/
	 public function insert( array $set )
	 {
		 if( ( $query = $this->db->insert( 'users', $set ) ) !== FALSE )
		 {
			 $id = $query->insert_id();

			 $this->db->insert( 'roles_users', array( 'user_id' => $id, 'role_id' => 1 ) );

			 return $id;
		 }
		 return FALSE;
	 }

	 /**
		* Faire une mise à jour d'une ligne.
		*
		* @param array valeur à mettre à jour
		* @param integer ID de la ligne
		* @return mixe retourne un object sinon false
		*/
	 public function update( $set = false, $id = false )
	 {
		 self::increment_niveau();

		 if( $set )
		 {
			 $set['ip'] = $_SERVER["REMOTE_ADDR"];
			 $set['last_action'] = time();
		 }
		 else
		 {
			 $this->ip = $_SERVER["REMOTE_ADDR"];
			 $this->last_action = time();
		 }

		 return $this->db->update( 'users', $set ? $set : $this->object, array( 'id' => $id ? $id : $this->id ) );
	 }

	 /**
		* Supprimer une ligne.
		*
		* @param integer ID de la ligne
		* @return	 bool retour false ou true
		*/
	 public function delete( $id = false )
	 {
		 return $this->db->delete( 'users', array( 'id' => $id ? $id : $this->id ) );
	 }

     /**
      * Vérifier d'un mail n'existe pas déjà.
      *
      * @param string email à vérifier
      * @return	 int 0 ou 1
      */
     public static function verification_mail( $email )
     {
         return Database::instance()->select( 'id' )->from( 'users' )->where( 'email', $email )->limit( 1 )->get()->count();
     }

     /**
      * Vérifier d'un username n'existe pas déjà.
      *
      * @param string username à vérifier
      * @return	 int 0 ou 1
      */
     public static function verification_username($username)
     {
         return Database::instance()->select( 'id' )->from( 'users' )->where( 'username', $username )->limit( 1 )->get()->count();
     }

	 /**
		* Modifier un mot de passe selon un mail.
		*
		* @param string email à vérifier
		* @return	 mixe string nouveau mot de passe ou false
		*/
	 public static function modifier_mot_de_passe( $email )
	 {
		 $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		 $makepass = '';
		 mt_srand( 10000000 * (double) microtime() );

		 for( $i = 0; $i < 8; $i++ )
			 $makepass .= $salt[mt_rand( 0, 61 )];

		 if( Database::instance()->update( 'users', array( 'password' => Auth::instance()->hash_password( $makepass ) ), array( 'email' => $email ) ) )
			 return $makepass;

		 return false;
	 }

	 /**
		* Afficher le XP du personnage.
		*
		* @return void
		*/
	 public function view_xp()
	 {
		 return (int) round( $this->xp / ( $this->niveau_suivant() / 100 ) );
	 }

	 /**
		* Calcul le niveau selon les XP.
		*
		* @return void
		*/
	 public function increment_niveau( $niveau_suivant = false )
	 {
		 if( !$niveau_suivant )
			 $niveau_suivant = self::niveau_suivant();

		 if( $this->xp >= $niveau_suivant )
		 {
			 $this->xp -= $niveau_suivant;
			 $this->niveau++;

			 $niveau_suivant = self::niveau_suivant();

			 if( $this->xp >= $niveau_suivant )
				 self::increment_niveau( $niveau_suivant );
		 }
	 }

	 /**
		* Pourcentage niveau suivant.
		*
		* @return	 integer niveau
		*/
	 public function niveau_suivant()
	 {
		 $valeur = 0;

		 if( $this->niveau > 0 )
			 $valeur = round( $this->niveau * Kohana::config( 'users.niveau_suivant' ) * 100 );

		 return (int) ( $valeur > 0 ) ? $valeur : 100;
	 }

	 /**
		* Calculer un pourcentage.
		*
		* @param integer valeur à convertir en pourcentage
		* @param integer valeur maximum de comparaison
		* @return	 integer pourcentage
		*/
	 public static function pourcent( $val, $max )
	 {
		 return (int) round( 100 - ( ($max - $val) / $max * 100 ) );
	 }

 }

?>
