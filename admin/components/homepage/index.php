<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Home Page Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'homepage';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Blocks';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Blocks';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Blocks';
	$subnav[1]['action'] = '';
	
	// ITEMS MANAGED IN DATABASE
	$items[0]['name'] 				= 'id';
	$items[0]['type'] 				= 'text';
	$items[0]['lable'] 				= 'ID';
	$items[0]['display'] 			= 'yes';
	$items[0]['displayWidth'] 		= '50px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 				= 'no';
	
	$items[1]['name'] 		= 'blockTitle';
	$items[1]['type'] 		= 'text';
	$items[1]['lable'] 		= 'Block Title';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '150px';
	$items[1]['displayWordLimit'] 	= '4';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'blockcontent';
	$items[2]['type'] 		= 'textareaC';
	$items[2]['lable'] 		= 'Block Content';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '100';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 				= 'sortBy';
	$items[3]['type'] 				= 'text';
	$items[3]['lable'] 				= 'Block Position';
	$items[3]['display'] 			= 'yes';
	$items[3]['displayWidth'] 		= '50px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 				= 'yes';
	
	$items[4]['name'] 		= 'linktext';
	$items[4]['type'] 		= 'text';
	$items[4]['lable'] 		= 'Link Text';
	$items[4]['display'] 	= 'yes';
	$items[4]['displayWidth'] = '100px';
	$items[4]['displayWordLimit'] 	= '4';
	$items[4]['edit'] 		= 'yes';
	
	$items[5]['name'] 		= 'link';
	$items[5]['type'] 		= 'text';
	$items[5]['lable'] 		= 'Link';
	$items[5]['display'] 	= 'yes';
	$items[5]['displayWidth'] = '100px';
	$items[5]['displayWordLimit'] 	= '4';
	$items[5]['edit'] 		= 'yes';
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
