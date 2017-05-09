<?php


if (!function_exists('get_route_authenticate')){
    function get_route_authenticate(){
        return BACKOFFICE."/".BACKOFFICE_AUTHENTICATE_SLUG;
    }
}

if (!function_exists('get_route_backoffice_home')){
    function get_route_backoffice_home(){
        return BACKOFFICE."/".BACKOFFICE_;

    }
}