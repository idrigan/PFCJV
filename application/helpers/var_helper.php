<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

if (! function_exists('isempty')) {

    function isempty ($data)
    {
        //return empty($data);
        return (! isset($data) || $data === NULL || (is_string($data) && empty($data)));
    }
}

if (! function_exists('isempty_array')) {

    function isempty_array ($data)
    {
        return (! $data || ! isset($data) || $data == NULL || (is_array($data) && count($data) <= 0));
    }
}

if (! function_exists('safe_array_get')) {

    function safe_array_get ($key = NULL, $array)
    {
        if (is_array($array) && ! isempty($key)) {
            return array_key_exists($key, $array) ? $array[$key] : '';
        }
        
        return '';
    }
}

if (! function_exists('safe_nl2br')) {

    function safe_nl2br ($data)
    {
        return str_replace("\r", '<br/>', str_replace("\n", '<br/>', str_replace("\r\n", '<br/>', $data)));

        return '';
    }
}

if (! function_exists('safe_br2nl')) {

    function safe_br2nl ($data)
    {
        return str_replace("<br/>", '\r\n', $data);

        return '';
    }
}

if (! function_exists('safe_nl2comma')) {

    function safe_nl2comma ($data)
    {
        return str_replace("\r", ', ', str_replace("\n", ', ', str_replace("\r\n", ', ', $data)));

        return '';
    }
}



if (! function_exists('nullify_string')) {

    function nullify_string ($value)
    {
        if (isempty($value) || $value === ''){
            return NULL;
        }

        return $value;
    }
}

if (! function_exists('denullify_string')) {

    function denullify_string ($value)
    {
        if (isempty($value) || is_null($value)){
            return '';
        }

        return $value;
    }
}

if (! function_exists('encode_identifier')) {

    function encode_identifier ($id = NULL)
    {
        if (isempty($id)){
            return FALSE;
        }

        return urlencode(base64_encode(utf8_encode($id)));
    }
}

if (! function_exists('decode_identifier')) {

    function decode_identifier ($id = NULL)
    {
        if (isempty($id) || !is_string($id)){
            return FALSE;
        }
        
        return utf8_decode(base64_decode(urldecode($id)));
    }
}

if (! function_exists('encode_SHA1')) {
    function encode_SHA1 ($string){
        if (isempty($string) || !is_string($string)){
            return FALSE;
        }
        
        return sha1($string);
    }
}


if (! function_exists('is_valid_mail')){
    function is_valid_mail($mail){
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        }
        return FALSE;
    }
}


if (!function_exists('str_needs_shorten')){
    function str_needs_shorten ($string, $length) {
        if (isempty($string) || ! is_numeric($length)){
            return FALSE;
        }
        return (strlen($string) > $length);
    }
}

if (!function_exists('str_shorten')){
    function str_shorten ($string, $length) {
        if (isempty($string) || ! is_numeric($length)){
            return '';
        }
        $real_length = strlen($string); 
        if ($real_length <= $length){
            return $string;
        }
        
        return substr($string, 0, $length). " ...";
       
    }
}

if (!function_exists('safe_implode')) {
    function safe_implode($keys, $array, $separator = ', '){
        if (!is_array($keys) && is_string($keys)){
            return safe_array_get($keys, $array);
        } else {
            $concat = '';
            foreach ($keys as $key){
                $value = safe_array_get($key,$array);
                if (isempty($value)){
                    continue;
                }
                if (!isempty($concat)){
                    $concat.=$separator;
                }
                $concat.=$value;
            }
            return $concat;
        }
    }
}

if (! function_exists('sanitize_filename_secure')){
    function sanitize_filename_secure($filename) {

        $CI =& get_instance();
        $CI->load->helper(array('security', 'text'));
        
        $filename = sanitize_filename($filename);
        $filename = convert_accented_characters($filename);

        $filename = preg_replace('~[^\\pL0-9_]+~u', '-', $filename);
        $filename = trim($filename, "-");
        $filename = iconv("utf-8", "us-ascii//TRANSLIT", $filename);
        $filename = strtolower($filename);
        $filename = preg_replace('~[^-a-z0-9_]+~', '', $filename);
        return $filename;
    }
}

if (! function_exists('array_extract_by_keys')) {
    function array_extract_by_keys($array, $keys){
        
        if (isempty_array($keys) || isempty_array($array)){
            return $array;
        }
        
        $result = array();
        $associative_keys = array();
        foreach ($keys as $key => $value){
            $associative_keys[$value] = '';
        }
        return array_intersect_key($array, $associative_keys);
    }
}


if (! function_exists('get_html_language')) {

    function get_html_language ()
    {
        $lang = session_get_language();

        return preg_replace('/_/i', '-', $lang);

    }
}

if (! function_exists('get_country_language')) {

    function get_country_language ()
    {
        $lang = session_get_language();

        return strtolower(substr($lang, 0, 2));

    }
}


if (! function_exists('get_request_uri')) {
    function get_request_uri(){
        $url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $url .= '://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        return $url;
    }
}

if (! function_exists('dir_exists_or_create')) {
    function dir_exists_or_create ($path)
    {
        
        if (! file_exists($path)) {
            if (! mkdir($path, 0775, true)) {
                // mkdir exception
                return FALSE;
            }
        }
        return TRUE;
    }
}

