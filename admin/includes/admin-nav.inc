<?php
require_once "class/components.class.inc";
$components = new Components;
$componentList = $components->listComponents();
require_once('settings.php');

if ($_SESSION['accessLevel'] > 0) {
$topNav = '<div id="nav-top">
				<div id="logo"><img src="/admin/images/smallLogo.jpg"></div>
				<div class="nav-item top-item"><a href="index.php">Dashboard</a></div>
				<div class="nav-item top-item"><a href="users.php">Users</a></div>
				<div class="nav-item top-item"><a href="categories.php">Categories</a></div>
				<div class="nav-item top-item"><a href="index.php?&logout=1">Logout</a></div>
				<div class="clear"></div>
			</div>';
} else {
$topNav = '<div id="nav-top">
				<div class="nav-item"><a href="index.php">Dashboard</a></div>
				<div class="nav-item"><a href="categories.php">Categories</a></div>
				<div class="nav-item"><a href="index.php?&logout=1">Logout</a></div>
				<div class="clear"></div>
			</div>';
}
?>

<div id="nav">
	<?php echo $topNav; ?>
	<div id="nav-bottom">
<?php
	if ($_SESSION['accessLevel'] > 0) {
		foreach ($componentList as $component) {
			echo '<div class="nav-item"><a href="/admin/?comp=' . $component['directory'] . '&action=">' . $component['name'] . '</a></div>';
		}
	} else {
		foreach ($componentList as $component) {
			if (in_array($component['name'],$allowed)) {
				echo '<div class="nav-item"><a href="/admin/?comp=' . $component['directory'] . '&action=">' . $component['name'] . '</a></div>';
			}
			
		}
	}
?>
	<div class="clear"></div>
	</div>
	
</div>