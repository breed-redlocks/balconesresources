<?php
session_start();
require_once "class/users.class.inc";
require_once('includes/settings.php');

//print_r($_SESSION);

	if (isset($_GET['action'])) {
  		$action = $_GET['action'];
	}
	if (isset($_POST['process'])) {
  		$process = $_POST['process'];
	}
	if (isset($_GET['logMessage'])) {
  		$logMessage = $_GET['logMessage'];
	}
	if (isset($_GET['comp'])) {
  		$comp = $_GET['comp'];
	}
	if (isset($_GET['sortBy'])) {
  		$sortBy = $_GET['sortBy'];
	} else {
		$sortBy = "sortBy";
	}
?>
<html>
	<head>
		<title>Admin</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, print">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.14.custom.css" media="screen, print">

				<script type="text/javascript" src="js/nicEdit.js"></script>
				<script type="text/javascript" src="js/jquery-1.5.1.min.js" ></script>
				<script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
<?php
/*
		if (($comp == "news") || ($comp =="people")){
			echo '<script src="/admin/js/jquery.Jcrop.js" type="text/javascript"></script>
    				<link rel="stylesheet" href="/admin/css/jquery.Jcrop.css" type="text/css" />
    				<link rel="stylesheet" href="/admin/css/demos.css" type="text/css" />
    				
    				<link rel="stylesheet" href="/admin/css/fileuploader.css" type="text/css" />
    				<script src="/admin/js/fileuploader.js" type="text/javascript"></script>
    				<script type="text/javascript">

					window.onload = function() {

    				// add old fashioned but reliable event handler
    				document.getElementById(\'file_input\').onchange = function() {
        				// submit the form that contains the target element
        				this.form.submit();
    					}
					}

</script>
<script type="text/javascript">

    jQuery(function($){

      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      
      $(\'#target\').Jcrop({
        	onChange: updatePreview,
        	onSelect: updatePreview,
        	maxSize: [500,500],
       	// 	onChange: showCoords,
		//	onSelect: showCoords,
        	bgOpacity:   .7,
        	setSelect:   [ 0, 0, 191, 178 ],
        	aspectRatio: 191 / 178
      },function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
      });
      
      function showCoords(c)
			{
				jQuery(\'#x1\').val(c.x);
				jQuery(\'#y1\').val(c.y);
				jQuery(\'#x2\').val(c.x2);
				jQuery(\'#y2\').val(c.y2);
				jQuery(\'#w\').val(c.w);
				jQuery(\'#h\').val(c.h);
			};

      function updatePreview(c)
      {
      			jQuery(\'#x1\').val(c.x);
				jQuery(\'#y1\').val(c.y);
				jQuery(\'#x2\').val(c.x2);
				jQuery(\'#y2\').val(c.y2);
				jQuery(\'#w\').val(c.w);
				jQuery(\'#h\').val(c.h);
				
        if (parseInt(c.w) > 0)
        {
          var rx = 191 / c.w;
          var ry = 178 / c.h;

          $(\'#preview\').css({
            width: Math.round(rx * boundx) + \'px\',
            height: Math.round(ry * boundy) + \'px\',
            marginLeft: \'-\' + Math.round(rx * c.x) + \'px\',
            marginTop: \'-\' + Math.round(ry * c.y) + \'px\'
          });
        }
      };

    });

  </script>
';

		}
*/
?>
				<script type="text/javascript" src="js/stratAdmin.js"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

		<script>
			function confirmDelete(delUrl) {
  				if (confirm("Are you sure you want to delete")) {
    				document.location = delUrl;
  				}
			}
		</script>
	</head>
	<body>
	<div id="wrapper">
		
		
	<?php 
		
		// LOGOUT WAS CLICKED DESTROY SESSION AND CONFIRM
		if ($_GET[logout]) {
			session_destroy();
			$logMessage = 3;
			Users::displayLogin('login', $logMessage);
		
		// NOT LOGGED IN DISPLAY LOGIN FORM
		} elseif (!$_SESSION[id]) {
			Users::displayLogin('login', $logMessage);
		} else {
			
			// WE ARE LOGGED IN NOW WAT DO YOU WANT TO DO
			include "includes/admin-nav.inc";
			require_once "class/components.class.inc";
			$components = new Components;
			$componentList = $components->listComponents();

			
				if ($comp) {
					Components::subNav($comp);
					 if ($action == "") {
					 	$list = $components->listItems($comp);
					 	echo Components::displayList($list, $comp);
					 }
					 if ($action == "add") {
					 	$form = $components->form($comp);
					 	
					 		if ($process) {
					 			$added = $components->insert($comp, $_POST);
					 		}
					 	
					 }
					 if ($action == "update") {
					 	$where = "id = '" . $_GET[id] . "'";
					 	$record = $components->listItems($comp, $where);
					 	
					 		if ($process) {
					 			$added = $components->update($comp, $_POST);
					 			$list = $components->listItems($comp);
					 			echo Components::displayList($list, $comp);
					 		} else {
					 		
					 		$form = $components->form($comp, $record);
					 	}
					 }
					 if ($action == "delete") {
					 			$deleted = $components->delete($comp, $_GET);
					 			$list = $components->listItems($comp);
					 			echo Components::displayList($list, $comp);
					 	
					 }
				} else {
				
				
					//LIST COMPONENTS ON DASHBOARD
					foreach ($componentList as $component) {
						echo Components::dashboard($component['directory'], $component['name'], $allowed);
					}
		
				}
	
		} // END AUTHORIZATION IF
	?>
	
	
	</div>
	</body>
</html>