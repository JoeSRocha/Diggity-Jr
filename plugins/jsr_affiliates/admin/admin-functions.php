<?php

add_action('admin_menu', 'affiliate_plugin_setup_menu');

function affiliate_plugin_setup_menu(){
		add_menu_page( 'Affiliates Backend UI', 'Affiliates', 'manage_options', 'affiliates', 'affiliate_init', 'dashicons-universal-access-alt' );
}

function affiliate_init(){
	$aff_db = get_option( 'affiliates' );
	echo '<div class="wrap">
	<h1>Registered Affiliates</h1>';
	if ( ! empty ( $aff_db ) ) {
		for ( $i = 0; $i <= count( $aff_db ) - 1; $i++ ) {

			echo '<form method="post">';
			echo '<table class="form-table"><tbody>';
			echo '<tr><th scope="row"><label>First Name:</label></th> <td><input name="first" type="text" class="regular-text" value="' . $aff_db[$i]['first'] . '"></td></tr>';
			echo '<tr><th scope="row"><label>Last Name:</label></th> <td><input name="last" type="text" class="regular-text" value="' . $aff_db[$i]['last']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Email:</label></th> <td><input name="email" type="text" class="regular-text" value="' . $aff_db[$i]['email']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Instagram User:</label></th> <td><input type="text" name="ig" class="regular-text" value="' . $aff_db[$i]['ig']  . '"></td></tr>';
			echo '<tr><th scope="row"><label>Code:</label></th> <td><input type="text" name="coupon" class="regular-text" value="' . $aff_db[$i]['coupon']  . '"></td></tr>';
			echo '<tr><th scope="row"><button class="button button-primary type="submit" name="' . $i . '_delete" method="post">Delete</button></th><th scope="row"><button class="button button-primary type="submit" name="' . $i . '_update" method="post">Update</button></th></tr>';
			echo '</tbody></table>';
			echo '</form>';
		}
	} else {
		echo 'None yet :/';
	}
	echo '</div>';

	if ( isset($_POST) ) {
		require_once( plugin_dir_path( __DIR__ ) . 'affiliates.class.php' );
		$affiliate_list = new Affiliates;
		$affiliate_list->all_affiliates = get_option( 'affiliates' );

		for ( $i = 0; $i <= count( $aff_db ) - 1; $i++ ) {
			// Update Value
			if ( isset( $_POST[$i.'_update'] ) ) {
				$old_values = $aff_db[$i];
				$new_values = [
					'first' => $_POST['first'],
					'last' 	=> $_POST['last'],
					'email' => $_POST['email'],
					'ig'	=>  $_POST['ig'],
					'coupon' => $_POST['coupon'],
				];
				$diff_old = array_diff( $old_values, $new_values );
				$diff_new = array_diff( $new_values, $old_values );
				foreach( $diff_old as $k => $v ) { $old_val = $v; };
				foreach( $diff_new as $k => $v ) { $new_val = $v; };
				$affiliates = $affiliate_list->update_affiliates( $old_val, $new_val );
				$affiliates = array_values( $affiliates ); // re-index array.
				update_option( 'affiliates', $affiliates );
				header( "Refresh:0" );
			}

			// Delete User
			if ( isset( $_POST[$i.'_delete'] ) ) {
				$email = $aff_db[$i]['email'];
				$affiliates = $affiliate_list->del_affiliate( $email );
				$affiliates = array_values( $affiliates ); // re-index array.
				update_option( 'affiliates', $affiliates );
				header( "Refresh:0" );
			}
		}
	}

}



?>