<!DOCTYPE html>
<?php


global $current_user; wp_get_current_user();
require_once("connection.php");

//Get ID from 'Edit'
$ID = $_GET['Edit'];
//Query row
$query = "SELECT * FROM wp_iecrm_customers WHERE EMAIL='".$current_user->user_email."'";
$result = mysqli_query($con, $query);


//Fetch data and store into variables
while($row=mysqli_fetch_assoc($result))
{
	$name = $row['name'];
	$phone = $row['phone'];
	$email = $row['email'];
	$address = $row['address'];
	$companyName = $row['companyName'];
	$abn = $row['abn'];
}

//Check if submit button pushed
if (array_key_exists('submit_enquiry_manual', $_POST)) {
	require_once("connection.php");
    
//Take new data and store/override (idk how php works) variables
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$companyName = $_POST['companyName'];
	$abn = $_POST['abn'];
    $current_user->user_login = $_POST[ 'username' ];
    $current_user->user_email = $_POST[ 'email' ];
    $current_user->user_pass = $_POST[ 'password' ];
    $current_user->display_name = $_POST[ 'name' ];
    
	
//Checks if the query returned a result from there WHERE statement
//Else creates a new row in both databases
    if(mysqli_num_rows($result) > 0)
    {   
        //Update query setting all variables using ID from above 'isset($_GET)'
        $query = "UPDATE wp_iecrm_customers SET name='".$name."', phone='".$phone."', email='".$email."', address='".$address."', companyName='".$companyName."', abn='".$abn."' WHERE EMAIL='".$current_user->user_email."'";
    	$result = mysqli_query($con,$query);
    	mysqli_close($con);
        
        //Updates wp user
        wp_update_user( array(
            'ID' => $current_user->ID,
            'user_login' => $_POST[ 'username' ],
            'user_email' => $_POST[ 'email' ],
            'user_pass' => $_POST[ 'password' ],
            'display_name' => $_POST[ 'name' ]
        ) );   
    }
    else{
        //Insert row into database using all variables submitted
        $query = "INSERT INTO wp_iecrm_customers SET name='".$name."', phone='".$phone."', email='".$email."', address='".$address."', companyName='".$companyName."', abn='".$abn."'";
    	$result = mysqli_query($con,$query);
    	mysqli_close($con);
        
        //Creates wp user
        $user = wp_insert_user([
    	    'user_login' => $_POST[ 'username' ],
    	    'user_email' => $_POST[ 'email' ],
    	    'user_pass' => $_POST[ 'password' ],
    	    'display_name' => $_POST[ 'name' ],
    	]);  
    }
    
	//Dismissible message after successful database insertion
	?>
	<div id = "setting-error-settings-updated" class = "updated settings-error notice is-dismissible"><strong>Account Details Updated!</strong></div>
	
	<?php
}
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	
	@font-face {
  font-family: Montserrat-Regular;
  src: url('../fonts/montserrat/Montserrat-Regular.ttf'); 
}

@font-face {
  font-family: Montserrat-Bold;
  src: url('../fonts/montserrat/Montserrat-Bold.ttf'); 
}

@font-face {
  font-family: Montserrat-Black;
  src: url('../fonts/montserrat/Montserrat-Black.ttf'); 
}

@font-face {
  font-family: Montserrat-SemiBold;
  src: url('../fonts/montserrat/Montserrat-SemiBold.ttf'); 
}

@font-face {
  font-family: Montserrat-Medium;
  src: url('../fonts/montserrat/Montserrat-Medium.ttf'); 
}



/*//////////////////////////////////////////////////////////////////
[ RESTYLE TAG ]*/

* {
	margin: 0px; 
	padding: 0px; 
	box-sizing: border-box;
}

body, html {
	height: 100%;
	font-family: Poppins-Regular, sans-serif;
}

/*---------------------------------------------*/
a {
	font-family: Poppins-Regular;
	font-size: 14px;
	line-height: 1.7;
	color: #666666;
	margin: 0px;
	transition: all 0.4s;
	-webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
}

a:focus {
	outline: none !important;
}

a:hover {
	text-decoration: none;
}

/*---------------------------------------------*/
h1,h2,h3,h4,h5,h6 {
	margin: 0px;
}

p {
	font-family: Poppins-Regular;
	font-size: 14px;
	line-height: 1.7;
	color: #666666;
	margin: 0px;
}

ul, li {
	margin: 0px;
	list-style-type: none;
}


/*---------------------------------------------*/
input {
	outline: none;
	border: none;
}

input[type="number"] {
    -moz-appearance: textfield;
    appearance: none;
    -webkit-appearance: none;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

textarea {
  outline: none;
  border: none;
}

textarea:focus, input:focus {
  border-color: transparent !important;
}

input:focus::-webkit-input-placeholder { color:transparent; }
input:focus:-moz-placeholder { color:transparent; }
input:focus::-moz-placeholder { color:transparent; }
input:focus:-ms-input-placeholder { color:transparent; }

textarea:focus::-webkit-input-placeholder { color:transparent; }
textarea:focus:-moz-placeholder { color:transparent; }
textarea:focus::-moz-placeholder { color:transparent; }
textarea:focus:-ms-input-placeholder { color:transparent; }

input::-webkit-input-placeholder { color: #adadad;}
input:-moz-placeholder { color: #adadad;}
input::-moz-placeholder { color: #adadad;}
input:-ms-input-placeholder { color: #adadad;}

textarea::-webkit-input-placeholder { color: #adadad;}
textarea:-moz-placeholder { color: #adadad;}
textarea::-moz-placeholder { color: #adadad;}
textarea:-ms-input-placeholder { color: #adadad;}

/*---------------------------------------------*/
button {
	outline: none !important;
	border: none;
	background: transparent;
}

button:hover {
	cursor: pointer;
}

iframe {
	border: none !important;
}


/*---------------------------------------------*/
.container {
	max-width: 1200px;
}


/*//////////////////////////////////////////////////////////////////
[ Utility ]*/

.bg0 {background-color: #fff;}
.bg1 {background-color: #f7f7f7;}


/*//////////////////////////////////////////////////////////////////
[ Contact ]*/

.container-contact100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: #e6e6e6;
  
}

.wrap-contact100 {
  width: 920px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  padding: 62px 55px 90px 55px;
}


/*------------------------------------------------------------------
[  ]*/

.contact100-form {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.contact100-form-title {
  display: block;
  width: 100%;
  font-family: Montserrat-Black;
  font-size: 39px;
  color: #333333;
  line-height: 1.2;
  text-align: center;
  padding-bottom: 59px;
}



/*------------------------------------------------------------------
[  ]*/

.wrap-input100 {
  width: 100%;
  position: relative;
  border: 1px solid #e6e6e6;
  border-radius: 13px;
  padding: 10px 30px 9px 22px;
  margin-bottom: 20px;
}

.rs1-wrap-input100 {
  width: calc((100% - 30px) / 2);
}

.label-input100 {
  font-family: Montserrat-SemiBold;
  font-size: 10px;
  color: #393939;
  line-height: 1.5;
  text-transform: uppercase;
}

.input100 {
  display: block;
  width: 100%;
  background: transparent;
  font-family: Montserrat-SemiBold;
  font-size: 18px;
  color: #555555;
  line-height: 1.2;
  padding-right: 15px;
}


/*---------------------------------------------*/
input.input100 {
  height: 40px;
}


textarea.input100 {
  min-height: 120px;
  padding-top: 9px;
  padding-bottom: 13px;
}


.input100:focus + .focus-input100::before {
  width: 100%;
}

.has-val.input100 + .focus-input100::before {
  width: 100%;
}


/*------------------------------------------------------------------
[ Button ]*/
.container-contact100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 20px;
  width: 100%;
}

.contact100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  width: 100%;
  height: 50px;
  background-color: #333333;
  border-radius: 25px;

  font-family: Montserrat-Medium;
  font-size: 16px;
  color: #fff;
  line-height: 1.2;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn i {
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn:hover {
  background-color: #00ad5f;
}

.contact100-form-btn:hover i {
  -webkit-transform: translateX(10px);
  -moz-transform: translateX(10px);
  -ms-transform: translateX(10px);
  -o-transform: translateX(10px);
  transform: translateX(10px);
}

/*------------------------------------------------------------------
[ Responsive ]*/

@media (max-width: 768px) {
  .rs1-wrap-input100 {
    width: 100%;
  }

}

@media (max-width: 576px) {
  .wrap-contact100 {
    padding: 62px 15px 90px 15px;
  }

  .wrap-input100 {
    padding: 10px 10px 9px 10px;
  }
}



/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}

.alert-validate::before {
  content: attr(data-validate);
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  position: absolute;
  width: 100%;
  min-height: 40px;
  background-color: #f7f7f7;
  top: 35px;
  left: 0px;
  padding: 0 45px 0 22px;
  pointer-events: none;

  font-family: Montserrat-SemiBold;
  font-size: 18px;
  color: #fa4251;
  line-height: 1.2;
}

.btn-hide-validate {
  font-family: Material-Design-Iconic-Font;
  font-size: 18px;
  color: #fa4251;
  cursor: pointer;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 40px;
  height: 40px;
  top: 35px;
  right: 12px;
}

.rs1-alert-validate.alert-validate::before {
  background-color: #fff;
}

.true-validate::after {
  content: "\f26b";
  font-family: Material-Design-Iconic-Font;
  font-size: 18px;
  color: #00ad5f;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 40px;
  height: 40px;
  top: 35px;
  right: 10px;
}

/*---------------------------------------------*/
@media (max-width: 576px) {
  .alert-validate::before {
    padding: 0 10px 0 10px;
  }

  .true-validate::after,
  .btn-hide-validate {
    right: 0px;
    width: 30px;
  }
}


/*==================================================================
[ Restyle Select2 ]*/

.select2-container {
  display: block;
  max-width: 100% !important;
  width: auto !important;
}

.select2-container .select2-selection--single {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  background-color: transparent;
  border: none;
  height: 40px;
  outline: none;
  position: relative;
}

/*------------------------------------------------------------------
[ in select ]*/
.select2-container .select2-selection--single .select2-selection__rendered {
  font-family: Montserrat-SemiBold;
  font-size: 18px;
  color: #555555;
  line-height: 1.2;
  padding-left: 0px ;
  background-color: transparent;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 100%;
  top: 50%;
  transform: translateY(-50%);
  right: 0px;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.select2-selection__arrow b {
  display: none;
}

.select2-selection__arrow::before {
  content: '\f312';
  font-family: Material-Design-Iconic-Font;
  font-size: 18px;
  color: #555555;
}


/*==================================================================
[ Restyle Radio ]*/
.wrap-contact100-form-radio {
  width: 100%;
  padding: 15px 25px 0 25px;
}

.contact100-form-radio {
  padding-bottom: 5px;
}

.input-radio100 {
  display: none;
}

.label-radio100 {
  display: block;
  position: relative;
  padding-left: 28px;
  cursor: pointer;
  font-family: Montserrat-SemiBold;
  font-size: 18px;
  color: #555555;
  line-height: 1.2;
}

.label-radio100::before {
  content: "";
  display: block;
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 1px solid #cdcdcd;
  background: #fff;
  left: 0;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}

.label-radio100::after {
  content: "";
  display: block;
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 6px solid transparent;
  background: #00ad5f;
  -moz-background-clip: padding;     
  -webkit-background-clip: padding;  
  background-clip: padding-box; 
  left: 0;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  display: none;

}

.input-radio100:checked + .label-radio100::after {
  display: block;
}


/*==================================================================
[ rs NoUI ]*/
.wrap-contact100-form-range {
  width: 100%;
  padding: 20px 25px 57px 25px;
}

.contact100-form-range-value {
  font-family: Montserrat-SemiBold;
  font-size: 18px;
  color: #555555;
  line-height: 1.2;
  padding-top: 10px;
  padding-bottom: 30px;
}

.contact100-form-range-value input {
  display: none;
}

 .container #btn{
	    
        position:relative;
        cursor:pointer;
        color:#fff;
        background:#007cba;
        font-size: 1.2em;
        display: inline-block;
        height:20px;
        width:200px;
        text-align:center;
        border-radius: 6px;
    }

#filter-bar {
  height: 20px;
  border: 1px solid #e6e6e6;
  border-radius: 9px;
  background-color: #f7f7f7;
}
#filter-bar .noUi-connect {
  border: 1px solid #e6e6e6;
  border-radius: 9px;
  background-color: #00ad5f;
  box-shadow: none;
}
#filter-bar .noUi-handle {
  width: 40px;
  height: 36px;
  border: 1px solid #cccccc;
  border-radius: 9px;
  background: #f5f5f5;
  cursor: pointer;
  box-shadow: none;
  outline: none;
  top: -8px;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
}

#filter-bar .noUi-handle.noUi-handle-lower {
  left: -1px;
}

#filter-bar .noUi-handle.noUi-handle-upper {
  left: -39px;
}

#filter-bar .noUi-handle:before {
  content: "";
  display: block;
  position: unset;
  height: 12px;
  width: 9px;
  background-color: transparent;
  border-left: 2px solid #cccccc;
  border-right: 2px solid #cccccc;
}
#filter-bar .noUi-handle:after {
  display: none;
}

@media (max-width: 576px) {
  .wrap-contact100-form-range {
    padding: 20px 0px 57px 0px;
  }

  .wrap-contact100-form-radio {
    padding: 15px 0px 0 0px;
  }
}
	
</style>




<!-- HTML Kiddy Scripts -->
<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form">
				<span class="contact100-form-title">
					Edit Account Details
				</span>
				
				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" <span class="label-input100">Name *</span>
					<input class="input100" type = "text"  name = "name" value=<?php  echo $current_user->display_name; ?> required><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" <span class="label-input100">UserName *</span>
					<input class="input100" type = "text"  name = "name" value=<?php  echo $current_user->user_login; ?> required><br>
				</div>
				
				<div class="wrap-input100 bg1 rs1-wrap-input100">
					<span class="label-input100">Phone Number</span>
					<input class="input100" type = "tel" id = "phone" name = "phone"  value="<?php echo $phone ?>" pattern="[0-9]{10}" required><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Email (e@a.x)">
					<span class="label-input100">Email Address *</span>
					<input class="input100" type = "email" id = "email" name = "email" value=<?php  echo $current_user->user_email; ?> required><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1" data-validate="Property addres">
					<span class="label-input100">Residential Address *</span>
					<input class="input100" type="text" name="address"><?php echo $address ?></textarea><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Company Name</span>
					<input class="input100" type="text" name="companyName" placeholder="Enter Company Name">
				</div>
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">ABN</span>
					<input class="input100" type="text" name="abn" placeholder="Enter ABN">
				</div>
				
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Password *</span>
					<input class="input100" type="password" id = "password" name="password" placeholder="Enter password">
			
				<br><br><div id="btn" onclick="randPass();">Generate Password</div>
				<br><br><input type="checkbox" onclick="passwordToggle()">Show Password
				<br><br>
			</div>
				
	</div> 
	
	<div class="container-contact100-form-btn" id="buttonContainer">
					<button type = "submit" name = "submit_enquiry_manual" button class="contact100-form-btn">
						<span>
							Submit
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
</div>
</form>

    <script type="text/javascript">
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
            var chars = "ABCDEFGHIKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz0123456789!@#$%^&*"
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

</html>