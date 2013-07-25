<?php

require_once 'database.class.inc';
require_once "error.inc";

class Constants extends Default_Table
{

    // additional class variables go here
    function Constants ()
    {
        //$this->tablename       = 'categories';
        //$this->dbname          = 'devjackw';
        //$this->rows_per_page   = 15;
        //$this->fieldlist       = array(	'id', 'slug', 'name', 'parent');
        
       // $this->fieldlist['id'] = array('pkey' => 'y');
				
    } // end class constructor
    
    function getConstants() {
    	$theUrl = $_SERVER['REQUEST_URI'];
   		$CON['path_parts'] = pathinfo($theUrl);
   		return $CON;
    }

} // end class
?>