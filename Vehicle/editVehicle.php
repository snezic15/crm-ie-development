<!DOCTYPE html>
<?php
require_once("connection.php");

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_vehicles WHERE ID='".$ID."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result)) {
	$name = $row['name'];
	$dateRegistered = $row['dateRegistered'];
	$license = $row['license'];
	$capacity = $row['capacity'];
	$dimensions = $row['dimensions'];
	$ton = $row['ton'];
	$status = $row['status'];
	$serviceDate = $row['serviceDate'];
	$generalNotes = $row['generalNotes'];
}

//If update button is pressed
if (array_key_exists('update', $_POST)) {
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
	$query = "UPDATE wp_iecrm_vehicles SET name='".$name."', dateRegistered='".$dateRegistered."', license='".$license."', capacity= '".$capacity."', dimensions= '".$dimensions."', ton='".$ton."' , status='".$status."', serviceDate='".$serviceDate."', generalNotes='".$generalNotes."' WHERE ID='".$ID."'";

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
			<span class="contact100-form-title">Update Vehicle License Number: <?php echo $license ?></span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Vehicle Nickname*</span>
				<input class="input100" type="text" name="name" placeholder="Nickname for Vehicle" value="<?php echo $name; ?>" required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Date Registered*</span>
				<input class="input100" type = "date" id = "datePicker" name = "dateRegistered" value="<?php echo $dateRegistered; ?>" required><br>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">License Plate*</span>
				<input class="input100" type="text" name="license" placeholder="License Plate of Vehicle" value="<?php echo $license; ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Capacity (m^3)*</span>
				<input class="input100" type="number" name="capacity" placeholder="***m^3" value="<?php echo $capacity; ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Body Dimensions (m^3)*</span>
				<input class="input100" type="number" name="dimensions" placeholder="Height x Width x Length" value="<?php echo $dimensions; ?>" required>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100" style="text-align: center !important;">
				<span class="label-input100" >Vehicle Weight (Tons)</span><br>
				<select class="js-select2" name="ton">
					<option value="0" <?php echo ($ton == '0' ? 'selected' : ''); ?>>2</option>
					<option value="1" <?php echo ($ton == '1' ? 'selected' : ''); ?>>4</option>
					<option value="2" <?php echo ($ton == '2' ? 'selected' : ''); ?>>8</option>
					<option value="3" <?php echo ($ton == '3' ? 'selected' : ''); ?>>10</option>
				</select>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100" style="text-align: center !important;">
				<span class="label-input100" >Vehicle Status</span><br>
				<select class="js-select2" name="status">
					<option value="0" <?php echo ($status == '0' ? 'selected' : ''); ?>>Active</option>
					<option value="1" <?php echo ($status == '1' ? 'selected' : ''); ?>>In For Maintenance</option>
					<option value="2" <?php echo ($status == '2' ? 'selected' : ''); ?>>Archived</option>
				</select>
			</div>
			
			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Service Date*</span>
				<input class="input100" type = "date" id = "datePicker" name = "serviceDate" value="<?php echo $serviceDate; ?>" required><br>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="generalNotes" placeholder="Make and type of vehicle"><?php echo $generalNotes; ?></textarea>
			</div>

			<div class="container-contact100-form-btn" style="text-align: center;">
			    <input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=vehicle-list'" style="width: 250px;">
				<button type = "submit" name = "update" class = "contact100-form-btn" style="width: 250px;">Update Vehicle</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		document.getElementById("vehicleList").innerHTML = "";
	}
</script>
</html>