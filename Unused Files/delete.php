<?php

$ID = $_GET['Del'];

if (array_key_exists('deleteSelected', $_POST)) {
	require_once("connection.php");

	$query = "DELETE FROM wp_iecrm_enquiries WHERE ID = '".$ID."'";

	$result = mysqli_query($con, $query);
	mysqli_close($con);
	
	?>

	<div id = "setting-error-settings-updated" class = "updated settings-error notice is-dismissible"><strong>Enquiry Deleted!</strong></div>

<script type="text/javascript">
	   document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById("ToClear").innerHTML = "";
    });
	</script>

	<div class = "wrap">
		<h2></h2>

	<input type="button" class = "button button-primary" value="Back" onclick="window.location.href='admin.php?page=enquiry-list'" style="width:100px">
	</div>
	<?php
}

if (array_key_exists('cancelSelected', $_POST)) {
	header("Refresh:0; url=admin.php?page=enquiry-list");
}

?>

<!DOCTYPE html>

<!-- CSS Shiiiieeeettt -->
<style>
	input {
		width: 270px;
	}

	form {
		font-size: 1.2em;
	}
	
	#setting-error-settings-updated{
	    padding-top:1%;
	    font-size: 20px;
	    font-weight:bold;
	    width:95.5%;
	    height:25px;
	    background-color: #90EE90;
	    
	}
</style>

<!-- HTML Kiddy Scripts -->
<div class = "wrap" id= "ToClear">
	<h1>Update Enquiry Manual</h1>

<script type="text/javascript">
    window.onload = function() {
        document.getElementById("MyDiv").innerHTML = "";
    }
</script>

<!-- Same style as addEnquiry form -->
<div class = "wrap">
	<h2> Are you sure you want to delete ID = <?php echo $ID ?>? </h2>
	<form method = "post" action = "">

		<tr>
			<th> <button name = "cancelSelected" class = "button button-primary">Cancel</button> </th>
			<th> <button name = "deleteSelected" class = "button button-primary">Delete</button> </th>
		</tr>
	</div>
</form>