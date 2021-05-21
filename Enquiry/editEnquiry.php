<!DOCTYPE html>
<?php
require_once("connection.php");

//temp variable for disabled status
$disabled = "";

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_enquiries WHERE ID='".$ID."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
	$date = $row['date'];
	$movingTo = $row['movingTo'];
	$movingFrom = $row['movingFrom'];
	$listItems = $row['listItems'];
	$details = $row['details'];
	$confirmed = $row['confirmed'];
}

if($confirmed == 2) {
    $disabled = "disabled";
}

//If update button is pressed
if (array_key_exists('update', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$date = $_POST['date'];
	$movingTo = $_POST['movingTo'];
	$movingFrom = $_POST['movingFrom'];
	$pickUp=$_POST['pickUp'];
	$dropOff=$_POST['dropOff'];
	$listItems = $_POST['listItems'];
	$details = $_POST['details'];
	$confirmed = $_POST['confirmed'];

//Update query setting all variables using ID from above 'isset($_GET)'
	$query = "UPDATE wp_iecrm_enquiries SET name='".$name."', phone='".$phone."', email='".$email."', date='".$date."', movingTo='".$movingTo."', movingFrom='".$movingFrom."', pickUp='".$pickUp."', dropOff='".$dropOff."', listItems='".$listItems."', details='".$details."', confirmed='".$confirmed."' WHERE ID='".$ID."'";
	
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Enquiry Updated!</strong></div>
		<?php
	}

	mysqli_close($con);
}

if (array_key_exists('pushToBooking', $_POST)) {
	include 'enquiryToBooking.php';
}

//Check if submit button pushed
if (array_key_exists('submit_enquiry_booking', $_POST)) {
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

	//Update enquiry status
	$queryEnquiryFinal = "UPDATE wp_iecrm_enquiries SET confirmed=2 WHERE ID='".$ID."'";

	if (!mysqli_query($con,$queryEnquiryFinal)) {
		wp_die("An error has occured setting confirmed status in wp_iecrm_enquiries");
	}
	
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
    
	//Insert into booking
	$query = "INSERT INTO wp_iecrm_bookingCal (foriegnID, customerID, name, phone, email, start_event, end_event, addressStart, addressEnd, rate, status, pickUp, dropOff, listItems, generalNotes, dateSubmit, assignedEmployee, assignedVehicle) VALUES ('".$ID."', '".$customerID."', '".$name."', '".$phone."', '".$email."', '".$startDate."', '".$endDate."', '".$movingFrom."', '".$movingTo."', '".$rate."', '".$status."', '".$pickUp."', '".$dropOff."', '".$listItems."', '".$generalNotes."', '".$dateSubmit."', '".$framework."', '".$framework2."')";

	//Check to see if database insertion was successful and reload page
	header("Refresh:0");
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Booking Created!</strong></div>
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
	<div class="wrap-contact100" id="editEnquiry">
		<form class="contact100-form validate-form" method = "post" action = "">
			<span class="contact100-form-title">Update Enquiry ID: <?php echo $ID ?></span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Name*</span>
				<input class="input100" type="text" name="name" placeholder="Customer Name" value="<?php echo $name ?>" <?php echo $disabled ?> required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" value="<?php echo $email ?>" <?php echo $disabled ?> required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" value="<?php echo $phone ?>" pattern="[0-9]{10}" <?php echo $disabled ?> required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving From*</span>
				<input class="input100" type="text" name="movingFrom" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingFrom ?>" <?php echo $disabled ?> required>
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Moving To*</span>
				<input class="input100" type="text" name="movingTo" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $movingTo ?>" <?php echo $disabled ?> required>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Date Requested*</span>
				<input class="input100" type = "date" id = "datePicker" name = "date" value= "<?php echo $date ?>" <?php echo $disabled ?> required><br>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Pick-Up Details</span>
				<textarea class="input100" name="pickUp" placeholder="Notes on location/house" <?php echo $disabled ?>><?php echo $pickUp ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Drop-Off Details</span>
				<textarea class="input100" name="dropOff" placeholder="Notes on location/house" <?php echo $disabled ?>><?php echo $dropOff ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">List of Items</span>
				<textarea type="text" class="input100" name="listItems" placeholder="List items for move" <?php echo $disabled ?>><?php echo $listItems ?></textarea>
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">Notes</span>
				<textarea type="text" class="input100" name="details" placeholder="Additional notes" <?php echo $disabled ?>><?php echo $details ?></textarea>
			</div>

			<div class="wrap-input100 input100-select bg1" style="text-align: center !important;">
				<span class="label-input100" >Followed Up With Client</span><br>
				<select class="js-select2" name="confirmed" <?php echo $disabled ?>>
					<option value="0" <?= ($confirmed == 0 ? "selected" : "") ?>>Follow-Up</option>
					<option value="1" <?= ($confirmed == 1 ? "selected" : "") ?>>Quote Provided</option>
					<option value="2" <?= ($confirmed != 2 ? "hidden" : "") ?> <?= ($confirmed == 2 ? "selected" : "") ?>>Locked (Moved to Booking)</option>
					<option value="3" <?= ($confirmed != 2 ? "hidden" : "") ?> <?= ($confirmed == 3 ? "selected" : "") ?>>Lost</option>
				</select>
			</div>

			<div class="container-contact100-form-btn">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=enquiry-list'" style="width:250px">
				<button name = "update" class = "contact100-form-btn" <?php echo $disabled ?> style="width:250px">Update Enquiry</button>
				<button name = "pushToBooking" class = "contact100-form-btn" <?php echo $disabled ?> style="width:250px">Convert To Booking</button>
				<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		document.getElementById("enquiryList").innerHTML = "";
	}
</script>
</html>