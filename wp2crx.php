<?php
/*
Plugin name: Instant Blog Traffic - Connect to Browser
Description: Instantly drives traffic to your blog by notifying your readers via a Chrome extension - automatically generated for you!
Author: Jean Paul (a.k.a. The Last Mogul Standing )
Author URI: http://ActionPHP.com
Version: 1.0
*/

require_once 'wp2crx_extension.php';
require_once 'class-wp2crx.php';

$WP2CRX = new WP2CRX;
$WP2CRX->run();