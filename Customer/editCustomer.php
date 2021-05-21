<!DOCTYPE html>
<?php
require_once("connection.php");

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_customers WHERE ID='".$ID."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result)) {
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
	$address = $row['address'];
	$companyName = $row['companyName'];
	$abn = $row['abn'];
	$businessType = $row['businessType'];
	$notes = $row['notes'];
	$status = $row['status'];
	$dateCreated = $row['dateCreated'];
}

//If update button is pressed
if (array_key_exists('update', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$companyName = $_POST['companyName'];
	$abn = $_POST['abn'];
	$businessType = $_POST['businessType'];
	$notes = $_POST['notes'];
	$status = $_POST['status'];

//Update query setting all variables using ID from above 'isset($_GET)'
	$query = "UPDATE wp_iecrm_customers SET name='".$name."', phone='".$phone."', email='".$email."', address='".$address."', companyName='".$companyName."', abn='".$abn."', businessType='".$businessType."', notes='".$notes."', status='".$status."' WHERE ID='".$ID."'";
	
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Customer Updated!</strong></div>
		<?php
	}

	mysqli_close($con);
}
?>

<!-- CSS Shiiiieeeettt -->
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	<?php 
	$dir = ABSPATH . 'wp-content/plugins/ie-crm';
	include($dir . '/CSS/cssMain.css');
	?>
</style>

<!-- Same style as addEnquiry form -->
<div class="container-contact100">
	<div class="wrap-contact100">
		<form class="contact100-form validate-form" method = "post" action = "">
			<span class="contact100-form-title">Update Customer ID: <?php echo $ID ?></span>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Name*</span>
				<input class="input100" type="text" name="name" placeholder="Name" value="<?php echo $name ?>" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" value="<?php echo $phone ?>" required>
			</div>
			
			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="text" name="email" placeholder="email@provider.com" value="<?php echo $email ?>" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Address*</span>
				<input class="input100" type="text" name="address" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $address ?>"required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Company Name</span>
				<input class="input100" type="text" name="companyName" placeholder="Company Name" value="<?php echo $companyName ?>">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">ABN</span>
				<input class="input100" type="number" name="abn" placeholder="Enter ABN" min="11111111111" max="99999999999" value="<?php echo $abn ?>">
			</div> 
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Type of Business</span>
				<input class="input100" type="text" name="businessType" placeholder="Business Type" value="<?php echo $businessType ?>">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Date Created</span>
				<input class="input100" type="text" name="dateCreated" value="<?php echo $dateCreated ?>" readonly="readonly">
			</div>
			
			<div class="wrap-input100 validate-input bg0 rs1-alert-validate">
				<span class="label-input100">General Notes</span>
				<textarea class="input100" name="notes" placeholder="Additional Notes"><?php echo $notes; ?></textarea>
			</div>
			
			<div class="container-contact100-form-btn" style="text-align: center;">
					<span class="label-input100">Status</span><br>
					<select class="js-select2" name="status">
					    <option value="0" <?php echo ($status == 0 ? "selected" : "") ?>>Active</option>
						<option value="1" <?php echo ($status == 1 ? "selected" : "") ?>>Disabled</option>
					</select>
				</div>
			
			<div class="container-contact100-form-btn" style="text-align: center;">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=customer-list'" style="width: 250px;">
				<button type = "submit" name = "update" class = "contact100-form-btn" style="width: 250px;">Update Customer</button>
			</div>
		</form> 
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		document.getElementById("customerList").innerHTML = "";
	}
</script>
</html>