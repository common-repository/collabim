<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package CollabimPlgun
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Clear Database stored data

// Access the database via SQL
global $wpdb;

$wpdb -> delete($wpdb->options, array('option_name' => 'project_select'));
$wpdb -> delete($wpdb->options, array('option_name' => 'api_set'));
$wpdb -> delete($wpdb->options, array('option_name' => 'check_first_select'));
$wpdb -> delete($wpdb->options, array('option_name' => 'check_first_api'));

