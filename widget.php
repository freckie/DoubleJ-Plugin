<?php

/*
 * < Double J Widget >
 * made by Freckie.
 */

/* Setting CSS & JS */
function set_widget_css_js()
{
	wp_register_style('widget-style', plugin_dir_url(__FILE__).'/css/widget_style.css');
	wp_enqueue_style('widget-style');

	wp_register_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');
	wp_enqueue_style('bootstrap-style');

	wp_register_style('jan-modal-style', plugin_dir_url(__FILE__).'/css/jan_modal_style.css');
	wp_enqueue_style('jan-modal-style');

	/*wp_register_script('jan-modal-script', plugin_dir_url(__FILE__).'/js/jan_modal.js', array(), NULL, false);
	wp_enqueue_script('jan-modal-script');*/
}

add_action('wp_enqueue_scripts', 'set_widget_css_js');


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
		// Get User Names
		$user_list = $wpdb->get_results(
				"SELECT display_name, jol, user_login FROM $wpdb->users ORDER BY jol DESC"
			);
		// Get Current User (use like $var->ID / $var->display_name)
		$current_user = wp_get_current_user();

		$plugin_url = plugin_dir_url(__FILE__);

		?>

		<!-- Modal Script -->
		<script>
			function open_modal() 
			{
				document.getElementById("id-jan-modal").style.display = "block";
			}

			function close_modal() 
			{
				document.getElementById("id-jan-modal").style.display = "none";
			}

			window.onclick = function(event) 
			{
				if(event.target == document.getElementById("id-jan-modal"))
				{
					document.getElementById("id-jan-modal").style.display = "none";
				}
			}
		</script>

		<!-- Send Jan Script -->
		<script>
			function send_jan(sender_name, receiver_name)
			{
				if(sender_name == "")
				{
					alert("로그인 후 사용하세요!");
					return 0;
				}
				if(sender_name == receiver_name)
				{
					alert("자기 자신에게 보낼 수 없습니다! 친구를 사귀세요 ㅠ");
					return 0;
				}
				var send_msg = document.getElementById("accor-msg").value;
				var file_dir = "<?php echo $plugin_url; ?>" + "send_jan.php";
				var url = file_dir + "?send=" + sender_name + "&recv=" + receiver_name + "&msg=" + send_msg + "";
				var opt = "width=200, height=200, resizable=no, status=no, scrollbars=no";
				window.open(url, "hiddenframe", opt);

				alert(receiver_name + "님에게 짠!");
			}
		</script>

		<!-- Jan Popup (for Unvisible) -->
		<iframe width=0 height=0 name="hiddenframe" style="display:none;"></iframe>



		<!-- Jan Modal -->
		<div id="id-jan-modal" class="jan-modal">

			<div class="modal-content">

				<!-- Jan Modal Header -->
				<div class="modal-header">
					<span class="modal-close" onclick="close_modal()">&times;</span>
					<h2>짠!</h2>
				</div>

				<!-- Jan Modal Body -->
				<div class="modal-body" align="center">

					<!-- STEP 1 Accordion -->
					<button class="accor-btn">STEP 1. 잔과 함께 보낼 메시지</button>

					<div class="accor-panel">
						<input type="text" id="accor-msg" placeholder="ex) 맛있는 술!!">
					</div>

					<!-- STEP 2 Accordion -->
					<button class="accor-btn">STEP 2. 보낼 사람 선택</button>

					<div class="accor-panel">
					<?php
						$idx = 1;
						
						foreach($user_list as $user)
						{
							// onclick action 추가하기
							$onclick_str = "send_jan(\"$current_user->user_login\", \"$user->user_login\")";
							$echo_str = "<button class='user-btn' onclick='$onclick_str'> $user->display_name ($user->jol)</button>";
							echo $echo_str;
							$idx++;
						}
					?>
					</div>

					<!-- Accordion Script -->
					<script>
						var acc = document.getElementsByClassName("accor-btn");
						var i;

						for (i = 0; i < acc.length; i++) 
						{
							acc[i].onclick = function() 
							{
								this.classList.toggle("active");
								var panel = this.nextElementSibling;
								if (panel.style.maxHeight)
								{
									panel.style.maxHeight = null;
								}
								else
								{
									panel.style.maxHeight = panel.scrollHeight + "px";
								} 
							}
						}
					</script>

				</div>

				<!-- Jan Modal Footer -->
				<div class="modal-footer">
				</div>

			</div>

		</div>


		<!-- Jan Receive Modal -->



		<!-- Jol Ranking Widget -->
		<aside id='doublej_widget'>

			<div class='widget-user-names'>

				<!-- Jan Modal Open Trigger Button -->
				<div align="right">
					<text style="text-align:center">이 주의 쫄 랭킹</text>
					<button id="jan-modal-btn" onclick="open_modal()">&#10095;</button>
				</div>

				<!-- Jol Ranking Table -->
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
							if($idx > 5)
								break;

							$echo_str = "<tr>
								<th scope='row'>$idx</th>
								<td>$user->display_name</td>
								<td>$user->jol</td>
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