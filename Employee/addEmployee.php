<!DOCTYPE html>
<?php

//Check if submit button pushed
if (array_key_exists('submit_employee_manual', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$tfn = $_POST['tfn'];
	$abn = $_POST['abn'];
	$password = $_POST['password'];
	$status = $_POST['status'];
	$role = $_POST['role'];
	$visa = $_POST['visa'];
    $licence = $_POST['licence'];
    $bank = $_POST['bank'];
    $joindate = $_POST['joindate'];
    $experience = $_POST['experience'];
	
	$to = $email; // Send email to our user
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
    $query = "INSERT INTO wp_iecrm_employees (role, name, phone, email, address, tfn, abn, status, visa, licence, bank, joindate, experience) VALUES ('".$role."', '".$name."', '".$phone."', '".$email."', '".$address."', '".$tfn."', '".$abn."', '".$status."', '".$visa."', '".$licence."', '".$bank."', '".$joindate."', '".$experience."')";
    
    //Creates wp user using variables from above
    $user = wp_insert_user([
    	'user_login' => $email,
    	'user_email' => $email,
    	'user_pass' => $password,
		'display_name' => $_POST[ 'name' ]
    ]);    

	//Sets employee account role to staffemployee
	if ($role == 0) {
    wp_update_user( array ('ID' => $user, 'role' => 'staffadmin'));
	}
	
	else {
	wp_update_user( array ('ID' => $user, 'role' => 'staffemployee'));
	}


    //Check to see if database insertion was successful
    if (!mysqli_query($con,$query)) {
    	?>
    	<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
    	<?php
    }

    else {
    	?>
    	<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Employee Added!</strong></div>
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
			<span class="contact100-form-title">Add New Employee</span>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Name*</span>
				<input class="input100" type="text" name="name" placeholder="Employee Name" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Bank Account</span>
				<input class="input100" type="text" pattern="[\d-]+" name="bank" placeholder="[BSB]-[Account Number]">
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Residential Address*</span>
				<input class="input100" type="text" name="address" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">TFN</span>
				<input class="input100" type="number" name="tfn" placeholder="Enter TFN" min="11111111" max="999999999">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">ABN</span>
				<input class="input100" type="number" id = "abn" name = "abn" placeholder="Enter ABN" min="11111111111" max="99999999999">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Visa Status</span><br>
				<select class="js-select2" name="visa">
					<option value="0" selected>Citizen</option>
					<option value="1">Permanent Residency</option>
					<option value="2" >Temporary Residency</option>
					<option value="3" >Student Visa</option>
				</select>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Licence Type</span><br>
				<select class="js-select2" name="licence">
					<option value="0" selected>C</option>
					<option value="1" >LR</option>
					<option value="2" >MR</option>
					<option value="3" >HR</option>
					<option value="4" >HC</option>
					<option value="5" >MC</option>
					<option value="6" >No licence</option>
				</select>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Join Date</span><br>
				<input class="input100" type="date" name ="joindate">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Experience Status</span><br>
				<select class="js-select2" name="experience">
					<option value="0" >Beginner</option>
					<option value="1" selected >Medium</option>
					<option value="2" >Advance</option>
				</select>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Role</span><br>
				<select class="js-select2" name="role">
					<option value="0">Admin</option>
					<option value="1" selected>Removalist</option>
				</select>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Status</span><br>
				<select class="js-select2" name="status">
					<option value="0" selected>Active</option>
					<option value="1">Inactive</option>
				</select>
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
				<button type = "submit" name = "submit_employee_manual" button class="contact100-form-btn">
					<span>Add Employee</span>
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