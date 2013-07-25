<?php

require_once 'database.class.inc';
require_once "error.inc";

class Research extends Default_Table
{

    // CLASS VARIABLES
    function Research ()
    {
        $this->tablename      	= 'research';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 100;
        $this->fieldlist       	= array(	'id', 'name', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->orderby			= 'sortBy';
        $this->researchList		= Default_Table::getData();
				
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
	
		$theHtml = '<div style="height:300px">&nbsp;</div>';
				return $theHtml;
		}
		
	function homeBadges() {
		$theHtml = 'Module Class Only';
				return $theHtml;
	
	}
	} // END CONTACT CLASS
?>