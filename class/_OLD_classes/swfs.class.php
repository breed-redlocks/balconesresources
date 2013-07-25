<?php

require_once 'database.class.inc';
require_once "error.inc";

class Swfs extends Default_Table
{

    // CLASS VARIABLES
    function Swfs ()
    {
        require_once "pages.class.php";
       	$this->page				= new Pages;
        $this->tablename      	= 'swfs';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'name', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->orderby			= 'sortBy';
        $this->swfList		= Default_Table::getData();
				
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
	
		//echo "<br> The Selector is = ".$selector;
		//echo "<br> The Select Value is = ".$selectValue."<br>";
		
		$thePage = $this->getPage();
		//echo "<br> The page link is = ".$thePage['page']."<br>";
		
    	$where = "link = '".$thePage['page']."'";
    	$thisPageX = $this->page->getData($where);
		$thisPage = $thePage['page'];
		
		$where = "page = '".$thisPage."'";
		$pageSwf = Default_Table::getData($where);
		$theHtml = '';
		$theHtml .= '<div id="left-column-nav">
    					<div id="page-title">'.$thisPageX[0]['title'].'</div>
    					<div class="thin-seperator1">&nbsp;</div>
    				</div>
    				<div class="thin-seperator2">&nbsp;</div>
    				<div class="clear"></div>';
    				
    		if ($thisPage == "deathofcredit") {
    			if (isset($selectValue)) {
    			
    				$theHtml .= '<div id="flash-box">
    								<object width="740" height="520" type="application/x-shockwave-flash" data="/rsrc/swfs/deathofcredit.swf" id="feature" style="visibility: visible;">
    								<param name="wmode" value="transparent">
    								<param name="flashvars" value="video='.$selectValue.'">
    								</object>
    							</div>';
    			
    			} else {
    				$theHtml .= '<div id="flash-box">'.$pageSwf[0]['script'].'</div>';
    			}
    		
    			
    		
    		} else {
    		
				$theHtml .= '<div id="flash-box">'.stripslashes($pageSwf[0]['script']).'</div>';
				
			}
		return $theHtml;
		}
		
	
		
	function getPage() {
		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);
   		//print_r($path_parts);

   		if ($path_parts['dirname'] == "/") {
   			
   				$thePage['page'] = $path_parts['basename'];

   		} else {
   			$thePage['page'] = preg_replace('/[^a-zA-Z0-9-]/', '', $path_parts['dirname']);

   		}
   		
   		return $thePage;
   	}

} // END CONTACT CLASS
?>