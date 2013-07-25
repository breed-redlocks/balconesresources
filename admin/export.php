<?php

session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
include "class/export.class.php";
$component = $_GET['data'];
$export = new Export;
//$categoryList = $categories->getData();
$form = $export->getHtml($component, 'id');

if ($_POST['process']) {
  		header("Content-disposition: attachment; filename=spreadsheet-".$_POST['endDate'].".xls");
  		
  		//print_r($_POST);
  		
  		$data = $export->returnData();
  		//print_r($data);
  		foreach ($data as $record) {
  		
  			$theHtml .= $record['id']."\t".$record['name']."\t".$record['phone']."\t".$record['email']."\t".$record['company']."\t".$record['address']."\t".$record['state']."\t".$record['contactname']."\t".$record['details']."\n";

  		}
  		echo $theHtml;
} else {
?>
<html>
	<head>
		<title>Admin</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, print">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.14.custom.css" media="screen, print">

				<script type="text/javascript" src="js/nicEdit.js"></script>
				<script type="text/javascript" src="js/jquery-1.5.1.min.js" ></script>
				<script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>


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

include "includes/admin-nav.inc";


echo $form;

?>
</body>
</html>
<?php

}
?>