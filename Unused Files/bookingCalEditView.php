<?php
//Query row
$query = "SELECT * FROM wp_iecrm_enquiries WHERE ID='".$ID."'";
$result = mysqli_query($con, $query);
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
				<h3>Booking Details </h3>
			</div>
			
			<div class="modal-body">
				<h4>ID</h4><br>
				<h4 id="testID"></h4><br>
				<h4>Name</h4><br>
				<h4></h4><br>

				<h4>Phone</h4><br>
				<h4></h4><br>

				<h4>Date/Time</h4><br>
				<h4></h4><br>

				<h4>Date/Time</h4><br>
				<h4></h4>
			</div>
		</div>
	</div> 
</div>
</form>

<script>
//Open enquiry calc
function showCal(){
	document.getElementById("calBox").style.display = "block";
	alert(id);
}

//Close using 'X'
function closeCal(){
	document.getElementById("calBox").style.display = "none";
}
</script>
</html>