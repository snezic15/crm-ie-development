<!DOCTYPE html>
<?php

//Same for 'Edit'
if (isset($_GET['Edit'])){
	editEnquiry($_GET['Edit']);
}

// Checks BulkActions to see current value (designed for additonal values if needed)
if (isset($_POST['bulkActions'])){
	$temp = $_POST['bulkActions'];

	switch ($temp) {
		case "StatusBulk":
		statusBulk();
		break;

		case "DeleteBulk":
		deleteBulk();
		break;

		case "Default":
		errorHandling();
		break;
	}
}

//Includes edit enquiry data
function editEnquiry($res) {
	include 'editEnquiry.php';
}

//Handles erorrs in selection
function errorHandling() {
	$message = "No action selected";
	echo "<script type='text/javascript'>alert('$message');</script>";
}

//Bulk delete function, small enough to keep here
function deleteBulk() {
	if(!empty($_POST['check'])){
		foreach ($_POST['check'] as $checkbox) {
			require_once("connection.php");

			$query = "DELETE FROM wp_iecrm_enquiries WHERE ID ='".$checkbox."'";
			$result = mysqli_query($con, $query);
		}
		
		$message = "Enquiries Deleted";
	    echo "<script type='text/javascript'>alert('$message');</script>";
	}

	else {
		$message = "No values selected";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
}

//Bulk status update function, flips current status value. Still small enough to keep here
function statusBulk() {
	if(!empty($_POST['check'])){
		foreach ($_POST['check'] as $checkbox) {
			require_once("connection.php");

			$query = "UPDATE wp_iecrm_enquiries SET confirmed=1 WHERE ID='".$checkbox."'";
			$result = mysqli_query($con,$query);
		}
		
		$message = "Status Updated";
	    echo "<script type='text/javascript'>alert('$message');</script>";
	}

	else {
		$message = "No values selected";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
}
?>

<html>
<style>
	<?php 
	$dir = ABSPATH . 'wp-content/plugins/ie-crm';
	include($dir . '/CSS/cssMain.css');
	include($dir . '/CSS/cssListMain.css');
	?>
</style>

<!-- Table Wrapper and Columns -->
<div class="wrap" id="enquiryList">
	<form action="#" method="post">
		<span class="contact100-form-title">Enquiry List</span>
		<div class="container-table100">
			<div class="wrap-table100">
				<input type="button" class = "contact100-form-btn2" value="Add New Enquiry" id="btn1" onclick="window.location.href='admin.php?page=enquiry-new'" style="width: 15%;">
				<div style="float: right;">
					<input type="button" class = "contact100-form-btn" value="Search" onclick="window.location.href='admin.php?page=enquiry-list' + inputCheck();">
				</div>
				<div style="float: right;">
					<input type="text" class="input100" placeholder="Search by Name" id="searchVal" value="" style="height: 50px;">
				</div><br><br>

				<div class="table100 ver1 m-b-110">
					<table data-vertable="ver1">
						<thead>
							<tr class="row100 head">
								<th class="column100 column2" data-column="column2" style="border-radius: 25px 0px 0px 0px;"><input type="checkbox" onclick="toggleAll(this)" name="selectAll" style="background-color: #d1d1d1;"/></th>
								<th class="column100 column3" data-column="column3"> <a href = "admin.php?page=enquiry-list&Val=name<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">NAME</a></th>
								<th class="column100 column4" data-column="column4"> <a href = "admin.php?page=enquiry-list&Val=date<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">DATE REQUESTED</a></th>
								<th class="column100 column5" data-column="column5"> <a href = "admin.php?page=enquiry-list&Val=dateSubmit<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">DATE SUBMITTED</a></th>
								<th class="column100 column6" data-column="column6"> <a href = "admin.php?page=enquiry-list&Val=movingFrom<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING FROM</a></th>
								<th class="column100 column7" data-column="column7"> <a href = "admin.php?page=enquiry-list&Val=movingTo<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING TO</a></th>
								<th class="column100 column8" data-column="column8"> <a href = "admin.php?page=enquiry-list&Val=confirmed<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">STATUS</a></th>
								<th class="column100 column9" data-column="column9" style="border-radius: 0px 25px 0px 0px;">VIEW/EDIT</th>
							</tr> 
						</thead>

						<?php
						//PHP shiz to set sort-by values and current page of results (default atm = date newest to oldest)
						$orderBy = array('name', 'date', 'dateSubmit', 'movingFrom', 'movingTo', 'confirmed');
						$limitMin = 0;
						$limitMax = 10;
						$limFinal = ' LIMIT '.$limitMin.','.$limitMax;
						$order = 'dateSubmit';

						if (isset($_GET['Val']) && in_array($_GET['Val'], $orderBy)) {
							$order = $_GET['Val'];
						}

						if (isset($_GET['Asc'])) {
							$limitMin = $_GET['Asc'];
							$limFinal = ' LIMIT '.$limitMin.','.$limitMax;
						}

						//New Search function shiz!
						if (isset($_GET['Search'])) {
							//Checks URL for 'Search', stores data from URL as input for SQL Query
							$search = $_GET['Search'];
				   			//Stops stupid characters getting through
							$search = preg_replace("#[^0-9a-z]#i", "", $search);

				    		//Modification of generic query. May merge into one, but depends on client (if more search fields requested, easier to have seperate prompt)
							$query = "SELECT * FROM wp_iecrm_enquiries WHERE name LIKE '%$search%' ORDER BY ".$order." Desc".$limFinal;
						}

						else {
							//Generic query
							$query = 'SELECT * FROM wp_iecrm_enquiries ORDER BY '.$order.' Desc'.$limFinal;
						}

						global $wpdb;
						$result = $wpdb->get_results($query);

						foreach ( $result as $print ) {  
							//Changes the formatting of the date for increased usability (good to see we learnt something from that unit lol)  
							$newDateRequest = date("d-m-Y", strtotime($print->date));
							$newDateSubmit = date("d-m-Y", strtotime($print->dateSubmit));
							?> 
							<!-- Inserting rows into table -->
							<tbody>
								<tr class="row100">
									<td class="column100 column2" data-column="column2"><input type="checkbox" class="rowCheckbox" id="checkItem" name="check[]" value="<?php echo $print->ID ?>" style="background-color: #d1d1d1;"/></td>
									<td class="column100 column3" data-column="column3"> <?php echo $print->name; ?> </td>
									<td class="column100 column4" data-column="column4"> <?php echo $newDateRequest; ?> </td>
									<td class="column100 column5" data-column="column5"> <?php echo $newDateSubmit; ?> </td>
									<td class="column100 column6" data-column="column6"> <?php echo $print->movingFrom; ?> </td>
									<td class="column100 column7" data-column="column7"> <?php echo $print->movingTo; ?> </td>
									<td class="column100 column8" data-column="column8" style="color: <?php echo ($print->confirmed == '2' ? 'green' : ''); ?><?php echo ($print->confirmed == '1' ? 'orange' : ''); ?><?php echo ($print->confirmed == '0' ? 'red' : ''); ?>"> <?php echo ($print->confirmed == '0' ? 'Follow-Up' : ''); ?> <?php echo ($print->confirmed == '1' ? 'Quote Provided' : ''); ?> <?php echo ($print->confirmed == '2' ? 'Booking Created' : ''); ?> <?php echo ($print->confirmed == '3' ? 'Lost' : ''); ?></td>
									<td class="column100 column9" data-column="column9"><input type="button" class = "contact100-form-btn" value="View/Edit" onclick="window.location.href='admin.php?page=enquiry-list&Edit=<?php echo $print->ID; ?>'"></td>
									</tr>
									<!-- Honeslty the fact that the next two lines even need to exist gives me coniptions -->
								<?php }
								?>
							</tbody>
						</table>
					</div><br>
					
					<div style="float: left;">
						<!-- Bulk actions and submit stuff -->
						<label for="bulkActions" class="label-input100">Bulk Actions: </label>
						<select name="bulkActions" class="js-select2">
							<option value="Default" selected>Choose an Action</option>
							<option value="DeleteBulk">Delete</option>
							<option value="StatusBulk">Mark as 'Quote Provided'</option>
						</select>

						<input type="submit" onclick="return confirm('Are you sure you want to apply this action?');" name="BulkStatus" class = "contact100-form-btn" value="Apply" style="width: auto; background:#0073aa;">
					</div>

					<!-- Lots of words, basically goes forwards and backwards a page. Also makes sure it doesn't go backwards further than 0 (for obvious reasons) -->
					<div style="float: right;">
						<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=enquiry-list<?php echo (isset($_GET['Val']) ? "&Val=".$_GET['Val']: ''); ?><?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>&Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] - 10: 0); ?>'" style="width: 100px;">
						<input type="button" class = "contact100-form-btn" value="Next" onclick="window.location.href='admin.php?page=enquiry-list<?php echo (isset($_GET['Val']) ? "&Val=".$_GET['Val']: ''); ?><?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>&Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] + 10: 10); ?>'" style="width: 100px;">
					</div>
				</div>
			</div>
		</form>
	</div>

	<script>
	//Toggles checkboxes
	function toggleAll(elem) {
		var isChecked = elem.checked;
		var rowCheckboxes = document.getElementsByClassName("rowCheckbox");
		for(var i = 0; i < rowCheckboxes.length; i++) {
			var currentCheckbox = rowCheckboxes[i];
			currentCheckbox.checked = isChecked;
		}
	}

	//Checks search input (tenary condition doesn't work unfortunately)
	function inputCheck() {
		if (document.getElementById('searchVal').value != "") {
			var temp = '&Search=' + document.getElementById('searchVal').value;
			return temp;
		}

		else {
			alert ("Not A Valid Search");
			return "";
		}
	}
</script>	
</html>