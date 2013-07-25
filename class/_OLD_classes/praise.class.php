<?php

require_once 'database.class.inc';
require_once "error.inc";

class Praise extends Default_Table
{

    // CLASS VARIABLES
    function Praise ()
    {
    	require_once "sidenav.class.php";
		$this->sidenav		= new Sidenav;
        $this->tablename      	= 'praise';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'name', 'mediaPath1');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->orderby			= 'name';
        $this->praiseList		= Default_Table::getData();
				
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
		$sidenav = $this->sidenav;
		$theHtml = $sidenav->getHtml('','','','');
		$theHtml .= '<div id="two-column-right">
    					<div class="thin-seperator2">&nbsp;</div>
    					<div id="praise-box">';
    					//print_r($this->praiseList);
    				foreach ($this->praiseList as $praise) {
    					if ($praise['name'] % 2 == 0) { 
 							$class = "even";
 							//echo "class - ".$class."<br>Name - ".$praise['name']."<br>-<br>";
						} else { 
							 $class = "odd"; 
							 //echo "class - ".$class."<br>Name - ".$praise['name']."<br>-<br>";
						}
    					$theHtml .= '<div id="praise-image" class="'.$class.'"><img src="/rsrc/praise/'.$praise['mediaPath1'].'"></div>';
    				}
		
		$theHtml .= '	</div>
					</div>';
				
			return $theHtml;
		}
		
	function homeBadges() {
		$theHtml = '';
		$i=0;
		foreach ($this->praiseList as $badge) {
			if ($i == 0) {
				$theHtml .= '<li class="show">
    						<img src="/rsrc/praise/' . $badge['mediaPath1'] . '" alt="pic2" />
    					</li>';
    		} else {
				$theHtml .= '<li>
    						<img src="/rsrc/praise/' . $badge['mediaPath1'] . '" alt="pic2" />
    					</li>';
    		}
    			$i++;
		}
		return $theHtml;
	
	}
	} // END CONTACT CLASS
?>