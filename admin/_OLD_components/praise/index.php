<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Praise Manager";
	
	// ICON IMAGE ON DASHBOARD
	$icon = 'praise.png';
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'praise';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Praise';

	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';
	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Praise';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Praise';
	$subnav[1]['action'] = '';
	
	// ITEMS MANAGED IN DATABASE
	// ITEM WITH DATATYPES MUST MATCH IN NAME THE SUPPORTING TABLE
	$items[0]['name'] 		= 'id';
	$items[0]['type'] 		= 'text';
	$items[0]['lable'] 		= 'ID';
	$items[0]['display'] 	= 'yes';
	$items[0]['displayWidth'] = '30px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 		= 'no';
	
	$items[1]['name'] 		= 'name';
	$items[1]['type'] 		= 'text';
	$items[1]['lable'] 		= 'Name';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '130px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'mediaPath1';
	$items[2]['type'] 		= 'file';
	$items[2]['lable'] 		= 'Logo Upload';
	$items[2]['display'] 	= 'no';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';

	$items[3]['name'] 		= 'aceOnly';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Additional Clients Only';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '130px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 				= 'sortBy';
	$items[4]['type'] 				= 'text';
	$items[4]['lable'] 				= 'Order';
	$items[4]['display'] 			= 'yes';
	$items[4]['displayWidth'] 		= '50px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 				= 'yes';
	
?>
