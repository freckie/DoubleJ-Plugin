<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<?php

/*
 * < Double J Widget >
 * made by Freckie.
 */


/* Setting CSS */
function set_widget_css()
{
	wp_register_style('widget-style', plugin_dir_url(__FILE__).'/widget_style.css');
	wp_enqueue_style('widget-style');
}

add_action('wp_enqueue_scripts', 'set_widget_css');


/* Widget Class */
class doublej_widget extends WP_Widget
{
	/* Widget Class Constructor */
	public function __construct()
	{
		// Set Widget Title
		parent::__construct(
				'doublej_widget', // ID of this Widget
				'(짠&쫄) Double-J Widget', // Widget Name on Setting page
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
				"SELECT display_name FROM $wpdb->users"
			);

		?>

		<aside id='doublej_widget'>
			<div class='widget-user-names'>
				<table class='table table-striped'>
					<thead>
						<tr>
							<th>#</th>
							<th>이름</th>
							<th>쫄</th>
						</tr>
					</thead>

					<tbody>
					<?php
					$idx = 1;
					foreach($user_list as $user)
					{
						$echo_str = "<tr>
							<th scope='row'><h5>$idx</h5></th>
							<td><h5>$user->display_name</h5></td>
							<td><h5>0</h5></td>
							</tr>";
						echo $echo_str;
						$idx++;
					}
					?>
					</tbody>
				</table>
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

/*function myplugin_register_widgets()
{
	register_widget('doublej_widget');
}*/

add_action('widgets_init', create_function('', 'register_widget("doublej_widget");'));

?>