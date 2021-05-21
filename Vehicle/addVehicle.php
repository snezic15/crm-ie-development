<!DOCTYPE html>
<?php

//Check if submit button pushed
if (array_key_exists('submit_vehicle_manual', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$dateRegistered = $_POST['dateRegistered'];
	$license = $_POST['license'];
	$capacity = $_POST['capacity'];
	$dimensions = $_POST['dimensions'];
	$ton = $_POST['ton'];
	$status = $_POST['status'];
	$serviceDate = $_POST['serviceDate'];
	$generalNotes = $_POST['generalNotes'];
	
//Update query setting all variables using ID from above 'isset($_GET)'
	$query = "INSERT INTO wp_iecrm_vehicles (name, dateRegistered, license, capacity, dimensions, ton, status, serviceDate, generalNotes) VALUES ('".$name."', '".$dateRegistered."','".$license."','".$capacity."','".$dimensions."','".$ton."', '".$status."', '".$serviceDate."', '".$generalNotes."')";
	
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Vehicle Submitted!</strong></div>
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

<div class="container-contact100">
	<div class="wrap-contact100">
		<form class="contact100-form validate-form" method = "post" action = "">
			<span class="contact100-form-title">Add Vehicle</span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Vehicle Nickname*</span>
				<input class="input100" type="text" name="name" placeholder="Nickname for Vehicle" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Date Registered*</span>
				<input class="input100" type = "date" id = "datePicker" name = "dateRegistered" max = "<?php echo date("Y-m-d"); ?>" required><br>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">License Plate*</span>
				<input class="input100" type="text" name="license" placeholder="License Plate of Vehicle" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Capacity (m^3)*</span>
				<input class="input100" type="number" name="capacity" placeholder="***m^3" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Body Dimensions (m^3)*</span>
				<input class="input100" type="number" name="dimensions" placeholder="Heigh x Width x Length" required>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100" style="text-align: center !important;">
				<span class="label-input100" >Vehicle Weight (Tons)</span><br>
				<select class="js-select2" name="ton">
				    <option value="0">2</option>
				    <option value="1">4</option>
				    <option value="2">8</option>
					<option value="3">10</option>
				</select>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100" style="text-align: center !important;">
				<span class="label-input100" >Vehicle Status</span><br>
				<select class="js-select2" name="status">
					<option value="0">Active</option>
					<option value="1">In For Maintenance</option>
				</select>
			</div>
			
			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Service Date*</span>
				<input class="input100" type = "date" id = "datePicker" name = "serviceDate" max = "<?php echo date("Y-m-d"); ?>" required><br>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Make and type of vehicle"></textarea>
			</div>

			<div class="container-contact100-form-btn">
				<button type = "submit" name = "submit_vehicle_manual" class = "contact100-form-btn">Add Vehicle</button>
			</div>
		</form>
	</div>
</div>
</html>