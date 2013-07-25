<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Flash Page Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'swfs';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Flash Page';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Flash Page';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List Flash Pages';
	$subnav[1]['action'] = '';
	
	// ITEMS MANAGED IN DATABASE
	$items[0]['name'] 				= 'id';
	$items[0]['type'] 				= 'text';
	$items[0]['lable'] 				= 'ID';
	$items[0]['display'] 			= 'yes';
	$items[0]['displayWidth'] 		= '50px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 				= 'no';
	
	$items[1]['name'] 		= 'script';
	$items[1]['type'] 		= 'textarea';
	$items[1]['lable'] 		= 'Script';
	$items[1]['display'] 	= 'no';
	$items[1]['displayWidth'] = '600px';
	$items[1]['displayWordLimit'] 	= '100';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'page';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Page Link';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '300px';
	$items[2]['displayWordLimit'] 	= '100';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'sortBy';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Order';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '300px';
	$items[3]['displayWordLimit'] 	= '100';
	$items[3]['edit'] 		= 'yes';

	


?>
