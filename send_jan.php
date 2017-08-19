<?php

$get_send = $_GET['send'];
$get_recv = $_GET['recv'];
$get_msg = $_GET['msg'];

include_once('../../../wp-includes/wp-db.php');
include_once('../../../wp-load.php');

/* Jan Function */
function jan($sender_name, $receiver_name, $message)
{
	global $wpdb;

	$table_name = $wpdb->prefix . "doublej_jan";

	// Jan Log Insert Query (doublej_jan)
	$wpdb->insert(
		$table_name,
		array(
			"sender" => "$sender_name",
			"receiver" => "$receiver_name",
			"message" => "$message"
		)
	);

	// Jol Count Update Query (users)
	$receiver_id = get_id_by_name($receiver_name);
	$curr_jol = $wpdb->get_var("SELECT jol FROM $wpdb->users WHERE ID = $receiver_id");
	$curr_jol = $curr_jol + 1;

	$wpdb->update(
		$wpdb->users,
		array( "jol" => $curr_jol ),
		array( "ID" => $receiver_id ),
		array( "%d" ),
		array( "%d" )
	);

	// Insert to AjaxChat
	$table_name2 = $wpdb->prefix . "ajax_chat";

	$jan_text = $sender_name . "님이 " . $receiver_name . "님에게, '$message'";

	$wpdb->insert(
		$table_name2,
		array(
			"name" => "짠 알리미",
			'time' => current_time('timestamp'),
			"text" => "$jan_text",
			"ip" => "000.000.000.000"
		)
	);

	// Add Alert

}

jan($get_send, $get_recv, $get_msg);

?>