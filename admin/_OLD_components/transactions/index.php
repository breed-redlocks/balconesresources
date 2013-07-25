<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Transaction Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'transactions';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Transaction';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add Transaction';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Transactions';
	$subnav[1]['action'] = '';
	
	// ITEMS MANAGED IN DATABASE
	$items[0]['name'] 				= 'id';
	$items[0]['type'] 				= 'text';
	$items[0]['lable'] 				= 'ID';
	$items[0]['display'] 			= 'yes';
	$items[0]['displayWidth'] 		= '50px';
	$items[0]['displayWordLimit'] 	= '0';
	$items[0]['edit'] 				= 'no';
	
	$items[1]['name'] 		= 'title';
	$items[1]['type'] 		= 'text';
	$items[1]['lable'] 		= 'Title';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '250px';
	$items[1]['displayWordLimit'] 	= '4';
	$items[1]['edit'] 		= 'yes';

	$items[2]['name'] 		= 'body';
	$items[2]['type'] 		= 'textarea';
	$items[2]['lable'] 		= 'Body';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '400px';
	$items[2]['displayWordLimit'] 	= '10';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'categories';
	$items[3]['type'] 		= 'catSelect';
	$items[3]['lable'] 		= 'Categories';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '150px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
	$items[3]['dataTable'] 	= 'categories';
	
	$items[4]['name'] 		= 'date';
	$items[4]['type'] 		= 'date';
	$items[4]['lable'] 		= 'Date';
	$items[4]['display'] 	= 'yes';
	$items[4]['displayWidth'] = '100px';
	$items[4]['displayWordLimit'] 	= '0';
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
	
	$items[6]['name'] 		= 'source';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'Source';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '200px';
	$items[6]['displayWordLimit'] 	= '4';
	$items[6]['edit'] 		= 'yes';
	
	$items[7]['name'] 		= 'internal';
	$items[7]['type'] 		= 'selectYN';
	$items[7]['dataTable']	= 'transactions';
	$items[7]['lable'] 		= 'Internal';
	$items[7]['display'] 	= 'no';
	$items[7]['displayWidth'] = '150px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
		
	$items[8]['name'] 		= 'mediaPath1';
	$items[8]['type'] 		= 'file';
	$items[8]['lable'] 		= 'Graphic for Practice Areas';
	$items[8]['display'] 	= 'no';
	$items[8]['displayWidth'] = '150px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';

	$items[9]['name'] 		= 'practiceAreas';
	$items[9]['type'] 		= 'profileSelect';
	$items[9]['multiple']	= 'yes';
	$items[9]['dataTable']	= 'practiceareas';
	$items[9]['lable'] 		= 'Associated Practice Areas for Graphic';
	$items[9]['display'] 	= 'no';
	$items[9]['displayWidth'] = '150px';
	$items[9]['displayWordLimit'] 	= '0';
	$items[9]['edit'] 		= 'yes';

	
	$items[19]['name'] 				= 'sortBy';
	$items[19]['type'] 				= 'text';
	$items[19]['lable'] 				= 'Order';
	$items[19]['display'] 			= 'no';
	$items[19]['displayWidth'] 		= '50px';
	$items[19]['displayWordLimit'] 	= '0';
	$items[19]['edit'] 				= 'no';

?>
