<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Tag Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'tags';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Tags';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Tag';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List all Tags';
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
	$items[1]['lable'] 		= 'Tag Name';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '150px';
	$items[1]['displayWordLimit'] 	= '100';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'slug';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Tag Slug';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '100';
	$items[2]['edit'] 		= 'yes';
/*
	$items[2]['name'] 		= 'body';
	$items[2]['type'] 		= 'textarea';
	$items[2]['lable'] 		= 'Body';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '500px';
	$items[2]['displayWordLimit'] 	= '20';
	$items[2]['edit'] 		= 'yes';
*/

?>
