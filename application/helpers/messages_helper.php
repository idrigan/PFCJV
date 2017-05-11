<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');


function print_collection ($items = array(), $container_prefix, $container_suffix, $item_prefix, $item_suffix)
{
    if (!is_array($items)){
        return FALSE;
    }
    echo $container_prefix;

    foreach ($items as $item) {
        echo "$item_prefix$item$item_suffix";
    }
    echo $container_suffix;
}

if (! function_exists('print_errors')) {

    function print_errors ($errors = array())
    {
        //single error
        if (!is_array($errors)){
            $errors = array($errors);
        }
        print_collection($errors, ERRORS_PREFIX, ERRORS_SUFFIX, ERROR_PREFIX, ERROR_SUFFIX);
    }
}

if (! function_exists('print_warnings')) {

    function print_warnings ($warnings = array())
    {
        //single message
        if (!is_array($warnings)){
            $warnings = array($warnings);
        }

        print_collection($warnings, '', '', WARNING_PREFIX, WARNING_SUFFIX);
    }
}

if (! function_exists('print_messages')) {

    function print_messages ($messages = array())
    {
        //single message
        if (!is_array($messages)){
            $messages = array($messages);
        }

        print_collection($messages, '', '', SUCCESS_PREFIX, SUCCESS_SUFFIX);
    }
}

if (! function_exists('print_session_error_message')) {

    function print_session_error_message ()
    {
        if (session_has_error_message()){
            print_errors(session_get_error_message());
            session_remove_error_message();
        }
    }
}


if (! function_exists('print_session_success_message')) {

    function print_session_success_message ()
    {
        if (session_has_success_message()){
            print_messages(session_get_success_message());
            session_remove_success_message();
        }
    }
}