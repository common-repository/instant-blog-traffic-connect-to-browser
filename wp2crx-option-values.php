<?php

//Let's get the name of our extension
$extension_name = (get_option('wp2crx_extension_name')) ? get_option('wp2crx_extension_name') : get_bloginfo('name') ;
//Let's get the description of our extension as well! 
$extension_description = (get_option('wp2crx_extension_description')) ? get_option('wp2crx_extension_description') : get_bloginfo('description');

//Then we want the author image
$author_picture = (get_option('wp2crx_author_picture')) ? get_option('wp2crx_author_picture') : '' ;

//Plust the icon for the extension
$extension_icon = (get_option('wp2crx_extension_icon')) ? get_option('wp2crx_extension_icon') : '';

//The sender ID (project in in Google Developer Console)
$sender_id = (get_option('wp2crx_sender_id')) ?  get_option('wp2crx_sender_id') : '';

$chrome_gcm_api_key = (get_option('wp2crx_chrome_gcm_api_key')) ?  get_option('wp2crx_chrome_gcm_api_key') : '';