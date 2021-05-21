<!DOCTYPE html>
<?php

//Check if submit button pushed
if (array_key_exists('submit_customer_manual', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$companyName = $_POST['companyName'];
	$abn = $_POST['abn'];
	$businessType = $_POST['businessType'];
	$notes = $_POST['notes'];
	$password = $_POST['password'];

    $to = $email; // Send email to our customer
    $subject = 'Account Creation'; // Give the email a subject 
    $message = '

    Thanks '.$name.' for signing up!
    Your account has been created, you can login with the following credentials.

    ------------------------
    Username: '.$email.'
    Password: '.$password.'
    ------------------------
    
    To see your profile, please follow the link below:
    https://development.u20s1004.monash-ie.me/login/
    
    Thanks for choosing Easy Peasy Removals!


    ';

    $headers = 'From:noreply@easypeasyremovals.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email

//Update query setting all variables using ID from above 'isset($_GET)'
    $query = "INSERT INTO wp_iecrm_customers (name, phone, email, address, companyName, abn, businessType, notes, dateCreated) VALUES ('".$name."', '".$phone."', '".$email."', '".$address."', '".$companyName."', '".$abn."', '".$businessType."', '".$notes."', '".date("Y/m/d")."')";

    //Creates wp user using variables from above
    $user = wp_insert_user([
    	'user_login' => $email,
    	'user_email' => $email,
    	'user_pass' => $password,
    	'display_name' => $_POST[ 'name' ]
    ]);    

	//Sets customer account role to customer
    wp_update_user( array ('ID' => $user, 'role' => 'customer') ) ;
    
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Customer Added!</strong></div>
		<?php
	}

	mysqli_close($con);
}
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	<?php 
	$dir = ABSPATH . 'wp-content/plugins/ie-crm';
	include($dir . '/CSS/cssMain.css');
	?>
</style>

<!-- HTML Kiddy Scripts -->
<div class="container-contact100">
	<div class="wrap-contact100">
		<form class="contact100-form validate-form" method = "post" action = "">
			<span class="contact100-form-title">Add New Customer</span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer NAME*</span>
				<input class="input100" type="text" name="name" placeholder="Enter Customer Name" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="text" name="email" placeholder="email@provider.com" required>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Company Address*</span>
				<input class="input100" type="text" name="address" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Company Name</span>
				<input class="input100" type="text" name="companyName" placeholder="Enter Company Name">
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">ABN</span>
				<input class="input100" type="number" id = "abn" name = "abn" placeholder="Enter ABN" min="11111111111" max="99999999999">
			</div>
			
			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Type of Business</span>
				<input class="input100" type="text" name="businessType" placeholder="Business Type">
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Notes</span>
				<textarea class="input100" name="notes" placeholder="Additional notes"></textarea>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Password*</span>
				<input class="input100" type="password" id = "password" name="password" placeholder="Enter password" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100" style="text-align: center;">
				<input type="button" class="contact100-form-btn" onclick="randPass();" value="Generate Password" style="text-align: center !important;">
				<br><br><span>Show Password</span>
				<input type="checkbox" onclick="passwordToggle();">
			</div>

			<div class="container-contact100-form-btn" id="buttonContainer">
				<button type = "submit" name = "submit_customer_manual" button class="contact100-form-btn">
					<span>Add Customer</span>
				</button>
			</div>
		</form> 
	</div>
</div>

<script type="text/javascript">
	//Toggle Password visiblity because stuff HTML
	function passwordToggle() {
		var x = document.getElementById("password");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}

	//Generates random pasword to WordPress specifications
	function randPass() {
		var chars = "ABCDEFGHIKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz0123456789!@#$%^&*"
		var passwordLength = 16;
		var password = "";

		for(var i=0;i<passwordLength;i++){
			var randomNumber = Math.floor(Math.random()*chars.length);
			password+= chars.substring(randomNumber,randomNumber+1);
		}

		document.getElementById("password").value = password;
	}
</script>
</html>