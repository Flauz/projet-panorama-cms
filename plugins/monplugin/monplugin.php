<?php
/*
Plugin Name: Mon plugin
Plugin Uri: monplugin.me.com
Author: Alice
Author URI: alice.me.com
Text Domain: monpluginlg
Description: mon premier plugin sur Wordpress
Version: 0.0
*/

require_once plugin_dir_path(__FILE__).'includes/toto-functions.php';

register_activation_hook(__FILE__, 'monplugin_Activation');

function monplugin_Activation() {
	global $wpdb;
	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}toto_table (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");
}

register_deactivation_hook(__FILE__, 'monplugin_Deactivation'); 

function monplugin_Deactivation() {

	// Supprimer la table en base de données - Methode Uninstall plus appropriée pour ce genre d'actions
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}toto_table;");

}