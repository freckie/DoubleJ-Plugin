<?php

/*
 * < Double J Widget >
 * made by Freckie.
 */


/* Widget Class */
class DoubleJWidget extends WP_Widget
{
	function __construct()
	{
		// Set Widget Title
		parent::__construct(
				'doublej_widget', // ID of this Widget
				'Double-J Widget', // Widget Name on Setting page
				array(
					'description' => 'Jan & Jol Widget. Use with Double-J Plugin.'
				)
			);
	}

	/* Widget Appearance */
	public function widget($args, $instance)
	{
		global $wpdb;
		$user_list = $wpdb->get_results(
				"SELECT display_name FROM $wpdb->user_list"
			);
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<aside id='doublej_widget'>
	<div class='widget-user-names'>
		<?php
		for($i=0; $i<=count($user_list); $i++)
		{
			echo "<h5>$user_list[$i]</h5>";
		}
		?>
	</div>
</aside>

<?php
		// end of function widget()
	}

	/* Widget Update (Changing Widget Setting Data) */
	function update($new_instance, $old_instance)
	{

	}

	/* Widget Setting Page Appearance*/
	function form($instance)
	{

	}
}

function myplugin_register_widgets()
{
	registeR_widget('MyNewWidget');
}

add_action('widgets_init', 'myplugin_register_widgets');

?>