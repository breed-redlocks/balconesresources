<?php

require_once 'database.class.inc';
require_once "error.inc";

class Clients extends Default_Table
{

    // CLASS VARIABLES
    function Clients ()
    {
        $this->tablename      	= 'clients';
        $this->dbname          	= 'headwatersmb';
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
	if (isset($_POST['submitted'])) { 
	$this->insertData($_POST);
	$theResponse = $this->sendEmail($_POST); 
	
	}
		$theHtml = '<div id="client-logo-grid">';
			$i=0;
			$col=4;
			$row=1;
			$where = "aceOnly='0'";
			$logos = Default_Table::getData($where);
			$centerText = 'Lorem ipsum dolor sit amet, in vix elitr tacimates conceptam, in ornatus similique est, ei nec affert diceret electram. Sed justo nobis perpetua ne, postea debitis in eos. Ipsum libris atomorum no sit, inani copiosae definiebas quo no, et eam iisque elaboraret.';

			foreach (array_reverse($logos) as $client) {
				if (!$client['mediaPath1']) {
					$client['mediaPath1'] = 'default.gif';
				}
				if ($i == 4) {
					$theHtml .= '<div class="client-logo">
									<img src="/rsrc/clients/' . $client['mediaPath1'] . '" title="ORDER - ' .  $client['sortBy'] . '">
								</div>';
					$theHtml .= '<div class="client-center-text">' . $centerText . '</div>';
					
				} else {
					$theHtml .= '<div class="client-logo">
									<img src="/rsrc/clients/' . $client['mediaPath1'] . '" title="ORDER - ' .  $client['sortBy'] . '">
								</div>';
				}
				$i++;
			}
		$theHtml .= '<div class="clear"></div></div>';
		
		
		$theHtml .= '<div id="client-additional-clients">
						<h1>Additional Client Experience</h1>';
		
			$whereAce = "aceOnly='1'";
			$aceList = Default_Table::getData($whereAce);
			//print_r($aceList);
			foreach ($aceList as $ace) {
				$theHtml .= '<div class="client-name">' . $ace['name'] . '</div>';
			}
					
		$theHtml .= '<div class="clear"></div></div>';
		
		
		
	
	return $theHtml;
		
	}
	} // END CONTACT CLASS
?>