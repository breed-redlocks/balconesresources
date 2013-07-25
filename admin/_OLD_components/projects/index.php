<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Project Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'projects';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Projects';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Project';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Projects';
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
	$items[1]['displayWidth'] = '150px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
		
	$items[2]['name'] 		= 'companyName';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Company Name';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '120px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';

	$items[3]['name'] 		= 'website';
	$items[3]['type'] 		= 'text';
	$items[3]['lable'] 		= 'Website';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '200px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'categories';
	$items[4]['type'] 		= 'select';
	$items[4]['multiple']	= 'yes';
	$items[4]['lable'] 		= 'Categories';
	$items[4]['display'] 	= 'yes';
	$items[4]['displayWidth'] = '130px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 		= 'yes';
	$items[4]['dataTable'] 	= 'categories';
	
	$items[5]['name'] 		= 'introText';
	$items[5]['type'] 		= 'textarea';
	$items[5]['lable'] 		= 'Short Text';
	$items[5]['display'] 	= 'yes';
	$items[5]['displayWidth'] = '200px';
	$items[5]['displayWordLimit'] 	= '20';
	$items[5]['edit'] 		= 'yes';
	

	
	$items[6]['name'] 		= 'allText';
	$items[6]['type'] 		= 'textarea';
	$items[6]['lable'] 		= 'Long Text';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '200px';
	$items[6]['displayWordLimit'] 	= '20';
	$items[6]['edit'] 		= 'yes';
	
	$items[12]['name'] 		= 'mediaTitle1';
	$items[12]['type'] 		= 'text';
	$items[12]['lable'] 		= 'Main Graphic Title';
	$items[12]['display'] 	= 'no';
	$items[12]['displayWidth'] = '150px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 		= 'yes';
	
	$items[13]['name'] 		= 'mediaPath1';
	$items[13]['type'] 		= 'file';
	$items[13]['lable'] 		= 'Main Graphic Upload';
	$items[13]['display'] 	= 'no';
	$items[13]['displayWidth'] = '150px';
	$items[13]['displayWordLimit'] 	= '0';
	$items[13]['edit'] 		= 'yes';
	
	$items[14]['name'] 		= 'mediaTitle2';
	$items[14]['type'] 		= 'text';
	$items[14]['lable'] 		= 'Graphic Title 2';
	$items[14]['display'] 	= 'no';
	$items[14]['displayWidth'] = '150px';
	$items[14]['displayWordLimit'] 	= '0';
	$items[14]['edit'] 		= 'yes';
	
	$items[15]['name'] 		= 'mediaPath2';
	$items[15]['type'] 		= 'file';
	$items[15]['lable'] 		= 'Graphic Upload 2';
	$items[15]['display'] 	= 'no';
	$items[15]['displayWidth'] = '150px';
	$items[15]['displayWordLimit'] 	= '0';
	$items[15]['edit'] 		= 'yes';
	
	$items[16]['name'] 		= 'mediaTitle3';
	$items[16]['type'] 		= 'text';
	$items[16]['lable'] 		= 'Graphic Title 3';
	$items[16]['display'] 	= 'no';
	$items[16]['displayWidth'] = '150px';
	$items[16]['displayWordLimit'] 	= '0';
	$items[16]['edit'] 		= 'yes';
	
	$items[17]['name'] 		= 'mediaPath3';
	$items[17]['type'] 		= 'file';
	$items[17]['lable'] 		= 'Graphic Upload 3';
	$items[17]['display'] 	= 'no';
	$items[17]['displayWidth'] = '150px';
	$items[17]['displayWordLimit'] 	= '0';
	$items[17]['edit'] 		= 'yes';
	
	$items[18]['name'] 		= 'mediaTitle4';
	$items[18]['type'] 		= 'text';
	$items[18]['lable'] 		= 'Graphic Title 4';
	$items[18]['display'] 	= 'no';
	$items[18]['displayWidth'] = '150px';
	$items[18]['displayWordLimit'] 	= '0';
	$items[18]['edit'] 		= 'yes';
	
	$items[19]['name'] 		= 'mediaPath4';
	$items[19]['type'] 		= 'file';
	$items[19]['lable'] 		= 'Graphic Upload 4';
	$items[19]['display'] 	= 'no';
	$items[19]['displayWidth'] = '150px';
	$items[19]['displayWordLimit'] 	= '0';
	$items[19]['edit'] 		= 'yes';
	
	$items[20]['name'] 		= 'mediaTitle5';
	$items[20]['type'] 		= 'text';
	$items[20]['lable'] 		= 'Graphic Title 5';
	$items[20]['display'] 	= 'no';
	$items[20]['displayWidth'] = '150px';
	$items[20]['displayWordLimit'] 	= '0';
	$items[20]['edit'] 		= 'yes';
	
	$items[20]['name'] 		= 'mediaPath5';
	$items[20]['type'] 		= 'file';
	$items[20]['lable'] 		= 'Graphic Upload 5';
	$items[20]['display'] 	= 'no';
	$items[20]['displayWidth'] = '150px';
	$items[20]['displayWordLimit'] 	= '0';
	$items[20]['edit'] 		= 'yes';
	
	$items[21]['name'] 		= 'mediaTitle6';
	$items[21]['type'] 		= 'text';
	$items[21]['lable'] 		= 'Graphic Title 6';
	$items[21]['display'] 	= 'no';
	$items[21]['displayWidth'] = '150px';
	$items[21]['displayWordLimit'] 	= '0';
	$items[21]['edit'] 		= 'yes';
	
	$items[22]['name'] 		= 'mediaPath6';
	$items[22]['type'] 		= 'file';
	$items[22]['lable'] 		= 'Graphic Upload 6';
	$items[22]['display'] 	= 'no';
	$items[22]['displayWidth'] = '150px';
	$items[22]['displayWordLimit'] 	= '0';
	$items[22]['edit'] 		= 'yes';
	
	$items[23]['name'] 		= 'mediaTitle7';
	$items[23]['type'] 		= 'text';
	$items[23]['lable'] 		= 'Graphic Title 7';
	$items[23]['display'] 	= 'no';
	$items[23]['displayWidth'] = '150px';
	$items[23]['displayWordLimit'] 	= '0';
	$items[23]['edit'] 		= 'yes';
	
	$items[24]['name'] 		= 'mediaPath7';
	$items[24]['type'] 		= 'file';
	$items[24]['lable'] 		= 'Graphic Upload 7';
	$items[24]['display'] 	= 'no';
	$items[24]['displayWidth'] = '150px';
	$items[24]['displayWordLimit'] 	= '0';
	$items[24]['edit'] 		= 'yes';
	
	$items[25]['name'] 		= 'mediaTitle8';
	$items[25]['type'] 		= 'text';
	$items[25]['lable'] 		= 'Graphic Title 8';
	$items[25]['display'] 	= 'no';
	$items[25]['displayWidth'] = '150px';
	$items[25]['displayWordLimit'] 	= '0';
	$items[25]['edit'] 		= 'yes';
	
	$items[26]['name'] 		= 'mediaPath8';
	$items[26]['type'] 		= 'file';
	$items[26]['lable'] 		= 'Graphic Upload 8';
	$items[26]['display'] 	= 'no';
	$items[26]['displayWidth'] = '150px';
	$items[26]['displayWordLimit'] 	= '0';
	$items[26]['edit'] 		= 'yes';
	
	$items[27]['name'] 		= 'mediaTitle9';
	$items[27]['type'] 		= 'text';
	$items[27]['lable'] 		= 'Graphic Title 9';
	$items[27]['display'] 	= 'no';
	$items[27]['displayWidth'] = '150px';
	$items[27]['displayWordLimit'] 	= '0';
	$items[27]['edit'] 		= 'yes';
	
	$items[28]['name'] 		= 'mediaPath9';
	$items[28]['type'] 		= 'file';
	$items[28]['lable'] 		= 'Graphic Upload 9';
	$items[28]['display'] 	= 'no';
	$items[28]['displayWidth'] = '150px';
	$items[28]['displayWordLimit'] 	= '0';
	$items[28]['edit'] 		= 'yes';
	
	$items[29]['name'] 		= 'mediaTitle10';
	$items[29]['type'] 		= 'text';
	$items[29]['lable'] 		= 'Graphic Title 10';
	$items[29]['display'] 	= 'no';
	$items[29]['displayWidth'] = '150px';
	$items[29]['displayWordLimit'] 	= '0';
	$items[29]['edit'] 		= 'yes';
	
	$items[30]['name'] 		= 'mediaPath10';
	$items[30]['type'] 		= 'file';
	$items[30]['lable'] 		= 'Graphic Upload 10';
	$items[30]['display'] 	= 'no';
	$items[30]['displayWidth'] = '150px';
	$items[30]['displayWordLimit'] 	= '0';
	$items[30]['edit'] 		= 'yes';
	
	$items[31]['name'] 				= 'sortBy';
	$items[31]['type'] 				= 'text';
	$items[31]['lable'] 			= 'Order';
	$items[31]['display'] 			= 'yes';
	$items[31]['displayWidth'] 		= '30px';
	$items[31]['displayWordLimit'] 	= '0';
	$items[31]['edit'] 				= 'yes';
	
	$items[32]['name'] 		= 'tags';
	$items[32]['type'] 		= 'select';
	$items[32]['multiple']	= 'yes';
	$items[32]['lable'] 		= 'Tags';
	$items[32]['display'] 	= 'yes';
	$items[32]['displayWidth'] = '130px';
	$items[32]['displayWordLimit'] 	= '0';
	$items[32]['edit'] 		= 'yes';
	$items[32]['dataTable'] 	= 'tags';
	
	


?>
