<?php

require_once 'database.class.inc';
require_once "error.inc";

class Pressreleases extends Default_Table
{

    // CLASS VARIABLES
    function Pressreleases ()
    {

        $this->tablename      	= 'pressreleases';
        $this->dbname          	= 'devjackw';
       // $this->rows_per_page   	= 500;
        $this->fieldlist       	= array(	'id', 'name', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        //$this->orderby			= 'date';
        $this->pressList		= Default_Table::getData();
				
    } // END CLASS CONSTRUCTOR
    
    // HANDLE ERRORS 
    function getErrors() {
    	echo errorHandler();
    }
	
	// CREATE HTML TO SEND TO PAGE
	//
	// GET HTML
	//////////////////////////////
	
	function getHtml($selector, $selectValue) {

		$theHtml = '';
						
			return $theHtml;
	}
	
	function getAll() {
		$this->rows_per_page   	= 1000;
		$this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";
  		$list = Default_Table::getData();
  		return $list;
		
	}
	
	function getEight() {
		$this->rows_per_page   	= 8;
		$this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";
  		$list = Default_Table::getData();
  		return $list;
		
	}
		
	
		} // END CONTACT CLASS
?>