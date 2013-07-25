<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Contacts";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'contact';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Contact';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Edit';
	$subnav[0]['action'] = '';
	$subnav[1]['title'] = 'List Contacts';
	$subnav[1]['action'] = '';
	$subnav[2]['title'] = 'Export';
	$subnav[2]['action'] = 'export';
	// ITEMS MANAGED IN DATABASE
	$items[0]['name'] 				= 'id';
	$items[0]['type'] 				= 'text';
	$items[0]['lable'] 				= 'ID';
	$items[0]['display'] 			= 'yes';
	$items[0]['displayWidth'] 		= '50px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 				= 'no';
	
	$items[1]['name'] 		= 'name';
	$items[1]['type'] 		= 'text';
	$items[1]['lable'] 		= 'Name';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '200px';
	$items[1]['displayWordLimit'] 	= '4';
	$items[1]['edit'] 		= 'yes';
	
	
	
	$items[3]['name'] 		= 'phone';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Phone';
	$items[3]['display'] 	= 'no';
	$items[3]['displayWidth'] = '100px';
	$items[3]['displayWordLimit'] 	= '4';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'email';
	$items[4]['type'] 		= 'text';
	$items[4]['lable'] 		= 'Email';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '200px';
	$items[4]['displayWordLimit'] 	= '4';
	$items[4]['edit'] 		= 'yes';
	
	$items[5]['name'] 		= 'company';
	$items[5]['type'] 		= 'text';
	$items[5]['lable'] 		= 'Company';
	$items[5]['display'] 	= 'yes';
	$items[5]['displayWidth'] = '100px';
	$items[5]['displayWordLimit'] 	= '4';
	$items[5]['edit'] 		= 'yes';

	$items[6]['name'] 		= 'address';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'Address';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '100px';
	$items[6]['displayWordLimit'] 	= '4';
	$items[6]['edit'] 		= 'yes';
	
	$items[7]['name'] 		= 'state';
	$items[7]['type'] 		= 'text';
	$items[7]['lable'] 		= 'State';
	$items[7]['display'] 	= 'no';
	$items[7]['displayWidth'] = '100px';
	$items[7]['displayWordLimit'] 	= '4';
	$items[7]['edit'] 		= 'yes';
	
	$items[8]['name'] 		= 'zipcode';
	$items[8]['type'] 		= 'text';
	$items[8]['lable'] 		= 'Zipcode';
	$items[8]['display'] 	= 'yes';
	$items[8]['displayWidth'] = '100px';
	$items[8]['displayWordLimit'] 	= '4';
	$items[8]['edit'] 		= 'yes';
	
	$items[9]['name'] 		= 'contactname';
	$items[9]['type'] 		= 'text';
	$items[9]['lable'] 		= 'Contact Name';
	$items[9]['display'] 	= 'yes';
	$items[9]['displayWidth'] = '100px';
	$items[9]['displayWordLimit'] 	= '4';
	$items[9]['edit'] 		= 'yes';

	$items[10]['name'] 		= 'details';
	$items[10]['type'] 		= 'textarea';
	$items[10]['lable'] 		= 'Details';
	$items[10]['display'] 	= 'no';
	$items[10]['displayWidth'] = '400px';
	$items[10]['displayWordLimit'] 	= '10';
	$items[10]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'postDate';
	$items[2]['type'] 		= 'date';
	$items[2]['lable'] 		= 'Date';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '100px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';
	
?>
