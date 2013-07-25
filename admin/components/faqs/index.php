<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "FAQ Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'faqs';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'FAQ';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a FAQ';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All FAQs';
	$subnav[1]['action'] = '';
	
	// ITEMS MANAGED IN DATABASE
	$items[0]['name'] 				= 'id';
	$items[0]['type'] 				= 'text';
	$items[0]['lable'] 				= 'ID';
	$items[0]['display'] 			= 'yes';
	$items[0]['displayWidth'] 		= '50px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 				= 'no';
	
	$items[1]['name'] 				= 'question';
	$items[1]['type'] 				= 'text';
	$items[1]['lable'] 				= 'Question';
	$items[1]['display'] 			= 'yes';
	$items[1]['displayWidth']	 	= '350px';
	$items[1]['displayWordLimit'] 	= '8';
	$items[1]['edit'] 				= 'yes';
	
	$items[2]['name'] 				= 'answer';
	$items[2]['type'] 				= 'textarea';
	$items[2]['lable'] 				= 'Answer';
	$items[2]['display'] 			= 'no';
	$items[2]['displayWidth'] 		= '200px';
	$items[2]['displayWordLimit'] 	= '4';
	$items[2]['edit'] 				= 'yes';
	

	$items[6]['name'] 				= 'sortBy';
	$items[6]['type'] 				= 'text';
	$items[6]['lable'] 			= 'Order';
	$items[6]['display'] 			= 'yes';
	$items[6]['displayWidth'] 		= '50px';
	$items[6]['displayWordLimit'] 	= '0';
	$items[6]['edit'] 				= 'yes';
	
	$items[7]['name'] 		= 'categories';
	$items[7]['type'] 		= 'catSelect';
	$items[7]['lable'] 		= 'Categories';
	$items[7]['display'] 	= 'yes';
	$items[7]['displayWidth'] = '150px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
	$items[7]['dataTable'] 	= 'categories';

?>
