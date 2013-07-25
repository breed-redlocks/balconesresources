<?php

require_once 'database.class.inc';
require_once 'users.class.inc';
$users = new Users;
require_once 'categories.class.inc';
$data = new Default_Table;

require_once "error.inc";


class Components extends Default_Table {

 function Components ()
    {
		$this->debug 		= false;
        $this->uploads		= $_FILES;
				
    } // end class constructor
   
	function getErrors() {
    echo errorHandler();
    }
  
    function displayList($list, $comp) {
    	include './components/' . $comp . '/index.php';
    	$category = new Categories;
		$numCols = count($items);
		$colWidth_a = floor(100 - $numCols);
		$colWidth = floor($colWidth_a / $numCols);
    	$i=0;
    	
    	$html = '<div class="table">'."\n";
    	$html .= '<div class="table-row-legend">'."\n";
    	$html .= '<div class="table-item" style="width:30px">&nbsp;</div>'."\n";
    	$html .= '<div class="table-item" style="width:30px">&nbsp;</div>'."\n";
    	//echo "<pre>";
    	//print_r($items);
    	//echo "</pre>";
    		foreach ($items as $item) {
    			if ($item['display'] == "yes") {
    				$html .= '<div class="table-lable" style="width:' . $item['displayWidth']. '">' . $item['lable'] . '</div>';
    				$matches[$i]['field'] = $item['name'];
    				$matches[$i]['width'] = $item['displayWidth'];
    				$matches[$i]['limit'] = $item['displayWordLimit'];
    				$matches[$i]['display'] = $item['display'];
    				$matches[$i]['dataTable'] = $item['dataTable'];
    				$matches[$i]['type'] = $item['type'];

    				$i++;
    			}
    		}
    	$html .= '<div class="clear"></div></div>';
    	//print_r ($matches);
		// START DYNAMIC TABLE ROW CREATION
		function limitWords($string, $word_limit) {
    			$words = explode(" ",$string);
    		return implode(" ",array_splice($words,0,$word_limit));
		}
//print_r($list);
    		foreach ($list as $listPart) {
    			$html .= '<div class="table-row">'."\n";
    			$html .= '<div class="table-item" style="width:30px"><a href="?comp=' . $comp . '&action=update&id=' . $listPart['id'] . '" title="EDIT / VIEW"><img src="./images/edit_button.png"></a></div>'."\n";
    			$html .= '<div class="table-item" style="width:30px"><a href="javascript:confirmDelete(\'?comp=' . $comp . '&action=delete&id=' . $listPart['id'] . '\')"><img src="./images/delete_button.png"></a></div>'."\n";
    			
    		    $x=0;
//print_r ($listPart);
    			foreach ($listPart as $key => $value) { 

    				if (in_array($key, $matches[$x])) {
    					if ($matches[$x]['field'] == 'categories') {
    							$value = explode("::", $value);
    							$value_b = '';
    							foreach ($value as $cat) {
    							
    								$where = "id = '" . $cat . "'";
    								$value_a = $category->getData($where);
									$value_b .= $value_a[0]['name'] . "<br>";
									$value = $value_b;
							}
    					    					}
    							
    							
    		

    				if ($matches[$x]['limit'] > 0) {
    						$wordCount = count(explode(" ",$value));
    					
    						if ($wordCount > $matches[$x]['limit']) {
    								$value = strip_tags(limitWords($value, $matches[$x]['limit']), '<br>').' ... <a href="?comp='.$comp.'&action=update&amp;id=' . $listPart['id'] . '"> - More</a>';
    						}
    						
    				}

    					$html .= '<div class="table-item" style="width:' . $matches[$x]['width'] . '">' . $value . '</div>'."\n";
    					$x++;
    			} 
    					
    					
    				}

    		$html .= '<div class="clear"></div></div>'."\n";    				
    		
    		}
    $html .= '</div>'; // END TABLE
    	
    	return $html;
    }
    
    function listItems ($comp,$where) {
    
    	//echo $comp. '- COMP<br>';
    	//echo $where. '- WHERE<br>';
    
		include './components/' . $comp . '/index.php';
    	$fieldList = '';
    		foreach ($items as $item) {
    			$fieldList .= "'" . $item['name'] . "', ";
    		}
       	//////////
    		//
    		// BASED ON COMPONENT PASSED AS TABLE, LIST ALL ITEMS IN DATABASE
    	//	//
    	//////

        $this->tablename       = $comp;
        $this->dbname          = 'brdevdb';
        $this->rows_per_page   = 1000;
        $this->fieldlist       = array($fieldList);
        $this->fieldlist['id'] = array('pkey' => 'y');
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
				
			$itemList =	Default_Table::getData($where);
			//print_r($itemList);
			return $itemList;
    }
   
    function insert ($comp, $post) {
    //echo 'COMPONENT = '.$comp;
		include './components/' . $comp . '/index.php';
		//print_r($post);
    	$fieldList = array();
    	$i=0;
    		foreach ($items as $item) {
    			if ($item['dynamic'] == "yes") {
    				$maxnum = 1;
    				while ($maxnum <= $item['maxnumber']){
    					$fieldList[$i] = $item['sname'].''.$maxnum;
    					$maxnum++;
    					$i++;
    				}
    				echo $item['name']." is dynamic<br>";
    			} else {
    			$fieldList[$i] = $item['name'];
    			$i++;
    			}
    			
    		}
    		//echo "<br>";
			//print_r($fieldList);
       	//////////
    		//
    		// PROCESS POST AND INSERT NEW RECORD
    	//	//
    	//////

        $this->tablename       = $comp;
        $this->dbname          = 'brdevdb';
        $this->rows_per_page   = 15;
        $this->fieldlist       = $fieldList;
        $this->fieldlist['id'] = array('pkey' => 'y');
        
        $x=1;
      	foreach($this->uploads as $media) {
      		$addToPost = $this->pathToDb($media, $comp, $media['name']);
      		if ($media['name'] != '') {
      		$post['mediaPath'.$x] = $addToPost;
      		}
      		$x++;

      	}
//print_r($post);
        foreach ($post as $key => $value) {
        		if ($key != "process") {
        			if (is_array($value)) {
        				$value = implode('::', $value);
        				$record[$key] = $value;
        			} else {
        			//echo $value."<br>";
        				$record[$key] = addslashes($value);
        				//$record[$key] = $this->cleanData($value);
        			}
				}

			}
		// DEBUG
		if ($this->debug) {
			echo "<pre>";
			print_r($post);
			print_r ($record);
			echo "</pre>";
		}
			$addedRecord =	Default_Table::insertRecord($record);
			return $addedRecord;
    }
    
    function update ($comp, $post) {
		include './components/' . $comp . '/index.php';
    	$fieldList = array();
    	$i=0;
    		foreach ($items as $item) {
    			$fieldList[$i] = $item['name'];
    			$i++;
    		}

       	//////////
    		//
    		// PROCESS POST AND UPDATE RECORD
    	//	//
    	//////

        $this->tablename       = $comp;
        $this->dbname          = 'brdevdb';
        $this->rows_per_page   = 15;
        $this->fieldlist       = $fieldList;
        $this->fieldlist['id'] = array('pkey' => 'y');

		$x=1;
      	foreach($this->uploads as $media) {
      		$addToPost = $this->pathToDb($media, $comp, $media['name']);
      		if ($media['name'] != '') {
      		$post['mediaPath'.$x] = $addToPost;
      		}
      		$x++;

      	}
      
        foreach ($post as $key => $value) {
        		if ($key != "process") {
        			if (is_array($value)) {
        				$value = implode('::', $value);
        				$record[$key] = $value;
        			} else {
        				//$record[$key] = $value;
        				$record[$key] = $this->cleanData($value);
        				}
				}

			}
		// DEBUG
		if ($this->debug) {
			echo "<pre>";
			print_r($post);
			print_r ($record);
			echo "</pre>";
		}
			$updatedRecord =	Default_Table::updateRecord($record);
			return $updatedRecord;
    }
    
    function delete ($comp, $get) {
       	//////////
    		//
    		// PROCESS POST AND DELETE RECORD
    	//	//
    	//////

        $this->tablename       = $comp;
        $this->dbname          = 'brdevdb';
        $this->rows_per_page   = 15;
        $this->fieldlist       = array('id', 'title', 'body');
        $this->fieldlist['id'] = array('pkey' => 'y');

        $record['id'] = $get['id'];
		$deletedRecord =	Default_Table::deleteRecord($record);
			
			return $deletedRecord;
    }
    

    function subNav($component) {
       	//////////
    		//
    		// READ COMPONENT INDEX.PHP AND CREATE SUBNAV
    	//	//
    	//////

    	include './components/' . $component . '/index.php';
    	echo '<div id="sub-nav">';
    		$i=0;
    		foreach ($subnav as $link) {
    			if ($link['action'] == 'export') {
    				echo '	<div class="sub-nav-item">
    					<a href="export.php?data=' . $component . '" target="_blank">' . $link['title'] . '</a> - | - 
    				</div>';
    			} else {
    				echo '	<div class="sub-nav-item">
    					<a href="?comp=' . $componentLink . '&action=' . $link['action'] . '">' . $link['title'] . '</a> - | - 
    				</div>';
    			}
    		
    		$i++;
    		}
    	echo '<div class="clear"></div></div>';
    }
    
    function dashboard($component, $theName, $allowed) {
       	//////////
    		//
    		// READ COMPONENT INDEX.PHP AND CREATE SUBNAV
    	//	//
    	//////
		
    	include './components/' . $component . '/index.php';
    	//echo $theName;
    	//print_r($allowed);
    	if ($_SESSION['accessLevel'] > 0) {
    		echo '<div id="dashboard-block" style="background-image:url(./components/' . $component . '/' . $icon . ');">
    				<h3><center>' . $componentName . '</center></h3>';
    		
    		$i=0;
    		foreach ($subnav as $link) {
    			
    				echo '	<div class="dashboard-block-item">
    							<a href="?comp=' . $componentLink . '&action=' . $link['action'] . '">' . $link['title'] . '</a>
    						</div>';
    			
    		$i++;
    		}
    	
    	echo '<div class="clear"></div></div>';
    	} else {
    	if (in_array($theName,$allowed)) {
    		echo '<div id="dashboard-block" style="background-image:url(./components/' . $component . '/' . $icon . ');">
    				<h3><center>' . $componentName . '</center></h3>';
    		
    		$i=0;
    		foreach ($subnav as $link) {
    			
    				echo '	<div class="dashboard-block-item">
    							<a href="?comp=' . $componentLink . '&action=' . $link['action'] . '">' . $link['title'] . '</a>
    						</div>';
    			
    		$i++;
    		}
    	
    	echo '<div class="clear"></div></div>';
    	}
    	}
    }

    function form($component, $record) {
       	//////////
    		//
    		// READ COMPONENT INDEX.PHP AND CREATE ADD / EDIT FORM
    	//	//
    	//////
    	
		$cats= new Categories;
    	include './components/' . $component . '/index.php';
    		if ($record[0]['id']) {
    			$recordId = $record[0]['id'];
    		}
    	
    	echo '<form id="admin" name="user" method="post" acton="?&amp;action=edit" enctype="multipart/form-data">
				<input type="hidden" name="id" value="' . $recordId . '">
				<input type="hidden" value="1" name="process">
				<fieldset>
				<legend>' . $itemName . '</legend>
				<ol>';
    		$i=0;
    		foreach ($items as $formField) {
    			// MAKE SURE FIELD IS SET TO BE EDITABLE
    			if ($formField['edit'] == "yes") {
    					
    					if ($formField['dynamic'] == "yes") {
    						echo '<li>';
    					} else {
    						echo '<li><label for="' . $formField['name'] . '">' . $formField['lable'] . ': </label> ' . "\n";
    					}
    			
    				// NORMAL TEXT FIELD
    				if ($formField['type'] == "text") {
    					echo '<input type="text" value="' . $record[0][$formField['name']] . '" name="' . $formField['name'] . '"></li>' . "\n";
    				}
    				// DATE FIELD
    				if ($formField['type'] == "date") {
    					echo '<input id="datepicker" type="text" value="' . $record[0][$formField['name']] . '" name="' . $formField['name'] . '"></li>' . "\n";
    				}
    				// DYNAMIC TEXT BOXES
    				if ($formField['type'] == "dynoText") {
    					echo '<br>	
    							<div id="input1" style="margin-bottom:4px;" class="clonedInput">
        						' . $formField['lable'] . '
        								<input type="text" id="' . $formField['name'] . '" value="' . $record[0][$formField['name']] . '" name="' . $formField['name'] . '">
       								</div>
    								<div>
        								<input type="button" id="btnAddResearchTitle" value="add another name" />
        								<input type="button" id="btnDelResearchTitle" value="remove name" />
    								</div></li>' . "\n";
    				}
    				// NORMAL TEXT AREA
    				if ($formField['type'] == "textarea") {
    					echo '<br><textarea name="' . $formField['name'] . '" rows="4">' . stripslashes($record[0][$formField['name']]) . '</textarea>' . "\n";
    				}
    				// TEXT AREA WITH EDITOR
    				if ($formField['type'] == "textareaC") {
    					echo '<br><textarea id="editor" name="' . $formField['name'] . '" cols="20" rows="10">' . stripslashes($record[0][$formField['name']]) . '</textarea>' . "\n";
    				}
    				// COMPONENT SELECT
    				if ($formField['type'] == "component") {
    					$componentSelect = $this->componentList($formField['name'], $record[0][$formField['name']]);
    					echo $componentSelect;
    				}
    				if ($formField['type'] == "select") {
    					if ($formField['multiple'] == "yes") {
    						$multiple = "multiple";
    					} else {
    						$multiple = '';
    					}
    					$select = Components::createSelect($formField['dataTable'], $record[0][$formField['dataTable']], $component, $formField['name'], $multiple);
    					echo $select;
    				}
    				if ($formField['type'] == "selectYN") {
    					if ($formField['multiple'] == "yes") {
    						$multiple = "multiple";
    					} else {
    						$multiple = '';
    					}
    					$where = "id = '" . $record[0]['id'] . "'";
    					$selected = Components::listItems($component, $where);
    					$select = Components::createSelectYN($formField['name'],$record[0][$formField['dataTable']],$selected);
    					echo $select;
    				}
    				if ($formField['type'] == "selectProvider") {
    					$where = "id = '" . $record[0]['id'] . "'";
    					$selected = Components::listItems($component, $where);
    					$select = Components::createSelectProvider($formField['name'],$record[0][$formField['dataTable']],$selected);
    					echo $select;
    				}
    				
    				if ($formField['type'] == "selectType") {
    					$where = "id = '" . $record[0]['id'] . "'";
    					$selected = Components::listItems($component, $where);
    					$select = Components::createSelectType($formField['name'],$record[0][$formField['dataTable']],$selected);
    					echo $select;
    				}
    				if ($formField['type'] == "file") {
    					$select = Components::createUpload($record[0][$formField['name']], $component, $formField['name']);
    					echo $select;
    				}
    				if ($formField['type'] == "catSelect") {
    					$allCats = Components::listItems('categories', '');
    					$where = "id = '" . $record[0]['categories'] . "'";
    					//echo $where;
						$selected = Components::listItems('categories', $where);
    					$select = $cats->catSelect($selected, $formField['name'],$allCats);
    					echo $select;
    				}
    				
    				if ($formField['type'] == "userSelect") {
						$allUsers = Components::listItems('users', '');
						$where = "id = '" . $record[0][$formField['name']] . "'";
						$selected = Components::listItems('users', $where);
						$selected = '<option value="' . $selected[0]['id'] . '" selected>' . $selected[0]['name'] . ' ' . $selected[0]['lastName'] . '</option>';
						//print_r($selected);
    					$select = Users::userSelect($allUsers, $selected);
    					echo $select;
    				}
    				if ($formField['type'] == "profileSelect") {
    					if ($formField['multiple'] == "yes") {
    						$multiple = "multiple";
    					} else {
    						$multiple = '';
    					}
    					$where = "id = '" . $record[0]['id'] . "'";
						$selected = Components::listItems($component, $where);
						$selected = $selected[0][$formField['name']];
						
    					$select = Components::createSelect($formField['dataTable'], $selected, $component, $formField['name'], $multiple);
    					echo $select;
    				}
    			
    			
    			$i++;
    			}
    		}
    	echo '</ol>
    			<fieldset>
					<button type="submit">Submit</button>
				</fieldset>';
    }
    
    function listComponents() {
		$directory = opendir("./components");
		$pages = array();
     	
     		while($entryName = readdir($directory)) {
       			$dirArray[] = $entryName;
     		}
     	closedir($directory);
     	$indexCount   = count($dirArray);
     	sort($dirArray);
     
     		for($index=0; $index < $indexCount; $index++) {
     		
          		if (substr("$dirArray[$index]", 0, 1) != "." && substr("$dirArray[$index]", 0, 9) !="index.php"){ // don't list hidden files
          			
          			$file =  './components/' . $dirArray[$index] . '/index.php';
          			include $file;
          				$i=0;
          				foreach ($subnav as $link) {
          					$list[$index]['subnav'][$i];
          					$i++;
          				}
          			
          			$list[$index]['subnav'] = $subnav;
           			$list[$index]['name'] = $componentName;
					$list[$index]['directory'] = $dirArray[$index];
					
       			}
       
     		}
     		return $list;
	}
	
	// CREATE COMPONENT SELECT FOR PAGE ADD / EDIT
	function componentList($selectName, $selected) {
		$directory = opendir("./components");
		$pages = array();
		$theHtml = '<select name="' . $selectName . '">';
		$theHtml .= '<option value ="none" selected>Select Component</option>';
		
			if ($selected) {
					$where = "id = '" . $selected . "'";
					$theHtml .=  '<option value ="' . $selected . '" selected>' . $selected . '</option>';
				
			}
     	
     		while($entryName = readdir($directory)) {
       			$dirArray[] = $entryName;
     		}
     	closedir($directory);
     	$indexCount   = count($dirArray);
     	sort($dirArray);
     
     		for($index=0; $index < $indexCount; $index++) {
     		
          		if (substr("$dirArray[$index]", 0, 1) != "." && substr("$dirArray[$index]", 0, 9) !="index.php"){ // don't list hidden files
          		        		
          			$theHtml .= '<option value ="' . $dirArray[$index] . '">' . $dirArray[$index] . '</option>';
					
       			}
       	
     		}
     		$theHtml .= '</select>';
     		return $theHtml;
	}
	
	
	function createSelect($listTable, $selectedId, $selectedTable, $selectName, $multiple) {
				// listTable is the table for the population of the select
				// selectedId is the id of the option that is selected
				// selectedTable is the table where the data is or will be stored
				// Name of the select list
			
		$options = Components::listItems($listTable, '');	
		
		if ($selectedId) {
			$selectedIds = explode("::", $selectedId);
			$selected = '';
			foreach ($selectedIds as $chosen) {
				$where = "id = '" . $chosen . "'";
				$record = Components::listItems($listTable, $where);
				$selected .=  '<option value ="'.$record[0]['id'].'" selected>'.$record[0]['name'].' '.$record[0]['lastName'].'</option>';
				
			}
			
		} else {
			$selected = '<option value ="" selected>Choose One</option>';
		}
		if ($multiple) {
			$selectName = $selectName . '[]';
			$size = "size=20";	
		}
				$html = '<select name="' . $selectName . '" ' . $multiple . ' '.$size.'>';
				$html .= $selected;
    			
    					foreach ($options as $option) {
    						$html .= '<option value ="'.$option['id'].'">'.$option['name'].' '.$option['lastName'].'</option>';
    					}
    			$html .= '</select>' . "\n";
    			
    			return $html;
	}
	
	function createSelectYN($selectName,$selectedValue,$selected) {
	
		//print_r($selected);
		$selectedX = $selected[0][$selectName];
		$html = '<select name="' . $selectName . '">';
	
		if ($selectedX) {
			if ($selectedX == 0){
				$html .=  '<option value ="0" selected>No</option>';
			} elseif ($selectedX == 1){
				$html .=  '<option value ="1" selected>Yes</option>';
			}
			
		} else {
			$html .= '<option value ="" selected>Choose One</option>';
		}

				
    			$html .= '<option value="0">No</option>';
    			$html .= '<option value="1">Yes</option>';
    			$html .= '</select>' . "\n";
    			
    			return $html;
	}
	
	function getName($id, $table) {
		$where = "id = '" . $id . "'";
		$name = Components::listItems($table, $where);
		return $name;
	
	}
	
function createSelectProvider($selectName,$selectedValue,$selected) {
	
		//print_r($selected);
		$selectedX = $selected[0][$selectName];
		$html = '<select name="' . $selectName . '">';
	
		if ($selectedX) {
			if ($selectedX == 0){
				$html .=  '<option value ="0" selected>Core Service Provider</option>';
			} elseif ($selectedX == 1){
				$html .=  '<option value ="1" selected>Specialized Service Provider</option>';
			}
			
		} else {
			$html .= '<option value ="" selected>Choose One</option>';
		}

				
    			$html .= '<option value="0">Core Service Provider</option>';
    			$html .= '<option value="1">Specialized Service Provider</option>';
    			$html .= '</select>' . "\n";
    			
    			return $html;
	}
	
	function createSelectType($selectName,$selectedValue,$selected) {
	
		//print_r($selected);
		$selectedX = $selected[0][$selectName];
		$html = '<select name="' . $selectName . '">';
	
		if ($selectedX) {
			if ($selectedX == "1norm"){
				$html .=  '<option value ="1norm" selected>Normal</option>';
			} elseif ($selectedX == "4url"){
				$html .=  '<option value ="4url" selected>Website</option>';
			} elseif ($selectedX == "2abs"){
				$html .=  '<option value ="2abs" selected>Abstract</option>';
			} elseif ($selectedX == "3pdf"){
				$html .=  '<option value ="3pdf" selected>PDF</option>';
			}
			
		} else {
			$html .=  '<option value ="1norm" selected>Normal</option>';
		}

				
    			$html .= '<option value="1norm">Normal</option>';
    			$html .= '<option value="4url">Website</option>';
    			$html .= '<option value="2abs">Abstract</option>';
    			$html .= '<option value="3pdf">PDF</option>';
    			$html .= '</select>' . "\n";
    			
    			return $html;
	}
	
	
	function createUpload($value, $component, $selectName) {
	
		if (!$value) {
			$value = 'no-image.jpg';
			//$width = '140px';
		} else {
			$newFile = '../rsrc/' . $component . '/NEW_' . $value;
			if (file_exists($newFile)) {
    			$value = 'NEW_'.$value;
    			echo 'New'.$value;
			} else {
    			$value = $value;
    			echo 'OLD . . . .'.$newFile;
			}
		}
		

		$html = '<input type="file" name="' . $selectName . '" size="35"><br>';
		if ($component == "news") {
			$html .= '	<br>
						<img id="target" src="/rsrc/' . $component . '/' . $value . '" width="' . $width . '">
						<div style="width:170px;height:173px;overflow:hidden;">
							<img src="/rsrc/' . $component . '/' . $value . '" id="preview" alt="Preview" class="jcrop-preview" />
						</div>
						<input type="hidden" size="4" id="x1" name="x1" />
						<input type="hidden" size="4" id="y1" name="y1" />
						<input type="hidden" size="4" id="x2" name="x2" />
						<input type="hidden" size="4" id="y2" name="y2" />
						<input type="hidden" size="4" id="w" name="w" />
						<input type="hidden" size="4" id="h" name="h" />';
		} else {
		$html .= '<br><img id="target" src="/rsrc/' . $component . '/' . $value . '" width="' . $width . '">';
		}
		$html .= '</li>';
		$html .= $addMore;
		return $html;
	
	}

	function uploadMedia($files, $comp, $arrayName) {
	
		//print_r($files);
 
 		if ($files[$arrayName]["error"] > 0) {
  			echo "Error: " . $files["error"] . "<br />";
  		} 
  		
  		else {
  			$this->resizeImage($files, $comp, $files["tmp_name"]);
  		} 
  		//if (move_uploaded_file($files["tmp_name"], "../rsrc/$comp/orig_" . $files["name"])) {
  		//	$this->resizeImage($files, $comp, $files["tmp_name"]);

     	//} else {
       //		echo "FAILD MOVE";
     	//}
	}

	function pathToDb($media, $comp, $name) {
			$message = '';
		if ($media['name'] != '') {
     		 $message .= $this->uploadMedia($media, $comp, $name); 
     		 
     		 $addToPost = $media['name'];
      }
      return $addToPost;
	}
	
	function cleanData($data) {
		$data = mysql_real_escape_string($data);
		//$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
		return $data;
	}
	
	function cropImages($height, $width, $files, $comp ) {
		$targ_w = $width;
		$targ_h = $height;
		$jpeg_quality = 90;
print_r($files);
		$src = "../rsrc/$comp/" . $files['name'];
		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],
    	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		
		$output_filename = "../rsrc/$comp/NEW_" . $files['name'];
		
		//header('Content-type: image/jpeg');
		imagejpeg($dst_r, $output_filename, $jpeg_quality);
		echo 'CREATED NEW CROPPED IMAGE '.$output_filename.'<br>';
		//echo 'output_filename'.$output_filename.'<br>';
		//echo 'jpeg_quality'.$jpeg_quality.'<br>';
		
	}
	
	function resizeImage($files, $comp, $orig) {
			if ($comp == 'none') {
				// SKIP RESIZE ROUTINE
				move_uploaded_file($orig, "../rsrc/$comp/" . $files["name"]);
			} elseif ($comp == 'people') {
				// SKIP RESIZE ROUTINE
				move_uploaded_file($orig, "../rsrc/$comp/" . $files["name"]);
			} elseif ($comp == 'news') {
				// SKIP RESIZE ROUTINE
				move_uploaded_file($orig, "../rsrc/$comp/" . $files["name"]);
				echo 'Primary image created in '. "../rsrc/$comp/" . $files["name"].'<br>';
				//$tempImage = "../rsrc/$comp/" . $files["name"];
				$this->cropImages(173, 170, $files, $comp);
				//echo 'Primary image created in '. "../rsrc/$comp/" . $files["name"];
			} else {
			
				if ($comp == 'newsBAK') {
					$n_width	= 170; // Fix the width of the thumb nail images
					//$n_height	= 125; // Fix the height of the thumb nail imaage
				} elseif ($comp == 'projects') {
					$n_width	= 925; // Fix the width of the thumb nail images
					//$n_height	= 125; // Fix the height of the thumb nail imaage
				} else {
					print_r($files);
					echo "<h1>COMPONENT NOT IDENTIFIED FOR resizeImage() in components.class.inc</h1>";
				}
		
		$tsrc		= "../rsrc/$comp/".$files['name']; // Path where thumb nail image will be stored
		echo "<br>".$tsrc;

			if (!($files['type'] =="image/jpeg" OR $files['type']=="image/gif")) {
				echo "Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
				exit;
			}
			
			//////////// Starting of GIF thumb nail creation///////////
			if ($files['type']=="image/gif")	{
				$im=imagecreatefromgif($orig);
				$width=imagesx($im); // Original picture width is stored
				$height=imagesy($im); // Original picture height is stored
				$newimage=imagecreatetruecolor($n_width,$n_height);
					imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
						if (function_exists("imagegif")) {
							Header("Content-type: image/gif");
							imagegif($newimage,$tsrc);
						} elseif (function_exists("imagejpeg")) {
							Header("Content-type: image/jpeg");
							imagejpeg($newimage,$tsrc);
						}
				chmod("$tsrc",0777);
			}
			////////// end of gif file thumb nail creation//////////

			////////////// starting of JPG thumb nail creation//////////
			if($files['type']=="image/jpeg") {
				$im=imagecreatefromjpeg($orig);
				$width=imagesx($im); // Original picture width is stored
				$height=imagesy($im); // Original picture height is stored
				$ratio= $n_width / $width;
            	$n_height= $height * $ratio;
				$newimage=imagecreatetruecolor($n_width,$n_height);
					imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
					imagejpeg($newimage,$tsrc);
				chmod("$tsrc",0777);
			}
			//////////////// End of JPG thumb nail creation //////////
		}

	}

} // end class
?>