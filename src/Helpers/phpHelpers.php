<?php  
namespace Helpers;

/**
 * Classe statique
 * Helpers généraux pour php
 */
class PhpHelpers
{
	/**
	 * Réindexe un tableau
	 * Le premier index sera 0
	 * @param  array() $array tableau à réindexer
	 * @return array()        tableau réindexé
	 */
	public static function reIndexArray($array)
    {
        return array_values($array);
    }

    /**
     * Test si un chaine commence par la chaine en paramètre
     * @param  string $haystack chaine a tester
     * @param  string $needle   chaine de test
     * @return bool           vrai si la $haystack commence par $needle
     */
    public static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

 	/**
     * Test si une chaine finit par la chaine en paramètre
     * @param  string $haystack chaine a tester
     * @param  string $needle   chaine de test
     * @return bool           vrai si la $haystack finit par $needle
     */
	public static function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    /**
     * Permet de d'avoir une représentation d'un élément (tableau ou objet) 
     * sous forme de chaine de caractère lisible
     * 
     * @param  array  $array
     * 
     * @return string
     */
    public static function arrayToString($elt = array())
    {
         return '{' . implode(', ', array_map(function ($v, $k) { return $k . '=' . $v; }, $elt, array_keys($elt))) . '}';
    }
}