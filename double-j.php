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


/*
 * < API Functions >
 * Do not use these functions directly.
 * Use only 'in the main functions'
 */


/* Get 'User ID' by 'User Name' (DB: wp_Dusers) */
function get_id_by_name($target_name)
{
	global $wpdb;

	$user_id = $wpdb->get_var("SELECT id FROM $wpdb->users WHERE user_login = '$target_name''");
	return $user_id;
}

/* Get 'User Name' by 'User ID' (DB: wp_Dusers) */
function get_name_by_id($target_id)
{
	global $wpdb;

	$user_name = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE id = '$target_id'");
	return $user_name;
}


/*
 * < Main Functions >
 */


/* Jan Function */
function jan($sender_name, $receiver_name, $message)
{
	global $wpdb;

	$table_name = $wpdb->prefix . "doublej_jan";

	// Insert Query
	$wpdb->insert(
		$table_name,
		array(
			"sender" => "$sender_name",
			"receiver" => "$receiver_name",
			"message" => "$message"
		)
	);

	// Should be alerted
	/* .. */
}

?>