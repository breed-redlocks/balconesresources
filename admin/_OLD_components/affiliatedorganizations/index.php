<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Affiliated Organizations";
	
	// ICON IMAGE ON DASHBOARD
	$icon = 'affiliatedorganizations.png';
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'affiliatedorganizations';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Affiliated Organization';

	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';
	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add an Affiliated Organization';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Affiliated Organizations';
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
	$items[1]['lable'] 		= 'Company Name';
	$items[1]['display'] 	= 'yes';
	$items[1]['displayWidth'] = '300px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'address1';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Address 1';
	$items[2]['display'] 	= 'no';
	$items[2]['displayWidth'] = '300px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'address2';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Address 2';
	$items[3]['display'] 	= 'no';
	$items[3]['displayWidth'] = '300px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'city';
	$items[4]['type'] 		= 'text';
	$items[4]['lable'] 		= 'City';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '300px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 		= 'no';
	
	$items[5]['name'] 		= 'state';
	$items[5]['type'] 		= 'text';
	$items[5]['lable'] 		= 'State';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '300px';
	$items[5]['displayWordLimit'] 	= '0';
	$items[5]['edit'] 		= 'yes';
	
	$items[6]['name'] 		= 'zip';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'Zip';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '300px';
	$items[6]['displayWordLimit'] 	= '0';
	$items[6]['edit'] 		= 'yes';
	
	$items[7]['name'] 		= 'phone';
	$items[7]['type'] 		= 'text';
	$items[7]['lable'] 		= 'Phone';
	$items[7]['display'] 	= 'no';
	$items[7]['displayWidth'] = '300px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
	
	$items[8]['name'] 		= 'fax';
	$items[8]['type'] 		= 'text';
	$items[8]['lable'] 		= 'Fax';
	$items[8]['display'] 	= 'no';
	$items[8]['displayWidth'] = '300px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';
	
	$items[9]['name'] 		= 'site';
	$items[9]['type'] 		= 'text';
	$items[9]['lable'] 		= 'Website';
	$items[9]['display'] 	= 'no';
	$items[9]['displayWidth'] = '300px';
	$items[9]['displayWordLimit'] 	= '0';
	$items[9]['edit'] 		= 'yes';
	
	$items[10]['name'] 		= 'body';
	$items[10]['type'] 		= 'textarea';
	$items[10]['lable'] 		= 'Description';
	$items[10]['display'] 	= 'no';
	$items[10]['displayWidth'] = '300px';
	$items[10]['displayWordLimit'] 	= '0';
	$items[10]['edit'] 		= 'yes';
	
	$items[11]['name'] 		= 'locations';
	$items[11]['type'] 		= 'text';
	$items[11]['lable'] 		= 'Locations';
	$items[11]['display'] 	= 'no';
	$items[11]['displayWidth'] = '300px';
	$items[11]['displayWordLimit'] 	= '0';
	$items[11]['edit'] 		= 'yes';
	
	$items[12]['name'] 		= 'mediaPath1';
	$items[12]['type'] 		= 'file';
	$items[12]['lable'] 		= 'Logo (sized to fit gif)';
	$items[12]['display'] 	= 'yes';
	$items[12]['displayWidth'] = '300px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 		= 'yes';
	
	$items[13]['name'] 		= 'providerType';
	$items[13]['type'] 		= 'selectProvider';
	$items[13]['lable'] 		= 'Provider Type';
	$items[13]['display'] 	= 'no';
	$items[13]['displayWidth'] = '130px';
	$items[13]['displayWordLimit'] 	= '0';
	$items[13]['edit'] 		= 'yes';
	
	$items[14]['name'] 				= 'sortBy';
	$items[14]['type'] 				= 'text';
	$items[14]['lable'] 				= 'Order';
	$items[14]['display'] 			= 'yes';
	$items[14]['displayWidth'] 		= '50px';
	$items[14]['displayWordLimit'] 	= '0';
	$items[14]['edit'] 				= 'yes';
	
?>
