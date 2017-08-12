<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->

		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

	<form class="form-horizontal" method="post">

		<div class="form-group">
			<label for="firstName" class="col-sm-2 control-label">First Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="lastName" class="col-sm-2 control-label"> Last Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="col-sm-2 control-label">Email address</label>
			<div class="col-sm-10">
				<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" required>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="instagramUser" class="col-sm-2 control-label">IG User</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="instagramUser" placeholder="Instagram User">
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="couponCode" class="col-sm-2 control-label">Coupon Code</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="couponCode" placeholder="Coupon Code">
			</div>
		</div>
		<br/>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Submit</button>
			</div> 
		</div>
		
	</form>

<?php

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
		$first_name = htmlspecialchars( $_POST['firstName'] );
		$last_name = htmlspecialchars( $_POST['lastName'] );
		$email = htmlspecialchars( $_POST['inputEmail'] );
		$coupon_code = htmlspecialchars( $_POST['couponCode'] );

		function mempty() {
			foreach( func_get_args() as $arg )
				if( ! empty( $arg ) )
					continue;
				else
					return false;
				return true;
		}

		if ( mempty( $first_name, $last_name, $email ) ) {
			echo "<br/><h5>Awesome! Will get back to you soon $first_name.</h5>";
		}
}
