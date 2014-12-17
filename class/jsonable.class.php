<?php
/**
* Fichier de l'interface Jsonable.
*/

/**
* Definition de l'interface Jsonable.
*
* @package Site
* @subpackage Utilitaires
*/
interface Jsonable
{
	/**
	* Getter du tableau associatif (JSON) de l'objet.
	*
	* @return array Le tableau associatif correspondant au JSON
	*/
	public function toJson();
}

?>