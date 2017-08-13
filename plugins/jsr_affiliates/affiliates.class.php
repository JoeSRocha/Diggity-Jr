<?php

class Affiliates {

	public $affiliates = [];
	private $affiliate = [];

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

		if ( ! empty( $this->affiliates ) ) {
			array_push( $this->affiliates, $this->affiliate );
			return $this->affiliates;
		} else {
			return $this->affiliate;
		}
	}

}

