<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Groceries";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'groceries';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Items';
	
	$itemOrder = 1;
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Item';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List Items';
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
	$items[1]['displayWidth'] = '150px';
	$items[1]['displayWordLimit'] 	= '5';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'quant';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Quantity';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '65px';
	$items[2]['displayWordLimit'] 	= '';
	$items[2]['edit'] 		= 'yes';

	$items[3]['name'] 		= 'price';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Price';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '65px';
	$items[3]['displayWordLimit'] 	= '5';
	$items[3]['edit'] 		= 'yes';
	
	$items[5]['name'] 		= 'note';
	$items[5]['type'] 		= 'textarea';
	$items[5]['lable'] 		= 'Note';
	$items[5]['display'] 	= 'yes';
	$items[5]['displayWidth'] = '200px';
	$items[5]['displayWordLimit'] 	= '4';
	$items[5]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'type';
	$items[4]['type'] 		= 'select';
	$items[4]['lable'] 		= 'Type';
	$items[4]['display'] 	= 'yes';
	$items[4]['displayWidth'] = '100px';
	$items[4]['displayWordLimit'] 	= '5';
	$items[4]['edit'] 		= 'yes';
	$items[4]['dataTable'] 	= 'grocTypes';




?>
