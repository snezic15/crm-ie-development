<!DOCTYPE html>
<?php
require_once("connection.php");

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_employees WHERE ID='".$ID."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$role = $row['role'];
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
	$address = $row['address'];
	$tfn = $row['tfn'];
	$abn = $row['abn'];
	$status = $row['status'];
	$visa = $row['visa'];
	$licence = $row['licence'];
	$bank = $row['bank'];
	$joindate = $row['joindate'];
    $experience = $row['experience'];
}

//If update button is pressed
if (array_key_exists('update', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$role = $_POST['role'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$tfn = $_POST['tfn'];
	$abn = $_POST['abn'];
	$status = $_POST['status'];
    $visa = $_POST['visa'];
	$licence = $_POST['licence'];
	$bank = $_POST['bank'];
	$joindate = $_POST['joindate'];
    $experience = $_POST['experience'];

//Update query setting all variables using ID from above 'isset($_GET)'
	$query = "UPDATE wp_iecrm_employees SET role='".$role."', name='".$name."', phone='".$phone."', email='".$email."', address='".$address."', tfn='".$tfn."', abn='".$abn."', status='".$status."', visa='".$visa."', licence='".$licence."', bank='".$bank."', joindate='".$joindate."', experience='".$experience."' WHERE ID='".$ID."'";
	
    //Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Employee Updated!</strong></div>
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
			<span class="contact100-form-title">Update Employee ID: <?php echo $ID ?></span>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Name*</span>
				<input class="input100" type="text" name="name" placeholder="Employee Name" value="<?php echo $name ?>"required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address*</span>
				<input class="input100" type="email" name="email" placeholder="email@provider.com" value="<?php echo $email ?>" required>
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number*</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" value="<?php echo $phone ?>" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Bank Account</span>
				<input class="input100" type="text" pattern="[\d-]+" name="bank" placeholder="BSB-Account Number" value="<?php echo $bank ?>">
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Residential Address</span>
				<input class="input100" type="text" name="address" placeholder="[Unit]/[No.], [Street], [Suburb] [Postcode]" value="<?php echo $address ?>" required>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">TFN</span>
				<input class="input100" type="number" name="tfn" placeholder="Enter TFN" min="11111111" max="999999999" value="<?php echo $tfn ?>">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">ABN</span>
				<input class="input100" type="number" name="abn" placeholder="Enter ABN" min="11111111111" max="99999999999" value="<?php echo $abn ?>">
			</div> 
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Visa Status</span><br>
				<select class="js-select2" name="visa">
					<option value="0" <?php echo ($visa == '0' ? 'selected' : ''); ?>>Citizen</option>
					<option value="1" <?php echo ($visa == '1' ? 'selected' : ''); ?>>Permanent Residency</option>
					<option value="2" <?php echo ($visa == '2' ? 'selected' : ''); ?>>Temporary Residency</option>
					<option value="3" <?php echo ($visa == '3' ? 'selected' : ''); ?> >Student Visa</option>
				</select>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Licence Type</span><br>
				<select class="js-select2" name="licence">
					<option value="0" <?php echo ($licence == '0' ? 'selected' : ''); ?>>C</option>
					<option value="1" <?php echo ($licence == '1' ? 'selected' : ''); ?>>LR</option>
					<option value="2" <?php echo ($licence == '2' ? 'selected' : ''); ?>>MR</option>
					<option value="3" <?php echo ($licence == '3' ? 'selected' : ''); ?>>HR</option>
					<option value="4" <?php echo ($licence == '4' ? 'selected' : ''); ?>>HC</option>
					<option value="5" <?php echo ($licence == '5' ? 'selected' : ''); ?>>MC</option>
					<option value="6"<?php echo ($licence == '6' ? 'selected' : ''); ?>>No licence</option>
				</select>
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Join Date</span><br>
				<input class="input100" type="date" name="joindate" value="<?php echo $joindate ?>">
			</div>
			
			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Experience Status</span><br>
				<select class="js-select2" name="experience">
					<option value="0" <?php echo ($experience == '0' ? 'selected' : ''); ?>>Beginner</option>
					<option value="1" <?php echo ($experience == '1' ? 'selected' : ''); ?>>Medium</option>
					<option value="2" <?php echo ($experience == '2' ? 'selected' : ''); ?>>Advance</option>
				</select>
			</div>
			

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Role</span><br>
				<select class="js-select2" name="role">
					<option value="0" <?php echo ($role == '0' ? 'selected' : ''); ?>>Admin</option>
					<option value="1" <?php echo ($role == '1' ? 'selected' : ''); ?>>Removalist</option>
				</select>
			</div>

			<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
				<span class="label-input100">Employee Status</span><br>
				<select class="js-select2" name="status">
					<option value="0" <?php echo ($status == '0' ? 'selected' : ''); ?>>Active</option>
					<option value="1" <?php echo ($status == '1' ? 'selected' : ''); ?>>Inactive</option>
					<option value="2" <?php echo ($status == '2' ? 'selected' : ''); ?>>Archive</option><br>
				</select>
			</div> 

			<div class="container-contact100-form-btn" style="text-align: center;">
				<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=employees-list'" style="width: 250px;">
				<button type = "submit" name = "update" class = "contact100-form-btn" style="width: 250px;">Update Employee</button>
			</div>
		</form> 
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		document.getElementById("employeeList").innerHTML = "";
	}
</script>
</html>