<?php

require_once 'database.class.inc';
require_once "error.inc";

class Categories extends Default_Table
{

    // additional class variables go here
    function Categories ()
    {
        $this->tablename       = 'categories';
        $this->dbname          = 'brdevdb';
        $this->rows_per_page   = 100;
        $this->fieldlist       = array(	'id', 'slug', 'name', 'parent', 'sortBy');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby		= 'name';
        $this->sql_orderby_seq 	= 'ASC';
       // $this->catList			= Default_Table::getData();
        
        $this->fieldlist['id'] = array('pkey' => 'y');
				
    } // end class constructor
    
    function getErrors() {
    
     errorHandler();
    }
    
    function catSelect($selected, $selectName, $data) {
    //print_r($selected);
    	$i=0;
    	$html = '<select name="' . $selectName . '">';
    		
    		if ($selected) {
    			
				$html .= '<option value="' . $selected[0]['id'] . '">' . $selected[0]['name'] . '</option>';
			} else {
				$html .= '<option value="">Select Category</option>';
			}
			
			$html .= '<option value="">None</option>';
			
			// BREAK CATS INTO PARENTS AND CHILDREN
			foreach ($data as $cat) {
					
				if ($cat['parent'] == 0) {
				//echo $cat['id']." - ";
					$html .= '<option value="' . $cat['id'] . '">' . $cat['name'] . '</option>';
					$children1 = Categories::getChildren($cat['id'],$data);
						if (isset($children1)) {
							foreach ($children1 as $childLevel1) {
								$html .= '<option value="' . $childLevel1['id'] . '">&nbsp;&nbsp;&nbsp;&nbsp;|_' . $childLevel1['name'] . '</option>';
								$children2 = Categories::getChildren($childLevel1['id'],$data);
									if (isset($children2)) {
										foreach ($children2 as $childLevel2) {
											$html .= '<option value="' . $childLevel2['id'] . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|_' . $childLevel2['name'] . '</option>';
										}
									}

							}
						}		
				}
			}
			
			$html .= '</select>';
			return $html;
    
    }
    
    function getChildren($parentId,$data){
    	//$where = "parent = '".$parentId."'";
    	//$children = Default_Table::getData($where);
    	$i=0;
    	foreach ($data as $cat) {
    		if ($cat['parent'] == $parentId){
    			$children[$i]['id'] = $cat['id'];
    			$children[$i]['name'] = $cat['name'];
    			$children[$i]['parent'] = $cat['parent'];
    			$i++;
    		
    		}
    	
    	}
    	return $children;
    
    }


} // end class
?>