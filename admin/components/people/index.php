<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Profile Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'people';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Profile';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Profile';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Profiles';
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
	$items[1]['lable'] 		= 'First Name';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '120px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'lastName';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Last Name';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '120px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'title';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Title';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '150px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
/*
	$items[4]['name'] 		= 'intro';
	$items[4]['type'] 		= 'textarea';
	$items[4]['lable'] 		= 'Bio Intro';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '200px';
	$items[4]['displayWordLimit'] 	= '20';
	$items[4]['edit'] 		= 'yes';
*/
	$items[5]['name'] 		= 'info';
	$items[5]['type'] 		= 'textarea';
	$items[5]['lable'] 		= 'Bio';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '200px';
	$items[5]['displayWordLimit'] 	= '20';
	$items[5]['edit'] 		= 'yes';		
	
	$items[6]['name'] 		= 'mediaTitle1';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'Main Graphic Title';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '150px';
	$items[6]['displayWordLimit'] 	= '0';
	$items[6]['edit'] 		= 'yes';

	$items[7]['name'] 		= 'mediaPath1';
	$items[7]['type'] 		= 'file';
	$items[7]['lable'] 		= 'Main Graphic Upload';
	$items[7]['display'] 	= 'no';
	$items[7]['displayWidth'] = '150px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
/*	
	$items[8]['name'] 		= 'twitter_username';
	$items[8]['type'] 		= 'text';
	$items[8]['lable'] 		= 'Twitter Username';
	$items[8]['display'] 	= 'yes';
	$items[8]['displayWidth'] = '150px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';
	
	$items[9]['name'] 		= 'twitter_homepage';
	$items[9]['type'] 		= 'selectYN';
	$items[9]['lable'] 		= 'Display Twitter on Homepage';
	$items[9]['display'] 	= 'yes';
	$items[9]['displayWidth'] = '150px';
	$items[9]['displayWordLimit'] 	= '0';
	$items[9]['edit'] 		= 'yes';
	
	$items[10]['name'] 		= 'telephone';
	$items[10]['type'] 		= 'text';
	$items[10]['lable'] 		= 'Telephone';
	$items[10]['display'] 	= 'no';
	$items[10]['displayWidth'] = '150px';
	$items[10]['displayWordLimit'] 	= '0';
	$items[10]['edit'] 		= 'yes';
	
	$items[11]['name'] 		= 'email';
	$items[11]['type'] 		= 'text';
	$items[11]['lable'] 		= 'Email';
	$items[11]['display'] 	= 'no';
	$items[11]['displayWidth'] = '150px';
	$items[11]['displayWordLimit'] 	= '0';
	$items[11]['edit'] 		= 'yes';
*/	
	$items[12]['name'] 		= 'displayProfile';
	$items[12]['type'] 		= 'selectYN';
	$items[12]['lable'] 		= 'Display Profile';
	$items[12]['display'] 	= 'yes';
	$items[12]['displayWidth'] = '150px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 		= 'yes';
		
	$items[13]['name'] 				= 'sortBy';
	$items[13]['type'] 				= 'text';
	$items[13]['lable'] 			= 'Order';
	$items[13]['display'] 			= 'yes';
	$items[13]['displayWidth'] 		= '30px';
	$items[13]['displayWordLimit'] 	= '0';
	$items[13]['edit'] 				= 'yes';


?>
