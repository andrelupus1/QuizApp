<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Librarie de normalização de palavras, mais especificamente URL's Amigaveis
 * Autor: Diego Sampaio - diego@estaleirodigital.com
 * V.: 1.0
 * Proibida toda e qualquer reprodução
 * 
 */
class Normalizapalavra{
    
    function normaliza_url($str){
        $str = strtolower(utf8_decode($str)); $i=1;
        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
        while($i>0) $str = str_replace('--','-',$str,$i);
        if (substr($str, -1) == '-') $str = substr($str, 0, -1);
        return $str;
    }
    
}
?>