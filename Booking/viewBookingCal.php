<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	<script>

		//On-load + click-to-load functions for Full Calendar
		$(document).ready(function() {
			var calendar = $('#calendar').fullCalendar({
				editable:true,
				header:{
					left:'prev,next today',
					center:'title',
					right:'month,agendaWeek,agendaDay'
				},
				events: {
					url: ajaxurl,
					method: 'POST',
					data: {
						action: 'cal_load_event'
					}
				},
				selectable:true,
				editable: false,
				selectHelper:true,

				eventClick:function(event){
					var id = event.id;
					showCal();
					pushID(id);
				},
			});
		});
	</script>
</head>

<body id="bookingCalendar">
	<div class="container">
		<input type="button" class = "contact100-form-btn" value="Add New Booking" onclick="window.location.href='admin.php?page=booking-new'" style="width: 15%;  background:#0073aa;"><br><br>
		<div id="calendar"></div>
	</div>
</body>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	<?php
	$dir = ABSPATH . 'wp-content/plugins/ie-crm';
	include($dir . '/CSS/cssMain.css');
	include($dir . '/CSS/cssCalEdit.css');
	?>
</style>

<div id="calBox" class="modal container-contact100 wrap-contact100">
	<form method = "post" action = "">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content contact100-form validate-form wrap-input100">

				<div class="closecontainer">
					<span class="closebtn" onclick="closeCal();">&times;</span>
				</div>

				<span class="contact100-form-title modal-header">Booking Details</span>

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">ID</span>
					<p class="input100 p1" name="ID" id="ID"></p><br>
				</div>

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Name</span>
					<p class="input100 p1" name="name" id="name"></p><br>
				</div>

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Customer Phone Number</span>
					<p class="input100 p1" name="phone" id="phone"></p><br>
				</div>			

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Start Date/Time</span>
					<p class="input100 p1" name="dateTime" id="dateTime"></p><br>
				</div>	
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Pick Up Address</span>
					<p class="input100 p1" name="addressStart" id="addressStart"></p><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Hourly Rate</span>
					<p class="input100 p1" name="rate" id="rate"></p><br>
				</div>
				
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Notes</span>
					<p class="input100 p1" name="generalNotes" id="generalNotes"></p><br>
				</div>

				<div class="container-contact100-form-btn">
					<input type="button" class = "contact100-form-btn" value="View/Edit" onclick="window.location.href='admin.php?page=booking-list&Edit=' + returnVal();">
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

// Retrieve ID info
function pushID(idInit) {
	document.getElementById("ID").innerHTML = idInit;
	var data = [];

	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: {
			action: 'cal_edit_event',
			id: idInit
		},
		success:function(results) {
			for(var i in results) {  
				document.getElementById("name").innerHTML = results[i].name;
				document.getElementById("phone").innerHTML = results[i].phone;
				document.getElementById("dateTime").innerHTML = new Date(results[i].start);
				document.getElementById("addressStart").innerHTML = results[i].addressStart;
				document.getElementById("rate").innerHTML = results[i].rate;
				document.getElementById("generalNotes").innerHTML = results[i].generalNotes;
			}
		}});
}

//Insert ID
function returnVal() {
	return document.getElementById("ID").innerHTML;
}

//Close using 'X'
function closeCal(){
	document.getElementById("calBox").style.display = "none";
}
</script>
</html>