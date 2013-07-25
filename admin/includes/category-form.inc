<?php
//include "../class/categories.class.inc";
//$categories = new Categories;

?>
<form acton="?&action=edit" method="post" name="category" id="admin">
	<input type="hidden" name="id" value="<?php echo $category[0][id]; ?>">
	<input type="hidden" name="hidden" value="<?php echo $hidden; ?>">
<fieldset>
<legend>Category ID = <?php echo $category[0][id]; ?><?php echo $message; ?></legend>
<ol>
	<!-- <li><label for="">Display Order</label><input type="text" name="sortBy" value="<?php echo $category[0][sortBy]; ?>"></li> -->
	<li><label for="">Category Name</label><input type="text" name="name" value="<?php echo $category[0][name]; ?>"></li>
	<li><label for="">Category Slug</label>&nbsp;<?php echo $category[0][slug]; ?></li>
	<li><label for="">Parent</label>
	

<?php
if ($category[0]['parent']) {
	$where = "id = '" . $category[0]['parent'] . "'";
	$selected = $categories->getData($where);
}
$data = $categories->getData($category[0][id]);
echo Categories::catSelect($selected, 'parent', $data);
?>
			</li>
</ol>
</fieldset>
<fieldset>
<button type="submit">Submit</button>
</fieldset>