<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<?php
global $current_user; wp_get_current_user();
require_once("connection.php");

//Query row
$query = "SELECT * FROM wp_iecrm_customers WHERE EMAIL='".$current_user->user_email."'";
$result = mysqli_query($con, $query);

function validateDate($date) {
    if (preg_match('/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/', $date) > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$customerID = $row['ID'];
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
}

//Check if submit button pushed
if (array_key_exists('submit_booking_manual', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$startDate=$_POST['startDate'];
	$endDate=$_POST['endDate'];
	$movingFrom=$_POST['movingFrom'];
	$movingTo=$_POST['movingTo'];
	$pickUp=$_POST['pickUp'];
	$dropOff=$_POST['dropOff'];
	$generalNotes=$_POST['generalNotes'];
	$dateSubmit=date("Y-m-d");
	
	if (validateDate($startDate) && validateDate($endDate)) {
	    //Update query setting all variables using ID from above 'isset($_GET)'
	$query = "INSERT INTO wp_iecrm_bookingCal (customerID, name, phone, email, start_event, end_event, addressStart, addressEnd, pickUp, dropOff, generalNotes, dateSubmit) VALUES ('".$customerID."', '".$name."', '".$phone."', '".$email."', '".$startDate."', '".$endDate."', '".$movingFrom."', '".$movingTo."', '".$pickUp."', '".$dropOff."','".$generalNotes."', '".$dateSubmit."')";

	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Booking Submitted!</strong></div>
		<?php
	}

	mysqli_close($con);
	}
	
	else {
	    ?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>Incorrect Date/Time Format. Please use Chrome/Edge Browser</strong></div>
		<?php
	}
}
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	<?php include'/home/u20s1004/dev_root/wp-content/plugins/ie-crm/CSS/cssMain.css'; ?>
	
	#hiddenDetails{
		visibility: hidden;
	}
</style>

<!-- HTML Kiddy Scripts -->
<div class="container-contact100">
	<div class="wrap-contact100">
		<form class="contact100-form validate-form" method = "post" action = "">
			<span class="contact100-form-title">Add Booking</span>


			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving From</span>
				<input class="input100" type="text" name="movingFrom" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving To</span>
				<input class="input100" type="text" name="movingTo" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Start Date/Time</span>
				<input class="input100" type="datetime-local" name="startDate" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">End Date/Time</span>
				<input class="input100" type="datetime-local" name="endDate" required>
			</div>

			<div class="wrap-input100 input100-select bg1">
				<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
					<span class="label-input100">Pick-Up Details</span>
					<textarea class="input100" name="pickUp" placeholder="Notes on location/house"></textarea>
				</div>
				
				<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
					<span class="label-input100">Drop-Off Details</span>
					<textarea class="input100" name="dropOff" placeholder="Notes on location/house"></textarea>
				</div>

				<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
					<span class="label-input100">General Notes</span>
					<textarea class="input100" name="generalNotes" placeholder="Additional notes from customer"></textarea>
				</div>
			</div>
			
			<div class="container-contact100-form-btn">
				<button type = "submit" name = "submit_booking_manual" class="contact100-form-btn">
					<span>Request Booking</span>
				</button>
			</div>
		</form>
	</div>
</div>