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

//Date to Date/Time Format
$beforeDate = "T00:00";
$startDateNew = $date.$beforeDate;
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
			<span class="contact100-form-title">Confirm Booking <a class="contact100-form-title" href = "admin.php?page=enquiry-list&Edit=<?php echo $ID; ?>">(Enquiry ID:<?php echo $ID; ?>)</a></span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer Name</span>
				<input class="input100" type="text" name="name" value="<?php echo $name ?>" placeholder="Customer Name" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Email</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" value="<?php echo $email ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" value="<?php echo $phone ?>" pattern="[0-9]{10}" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving From</span>
				<input class="input100" type="text" name="movingFrom" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingFrom ?>" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving To</span>
				<input class="input100" type="text" name="movingTo" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingTo ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Start Date/Time</span>
				<input class="input100" type="datetime-local" name="startDate" value= "<?php echo $startDateNew ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">End Date/Time</span>
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

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Pick-Up Details</span>
				<textarea class="input100" name="pickUp" placeholder="Notes on location/house"><?php echo $pickUp ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Drop-Off Details</span>
				<textarea class="input100" name="dropOff" placeholder="Notes on location/house"><?php echo $dropOff ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">List of Items</span>
				<textarea type="text" class="input100" name="listItems" placeholder="List items for move"><?php echo $listItems ?></textarea>
			</div>

			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Additional notes from customer"><?php echo $details ?></textarea>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Hourly Rate</span>
				<input class="input100" type="number" name="rate" placeholder="00.00">
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100" >Status</span><br>
				<select class="js-select2" name="status">
					<option value="0">Requires Approval</option>
					<option value="1" selected>Pending</option>
					<option value="2">Complete</option>
				</select>
			</div>

			<div class="container-contact100-form-btn" style="text-align: center;">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="return refresh()" style="width:250px">
				<button type = "submit" name = "submit_enquiry_booking" class="contact100-form-btn" style="width:250px">
					<span>Confirm Booking</span>
				</button>
			</div>
		</form>
	</div>
</div>

<script>
//Clear Pre-loaded page data
document.addEventListener("DOMContentLoaded", function(event) {
	document.getElementById("editEnquiry").innerHTML = "";
});

function refresh() {
	window.location.reload(true);
}

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