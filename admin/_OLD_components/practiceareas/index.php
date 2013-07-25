<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Practice Areas";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'practiceareas';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Practice Area';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Practice Area';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Practice Areas';
	$subnav[1]['action'] = '';
	
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
	$items[1]['displayWidth'] = '120px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'twitter_username';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Twitter Username';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';

	$items[3]['name'] 		= 'intro';
	$items[3]['type'] 		= 'textarea';
	$items[3]['lable'] 		= 'Intro Text';
	$items[3]['display'] 	= 'no';
	$items[3]['displayWidth'] = '200px';
	$items[3]['displayWordLimit'] 	= '20';
	$items[3]['edit'] 		= 'yes';

	$items[4]['name'] 		= 'info';
	$items[4]['type'] 		= 'textarea';
	$items[4]['lable'] 		= 'More Text';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '200px';
	$items[4]['displayWordLimit'] 	= '20';
	$items[4]['edit'] 		= 'yes';		
	
	$items[5]['name'] 		= 'teammembers';
	$items[5]['type'] 		= 'profileSelect';
	$items[5]['multiple']	= 'yes';
	$items[5]['dataTable']	= 'people';
	$items[5]['lable'] 		= 'Team Members';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '150px';
	$items[5]['displayWordLimit'] 	= '0';
	$items[5]['edit'] 		= 'yes';
	
	$items[6]['name'] 		= 'slug';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'URL';
	$items[6]['display'] 	= 'yes';
	$items[6]['displayWidth'] = '150px';
	$items[6]['displayWordLimit'] 	= '0';
	$items[6]['edit'] 		= 'yes';
		
	$items[12]['name'] 				= 'sortBy';
	$items[12]['type'] 				= 'text';
	$items[12]['lable'] 			= 'Order';
	$items[12]['display'] 			= 'yes';
	$items[12]['displayWidth'] 		= '30px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 				= 'yes';


?>
