<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$cmbab_color_value = 'cmbab_color_value';
 
delete_option($cmbab_color_value);
 
// for Multisite
delete_site_option($cmbab_color_value);

?>