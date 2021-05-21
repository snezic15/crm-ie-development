<?php

/**
*Plugin Name: Monash IE CRM System
*Version: 4.01
*Description: CRM System: Enquiries, Customer Accounts, Bookings, Employees, Vehicles
**/

//Add to sidebar
add_action("admin_menu", "addMenu");

//Function to add (name, display name, user restrictions, slug, function on-click)
function addMenu() {
	if (current_user_can('staffadmin') || current_user_can('administrator')){
        //Enquiry List
		add_menu_page("CRM System", "Enquiries", "manage_options", "enquiry-list", "retrieveEnquiryEntry", "dashicons-book", "2");
		add_submenu_page("enquiry-list", "New Enquiry", "New Enquiry", "manage_options", "enquiry-new", "saveEnquiryEntry");

	//Booking List
		add_menu_page("CRM System", "Bookings", "manage_options", "booking-cal", "retrieveBookingCal", "dashicons-book-alt", "2");
		add_submenu_page("booking-cal", "Booking List", "Booking List", "manage_options", "booking-list", "retrieveBookingList");
		add_submenu_page("booking-cal", "New Booking", "New Booking", "manage_options", "booking-new", "saveBookingEntry");
		add_submenu_page("booking-cal", "Archive List", "Archive List", "manage_options", "booking-archive", "retrieveBookingArchiveList");

	//Employee Contact Book
		add_menu_page("CRM System", "Employees", "manage_options", "employees-list", "retrieveEmployeeList", "dashicons-buddicons-buddypress-logo", "2");
		add_submenu_page("employees-list", "Add Employee", "Add Employee", "manage_options", "employees-new", "addEmployee");
		add_submenu_page("employees-list", "Archive List", "Archive List", "manage_options", "employees-archive", "retrieveEmployeeArchiveList");
		
	//Vehicle List
		add_menu_page("CRM System", "Vehicles", "manage_options", "vehicle-list", "retrieveVehicleList", "", "2");
		add_submenu_page("vehicle-list", "Add Vehicle", "Add Vehicle", "manage_options", "vehicle-new", "addVehicle");
		add_submenu_page("vehicle-list", "Archive List", "Archive List", "manage_options", "vehicle-archive", "retrieveVehicleArchiveList");
		
	//Customer Contact Book
		add_menu_page("CRM System", "Customers", "manage_options", "customer-list", "retrieveCustomerList", "dashicons-admin-users", "2");
		add_submenu_page("customer-list", "Add Customer", "Add Customer", "manage_options", "customer-new", "addCustomer");
		add_submenu_page("customer-list", "Archive List", "Archive List", "manage_options", "customer-archive", "retrieveCustomerArchiveList");
		
		//Account Details
		add_menu_page("CRM System", "Edit My Account Details", "manage_options", "account-edit", "editDetails", "dashicons-buddicons-buddypress-logo", "2");
		
	}
	
	if (current_user_can('staffadmin')){
	    //Unset menu items	
	global $menu;
	unset($menu[80]); // General Options
    unset($menu[75]); // Tools
	}
	
	if (current_user_can('staffemployee')){
    //Booking List
		add_menu_page("CRM System", "Bookings", "manage_options", "booking-list-employee", "retrieveBookingListEmployee", "dashicons-book-alt", "2");

	//Account Details
		add_menu_page("CRM System", "Edit My Account Details", "manage_options", "account-edit", "editDetails", "dashicons-buddicons-buddypress-logo", "2");
	
	//Unset menu items	
	global $menu;
	unset($menu[80]); // General Options
    unset($menu[75]); // Tools
}
}

//Enquiry entry function (eventually seperate into seperate file)
function saveEnquiryEntry() {
	include 'Enquiry/addEnquiry.php';
}

//Basic database retrieval function. Links to Retieval menu entry
function retrieveEnquiryEntry() {
	include 'Enquiry/viewEnquiry.php';
}

//Add new booking (when not coming from enquiries)
function saveBookingEntry() {
	include 'Booking/addBooking.php';
}

//Calendar view for bookings
function retrieveBookingCal() {
	include 'Booking/viewBookingCal.php';
}

//List view for bookings
function retrieveBookingList() {
	include 'Booking/viewBookingList.php';
}

//List view for booking archives
function retrieveBookingArchiveList() {
	include 'Booking/viewBookingArchiveList.php';
}

//EMPLOYEE VIEW retrieve booking list
function retrieveBookingListEmployee() {
    include 'EmployeeView/viewBookingList.php';
}

//Employee list view
function retrieveEmployeeList() {
	include 'Employee/employeeList.php';
}

//Add new employee
function addEmployee() {
	include 'Employee/addEmployee.php';
}

//Employee archive list view
function retrieveEmployeeArchiveList() {
	include 'Employee/viewEmployeeArchiveList.php';
}

//Edit current user account
function editDetails() {
	include 'Employee/editDetails.php';
}

//Vehicle list view
function retrieveVehicleList() {
	include 'Vehicle/vehicleList.php';
}

//Add new vehicle
function addVehicle() {
	include 'Vehicle/addVehicle.php';
}

//Vehicle list view
function retrieveVehicleArchiveList() {
	include 'Vehicle/viewVehicleArchiveList.php';
}

//Customer list view
function retrieveCustomerList() {
	include 'Customer/customerList.php';
}

//Add new customer
function addCustomer() {
	include 'Customer/addCustomer.php';
}

//Archive list view for customer
function retrieveCustomerArchiveList() {
	include 'Customer/viewCustomerArchiveList.php';
}

//Declare actions from admin-ajax
add_action( 'wp_ajax_cal_load_event', 'cal_load_event' );
add_action( 'wp_ajax_cal_edit_event', 'cal_edit_event' );

//Calendar load/refresh
function cal_load_event() {
	$connect = new PDO();

	$data = array();
	$query = "SELECT * FROM wp_iecrm_bookingCal WHERE status != 3 ORDER BY id";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row) {
		$temp = "";
		
		switch ($row["status"]) {
			case "0":
			$temp = "#ff6666";
			break;
			
			case "1":
			$temp = "#ff8533";
			break;
			
			case "2":
			$temp = "#66ff66";
			break;
		}
		
		$data[] = array(
			'id'   => $row["id"],
			'title'   => $row["name"],
			'start'   => $row["start_event"],
			'end'   => $row["end_event"],
			'color' => $temp
		);
	}

	wp_send_json($data);
	wp_die(); 
}

//Quickview pop-up calendar (on-click)
function cal_edit_event() { 
	$connect = new PDO();
	
	$id = isset($_POST['id']) ? $_POST['id'] : "";
	$data = array();
	$query = "SELECT * FROM wp_iecrm_bookingCal WHERE id='".$id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row) {
		$data[] = array(
			'name'   => $row["name"],
			'phone'   => $row["phone"],
			'start'   => $row["start_event"],
			'addressStart'   => $row["addressStart"],
			'rate'   => $row["rate"],
			'generalNotes'   => $row["generalNotes"]
		);
	}

	wp_send_json($data);
	wp_die(); 
}