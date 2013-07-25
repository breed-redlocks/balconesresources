<?php

require_once 'database.class.inc';
require_once "error.inc";

class Funfact extends Default_Table
{

    // CLASS VARIABLES
    function Funfact ()
    {
        $this->tablename      	= 'funfact';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'fact', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby = 'id';
  		$this->sql_orderby_seq = "ASC";
        $this->funfacts			= Default_Table::getData();
				
    } // END CLASS CONSTRUCTOR
    
    // HANDLE ERRORS 
    function getErrors() {
    	echo errorHandler();
    }
	
	// CREATE HTML TO SEND TO PAGE
	//
	// GET HTML
	//////////////////////////////

    function getHtml($selector,$selectValue,$pageTitle,$category,$subcategory) {
    		
    	$theHtml .= '';
		return $theHtml;
	}


	function getRandomFact() {

		$fact = $this->funfacts[rand(0,(count($this->funfacts))-1)];
				
		return $fact;
	}

	
	function getPage() {
		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);

   		if ($path_parts['dirname'] == "/") {
   			if (!$path_parts['basename']) {
   				$thePage['page'] = "home";
   			} else {
   				$thePage['page'] = $path_parts['basename'];
   			}
   		} else {
   			$thePage['page'] = $path_parts['basename'];
   			$thePage['section'] = $path_parts['dirname'];
   		}
   		
   		return $thePage;
   	}
	
		
} // END CONTACT CLASS
?>