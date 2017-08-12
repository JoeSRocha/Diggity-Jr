<?php

class Affiliates {

	private $affiliates = [];
	private $affiliate = [];

	public function input_affiliate( $first, $last, $email, $ig ) {

		$this->affiliate = array(
			'first' => $first,
			'last' 	=> $last,
			'email' => $email,
			'ig'	=> $ig,
		);

		array_push( $this->affiliates, $this->affiliate );
	}

	public function get_affiliates() {

		if ( ! empty( $this->affiliates ) ) {
			return $this->affiliates;
		} else {
			return $this->affiliate;
		}
	}

}

$affiliate_list = new Affiliates;
$joe = $affiliate_list->input_affiliate( 'Joe', 'Rocha', 'Joe.Rocha@me.com', 'JoeAdroit' );
$van = $affiliate_list->input_affiliate( 'Savannah', 'Rocha', 'Savannah.Rocha@me.com', 'VanDawg' );
$get_affiliates = $affiliate_list->get_affiliates();
print_r( $get_affiliates );
