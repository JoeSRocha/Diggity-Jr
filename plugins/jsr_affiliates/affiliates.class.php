<?php

class Affiliates {

	public $affiliate = [];
	public $all_affiliates = [];

	public function input_affiliate( $first, $last, $email, $ig, $coupon ) {

		$this->affiliate = [
			'first' => $first,
			'last' 	=> $last,
			'email' => $email,
			'ig'	=> $ig,
			'coupon' => $coupon,
		];
	}

	public function get_affiliates() {
		if ( empty( $this->all_affiliates ) ) {
			$this->all_affiliates = [];
			array_push( $this->all_affiliates, $this->affiliate );
			return $this->all_affiliates;
		} else {
			array_push( $this->all_affiliates, $this->affiliate );
			return $this->all_affiliates;
		}
	}

	public function update_affiliates( $old_val, $new_val ) {
		for ( $i = 0; $i < count( $this->all_affiliates ); $i++ ) {
			foreach ( $this->all_affiliates[$i] as $key => &$val ) {
				if ( $old_val == $val ) {
					$val = $new_val;
					//break;
				}
			}
		}
		return $this->all_affiliates;
	}

	public function check_coupon_affiliates( $coupon ) {
		for ( $i = 0; $i < count( $this->all_affiliates ); $i++ ) {
			foreach ( $this->all_affiliates[$i] as $key => &$val ) {
				if ( $coupon == $val ) {
					return $this->all_affiliates[$i];
				}
			}
		}
	}


	public function del_affiliate( $unset_affiliate ) {
		for ( $i = 0; $i < count( $this->all_affiliates ); $i++ ) {
			foreach ( $this->all_affiliates[$i] as $key => $val ) {
				if ( $unset_affiliate == $val ) {
					unset( $this->all_affiliates[$i] );
					break 2;
				}
			}
		}
		return $this->all_affiliates;
	}

}
