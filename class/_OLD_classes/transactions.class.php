<?php

require_once 'database.class.inc';
require_once "error.inc";

class Transactions extends Default_Table
{

    // CLASS VARIABLES
    function Transactions ()
    {
        require_once "pages.class.php";
        require_once "categories.class.inc";
       	$this->category			= new Categories;
        $this->tablename      	= 'transactions';
        $this->dbname          	= 'devjackw';
        $this->fieldlist       	= array(	'id', 'title', 'body', 'categories', 'sortBy', 'date', 'author', 'source');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        
				
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
	//echo $selector."-".$selectValue;
		
		$this->page			= new Pages;
		
		$this->transactionList	= Default_Table::getData();
		$transactions = $this->transactionList;
		$thisPage = $this->page->getData("id = 30");
		$theCats = $this->category->getData("parent = 19");
		$theWidth = count($transactions) / 2;
		$theWidth = $theWidth * 151;
		
		// CHECK FOR INDUSTRY
		if (isset($selectValue)){
			$theHtml .= '<div id="left-column-nav">
    					<div id="page-title">Track Record</div>
    					<div class="thin-seperator1">&nbsp;</div>
    					<div id="side-nav">
    						<div class="box-title">
    							Transactions By Industry
    						</div>
    						<ul>';
    							foreach ($theCats as $cat) {
    								if ($cat['id'] == $selectValue) {
    									$active = "active";
    								} else {
    									$active = '';
    								}
    								
    								$theHtml .= '<li><a class="'.$active.'" href="/'.$thisPage[0]['link'].'/industry-'.$cat['id'].'">'.$cat['name'].'</a></li>';
    							}
    							
    		$theHtml .= '	</ul>
    					</div>
    				</div>';
    		$theHtml .= '<div id="two-column-right">';
    		$theHtml .= '<div class="thin-seperator2">&nbsp;</div>';
    		$theHtml .= '<div id="industry-main" class="med-white-scala">';
    		$theHtml .= '<div id="blurb">OUR SENIOR PROFESSIONALS HAVE WIDE INDUSTRY EXPERIENCE. HERE IS A SELECTION OF THEIR CLIENTS BOTH AT HEADWATERS AND PRIOR FIRMS.</div>';
    		$theHtml .= '<div class="blurb-seperator">&nbsp;</div>
    						<div id="industry-title" class="large-white-scala">';
    			$whereCat = "id = '".$selectValue."'";
    			$thisIndustry = $this->category->getData($whereCat);
    			
    			$theHtml .= $thisIndustry[0]['name'];
    			$theHtml .= '	</div>';
    			$where = "categories = '".$selectValue."'";
    			$trans = Default_Table::getData($where);
    			//print_r($trans);
    					foreach ($trans as $tran) {
    						if ($tran['internal'] == 1) {
    							$marked = "*";
    						}
    			
    						$theHtml .= '<div class="box-title-trans">'.$tran['title'].' '.$marked.'</div>';
    		}
    		$theHtml .= ' 	<div id="dot">*</div>
    						<div class="disclaimer">DENOTES A HEADWATERS TRANSACTION</div>
    						<div class="clear"></div>';
    		$theHtml .= '		</div><div class="clear"></div></div>';
		
		} else {
		
		$theHtml = '<script type="text/javascript">$(document).ready(function(){	
		$(\'#trans-image-container\').serialScroll({
			items:\'li\',
			prev:\'#photoprev\',
			next:\'#photonext\',
			offset:0,
			start:0,
			duration:500,
			interval:6000,
			force:true,
			stop:true,
			lock:false,
			//exclude:0,
			cycle:true, //don\'t pull back once you reach the end
			jump: false //click on the images to scroll to them
		});
});</script>';
		//print_r($transactions);
		$theHtml .= '<div id="left-column-nav">
    					<div id="page-title">Track Record</div>
    					<div class="thin-seperator1">&nbsp;</div>
    					<div id="side-nav">
    						<div class="box-title">
    							Transactions By Industry
    						</div>
    						<ul>';
    							foreach ($theCats as $cat) {
    								$theHtml .= '<li><a href="/'.$thisPage[0]['link'].'/industry-'.$cat['slug'].'">'.$cat['name'].'</a></li>';
    							}
    							
    		$theHtml .= '	</ul>
    					
    					</div>
    				</div>';
 
		$theHtml .= '<div id="two-column-right">';
    	$theHtml .= '<div class="thin-seperator2">&nbsp;</div>';
    	$theHtml .= '<div id="top-text" class="large-white-scala">'.stripslashes($thisPage[0]['block1']).'</div>';
    	$theHtml .= '<div id="middle-text" class="jumbo-blue">'.stripslashes($thisPage[0]['block2']).'</div>';
    	$theHtml .= '<div id="bottom-text" class="large-white-scala">'.stripslashes($thisPage[0]['block3']).'</div>';
    	$theHtml .= '<div class="seperator">&nbsp;</div>';
    	$theHtml .= '<div id="control-bar">
    					<div class="title">Track Record</div>
    					<div id="arrows">
							<div id="photoprev">Previous</div>
							<div id="photonext">Next</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>	
    				</div>';
    	$theHtml .= '<div id="trans-image-container">
    					<ul id="trans-image-scrollable" style="width:'.$theWidth.'px">';
    	//$theHtml .= '<ul>';

		$proj			= 0;
		$col 			= 1;
		
		while ($proj <= count($transactions)) {

   				$theHtml .= '<li id="col-' . $col . '" class="trans-column">'."\n";

   				$theHtml .= $this->displayProject($proj, $column, '', $col);
   				$proj++;
   				
   				$theHtml .= $this->displayProject($proj, $column, 'b-', $col);
   				$proj++;
   			
   				$theHtml .= '</li>'; // END COLUMN
   				
   				$col++;

   			}
		

		$theHtml .= '		<div class="clear"></div>
							</ul>
						</div>';
		} // END IF FOR SET INDUSTRY
		
		return $theHtml;
		
	}
	
	function paBadges($paIds) {
		$this->transactionList		= Default_Table::getData();
		$transactions = $this->transactionList;
		$i=0;
		foreach ($transactions as $transaction) {
			
			if (isset($transaction['practiceAreas'])) {
				
				$ids = explode("::", $transaction['practiceAreas']);
					foreach ($ids as $id) {
						if ($id == $paIds) {
							if ($i==0){
								$badges .= '<li class="show"><img src="/rsrc/transactions/'.$transaction['mediaPath1'].'" alt="'.$transaction['mediaPath1'].'"></li>';
							} else {
								$badges .= '<li><img src="/rsrc/transactions/'.$transaction['mediaPath1'].'" alt="'.$transaction['mediaPath1'].'"></li>';
							}
							$i++;
						
						}
					
					} 
				
			}
		
		}
		return $badges;
	}
	
	function footerMostRecent() {
        
		$this->sql_orderby = 'id';
  		$this->sql_orderby_seq = "DESC";
		$this->rows_per_page = 10;
		$where = "practiceAreas = ''";
		$this->transactionList		= Default_Table::getData($where);
		$transaction = $this->transactionList;
		
		$theHtml = '<div class="click-box">'."\n";
		$theHtml .= $transaction[0]['title'];
		$theHtml .= '<br /><br /><a class="more-link" href="">More</a>'."\n";
		$theHtml .= '</div>'."\n";
		return $theHtml;
	}
	
	function displayProject($proj, $column, $ab, $col) {
		$theHtml .= '<div class="'.$ab.'trans-image">
						<img src="/rsrc/transactions/'.$this->transactionList[$proj]['mediaPath1'].'">
					</div>';
   			return $theHtml;
	
	}
	} // END CONTACT CLASS
?>