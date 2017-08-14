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

}
