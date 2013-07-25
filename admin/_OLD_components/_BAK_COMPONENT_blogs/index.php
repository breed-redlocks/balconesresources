<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Blog Manager";
	
	// ICON IMAGE ON DASHBOARD
	$icon = 'blog.png';
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'blogs';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Blogs';

	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';
	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Blog';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Blogs';
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
	$items[1]['displayWidth'] = '130px';
	$items[1]['displayWordLimit'] 	= '0';
	$items[1]['edit'] 		= 'yes';
	
	$items[2]['name'] 		= 'titleSlug';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Web Safe Title';
	$items[2]['display'] 	= 'no';
	$items[2]['displayWidth'] = '130px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';

	$items[3]['name'] 		= 'body';
	$items[3]['type'] 		= 'textarea';
	$items[3]['lable'] 		= 'Body';
	$items[3]['display'] 	= 'yes';
	$items[3]['displayWidth'] = '300px';
	$items[3]['displayWordLimit'] 	= '20';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'mediaTitle1';
	$items[4]['type'] 		= 'text';
	$items[4]['lable'] 		= 'Main Graphic Title';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '150px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 		= 'yes';
	
	$items[5]['name'] 		= 'mediaPath1';
	$items[5]['type'] 		= 'file';
	$items[5]['lable'] 		= 'Main Graphic Upload';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '150px';
	$items[5]['displayWordLimit'] 	= '0';
	$items[5]['edit'] 		= 'yes';
	
	$items[6]['name'] 		= 'bodyBelow';
	$items[6]['type'] 		= 'textarea';
	$items[6]['lable'] 		= 'Body';
	$items[6]['display'] 	= 'no';
	$items[6]['displayWidth'] = '300px';
	$items[6]['displayWordLimit'] 	= '20';
	$items[6]['edit'] 		= 'yes';
	
	$items[7]['name'] 		= 'author';
	$items[7]['type'] 		= 'userSelect';
	$items[7]['lable'] 		= 'Author';
	$items[7]['display'] 	= 'no';
	$items[7]['displayWidth'] = '150px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
	
	$items[8]['name'] 		= 'categories';
	$items[8]['type'] 		= 'select';
	$items[8]['multiple']	= 'yes';
	$items[8]['lable'] 		= 'Categories';
	$items[8]['display'] 	= 'yes';
	$items[8]['displayWidth'] = '130px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';
	$items[8]['dataTable'] 	= 'categories';
	
	$items[9]['name'] 		= 'tags';
	$items[9]['type'] 		= 'select';
	$items[9]['multiple']	= 'yes';
	$items[9]['lable'] 		= 'Tags';
	$items[9]['display'] 	= 'yes';
	$items[9]['displayWidth'] = '130px';
	$items[9]['displayWordLimit'] 	= '0';
	$items[9]['edit'] 		= 'yes';
	$items[9]['dataTable'] 	= 'tags';
	
	$items[10]['name'] 		= 'date';
	$items[10]['type'] 		= 'text';
	$items[10]['lable'] 		= 'Date';
	$items[10]['display'] 	= 'yes';
	$items[10]['displayWidth'] = '100px';
	$items[10]['displayWordLimit'] 	= '0';
	$items[10]['edit'] 		= 'yes';
	
	$items[11]['name'] 				= 'sortBy';
	$items[11]['type'] 				= 'text';
	$items[11]['lable'] 				= 'Order';
	$items[11]['display'] 			= 'yes';
	$items[11]['displayWidth'] 		= '50px';
	$items[11]['displayWordLimit'] 	= '0';
	$items[11]['edit'] 				= 'yes';
?>
