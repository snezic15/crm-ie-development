<?php
//Get ID from 'Edit'
$ID = $_GET['View'];

include "connection.php";

//Query row
$query = "SELECT * FROM wp_iecrm_bookingCal WHERE id = $ID";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result)) {
	$foriegnID= $row['foriegnID'];
	$customerID= $row['customerID'];
	$name= $row['name'];
	$phone= $row['phone'];
	$email= $row['email'];
	$startDate= $row['start_event'];
	$endDate= $row['end_event'];
	$movingFrom= $row['addressStart'];
	$movingTo= $row['addressEnd'];
	$rate= $row['rate'];
	$totalPaid=$row['totalPaid'];
	$status= $row['status'];
	$pickUp= $row['pickUp'];
	$dropOff= $row['dropOff'];
	$generalNotes= $row['generalNotes'];
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
			<span class="contact100-form-title">Booking ID: <?php echo $ID ?> </span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer Name</span>
				<input class="input100" type="text" name="name" placeholder="Customer Name" value="<?php echo $name; ?>" disabled>
			</div>

			<div class="wrap-input100 bg1" >
				<span class="label-input100">Email Address</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" value="<?php echo $email; ?>" disabled>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Phone Number</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" value="<?php echo $phone; ?>" disabled>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Moving From</span>
				<input class="input100" type="text" name="movingFrom" placeholder="Property address" value="<?php echo $movingFrom; ?>" disabled>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Moving To</span>
				<input class="input100" type="text" name="movingTo" placeholder="Property address" value="<?php echo $movingTo; ?>" disabled>
			</div>

			<div class="wrap-input100 bg1">
				<span class="label-input100">Start Date/Time</span>
				<input class="input100" type="datetime-local" name="startDate" value="<?php echo $startDate; ?>"disabled>
			</div>

			<div class="wrap-input100 bg1">
				<span class="label-input100">End Date/Time</span>
				<input class="input100" type="datetime-local" name="endDate" value="<?php echo $endDate; ?>" disabled>
			</div>

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Pick-Up Details</span>
				<textarea class="input100" name="pickUp" placeholder="Notes on location/house" disabled><?php echo $pickUp; ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Drop-Off Details</span>
				<textarea class="input100" name="dropOff" placeholder="Notes on location/house" disabled><?php echo $dropOff; ?></textarea>
			</div>

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Additional notes from customer" disabled><?php echo $generalNotes; ?></textarea>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Hourly Rate</span>
				<input class="input100" type="number" name="rate" placeholder="00.00" value="<?php echo $rate; ?>" disabled>
			</div>
			
			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Total Paid</span>
				<input class="input100" type="number" name="totalPaid" placeholder="00.00" value="<?php echo $totalPaid; ?>" disabled>
			</div>

			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100">Status</span><br>
				<select class="js-select2" name="status" disabled>
					<option value="0" <?php echo ($status == 0 ? "selected" : "") ?>>Requires Approval</option>
					<option value="1" <?php echo ($status == 1 ? "selected" : "") ?>>Pending</option>
					<option value="2" <?php echo ($status == 2 ? "selected" : "") ?>>Complete</option>
					<option value="3" <?php echo ($status == 3 ? "selected" : "") ?>>Archived</option>
				</select>
			</div>

			<div class="container-contact100-form-btn" style="text-align: center;">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='/booking-history/'" style="width: 250px;">

			</button>
		</div>
	</form>
</div>
</div>

<!--script for multiselect dropdown box-->
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		document.getElementById("bookingList").innerHTML = "";
	});
</script>