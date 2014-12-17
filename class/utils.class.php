<?php
/**
* Utils file
*/

/**
* 
* Static definition of the Utils class, it's an utility class
* @package Site
* @subpackage Utilitaires
*/
class Utils
{
	/** Set a text formating a string to Json
	* (PHP < 5.4.x No JSON_PRETTY_PRINT).
	*
	* @param mixed $json Le JSON soit en tableau, soit en string pré-encodé
	* @param string $istr ident chain
	*
	* @static
	* @link https://github.com/ryanuber/projects/blob/master/PHP/JSON/jsonpp.php
	*
	* @return string  idented JSON 
	*/
	public static function json_encode($json, $istr = "    ")
	{
		if($json instanceof Jsonable)
		{
			$json = json_encode($json->toJson());
		}
		
		if(is_array($json))
		{
			foreach($json as $idx => $value)
			{
				if($value instanceof Jsonable)
				{
					$json[$idx] = $value->toJson();
				}
			}
			
			$json = json_encode($json);
		}
		
		$result = '';
		
		for($p = $q = $i =0; isset($json[$p]); $p++)
		{
			$json[$p] == '"' && ($p>0 ? $json[$p-1] : '') != '\\' && $q=!$q;
			
			if(!$q && strchr(" \t\n", $json[$p]))
			{
				continue;
			}
			
			if(strchr('}]', $json[$p]) && !$q && $i--)
			{
				strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
			}
			
			$result .= $json[$p];
			
			if(strchr(',{[', $json[$p]) && !$q)
			{
				$i += strchr('{[', $json[$p]) === FALSE ? 0 : 1;
				strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
			}
		}
		
		if(preg_match("/^(\[\s*\{\}\s*\])$/", $result) == 1)
		{
			$result = "[]";
		}
		
		return $result;
	}
}
?>
