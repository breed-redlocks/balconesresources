<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
	
	// NAME TO BE DISPLAYED IN THE ADMIN AREA
	$componentName = "Page Manager";
	
	// NAME OF DIRECTORY COMPONENT IS IN
	$componentLink = 'pages';
	
	// PROPER NAME FOR WHAT IS BEING MANAGED
	$itemName = 'Pages';
	
	// IS COMPONENT FOR FRONT END(1) BACKEND(2) OR BOTH(3)
	//$displayMode = 2;
	
	// SUPPORTING TABLE OR TABLES. USE 0 FIRST
	$subTable[0]['name'] 	= '';
	$subTable[0]['index'] 	= '';
	$subTable[1]['name'] 	= '';
	$subTable[1]['index'] 	= '';
	$subTable[2]['name'] 	= '';
	$subTable[2]['index'] 	= '';

	
	// NAVIGATION ACTION AND TITLE FOR DISPLAY
	$subnav[0]['title'] = 'Add a Page';
	$subnav[0]['action'] = 'add';
	$subnav[1]['title'] = 'List All Pages';
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
		
	$items[2]['name'] 		= 'link';
	$items[2]['type'] 		= 'text';
	$items[2]['lable'] 		= 'Link';
	$items[2]['display'] 	= 'yes';
	$items[2]['displayWidth'] = '150px';
	$items[2]['displayWordLimit'] 	= '0';
	$items[2]['edit'] 		= 'yes';
	
	$items[3]['name'] 		= 'component';
	$items[3]['type'] 		= 'component';
	$items[3]['lable'] 		= 'Component';
	$items[3]['display'] 	= 'no';
	$items[3]['displayWidth'] = '100px';
	$items[3]['displayWordLimit'] 	= '0';
	$items[3]['edit'] 		= 'yes';
	
	$items[4]['name'] 		= 'layout';
	$items[4]['type'] 		= 'selectLayout';
	$items[4]['lable'] 		= 'Layout';
	$items[4]['display'] 	= 'yes';
	$items[4]['displayWidth'] = '150px';
	$items[4]['displayWordLimit'] 	= '0';
	$items[4]['edit'] 		= 'yes';
	$items[6]['dataTable'] 	= 'layout';
/*	
	$items[5]['name'] 		= 'theme';
	$items[5]['type'] 		= 'text';
	$items[5]['lable'] 		= 'Theme';
	$items[5]['display'] 	= 'no';
	$items[5]['displayWidth'] = '100px';
	$items[5]['displayWordLimit'] 	= '0';
	$items[5]['edit'] 		= 'yes';
*/	
	$items[6]['name'] 		= 'categories';
	$items[6]['type'] 		= 'catSelect';
	$items[6]['multiple']	= 'yes';
	$items[6]['lable'] 		= 'Categories';
	$items[6]['display'] 	= 'yes';
	$items[6]['displayWidth'] = '200px';
	$items[6]['displayWordLimit'] 	= '0';
	$items[6]['edit'] 		= 'yes';
	$items[6]['dataTable'] 	= 'categories';
	
	$items[7]['name'] 		= 'sortBy';
	$items[7]['type'] 		= 'text';
	$items[7]['lable'] 		= 'Order';
	$items[7]['display'] 	= 'yes';
	$items[7]['displayWidth'] = '50px';
	$items[7]['displayWordLimit'] 	= '0';
	$items[7]['edit'] 		= 'yes';
/*	
	$items[8]['name'] 		= 'isHome';
	$items[8]['type'] 		= 'selectYN';
	$items[8]['lable'] 		= 'Site Home Page?';
	$items[8]['display'] 	= 'no';
	$items[8]['displayWidth'] = '10px';
	$items[8]['displayWordLimit'] 	= '0';
	$items[8]['edit'] 		= 'yes';
	
*/	
	$items[9]['name'] 		= 'onNav';
	$items[9]['type'] 		= 'text';
	$items[9]['lable'] 		= 'Nav #';
	$items[9]['display'] 	= 'yes';
	$items[9]['displayWidth'] = '60px';
	$items[9]['displayWordLimit'] 	= '0';
	$items[9]['edit'] 		= 'yes';
	
	$items[10]['name'] 		= 'blockTitle1';
	$items[10]['type'] 		= 'text';
	$items[10]['lable'] 		= 'Block 1 Title';
	$items[10]['display'] 	= 'no';
	$items[10]['displayWidth'] = '20px';
	$items[10]['displayWordLimit'] 	= '0';
	$items[10]['edit'] 		= 'yes';
	
	$items[11]['name'] 		= 'block1';
	$items[11]['type'] 		= 'textarea';
	$items[11]['lable'] 		= 'Block 1';
	$items[11]['display'] 	= 'no';
	$items[11]['displayWidth'] = '200px';
	$items[11]['displayWordLimit'] 	= '20';
	$items[11]['edit'] 		= 'yes';
/*	
	$items[12]['name'] 		= 'blockLink1';
	$items[12]['type'] 		= 'text';
	$items[12]['lable'] 		= 'Block 1 Link';
	$items[12]['display'] 	= 'no';
	$items[12]['displayWidth'] = '20px';
	$items[12]['displayWordLimit'] 	= '0';
	$items[12]['edit'] 		= 'yes';
*/	
	$items[13]['name'] 		= 'blockTitle2';
	$items[13]['type'] 		= 'text';
	$items[13]['lable'] 		= 'Block 2 Title';
	$items[13]['display'] 	= 'no';
	$items[13]['displayWidth'] = '20px';
	$items[13]['displayWordLimit'] 	= '0';
	$items[13]['edit'] 		= 'yes';
	
	$items[14]['name'] 		= 'block2';
	$items[14]['type'] 		= 'textarea';
	$items[14]['lable'] 		= 'Block 2';
	$items[14]['display'] 	= 'no';
	$items[14]['displayWidth'] = '200px';
	$items[14]['displayWordLimit'] 	= '20';
	$items[14]['edit'] 		= 'yes';
/*	
	$items[15]['name'] 		= 'blockLink2';
	$items[15]['type'] 		= 'text';
	$items[15]['lable'] 		= 'Block 2 Link';
	$items[15]['display'] 	= 'no';
	$items[15]['displayWidth'] = '20px';
	$items[15]['displayWordLimit'] 	= '0';
	$items[15]['edit'] 		= 'yes';
*/	
	$items[16]['name'] 		= 'blockTitle3';
	$items[16]['type'] 		= 'text';
	$items[16]['lable'] 		= 'Block 3 Title';
	$items[16]['display'] 	= 'no';
	$items[16]['displayWidth'] = '20px';
	$items[16]['displayWordLimit'] 	= '0';
	$items[16]['edit'] 		= 'yes';
	
	$items[17]['name'] 		= 'block3';
	$items[17]['type'] 		= 'textarea';
	$items[17]['lable'] 		= 'Block 3';
	$items[17]['display'] 	= 'no';
	$items[17]['displayWidth'] = '200px';
	$items[17]['displayWordLimit'] 	= '20';
	$items[17]['edit'] 		= 'yes';
/*	
	$items[18]['name'] 		= 'blockLink3';
	$items[18]['type'] 		= 'text';
	$items[18]['lable'] 		= 'Block 3 Link';
	$items[18]['display'] 	= 'no';
	$items[18]['displayWidth'] = '20px';
	$items[18]['displayWordLimit'] 	= '0';
	$items[18]['edit'] 		= 'yes';
*/	
	$items[19]['name'] 		= 'blockTitle4';
	$items[19]['type'] 		= 'text';
	$items[19]['lable'] 		= 'Block 4 Title';
	$items[19]['display'] 	= 'no';
	$items[19]['displayWidth'] = '20px';
	$items[19]['displayWordLimit'] 	= '0';
	$items[19]['edit'] 		= 'yes';
	
	$items[20]['name'] 		= 'block4';
	$items[20]['type'] 		= 'textarea';
	$items[20]['lable'] 		= 'Block 4';
	$items[20]['display'] 	= 'no';
	$items[20]['displayWidth'] = '200px';
	$items[20]['displayWordLimit'] 	= '20';
	$items[20]['edit'] 		= 'yes';
/*	
	$items[21]['name'] 		= 'blockLink4';
	$items[21]['type'] 		= 'text';
	$items[21]['lable'] 		= 'Block 4 Link';
	$items[21]['display'] 	= 'no';
	$items[21]['displayWidth'] = '20px';
	$items[21]['displayWordLimit'] 	= '0';
	$items[21]['edit'] 		= 'yes';
*/	
	$items[22]['name'] 		= 'blockTitle5';
	$items[22]['type'] 		= 'text';
	$items[22]['lable'] 		= 'Block 5 Title';
	$items[22]['display'] 	= 'no';
	$items[22]['displayWidth'] = '20px';
	$items[22]['displayWordLimit'] 	= '0';
	$items[22]['edit'] 		= 'yes';
	
	$items[23]['name'] 		= 'block5';
	$items[23]['type'] 		= 'textarea';
	$items[23]['lable'] 		= 'Block 5';
	$items[23]['display'] 	= 'no';
	$items[23]['displayWidth'] = '200px';
	$items[23]['displayWordLimit'] 	= '20';
	$items[23]['edit'] 		= 'yes';
/*	
	$items[24]['name'] 		= 'blockLink5';
	$items[24]['type'] 		= 'text';
	$items[24]['lable'] 		= 'Block 5 Link';
	$items[24]['display'] 	= 'no';
	$items[24]['displayWidth'] = '20px';
	$items[24]['displayWordLimit'] 	= '0';
	$items[24]['edit'] 		= 'yes';
*/	
	$items[25]['name'] 		= 'blockTitle6';
	$items[25]['type'] 		= 'text';
	$items[25]['lable'] 		= 'Block 6 Title';
	$items[25]['display'] 	= 'no';
	$items[25]['displayWidth'] = '20px';
	$items[25]['displayWordLimit'] 	= '0';
	$items[25]['edit'] 		= 'yes';
	
	$items[26]['name'] 		= 'block6';
	$items[26]['type'] 		= 'textarea';
	$items[26]['lable'] 		= 'Block 6';
	$items[26]['display'] 	= 'no';
	$items[26]['displayWidth'] = '200px';
	$items[26]['displayWordLimit'] 	= '20';
	$items[26]['edit'] 		= 'yes';
/*	
	$items[27]['name'] 		= 'blockLink6';
	$items[27]['type'] 		= 'text';
	$items[27]['lable'] 		= 'Block 6 Link';
	$items[27]['display'] 	= 'no';
	$items[27]['displayWidth'] = '20px';
	$items[27]['displayWordLimit'] 	= '0';
	$items[27]['edit'] 		= 'yes';
*/	
	$items[28]['name'] 		= 'blockTitle7';
	$items[28]['type'] 		= 'text';
	$items[28]['lable'] 		= 'Block 7 Title';
	$items[28]['display'] 	= 'no';
	$items[28]['displayWidth'] = '20px';
	$items[28]['displayWordLimit'] 	= '0';
	$items[28]['edit'] 		= 'yes';
	
	$items[29]['name'] 		= 'block7';
	$items[29]['type'] 		= 'textarea';
	$items[29]['lable'] 		= 'Block 7';
	$items[29]['display'] 	= 'no';
	$items[29]['displayWidth'] = '200px';
	$items[29]['displayWordLimit'] 	= '20';
	$items[29]['edit'] 		= 'yes';
/*	
	$items[30]['name'] 		= 'blockLink7';
	$items[30]['type'] 		= 'text';
	$items[30]['lable'] 		= 'Block 7 Link';
	$items[30]['display'] 	= 'no';
	$items[30]['displayWidth'] = '20px';
	$items[30]['displayWordLimit'] 	= '0';
	$items[30]['edit'] 		= 'yes';
*/	
	$items[31]['name'] 		= 'blockTitle8';
	$items[31]['type'] 		= 'text';
	$items[31]['lable'] 		= 'Block 8 Title';
	$items[31]['display'] 	= 'no';
	$items[31]['displayWidth'] = '20px';
	$items[31]['displayWordLimit'] 	= '0';
	$items[31]['edit'] 		= 'yes';

	$items[32]['name'] 		= 'block8';
	$items[32]['type'] 		= 'textarea';
	$items[32]['lable'] 		= 'Block 8';
	$items[32]['display'] 	= 'no';
	$items[32]['displayWidth'] = '200px';
	$items[32]['displayWordLimit'] 	= '20';
	$items[32]['edit'] 		= 'yes';
/*	
	$items[33]['name'] 		= 'blockLink8';
	$items[33]['type'] 		= 'text';
	$items[33]['lable'] 		= 'Block 8 Link';
	$items[33]['display'] 	= 'no';
	$items[33]['displayWidth'] = '20px';
	$items[33]['displayWordLimit'] 	= '0';
	$items[33]['edit'] 		= 'yes';
*/	
	$items[34]['name'] 		= 'blockTitle9';
	$items[34]['type'] 		= 'text';
	$items[34]['lable'] 		= 'Block 9 Title';
	$items[34]['display'] 	= 'no';
	$items[34]['displayWidth'] = '20px';
	$items[34]['displayWordLimit'] 	= '0';
	$items[34]['edit'] 		= 'yes';
	
	$items[35]['name'] 		= 'block9';
	$items[35]['type'] 		= 'textarea';
	$items[35]['lable'] 		= 'Block 9';
	$items[35]['display'] 	= 'no';
	$items[35]['displayWidth'] = '200px';
	$items[35]['displayWordLimit'] 	= '20';
	$items[35]['edit'] 		= 'yes';
/*	
	$items[36]['name'] 		= 'blockLink9';
	$items[36]['type'] 		= 'text';
	$items[36]['lable'] 		= 'Block 9 Link';
	$items[36]['display'] 	= 'no';
	$items[36]['displayWidth'] = '20px';
	$items[36]['displayWordLimit'] 	= '0';
	$items[36]['edit'] 		= 'yes';
*/	
	$items[37]['name'] 		= 'blockTitle10';
	$items[37]['type'] 		= 'text';
	$items[37]['lable'] 		= 'Block 10 Title';
	$items[37]['display'] 	= 'no';
	$items[37]['displayWidth'] = '20px';
	$items[37]['displayWordLimit'] 	= '0';
	$items[37]['edit'] 		= 'yes';
	
	$items[38]['name'] 		= 'block10';
	$items[38]['type'] 		= 'textarea';
	$items[38]['lable'] 		= 'Block 10';
	$items[38]['display'] 	= 'no';
	$items[38]['displayWidth'] = '200px';
	$items[38]['displayWordLimit'] 	= '20';
	$items[38]['edit'] 		= 'yes';
/*	
	$items[39]['name'] 		= 'blockLink10';
	$items[39]['type'] 		= 'text';
	$items[39]['lable'] 		= 'Block 10 Link';
	$items[39]['display'] 	= 'no';
	$items[39]['displayWidth'] = '20px';
	$items[39]['displayWordLimit'] 	= '0';
	$items[39]['edit'] 		= 'yes';
	
	$items[40]['name'] 		= 'noLeftNav';
	$items[40]['type'] 		= 'selectYN';
	$items[40]['lable'] 		= 'Remove Left Nav';
	$items[40]['display'] 	= 'no';
	$items[40]['displayWidth'] = '50px';
	$items[40]['displayWordLimit'] 	= '0';
	$items[40]['edit'] 		= 'yes';
*/	
	$items[41]['name'] 		= 'metaKeys';
	$items[41]['type'] 		= 'textarea';
	$items[41]['lable'] 		= 'Meta Page Keywords';
	$items[41]['display'] 	= 'no';
	$items[41]['displayWidth'] = '20px';
	$items[41]['displayWordLimit'] 	= '0';
	$items[41]['edit'] 		= 'yes';
	
	$items[42]['name'] 		= 'metaDesc';
	$items[42]['type'] 		= 'textarea';
	$items[42]['lable'] 		= 'Meta Page Description';
	$items[42]['display'] 	= 'no';
	$items[42]['displayWidth'] = '20px';
	$items[42]['displayWordLimit'] 	= '0';
	$items[42]['edit'] 		= 'yes';
	
	$items[43]['name'] 		= 'metaTitle';
	$items[43]['type'] 		= 'textarea';
	$items[43]['lable'] 		= 'Meta Page Title';
	$items[43]['display'] 	= 'no';
	$items[43]['displayWidth'] = '20px';
	$items[43]['displayWordLimit'] 	= '0';
	$items[43]['edit'] 		= 'yes';
	
	$items[44]['name'] 		= 'display';
	$items[44]['type'] 		= 'selectYN';
	$items[44]['lable'] 		= 'Display on Site Map';
	$items[44]['display'] 	= 'no';
	$items[44]['displayWidth'] = '200px';
	$items[44]['displayWordLimit'] 	= '4';
	$items[44]['edit'] 		= 'yes';
		


?>
