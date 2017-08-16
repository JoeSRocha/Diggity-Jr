<?php

add_action('admin_menu', 'affiliate_plugin_setup_menu');

function affiliate_plugin_setup_menu(){
		add_menu_page( 'Affiliates Backend UI', 'Affiliates', 'manage_options', 'affiliates', 'affiliate_init', 'dashicons-universal-access-alt' );
}

function affiliate_init(){
	$aff_db = get_option( 'affiliates' );
	echo '<div class="wrap">
	<h1>Registered Affiliates</h1>';
	$emails = [];
	if ( ! empty ( $aff_db ) ) {
		for ( $i = 0; $i <= count( $aff_db ) - 1; $i++ ) {

			echo '<form method="post">';
			echo '<table class="form-table"><tbody>';
			echo '<tr><th scope="row"><label>First Name:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['first'] . '"></td></tr>';
			echo '<tr><th scope="row"><label>Last Name:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['last']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Email:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['email']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Instagram User:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['ig']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Code:</label></th> <td><input type="text" class="regular-text" value="' . $aff_db[$i]['coupon']  . '"></td></tr>';
			echo '<tr><th scope="row"><button class="button button-primary type="submit" name="' . $i . '" method="post">Delete</button></th><th scope="row"><button class="button button-primary type="submit" name="update' . $i . '" method="post">Update</button></th></tr>';
			echo '</tbody></table>';
			echo '</form>';
		}
	} else {
		echo 'None yet :/';
	}
	echo '</div>';

	if ( isset($_POST) ) {
		for ( $i = 0; $i <= count( $aff_db ) - 1; $i++ ) {
			if ( isset( $_POST[$i] ) ) {
				$email = $aff_db[$i]['email'];
				require_once( plugin_dir_path( __DIR__ ) . 'affiliates.class.php' );
				$affiliate_list = new Affiliates;
				$all = $affiliate_list->all_affiliates = get_option( 'affiliates' );
				$affiliates = $affiliate_list->del_affiliate( $email );
				$affiliates = array_values( $affiliates );
				update_option( 'affiliates', $affiliates );
				header( "Refresh:0" );
			}
		}
	}

}



?>