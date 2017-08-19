<?php
/*
Plugin Name: Double J
Plugin URI: 
Description: Jan & Jol Plugin
Version: 0.1.0
Author: Freckie
Author URI: http://frec.kr
License: GPL2
*/

/* Setting CSS */
function custom_style_sheet()
{
	wp_register_style('custom-style', plugin_dir_url(__FILE__).'/css/style.css');
	wp_enqueue_style('custom-style');
}

add_action('wp_enqueue_scripts', 'custom_style_sheet');

/* Importing Widget */
require_once(plugin_dir_path(__FILE__) . 'widget.php');




/*
 * < API Functions >
 * Do not use these functions directly.
 * Use only 'in the main functions'
 */


/* Get 'User ID' by 'User Name' (DB: wp_Dusers) */
function get_id_by_name($target_name)
{
	global $wpdb;

	$user_id = $wpdb->get_var("SELECT id FROM $wpdb->users WHERE user_login = '$target_name'");
	return $user_id;
}

/* Get 'User Name' by 'User ID' (DB: wp_Dusers) */
function get_name_by_id($target_id)
{
	global $wpdb;

	$user_name = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE id = '$target_id'");
	return $user_name;
}

/* Transfer 'User Name' to 'Display Name' */
function get_display_name($target_name)
{
	global $wpdb;

	$display_name = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_login = '$target_name'");
	return $display_name;
}






/*
 * < Main Functions >
 */

?>