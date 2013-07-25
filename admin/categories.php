<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
include "class/categories.class.inc";
$comp = 'categories';
$categories = new Categories;
$categoryList = $categories->getData();
$whereParent = "parent = 0";
$topLevel = $categories->getData($whereParent);
	
	if (isset($_GET['action'])) {
  		$action = $_GET['action'];
	}
		if (isset($_GET['id'])) {
  		$categoryId = $_GET['id'];
	}

?>
<html>
	<head>
		<title>Categories</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, print">
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
		
		if ($action == 'edit') {
			if ($_POST['id']) {
					$newSlug = preg_replace("![^a-z0-9]+!i", "-", $_POST['name']);
					$newSlug = strtolower($newSlug);
						
					$_POST['slug'] = $newSlug;
			 		$update = $categories->updateRecord($_POST);
			 		$message = " - Category Updated";
			 }
			
			$where = "id = '" . $categoryId . "'";
			$category = $categories->getData($where);
			include "includes/category-form.inc";
			
			} elseif ($action == 'add') {
				$hidden = 'new';
				if ($_POST[hidden] == 'new') {
						$newSlug = preg_replace("![^a-z0-9]+!i", "-", $_POST['name']);
						$newSlug = strtolower($newSlug);
						
						$_POST['slug'] = $newSlug;
			 			$insert = $categories->insertRecord($_POST);
			 			$message = " - Category Added";
			 		}
			include "includes/category-form.inc";
		
			} else {
		 		if  ($action == 'delete') { 
		 			$where[id] = $categoryId;
					$delete = $categories->deleteRecord($where);
		 		}
		echo '<div class="table">
					<div class="table-row">
						<div><a href="?&action=">List All Categories</a> | <a href="?&action=add">Add a Category</a></div>
					</div>
					<div class="clear"></div>
					<div class="table-row">
						<div class="table-item" style="width:30px">&nbsp;</div>
						<div class="table-item" style="width:30px">&nbsp;</div>
						<div class="item-short">ID</div>
						<div class="item-long">Category Name</div>
						<div class="item-long">Slug</div>
						<div class="item-short">Display Order</div>
						<div class="clear"></div>
					</div>';
		foreach ($topLevel as $parent) {
		
				$whereChild = "parent = ".$parent['id']."";
				$children = $categories->getData($whereChild);

				$theHtml .= '<div class="table-row">';
				$theHtml .= '	<div class="table-item" style="width:30px">
									<a href="?comp=' . $comp . '&action=edit&id=' . $parent['id'] . '" title="EDIT / VIEW">
										<img src="./images/edit.gif">
									</a>
								</div>
    							<div class="table-item" style="width:30px">
    								<a href="javascript:confirmDelete(\'?comp=' . $comp . '&action=delete&id=' . $parent['id'] . '\')">
    									<img src="./images/delete.gif">
    								</a>
    							</div>
								<div class="item-short">' . $parent['id'] . '</div>    			
								<div class="item-long">
									<a href="?&id=' . $parent['id'] . '&action=edit">' . $parent['name'] . '</a>
								</div>
								<div class="item-long">' . $parent['slug'] . '</div>
								<div class="item-short">' . $parent['sortBy'] . '</div>
								<div class="clear"></div>
							</div>';
				if ($children) {
					foreach ($children as $child) {
						$theHtml .= '<div class="table-row">';
				$theHtml .= '	<div class="table-item" style="width:30px">
									<a href="?comp=' . $comp . '&action=edit&id=' . $child['id'] . '" title="EDIT / VIEW">
										<img src="./images/edit.gif">
									</a>
								</div>
    							<div class="table-item" style="width:30px">
    								<a href="javascript:confirmDelete(\'?comp=' . $comp . '&action=delete&id=' . $child['id'] . '\')">
    									<img src="./images/delete.gif">
    								</a>
    							</div>
								<div class="item-short">' .$child['id'] . '</div>    			
								<div class="item-long">
									&nbsp;&nbsp;&nbsp;&nbsp;|_&nbsp;<a href="?&id=' . $child['id'] . '&action=edit">' . $child['name'] . '</a>
								</div>
								<div class="item-long">' . $child['slug'] . '</div>
								<div class="item-short">' . $child['sortBy'] . '</div>
								<div class="clear"></div>
							</div>';
					}
				}
				


			
		}
		$theHtml .= '</div>';
		echo $theHtml;
		}
	?>
	
	
	</div>
	</body>
</html>