<?php
global $current_user; wp_get_current_user();
require_once("connection.php");

if (isset($_GET['View'])){
	viewBooking($_GET['View']);
}

function viewBooking($res) {
	include 'viewBookingFront.php';
}
?>
	
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    <?php 
    	$dir = ABSPATH . 'wp-content/plugins/ie-crm';
    	include($dir . '/CSS/cssMain.css');
    	include($dir . '/CSS/cssListMain.css');
	?>
</style>

<div class="wrap" id="bookingList">
	<form action="#" method="post">
		<span class="contact100-form-title">Booking History</span>
		<div class="container-table100">
			<div class="wrap-table100">
				<input type="button" class = "contact100-form-btn" value="Add New Booking" onclick="window.location.href='/new-booking-request'" style="width: 20%;  background:#0073aa;">
				
				<div style="float: right;">
					<input type="button" class = "contact100-form-btn" value="Search" onclick="window.location.href='?' + inputCheck();">
				</div>
				
				<div style="float: right;">
					<input type="text" class="input100" placeholder="Search by Address" id="searchVal" value="" style="height: 50px;">
				</div><br><br>

				<div class="table100 ver1 m-b-110">
					<table data-vertable="ver1">
						<thead>
							<tr class="row100 head">
						    	<th class="column100 column3" data-column="column3"><a class = "orderByValue" href = "?Val=addressStart<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING FROM</a></th>
								
								<th class="column100 column4" data-column="column4"><a class = "orderByValue" href = "?Val=addressEnd<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING TO</a></th>
								
								<th class="column100 column5" data-column="column5"><a class = "orderByValue" href = "?Val=start_event<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">START DATE/TIME</a></th>
								
								<th class="column100 column6" data-column="column6"><a class = "orderByValue" href = "?Val=weight<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">WEIGHT</a></th>
								
								<th class="column100 column7" data-column="column7"><a class = "orderByValue" href = "?Val=totalPaid<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">TOTAL PAID</a></th>
								
								<th class="column100 column8" data-column="column8"><a class = "orderByValue" href = "?Val=status<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">STATUS</a></th>
								
								<th class="column100 column9" data-column="column9" style="border-radius: 0px 25px 0px 0px;">VIEW</th>
							</tr> 
						</thead>

						<?php
						//PHP shiz to set sort-by values and current page of results (default atm = date newest to oldest)
						$orderBy = array('addressStart', 'addressEnd', 'start_event', 'weight', 'totalPaid', 'status');
						$limitMin = 0;
						$limitMax = 10;
						$limFinal = ' LIMIT '.$limitMin.','.$limitMax;
						$order = 'start_event';

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
							$query = "SELECT * FROM wp_iecrm_bookingCal WHERE EMAIL='".$current_user->user_email."' AND (addressStart LIKE '%$search%' OR addressEnd LIKE '%$search%') AND status != 3 ORDER BY ".$order." Desc".$limFinal;
						}

						else {
							//Generic query
							$query = "SELECT * FROM wp_iecrm_bookingCal WHERE EMAIL='".$current_user->user_email."' AND status != 3 ORDER BY ".$order." Desc".$limFinal;
						}

						global $wpdb;
						$result = $wpdb->get_results($query);

						foreach ( $result as $print ) {  
						    $newDate = date("d-m-Y H:m", strtotime($print->start_event));
							?> 
							<!-- Inserting rows into table -->
							<tbody>
								<tr class="row100">
									<td class="column100 column3" data-column="column3"> <?php echo $print->addressStart; ?> </td>
									
									<td class="column100 column4" data-column="column4"> <?php echo $print->addressEnd; ?> </td>
									
									<td class="column100 column5" data-column="column5"> <?php echo $newDate; ?> </td>
									
									<td class="column100 column6" data-column="column6"> <?php echo ($print->weight == '0' ? 'Manpower' : ''); ?> <?php echo ($print->weight == '1' ? '2T' : ''); ?> <?php echo ($print->weight == '2' ? '4T' : ''); ?><?php echo ($print->weight == '3' ? '6T' : ''); ?><?php echo ($print->weight == '4' ? '8T' : ''); ?><?php echo ($print->weight == '5' ? '10T' : ''); ?></td>
									
									<td class="column100 column7" data-column="column7"> <?php echo $print->totalPaid; ?> </td>
									
									<td class="column100 column8" data-column="column8"> <?php echo ($print->status == '0' ? 'Requires Approval' : ''); ?> <?php echo ($print->status == '1' ? 'Pending' : ''); ?> <?php echo ($print->status == '2' ? 'Job Complete' : ''); ?></td>
									
									<td class="column100 column9" data-column="column9"><input type="button" class = "contact100-form-btn" value="View" onclick="window.location.href='?View=<?php echo $print->id; ?>'"></td>
								</tr>
							<?php }
							?>
						</tbody>
					</table>
					</div><br>

					<!-- Lots of words, basically goes forwards and backwards a page. Also makes sure it doesn't go backwards further than 0 (for obvious reasons) -->
					<div style="float: right;">
						<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='<?php echo (isset($_GET['Val']) ? "?Val=".$_GET['Val']: ''); ?>?Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] - 10: 0); ?>'" style="width:100px">
						<input type="button" class = "contact100-form-btn" value="Next" onclick="window.location.href='<?php echo (isset($_GET['Val']) ? "?Val=".$_GET['Val']: ''); ?>?Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] + 10: 10); ?>'" style="width:100px">
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
	
	function inputCheck() {
		if (document.getElementById('searchVal').value != "") {
			var temp = '?Search=' + document.getElementById('searchVal').value;
			return temp;
		}

		else {
			alert ("Not A Valid Search");
			return "";
		}
	}
</script>	
</html>