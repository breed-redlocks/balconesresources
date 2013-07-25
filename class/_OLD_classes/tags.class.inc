<?php

require_once 'database.class.inc';
require_once "error.inc";

class Tags extends Default_Table
{

    // additional class variables go here
    function Tags ()
    {
        $this->tablename       = 'tags';
        $this->dbname          = 'devjackw';
        $this->rows_per_page   = 15;
        $this->fieldlist       = array(	'id', 'slug', 'name', 'parent');
        
        $this->fieldlist['id'] = array('pkey' => 'y');
				
    } // end class constructor
    
    function getErrors() {
    echo errorHandler();
    }
    
    function catSelect($selected, $selectName, $data) {
    $html = '<select name="' . $selectName . '">';
    		if ($selected) {
    			
				$html .= '<option value="' . $selected[0]['id'] . '">' . $selected[0]['name'] . '</option>';
			} else {
				$html .= '<option value="">Select Parent Category</option>';
			}
			$html .= '<option value="">No Parent Category</option>';
			foreach ($data as $option) {
				$html .= '<option value="' . $option['id'] . '">' . $option['name'] . '</option>';
			}
			
	$html .= '</select>';
	return $html;
    
    }


} // end class
?>