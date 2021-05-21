<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<?php
//Vehicle and employee list retrieval
require_once("connection.php");
$queryEmployee = "SELECT name FROM wp_iecrm_employees";
$employeeName = mysqli_query($con, $queryEmployee);

$queryVehicle = "SELECT name FROM wp_iecrm_vehicles";
$vehicleName = mysqli_query($con, $queryVehicle);

//Check if submit button pushed
if (array_key_exists('submit_booking_manual', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$customerID = 0;
	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$startDate=$_POST['startDate'];
	$endDate=$_POST['endDate'];
	$movingFrom=$_POST['movingFrom'];
	$movingTo=$_POST['movingTo'];
	$rate=$_POST['rate'];
	$status=$_POST['status'];
	$pickUp=$_POST['pickUp'];
	$dropOff=$_POST['dropOff'];
	$listItems=$_POST['listItems'];
	$generalNotes=$_POST['generalNotes'];
	$weight=$_POST['weight'];
	$dateSubmit=date("Y-m-d");

	//Storing employee into database
	$framework = '';
	foreach($_POST["framework"] as $row){
		$framework .= $row . ', ';
	}
	$framework = substr($framework, 0, -2);
	$framework = serialize($framework);

	//Storing vehicle into database
	$framework2 = '';
	foreach($_POST["framework2"] as $row){
		$framework2 .= $row . ', ';
	}
	$framework2 = substr($framework2, 0, -2);
	$framework2 = serialize($framework2);
	
	//To attach commerical customer
	$queryCustomerEmail = "SELECT * FROM wp_iecrm_customers";
	$resultCustomer = mysqli_query($con, $queryCustomerEmail);
	
    //Temp Arrays for email and ID
	$customerTempID = array();
	$customerTempEmail = array();
	
    //Store database entries in arrays
	while($row=mysqli_fetch_assoc($resultCustomer)) {
		$customerTempID[] = (int) $row['ID'];
		$customerTempEmail[] = $row['email'];
	}
	
    //Array search, check if valid
    //If valid, use array key to get customer ID using customerTempID array
	if (array_search($email, $customerTempEmail)) {
		$customerID = $customerTempID[array_search($email, $customerTempEmail)];
	}
	
	//Update query setting all variables using ID from above 'isset($_GET)'
	$query = "INSERT INTO wp_iecrm_bookingCal (customerID, name, phone, email, start_event, end_event, addressStart, addressEnd, rate, status, pickUp, dropOff, listItems, generalNotes, dateSubmit, assignedEmployee, assignedVehicle, weight) VALUES ('".$customerID."', '".$name."', '".$phone."', '".$email."', '".$startDate."', '".$endDate."', '".$movingFrom."', '".$movingTo."', '".$rate."', '".$status."', '".$pickUp."', '".$dropOff."', '".$listItems."', '".$generalNotes."', '".$dateSubmit."', '".$framework."', '".$framework2."', '".$weight."')";

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
			<span class="contact100-form-title">Add Booking</span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer Name*</span>
				<input class="input100" type="text" name="name" placeholder="Customer Name" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Email*</span>
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

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Start Date/Time*</span>
				<input class="input100" type="datetime-local" name="startDate" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">End Date/Time*</span>
				<input class="input100" type="datetime-local" name="endDate" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Employee(s) Assigned</span><br>
				<select id="framework" name="framework[]" multiple class="js-select2" >
					<?php foreach($employeeName as $employee): ?>
						<option value="<?= $employee['name']; ?>"> <?=$employee['name'];?> </option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Vehicles(s) Assigned</span><br>
				<select id="framework2" name="framework2[]" multiple class=" js-select2" >
					<?php foreach($vehicleName as $vehicle): ?>
						<option value="<?= $vehicle['name']; ?>"> <?=$vehicle['name'];?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100" >Truck Weight</span><br>
				<select class="js-select2" name="weight">
					<option value="0">Manpower</option>
					<option value="1">2T</option>
					<option value="2">4T</option>
					<option value="3">6T</option>
					<option value="4">8T</option>
					<option value="5">10T</option>
				</select>
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
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Additional notes from customer"></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Hourly Rate</span>
				<input class="input100" type="number" name="rate" placeholder="00.00">
			</div>
			
			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Status</span><br>
				<select class="js-select2" name="status">
					<option value="0">Requires Approval</option>
					<option value="1" selected>Pending</option>
					<option value="2">Complete</option>
				</select>
			</div>

			<div class="container-contact100-form-btn">
				<button type = "submit" name = "submit_booking_manual" class="contact100-form-btn">
					<span>Add Booking</span>
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#framework').multiselect({
			nonSelectedText: 'Select Employee(s)',
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true
		});

		$('#framework_form').on('submit', function(event){
			event.preventDefault();
			var form_data = $(this).serialize();
			$.ajax({
				url:"insert.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#framework option:selected').each(function(){
						$(this).prop('selected', false);
					});
					$('#framework').multiselect('refresh');
					alert(data);
				}
			});
		});
	});

	$(document).ready(function(){
		$('#framework2').multiselect({
			nonSelectedText: 'Select Vehicle(s)',
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true
		});

		$('#framework_form').on('submit', function(event){
			event.preventDefault();
			var form_data = $(this).serialize();
			$.ajax({
				url:"insert.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#framework2 option:selected').each(function(){
						$(this).prop('selected', false);
					});
					$('#framework2').multiselect('refresh');
					alert(data);
				}
			});
		});
	});
</script>