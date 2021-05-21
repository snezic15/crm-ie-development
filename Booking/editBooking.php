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

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_bookingCal WHERE id='".$ID."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$foriegnID= $row['foriegnID'];
	$customerID= $row['customerID'];
	$name= $row['name'];
	$phone= $row['phone'];
	$email= $row['email'];
	$startDate= $row['start_event'];
	$endDate= $row['end_event'];
	$movingFrom= $row['addressStart'];
	$movingTo= $row['addressEnd'];
	$rate=$row['rate'];
	$totalPaid=$row['totalPaid'];
	$status= $row['status'];
	$pickUp= $row['pickUp'];
	$dropOff= $row['dropOff'];
	$weight= $row['weight'];
	$listItems= $row['listItems'];
	$generalNotes= $row['generalNotes'];
	$assignedEmployee= explode(", ", unserialize($row['assignedEmployee']));
	$assignedVehicle= explode(", ", unserialize($row['assignedVehicle']));
}

//If update button is pressed
if (array_key_exists('update_booking', $_POST)) {
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
	$totalPaid=$_POST['totalPaid'];
	$status=$_POST['status'];
	$pickUp=$_POST['pickUp'];
	$dropOff=$_POST['dropOff'];
	$weight=$_POST['weight'];
	$listItems=$_POST['listItems'];
	$generalNotes=$_POST['generalNotes'];
	
//Take new data and store then serialize data to be saved in sql
	$framework = '';
	foreach($_POST["framework"] as $row){
		$framework .= $row . ', ';
	}
	$framework = substr($framework, 0, -2);
	$framework = serialize($framework);

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
	$query = "UPDATE wp_iecrm_bookingCal SET customerID='".$customerID."', name='".$name."', phone='".$phone."', email='".$email."', start_event='".$startDate."', end_event='".$endDate."', addressStart='".$movingFrom."', addressEnd='".$movingTo."', rate='".$rate."', totalPaid='".$totalPaid."', status='".$status."', pickUp='".$pickUp."', dropOff='".$dropOff."', listItems='".$listItems."', generalNotes='".$generalNotes."', assignedEmployee='".$framework."', assignedVehicle='".$framework2."', weight='".$weight."' WHERE ID='".$ID."'";
	
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Booking Updated!</strong></div>
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
			<span class="contact100-form-title">Update Booking ID: <?php echo $ID ?> <?php echo ($foriegnID == 0 ? "" : "<a class='contact100-form-title' href = 'admin.php?page=enquiry-list&Edit=$foriegnID'>(Enquiry ID: $foriegnID)</a>")?></span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer Name*</span>
				<input class="input100" type="text" name="name" placeholder="Customer Name" value="<?php echo $name; ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Email* <?php echo ($customerID == 0 ? "" : "<a class='label-input100' href = 'admin.php?page=customer-list&Edit=$customerID'>(Customer ID: $customerID)</a>")?></span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" value="<?php echo $email; ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" value="<?php echo $phone; ?>" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving From*</span>
				<input class="input100" type="text" name="movingFrom" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingFrom; ?>" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving To*</span>
				<input class="input100" type="text" name="movingTo" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingTo; ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Start Date/Time*</span>
				<input class="input100" type="datetime-local" name="startDate" value="<?php echo $startDate; ?>"required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">End Date/Time*</span>
				<input class="input100" type="datetime-local" name="endDate" value="<?php echo $endDate; ?>" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Employee(s) Assigned</span><br>
				<span class="label-input100"><br><?php foreach($assignedEmployee as $row){echo $row.="<br>"; }?></span><br>
				<select id="framework" name="framework[]" multiple class="js-select2" >
					<?php foreach($employeeName as $employee): ?>
						<option value="<?= $employee['name']; ?>"> <?=$employee['name'];?> </option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Vehicles(s) Assigned</span><br>
				<span class="label-input100"><br><?php foreach($assignedVehicle as $row){echo $row.="<br>"; }?></span><br>
				<select id="framework2" name="framework2[]" multiple class=" js-select2" >
					<?php foreach($vehicleName as $vehicle): ?>
						<option value="<?= $vehicle['name']; ?>"> <?=$vehicle['name'];?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100" >Truck Weight</span><br>
				<select class="js-select2" name="weight">
					<option value="0" <?php echo ($weight == 0 ? "selected" : "") ?>>Manpower</option>
					<option value="1" <?php echo ($weight == 1 ? "selected" : "") ?>>2T</option>
					<option value="2" <?php echo ($weight == 2 ? "selected" : "") ?>>4T</option>
					<option value="3" <?php echo ($weight == 3 ? "selected" : "") ?>>6T</option>
					<option value="4" <?php echo ($weight == 4 ? "selected" : "") ?>>8T</option>
					<option value="5" <?php echo ($weight == 5 ? "selected" : "") ?>>10T</option>
				</select>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Pick-Up Details</span>
				<textarea class="input100" name="pickUp" placeholder="Notes on location/house"><?php echo $pickUp; ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Drop-Off Details</span>
				<textarea class="input100" name="dropOff" placeholder="Notes on location/house"><?php echo $dropOff; ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">List of Items</span>
				<textarea type="text" class="input100" name="listItems" placeholder="List items for move"><?php echo $listItems ?></textarea>
			</div>

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Additional notes from customer"><?php echo $generalNotes; ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Hourly Rate</span>
				<input class="input100" type="number" name="rate" placeholder="00.00" value="<?php echo $rate; ?>">
			</div>
			
			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Total Paid</span>
				<input class="input100" type="number" name="totalPaid" placeholder="00.00" value="<?php echo $totalPaid; ?>" step="any">
			</div>

			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100" >Status</span><br>
				<select class="js-select2" name="status">
					<option value="0" <?php echo ($status == 0 ? "selected" : "") ?>>Requires Approval</option>
					<option value="1" <?php echo ($status == 1 ? "selected" : "") ?>>Pending</option>
					<option value="2" <?php echo ($status == 2 ? "selected" : "") ?>>Complete</option>
					<option value="3" <?php echo ($status == 3 ? "selected" : "") ?>>Archived</option>
				</select>
			</div>

			<div class="container-contact100-form-btn" style="text-align: center;">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=booking-list'" style="width: 250px;">
				<button type = "submit" name = "update_booking" class = "contact100-form-btn" style="width: 250px;">
					<span>Update Booking</span>
				</button>
			</div>
		</form>
	</div>
</div>

<!--script for multiselect dropdown box-->
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		document.getElementById("bookingList").innerHTML = "";
		document.getElementById("bookingArchiveList").innerHTML = "";
		document.getElementById("calendar").innerHTML = "";
	});

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