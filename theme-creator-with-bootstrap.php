<?php
/**
* Plugin Name: Theme Creator for Bootstrap
* Plugin URI: https://ppmproject.altervista.org/
* Description: This plugin allows you to easly create your Bootstrap Theme in Wordpress.
* Version: 1.1
* Author: Davide Pucci, Christian Pratellesi
* License:			GPL v2
* License URI:		https://www.gnu.org/licenses/gpl-2.0.html
**/

if (!defined("ABSPATH")) {
	die;
}

define("TC4B_URL", plugin_dir_url(__FILE__));

if (is_admin()) {
	require_once __DIR__ . "/admin/admin-page.php";
}

?>
