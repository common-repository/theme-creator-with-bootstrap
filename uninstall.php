<?php

if (!defined("WP_UNINSTALL_PLUGIN")) {
    die;
}

delete_option("layout_option");
delete_option("page_option");
delete_option("theme_name");

?>
