<?php

//Initial variable value to stop crash
$finalCalc = 0;

if (array_key_exists('submit_enquiry_calc', $_POST)) {
	//Page Variables
	$bulkMan1 = $_POST['bulkMan1'];
	$bulkManDisc1 = $_POST['bulkManDisc1'];
	$bulkMan2 = $_POST['bulkMan2'];
	$bulkManDisc2 = $_POST['bulkManDisc2'];
	$bulkMan3 = $_POST['bulkMan3'];
	$bulkManDisc3 = $_POST['bulkManDisc3'];
	$bulkStorage = $_POST['bulkStorage'];
	$bulkPack = $_POST['bulkPack'];
	$pianoCheck = $_POST['piano'];
	$poolCheck = $_POST['pool'];
	$discount = $_POST['discount'];

	//Databse Variables
	global $wpdb;

	//Query row
	$query = "SELECT * FROM wp_iecrm_calcval";
	$result = $wpdb->get_results($query, ARRAY_A);

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

	//Calcs and Result
	$labourCalc = ($man1 * $bulkMan1) + ($man1disc * $bulkManDisc1) + ($man2 * $bulkMan2) + ($man2disc * $bulkManDisc2) + ($man3 * $bulkMan3) + ($man3disc * $bulkManDisc3);
	$storageCalc = ($storage * $bulkStorage);
	$packingCalc = ($packing * $bulkPack);
	$miscCalc = ($pianoCheck * $piano) + ($poolCheck * $pool);

	$finalCalc = $labourCalc + $storageCalc + $packingCalc + $miscCalc - $discount;
}
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	.modal{
		display: none; /* Hidden by default */
		position: fixed; 
		top: 100px;
		left:30%;
		width: 50%; /* Restricted width */
		height: auto; /* Dynamic height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		
	}
	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 3% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 90%; /* Could be more or less, depending on screen size */
	}
	
	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
	.parentContainer{
		text-align: center;
	}
</style>

<div id="calBox" class="modal">
    <form method = "post" action = "">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<span class="close" onclick="closeCal();">&times;</span>
			<div class="modal-header">
				<h3> Enquiry Calculator </h3>
			</div>
			
			<div class="modal-body">
				<h4> Labour Hire (hrs) (Base, Discounted) </h4>
				<label for = "man1">1 Man: </label>
				<select name="bulkMan1">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<select name="bulkManDisc1">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				
				<label for = "man2">2 Men: </label>
				<select name="bulkMan2">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<select name="bulkManDisc2">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				
				<label for = "man3">3 Men: </label>
				<select name="bulkMan3">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<select name="bulkManDisc3">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				
				<h4> Storage (days) </h4>
				<label for = "storage">Days: </label>
				<select name="bulkStorage">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				
				<h4> Packing/Unpacking (hrs) </h4>
				<label for = "packing">2 Men: </label>
				<select name="bulkPack">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				
				<h4> Misc Charges (each) </h4>
				<label for = "piano">Piano: </label>
				<input type="checkbox" id="piano" name="piano" value="1"><br>
				
				<label for = "pool">Pool Table: </label>
				<input type="checkbox" id="pool" name="pool" value="1"><br><br>
				
				<label for = "discount">Discount (to be deducted) </label><br>
				<textarea name="discount" cols="40">0</textarea><br>
			</div>
			
			<div class="modal-footer">
				<button type = "submit" name = "submit_enquiry_calc" class = "button button-primary">Enquiry Calculator</button>
			</div>
		</div>
	</div> 
</div>
</form>

<script>
//Open enquiry calc
function showCal(){
	document.getElementById("calBox").style.display = "block";
}

//Close using 'X'
function closeCal(){
	document.getElementById("calBox").style.display = "none";
}
</script>
</html>