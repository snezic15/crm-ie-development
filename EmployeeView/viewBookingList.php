<!DOCTYPE html>
<?php
//Same for 'Edit'
if (isset($_GET['Edit'])){
	editBooking($_GET['Edit']);
}

//Includes edit enquiry data
function editBooking($res) {
	include 'editBooking.php';
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
<div class="wrap" id="bookingList">
	<form action="#" method="post">
		<span class="contact100-form-title">Booking List</span>
		<div class="container-table100">
			<div class="wrap-table100">
				<div style="float: right;">
					<input type="button" class = "contact100-form-btn" value="Search" onclick="window.location.href='admin.php?page=booking-list-employee' + inputCheck();">
				</div>
				<div style="float: right;">
					<input type="text" class="input100" placeholder="Search by Name" id="searchVal" value="" style="height: 50px;">
				</div><br><br>

				<div class="table100 ver1 m-b-110">
					<table data-vertable="ver1">
						<thead>
							<tr class="row100 head">
								<th class="column100 column3" data-column="column3"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=id<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">ID</a></th>
								<th class="column100 column4" data-column="column4"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=name<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">NAME</a></th>
								<th class="column100 column5" data-column="column5"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=start_event<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">START DATE/TIME</a></th>
								<th class="column100 column6" data-column="column6"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=addressStart<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING FROM</a></th>
								<th class="column100 column7" data-column="column7"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=addressEnd<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">MOVING TO</a></th>
								<th class="column100 column8" data-column="column8"><a class = "orderByValue" href = "admin.php?page=booking-list-employee&Val=status<?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>">STATUS</a></th>
								<th class="column100 column9" data-column="column9" style="border-radius: 0px 25px 0px 0px;">VIEW</th>
							</tr> 
						</thead>

						<?php
						//PHP shiz to set sort-by values and current page of results (default atm = date newest to oldest)
						$orderBy = array('id', 'name', 'start_event', 'addressStart', 'addressEnd', 'status');
						$limitMin = 0;
						$limitMax = 10;
						$limFinal = ' LIMIT '.$limitMin.','.$limitMax;
						$order = 'id';

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
							$query = "SELECT * FROM wp_iecrm_bookingCal WHERE name LIKE '%$search%' AND status != 3 ORDER BY ".$order." Desc".$limFinal;
						}

						else {
							//Generic query
							$query = 'SELECT * FROM wp_iecrm_bookingCal WHERE status != 3 ORDER BY '.$order.' Desc'.$limFinal;
						}

						global $wpdb;
						$result = $wpdb->get_results($query);

						foreach ( $result as $print ) {  
							//Changes the formatting of the date for increased usability (good to see we learnt something from that unit lol)  
							$newDate = date("d-m-Y H:m", strtotime($print->start_event));
							?> 
							<!-- Inserting rows into table -->
							<tbody>
								<tr class="row100">
									<td class="column100 column3" data-column="column3"> <?php echo $print->id; ?> </td>
									<td class="column100 column4" data-column="column4"> <?php echo $print->name; ?> </td>
									<td class="column100 column5" data-column="column5"> <?php echo $newDate; ?> </td>
									<td class="column100 column6" data-column="column6"> <?php echo $print->addressStart; ?> </td>
									<td class="column100 column7" data-column="column7"> <?php echo $print->addressEnd; ?> </td>
									<td class="column100 column8" data-column="column8"> <?php echo ($print->status == '0' ? 'Requires Approval' : ''); ?> <?php echo ($print->status == '1' ? 'Pending' : ''); ?> <?php echo ($print->status == '2' ? 'Job Complete' : ''); ?></td>
									<td class="column100 column9" data-column="column9"><input type="button" class = "contact100-form-btn" value="View" onclick="window.location.href='admin.php?page=booking-list-employee&Edit=<?php echo $print->id; ?>'"></td>
								</tr>
								<!-- Honeslty the fact that the next two lines even need to exist gives me coniptions -->
							<?php }
							?>
						</tbody>
					</table>
					</div><br>

					<!-- Lots of words, basically goes forwards and backwards a page. Also makes sure it doesn't go backwards further than 0 (for obvious reasons) -->
					<div style="float: right;">
						<input type="button" class = "contact100-form-btn" value="Back" onclick="window.location.href='admin.php?page=booking-list-employee<?php echo (isset($_GET['Val']) ? "&Val=".$_GET['Val']: ''); ?><?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>&Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] - 10: 0); ?>'" style="width: 100px;">
						<input type="button" class = "contact100-form-btn" value="Next" onclick="window.location.href='admin.php?page=booking-list-employee<?php echo (isset($_GET['Val']) ? "&Val=".$_GET['Val']: ''); ?><?php echo (isset($_GET['Search']) ? "&Search=".$_GET['Search']: ''); ?>&Asc=<?php echo (isset($_GET['Asc']) && $_GET['Asc'] > 0 ? $_GET['Asc'] + 10: 10); ?>'" style="width: 100px;">
					</div>
				</div>
			</div>
		</form>
	</div>

	<script>
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