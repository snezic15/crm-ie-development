<!DOCTYPE html>
<?php
global $current_user; wp_get_current_user();
require_once("connection.php");

//Query row
$query = "SELECT * FROM wp_iecrm_customers WHERE email='".$current_user->user_email."'";
$result = mysqli_query($con, $query);

//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$ID = $row['ID'];
	$name = $row['name'];
	$phone = $row['phone'];
	$ieemail = $row['email'];
	$address = $row['address'];
	$companyName = $row['companyName'];
	$abn = $row['abn'];
	$businessType = $row['businessType'];
}

//If update button is pressed
if (array_key_exists('update', $_POST)) {
	require_once("connection.php");

//Take new data and store/override (idk how php works) variables
	$name = $_POST['iename'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$companyName = $_POST['companyName'];
	$abn = $_POST['abn'];
	$businessType = $_POST['businessType'];
	$password = $_POST['password'];
	
       //Update query setting all variables using ID from above 'isset($_GET)'
	$query = "UPDATE wp_iecrm_customers SET name='".$name."', phone='".$phone."', address='".$address."', companyName='".$companyName."', abn='".$abn."', businessType='".$businessType."' WHERE ID='".$ID."'";

        //Check to see if new password
	if($password === "") {
		$user = wp_update_user([
			'ID' => $current_user->ID,
			'user_login' => $ieemail,
			'user_email' => $ieemail,
			'display_name' => $_POST[ 'iename' ]
		]);
	}

	else {
		$user = wp_update_user([
			'ID' => $current_user->ID,
			'user_login' => $ieemail,
			'user_email' => $ieemail,
			'user_pass' => $password,
			'display_name' => $_POST[ 'iename' ]
		]);
	}
	
	//Check to see if database insertion was successful
	if (!mysqli_query($con,$query)) {
		?>
		<div id = "failInsertUpdate" class = "error settings-error notice is-dismissible"><strong>An Error Has Occured!</strong></div>
		<?php
	}

	else {
		?>
		<div id = "successInsertUpdate" class = "updated settings-error notice is-dismissible"><strong>Account Updated!</strong></div>
		<?php
	}
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
			<span class="contact100-form-title">Edit Profile</span>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Customer NAME</span>
				<input class="input100" type="text" name="iename" placeholder="Enter Customer Name" required value="<?php echo $name ?>">
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">Phone Number</span>
				<input class="input100" type="tel" name="phone" placeholder="(04)12345678" pattern="[0-9]{10}" required value="<?php echo $phone ?>">
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Email Address</span>
				<input class="input100" type="text" name="ieemail" placeholder="email@provider.com" required value="<?php echo $ieemail ?>" disabled>
			</div>

			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Company Address</span>
				<input class="input100" type="text" name="address" placeholder="Property address" required value="<?php echo $address ?>">
			</div>

			<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
				<span class="label-input100">Company NAME</span>
				<input class="input100" type="text" name="companyName" placeholder="Enter Company Name" value="<?php echo $companyName ?>">
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">ABN</span>
				<input class="input100" type="number" id = "abn" name = "abn" placeholder="Enter ABN number" min="11111111111" max="99999999999" value="<?php echo $abn ?>" disabled>
			</div>
			
			<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Type of Business</span>
				<input class="input100" type="text" name="businessType" placeholder="Business Type" value="<?php echo $businessType ?>">
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100">
				<span class="label-input100">New Password</span>
				<input class="input100" type="password" id = "password" name="password" placeholder="Enter new password">
			</div>

			<div class="wrap-input100 bg1 rs1-wrap-input100" style="text-align: center;">
				<input type="button" class="contact100-form-btn" onclick="randPass();" value="Generate Password" style="text-align: center !important;">
				<br><br><span>Show Password</span>
				<input type="checkbox" onclick="passwordToggle();">
			</div>

			<div class="container-contact100-form-btn">
				<button type = "submit" name = "update" class="contact100-form-btn">
					<span>Submit</span>
				</button>
			</div>
		</form> 
	</div>
</div>

<script type="text/javascript">
    //Password visibility 
    function passwordToggle() {
    	var x = document.getElementById("password");
    	if (x.type === "password") {
    		x.type = "text";
    	} else {
    		x.type = "password";
    	}
    }
    //function to generate random password
    function randPass()
    {
    	var chars = "ABCDEFGHIKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz0123456789!@#$%^&*";
    	var passwordLength = 16;
    	var password = "";

    	for(var i=0;i<passwordLength;i++){
    		var randomNumber = Math.floor(Math.random()*chars.length);
    		password+= chars.substring(randomNumber,randomNumber+1);
    	}
            //set value of element to password by ID
            document.getElementById("password").value = password;
            
        }
    </script>