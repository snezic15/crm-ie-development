<!DOCTYPE html>
<?php

//Check if submit button pushed
if (array_key_exists('submit_enquiry_manual', $_POST)) {
	require_once("connection.php");

	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$date=$_POST['date'];
	$movingTo=$_POST['movingTo'];
	$movingFrom=$_POST['movingFrom'];
	$pickUp=$_POST['pickUp'];
	$dropOff=$_POST['dropOff'];
	$listItems=$_POST['listItems'];
	$details=$_POST['details'];
	$dateSubmit=date("Y-m-d");
	$confirmed=$_POST['confirmed'];

	//Database query
	$query = "INSERT INTO wp_iecrm_enquiries (name, phone, email, date, movingTo, movingFrom, pickUp, dropOff, listItems, details, dateSubmit, confirmed) VALUES ('".$name."', '".$phone."', '".$email."', '".$date."', '".$movingTo."', '".$movingFrom."', '".$pickUp."', '".$dropOff."', '".$listItems."', '".$details."', '".$dateSubmit."', '".$confirmed."')";

	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Enquiry Submitted!</strong></div>
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
			<span class="contact100-form-title">Add Enquiry</span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Name*</span>
				<input class="input100" type="text" name="name" placeholder="Customer Name" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving From*</span>
				<input class="input100" type="text" name="movingFrom" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving To*</span>
				<input class="input100" type="text" name="movingTo" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Date Requested*</span>
				<input class="input100" type = "date" id = "datePicker" name = "date" min = "<?php echo date("Y-m-d"); ?>" required><br>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Pick-Up Details</span>
				<textarea class="input100" name="pickUp" placeholder="Notes on location/house"></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Drop-Off Details</span>
				<textarea class="input100" name="dropOff" placeholder="Notes on location/house"></textarea>
			</div>

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">List of Items</span>
				<textarea type="text" class="input100" name="listItems" placeholder="List items for move"></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Notes</span>
				<textarea type="text" class="input100" name="details" placeholder="Additional notes"></textarea>
			</div>

			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100" >Followed Up With Client</span><br>
				<select class="js-select2" name="confirmed">
					<option value="0">Follow-Up</option>
					<option value="1">Quote Provided</option>
				</select>
			</div>
			
			<div class="container-contact100-form-btn">
				<button type = "submit" name = "submit_enquiry_manual" class = "contact100-form-btn">Add Enquiry</button>
			</div>
		</form>
	</div>
</div>
</html>