<?php

add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
		add_menu_page( 'Affiliates Backend UI', 'Affiliates', 'manage_options', 'affiliates', 'affiliate_init', 'dashicons-universal-access-alt' );
}

function affiliate_init(){
		$aff_db = get_option( 'affiliates' );
		echo '<div class="wrap">
		<h1>Registered Affiliates</h1>';

		if ( ! empty ( $aff_db ) ) {
			for ( $i = 0; $i <= count( $aff_db ) - 1; $i++ ) {
				echo '<table class="form-table"><tbody>';
				echo '<tr><th scope="row"><label>First Name:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['first'] . '"></td></tr>';
				echo '<tr><th scope="row"><label>Last Name:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['last']  . '"></td></tr>';
				echo '<tr><th scope="row"><label>Email:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['email']  . '"></td></tr>';
				echo '<tr><th scope="row"><label>Instagram User:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['ig']  . '"></td></tr>';
				echo '<tr><th scope="row"><label>Code:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['coupon']  . '"></td></tr>';
				echo '<tr><th scope="row"><button>Delete</button></th></tr>';
				echo '</tbody></table>';
			}
		} else {
			echo 'None yet :/';
		}
		echo '</div>';
}

?>