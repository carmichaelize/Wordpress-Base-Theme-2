<?php

class Sc_Str {

	/**
	* Convert a string to lowercase.
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function lower($string = ''){
		return strtolower(strip_tags($string));
	}

	/**
	* Convert a string to uppercase.
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function upper($string = ''){
		return strtoupper(strip_tags($string));
	}

	/**
	* Convert a string to title case (ucwords equivalent).
	*
	* @param  string  $string
	* @return string
	*
	*/

	public static function title($string = ''){
		return ucwords(strtolower(strip_tags($string)));
	}

	/**
	* Get the length of a string.
	*
	* @param  string  $string
	* @return int
	*
	*/

	public static function length($string = ''){
		return  strlen(strip_tags($string));
	}

	/**
	* Limit the number of characters in a string.
	* @param  string  $string
	* @param  int     $limit
	* @param  string  $trail
	* @return string
	*
	*/

	public static function limit($string = '', $limit, $trail = '...'){

		$string = trim(strip_tags($string));
		return strlen($string) <= $limit ? $string : substr($string, 0, $limit).$trail ;

	}

	/**
	* Limit the number of words in a string.
	*
	* @param  string  $string
	* @param  int     $limit
	* @param  string  $trail
	* @return string
	*
	*/

	public static function words($string = '', $limit, $trail = '...'){

		$string = strip_tags($string);

		if (trim($string) == ''){
			return '';
		}

		preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $string, $matches);

		return rtrim($matches[0]).$trail;
	}

	/**
	* Generate a random alpha or alpha-numeric string.
	*
	* @param  int	  $length
	* @param  string  $type
	* @return string
	*
	*/

	public static function random($length, $type = 'alpha_num'){

		switch($type){
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;

			case 'num':
				$pool = '1234567890';
			break;

			case 'alpha_num':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		}

		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);

	}

	/**
	* Generate a URL friendly "slug" from a given string.
	*
	* @param  string  $string
	* @param  string  $separator
	* @return string
	*
	*/
	public static function slug($string, $separator = '-'){

		// Remove all characters that are not the separator, letters, numbers, or whitespace.
		$string = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower(strip_tags($string)));

		// Replace all separator characters and whitespace by a single separator
		$string = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $string);

		return trim($string, $separator);
	}

	/**
	* Return the "URI" style segments in a given string.
	*
	* @param  string  $string
	* @return array
	*
	*/

	public static function segments($string){

		return array_diff(explode('/', trim($string, '/')), array(''));

	}

}

?>