<?php

require_once 'database.class.inc';
require_once "error.inc";

class Clients extends Default_Table
{

    // CLASS VARIABLES
    function Clients ()
    {
        $this->tablename      	= 'praise';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'name', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->orderby			= 'sortBy';
        $this->clientList		= Default_Table::getData();
				
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
	
		$theHtml = '<div id="dummy" style="height:300px;background-color:white;color:#000;font-size:30px;line-height:36px">Example headline which is 30 point tall.</div>';
				return $theHtml;
				}
		
	} // END CONTACT CLASS
?>