<!DOCTYPE html>
<?php
global $wpdb;

//General query
$query = "SELECT * FROM wp_iecrm_calcval";
$result = $wpdb->get_results($query, ARRAY_A);

//Could be easier if all variables renamed etc. Store in array (refer to update query format). Maybe change in future to simplify, but this works and doesn't slow down much atm
$man1 = $result[0]['priceVal'];
$man1disc = $result[1]['priceVal'];
$man2 = $result[2]['priceVal'];
$man2disc = $result[3]['priceVal'];
$man3 = $result[4]['priceVal'];
$man3disc = $result[5]['priceVal'];
$storage = $result[6]['priceVal'];
$packing = $result[7]['priceVal'];
$piano = $result[8]['priceVal'];
$pool = $result[9]['priceVal'];
$boxBook = $result[10]['priceVal'];
$boxTea = $result[11]['priceVal'];
$boxPort = $result[12]['priceVal'];
$boxLarge = $result[13]['priceVal'];
$mattressSingle = $result[14]['priceVal'];
$mattressKing = $result[15]['priceVal'];
$mattressQueen = $result[16]['priceVal'];
$bubble = $result[17]['priceVal'];
$shrink = $result[18]['priceVal'];
$tape = $result[19]['priceVal'];
$mattressSingleHire = $result[20]['priceVal'];
$mattressKingHire = $result[21]['priceVal'];
$mattressQueenHire = $result[22]['priceVal'];
$sofa = $result[23]['priceVal'];

//If update button is pressed...
if (array_key_exists('update', $_POST)) {
	require_once("connection.php");

//Store att current input boxes in an array (because easier workings for below)
	$tempArray = array();

	$tempArray[] = floatval($_POST['man1']);
	$tempArray[] = floatval($_POST['man1disc']);
	$tempArray[] = floatval($_POST['man2']);
	$tempArray[] = floatval($_POST['man2disc']);
	$tempArray[] = floatval($_POST['man3']);
	$tempArray[] = floatval($_POST['man3disc']);
	$tempArray[] = floatval($_POST['storage']);
	$tempArray[] = floatval($_POST['packing']);
	$tempArray[] = floatval($_POST['piano']);
	$tempArray[] = floatval($_POST['pool']);
	$tempArray[] = floatval($_POST['boxBook']);
	$tempArray[] = floatval($_POST['boxTea']);
	$tempArray[] = floatval($_POST['boxPort']);
	$tempArray[] = floatval($_POST['boxLarge']);
	$tempArray[] = floatval($_POST['mattressSingle']);
	$tempArray[] = floatval($_POST['mattressKing']);
	$tempArray[] = floatval($_POST['mattressQueen']);
	$tempArray[] = floatval($_POST['bubble']);
	$tempArray[] = floatval($_POST['shrink']);
	$tempArray[] = floatval($_POST['tape']);
	$tempArray[] = floatval($_POST['mattressSingleHire']);
	$tempArray[] = floatval($_POST['mattressKingHire']);
	$tempArray[] = floatval($_POST['mattressQueenHire']);
	$tempArray[] = floatval($_POST['sofa']);

//Update query by pushing it 24 TIMES BECAUSE FUCK SQL AND THE INABILITY TO UPDATE MULTIPLE ROWS
	for ($i = 0; $i < count($tempArray); $i++) {
		//temp variable is safeguard because idk if I can do math operations in query
		$temp = $i + 1;
		$query = "UPDATE wp_iecrm_calcval SET priceVal='".number_format($tempArray[$i], 2)."' WHERE priceID='".$temp."'";
		$result = mysqli_query($con,$query);
	}

	//Refresh because inputs not updating 	
	mysqli_close($con);
    header('Location: '.$_SERVER['REQUEST_URI']);
}
?>
<html>
<!-- CSS Shizzzz -->
<style>
	input {
		width: 100px;
		height:25px;
	}

	button, #btn1{
		text-align:center;
		width:150px;
		height:50px;
		cursor: pointer;
	}

	form {
		font-size: 1.2em;
	}

	table {
		width:100%;
		background-color:#bcd2e8;
		border-collapse: separate !important;
	}
	
	td {
		border-style: none !important;

	}

	label{
		font-size:15px;
		font-weight:bold;
	}

	.container{
		width:100%;
		background-color:#bcd2e8;
		display:table;  
	}

	#leftbox { 
		float:left; 
		text-align:center;
		width:50%; 
		height:100%;
	}

	#rightbox{ 
		float:right; 
		text-align:center;
		width:50%; 
		height:100%;
	} 

	
</style>

<!-- HTML, same layout as addEnquiry and editEnquiry -->
<div class = "wrap">
	<h1>Enquiry Calculator</h1>
</div>

<div class = "wrap">
	<h2> View/Update Service Pricings </h2>
	
	<form method = "post" action = "">
		<div class="container" id = "boxes"> 
			<div class="container" id = "leftbox"> 
				<h3> Labour Hire ($/hr) (Base, Discounted) </h3>
				<label for = "man1">1 Man: </label>
				<input type = "number" id = "man1" name = "man1" value="<?php echo $man1 ?>">
				<input type = "number" id = "man1" name = "man1disc" value="<?php echo $man1disc ?>"><br>

				<label for = "man2">2 Men: </label>
				<input type = "number" id = "man2" name = "man2" value="<?php echo $man2 ?>">
				<input type = "number" id = "man2" name = "man2disc" value="<?php echo $man2disc ?>"><br>

				<label for = "man3">3 Men: </label>
				<input type = "number" id = "man3" name = "man3" value="<?php echo $man3 ?>">
				<input type = "number" id = "man3" name = "man3disc" value="<?php echo $man3disc ?>"><br>
				
				<h3> Storage ($/day) </h3>
				<label for = "storage">1 Day: </label>
				<input type = "number" id = "storage" name = "storage" value="<?php echo $storage ?>"><br>

				<h3> Packing and Unpacking ($/hr) </h3>
				<label for = "packing">2 Men: </label>
				<input type = "number" id = "packing" name = "packing" value="<?php echo $packing ?>"><br>

				<h3> Misc Charges ($/each) </h3>
				<label for = "piano">Piano: </label>
				<input type = "number" id = "piano" name = "piano" value="<?php echo $piano ?>"><br>

				<label for = "pool">Pool Table: </label>
				<input type = "number" id = "pool" name = "pool" value="<?php echo $pool ?>"><br>
				<br>
			</div>  

			<div class="container" id = "rightbox"> 
				<h3> Packaging Material ($/each) </h3>
				<label for = "boxBook">Box (Book/Wine): </label>
				<input type = "number" id = "boxBook" name = "boxBook" value="<?php echo $boxBook ?>"><br>

				<label for = "boxTea">Box (Tea Chest): </label>
				<input type = "number" id = "boxTea" name = "boxTea" value="<?php echo $boxTea ?>"><br>

				<label for = "boxPort">Box (Port-A-Robe): </label>
				<input type = "number" id = "boxPort" name = "boxPort" value="<?php echo $boxPort ?>"><br>
				
				<label for = "boxLarge">Box (Large): </label>
				<input type = "number" id = "boxLarge" name = "boxLarge" value="<?php echo $boxLarge ?>"><br>

				<label for = "mattress">Mattress Cover (Single, King, Queen): </label>
				<input type = "number" id = "mattress" name = "mattressSingle" value="<?php echo $mattressSingle ?>">
				<input type = "number" id = "mattress" name = "mattressKing" value="<?php echo $mattressKing ?>">
				<input type = "number" id = "mattress" name = "mattressQueen" value="<?php echo $mattressQueen ?>"><br>

				<label for = "bubble">Bubble Wrap ($/m): </label>
				<input type = "number" id = "bubble" name = "bubble" value="<?php echo $bubble ?>"><br>

				<label for = "shrink">Shrink Wrap ($/m): </label>
				<input type = "number" id = "shrink" name = "shrink" value="<?php echo $shrink ?>"><br>

				<label for = "tape">Tape: </label>
				<input type = "number" id = "tape" name = "tape" value="<?php echo $tape ?>"><br>

				<h3> Supplies Hire ($/each) </h3>
				<label for = "mattressHire">Mattress Cover (Single, King, Queen): </label>
				<input type = "number" id = "mattressHire" name = "mattressSingleHire" value="<?php echo $mattressSingleHire ?>">
				<input type = "number" id = "mattressHire" name = "mattressKingHire" value="<?php echo $mattressKingHire ?>">
				<input type = "number" id = "mattressHire" name = "mattressQueenHire" value="<?php echo $mattressQueenHire ?>"><br>

				<label for = "sofa">Sofa Cover (2/3 Seater): </label>
				<input type = "number" id = "sofa" name = "sofa" value="<?php echo $sofa ?>"><br>
				<br>
			</div> 
		</div> 

		<br>
		<input type="button" class = "button button-primary" value="Back" id="btn1" onclick="window.location.href='admin.php?page=enquiry-list'">
		<button name = "update" class = "button button-primary">Update Pricing</button>
	</form>
</div>
</html>