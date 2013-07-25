<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "News Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'news';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'News';
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add News';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All News';
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
	$items[1]['displayWidth'] = '300px';
	$items[1]['displayWordLimit'] 	= '6';
	$items[1]['edit'] 		= 'yes';
/*	
	$items[2]['name'] 		= 'subTitle';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Subtitle';
	$items[2]['display'] 	= 'no';
	$items[2]['displayWidth'] = '200px';
	$items[2]['displayWordLimit'] 	= '4';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'newsType';
	$items[3]['type'] 		= 'selectType';
	$items[3]['lable'] 		= 'News Type';
	$items[3]['display'] 	= 'no';
	$items[3]['displayWidth'] = '200px';
	$items[3]['displayWordLimit'] 	= '4';
	$items[3]['edit'] 		= 'yes';
*/	
	$items[4]['name'] 		= 'sourceLink';
	$items[4]['type'] 		= 'text';
	$items[4]['lable'] 		= 'Source Link';
	$items[4]['display'] 	= 'no';
	$items[4]['displayWidth'] = '200px';
	$items[4]['displayWordLimit'] 	= '4';
	$items[4]['edit'] 		= 'yes';

	$items[5]['name'] 		= 'body';
	$items[5]['type'] 		= 'textarea';
	$items[5]['lable'] 		= 'Body';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '400px';
	$items[5]['displayWordLimit'] 	= '30';
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
	$items[6]['name'] 		= 'blurb';
	$items[6]['type'] 		= 'text';
	$items[6]['lable'] 		= 'Blurb (Bottom italic text)';
	$items[6]['display'] 	= 'yes';
	$items[6]['displayWidth'] = '400px';
	$items[6]['displayWordLimit'] 	= '10';
	$items[6]['edit'] 		= 'yes';
	
	$items[7]['name'] 		= 'categories';
	$items[7]['type'] 		= 'catSelect';
	$items[7]['lable'] 		= 'Categories';
	$items[7]['display'] 	= 'yes';
	$items[7]['displayWidth'] = '150px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
	$items[7]['dataTable'] 	= 'categories';
*/
	
	$items[8]['name'] 		= 'date';
	$items[8]['type'] 		= 'date';
	$items[8]['lable'] 		= 'Date';
	$items[8]['display'] 	= 'yes';
	$items[8]['displayWidth'] = '100px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';
/*	
	$items[9]['name'] 		= 'author';
	$items[9]['type'] 		= 'text';
	$items[9]['lable'] 		= 'Author';
	$items[9]['display'] 	= 'no';
	$items[9]['displayWidth'] = '200px';
	$items[9]['displayWordLimit'] 	= '4';
	$items[9]['edit'] 		= 'yes';
*/	
	$items[10]['name'] 		= 'sourceText';
	$items[10]['type'] 		= 'text';
	$items[10]['lable'] 		= 'Source Text';
	$items[10]['display'] 	= 'no';
	$items[10]['displayWidth'] = '200px';
	$items[10]['displayWordLimit'] 	= '4';
	$items[10]['edit'] 		= 'yes';
	
	$items[11]['name'] 		= 'displayNews';
	$items[11]['type'] 		= 'selectYN';
	$items[11]['lable'] 		= 'Display';
	$items[11]['display'] 	= 'no';
	$items[11]['displayWidth'] = '200px';
	$items[11]['displayWordLimit'] 	= '4';
	$items[11]['edit'] 		= 'yes';
/*	
	$items[12]['name'] 				= 'sortBy';
	$items[12]['type'] 				= 'text';
	$items[12]['lable'] 				= 'Order';
	$items[12]['display'] 			= 'no';
	$items[12]['displayWidth'] 		= '50px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 				= 'yes';
	*/

?>
