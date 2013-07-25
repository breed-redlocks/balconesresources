<?php

require_once 'database.class.inc';
require_once "error.inc";

class Millsandbrokers extends Default_Table
{

    // CLASS VARIABLES
    function Millsandbrokers ()
    {
    	require_once "news.class.php";
		$this->news		= new News;
        $this->tablename      	= 'millsandbrokers';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'firstname', 'lastname', 'phone', 'email', 'interest', 'message');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		//require_once "users.class.inc";
		//$this->users			= new Users;
        $this->blockList		= Default_Table::getData();
				
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
		$thePage = $this->getPage();
		$where = "link = '".$thePage['page']."'";
		//$pageItems = $this->pages->getData($where);
		
		if (isset($_POST['submitted'])) { 
			$this->insertData($_POST);
			$theResponse = $this->sendEmail($_POST); 
		}
		
		
    	
    	$theHtml .= '<div id="home-left">';
    	$theHtml .= '	<div class="slider-wrapper theme-default">
            				<div id="slider" class="nivoSlider">';
        $theHtml .= '			<img src="/rsrc/millsandbrokers-slides/one.jpg" data-thumb="/rsrc/millsandbrokers-slides/thumbs/homeSlide1.jpg" alt="" />';
        $theHtml .= '			<img src="/rsrc/millsandbrokers-slides/two.jpg" data-thumb="/rsrc/millsandbrokers-slides/thumbs/homeSlide1.jpg" alt="" />';
        $theHtml .= '			<img src="/rsrc/millsandbrokers-slides/three.jpg" data-thumb="/rsrc/millsandbrokers-slides/thumbs/homeSlide1.jpg" alt="" />';
       
                			
        $theHtml .= '   	</div>
            		 	</div>';
    	$theHtml .= '<div class="contentBlockTitle">'.$this->convert_high_bytes($this->convert_smart_quotes($this->blockList[0]['blockTitle'])).'</div>';
    	$theHtml .= '<div class="contentBlockBody">'.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($this->blockList[0]['blockcontent']))).'</div>';
				
		$theHtml .= '</div>'; // END HOME_LEFT
		$theHtml .= '<div id="home-right">';
		$theHtml .= '<div id="staticBadges">
						<div class="badges"><a href="cleanest"><img src="/rsrc/common/cleanest.gif" alt=""></a></div>
						<div class="badges"><a href="inventory"><img src="/rsrc/common/inventory.gif" alt=""></a></div>						
					</div>
					<div id="dynamicBadges">'.$this->news->getHomeNews().'
					</div>
					<div id="staticBadges">
						<div id="social">
   							<div id="facebook">
   								<a href="http://www.facebook.com/Balcones.Resources" target="_blank">
   									<img src="/rsrc/common/facebook.gif" alt="">
   								</a>
   							</div>
   							<div id="twitter">
   								<a href="https://twitter.com/balconesrecycle" target="_blank">
   									<img src="/rsrc/common/twitter.gif" alt="">
   								</a>
   							</div>
   							<div id="googlePlus">
   								<a href="https://plus.google.com/107020083238084999697/about" target="_blank">
   									<img src="/rsrc/common/googlePlus.gif" alt="">
   								</a>
   							</div>
   							<div id="pintrest">
   								<a href="http://pinterest.com/balconesrecycle/" target="_blank">
   									<img src="/rsrc/common/pintrest.gif" alt="">
   								</a>
   							</div>
   						</div>
   						<div id="millsBrokers">
   							<a href="/">
   								<img src="/rsrc/common/balconesresources-button.gif" alt="">
   							</a>
   						</div>
   						<div class="clear"></div>
					</div>';
		$theHtml .= '</div>';
		//$theHtml .= '<div class="clear"></div>';
		$theHtml .= '<script type="text/javascript">
    					$(window).load(function() {
        					$(\'#slider\').nivoSlider({
        						controlNav: true,
        					
        					});
    					});
    				</script>
    				<script type="text/javascript">
    					$(function() {
        					$(\'#dynamicBadges a\').lightBox();
    					});
    				</script>';
	
	return $theHtml;
		
	}
	
	function convert_smart_quotes($string) 	{ 
   		$search = array(chr(145), 
                    chr(146), 
                    chr(147), 
                    chr(148),                   
                    chr(151),
                    chr(150)); 

    	$replace = array("'", 
                     "'", 
                     '"', 
                     '"', 
                     '-', 
                     '-'); 

    	return str_replace($search, $replace, $string); 
	}
	
	function convert_high_bytes($string) 	{ 	
   		$highByte = array( array('#COPY#','#REG#','#TM#'), array('&copy;','&reg;','&trade;') );
		return str_replace($highByte[0],$highByte[1],$string);
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