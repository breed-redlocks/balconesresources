<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Research Manager";
	
	// ICON IMAGE ON DASHBOARD
	$icon = 'research.png';
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'research';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Research';

	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';
	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Research';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Research';
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
	
	$items[1]['name'] 		= 'title';
	$items[1]['type'] 		= 'text';
	$items[1]['lable'] 		= 'Title';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '400px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'mediaPath1';
	$items[2]['type'] 		= 'file';
	$items[2]['lable'] 		= 'Pdf Upload';
	$items[2]['display'] 	= 'no';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';

	$items[5]['name'] 		= 'practiceAreas';
	$items[5]['type'] 		= 'profileSelect';
	$items[5]['multiple']	= 'yes';
	$items[5]['dataTable']	= 'practiceareas';
	$items[5]['lable'] 		= 'Associated Practice Areas';
	$items[5]['display'] 	= 'yes';
	$items[5]['displayWidth'] = '150px';
	$items[5]['displayWordLimit'] 	= '0';
	$items[5]['edit'] 		= 'yes';
	
	$items[4]['name'] 				= 'sortBy';
	$items[4]['type'] 				= 'text';
	$items[4]['lable'] 				= 'Order';
	$items[4]['display'] 			= 'yes';
	$items[4]['displayWidth'] 		= '50px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 				= 'yes';
	
?>
