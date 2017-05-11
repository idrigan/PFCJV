<!DOCTYPE html>
<html lang="<?php echo get_html_language()?>">
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="keywords" content="{meta-keywords}" />
    <meta name="description" content="{meta-description}" />
    <meta name="author" content="{meta-author}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo base_url("favicon.ico")?>" />

    <!-- BEGIN CSS -->
    <?php
    if (!isempty_array($var_head_css)){
        foreach ($var_head_css as $css){
            echo $css."\r\n";
        }
    }?>
    <!-- END CSS -->

    <!-- Head Libs -->
    <script src="<?php echo base_url("public/vendor/vendor/modernizr/modernizr.js")?>"></script>

    <!--[if IE]>
    <link rel="stylesheet" href="<?php echo base_url("public/css/ie.css")?>">
    <![endif]-->

    <!--[if lte IE 8]>
    <script src="<?php echo base_url("public/vendor/respond/respond.js")?>"></script>
    <script src="<?php echo base_url("public/vendor/excanvas/excanvas.js")?>"></script>
    <![endif]-->

    <!-- BEGIN JS -->
    <?php
    if (!isempty_array($var_head_js)){
        foreach ($var_head_js as $script){
            echo "<script src=\"".base_url($script)."?v".CONST_VERSION."\" type =\"text/javascript\"></script>\r\n";
        }
    }?>
    <!-- END JS -->

    <title>{header-title}</title>
</head>
<body>
<div class="body">