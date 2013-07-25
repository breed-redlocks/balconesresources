<?php

require_once 'database.class.inc';
require_once "error.inc";

class Faqs extends Default_Table
{

    // CLASS VARIABLES
    function Faqs ()
    {
    	//require_once "pages.class.php";
		//$this->pages		= new Pages;
        $this->tablename      	= 'faqs';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'firstname', 'lastname', 'phone', 'email', 'interest', 'message');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		//require_once "users.class.inc";
		//$this->users			= new Users;
        
        require_once "contact.class.php";
       	$this->contact			= new Contact;       	
       	
       	// WE KNOW ID=28 FOR ALTERNATIVE ENERGY AND 29 FOR HOW+WHY
       	$this->page = $this->getPage();
       	if ($this->page['section']=='/alternative-energy') $where = "categories = '28'";
       	if ($this->page['section']=='/how-why') $where = "categories = '29'";
       	
        $this->sql_orderby = 'sortBy';
  		$this->sql_orderby_seq = "ASC";       	
        $this->faqs		= Default_Table::getData($where);
				
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
    
	   		$theHtml .= '<div id="two-column-center">';

    		$theHtml .= '<div id="top-image">
    						<img src="/rsrc/top/'.$this->page['page'].'-top.jpg">
    					</div>';

			if ($_POST) {
				//echo $selector;
				$theHtml .= '<div id="thank-u">'.$this->contact->sendEmail($_POST).'</div>';
			} 
			      		
    		$theHtml .= '	<div id="faqs">
    							<h1>FAQ</h1>'
    							.$this->getFaqs().
    						'</div>';
    						
       		$theHtml .= '</div>';
       		
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';	

 			$theHtml .= '		<div id="promoOne">';    								
    								//<a href=""><img src="/rsrc/self-promo/'.$this->page['page'].'.gif"></a>
    		$theHtml .=			'</div>';    			
   							
    		$theHtml .= '	</div>';
    		
    		$theHtml .= '	<div id="contact">
    							<h3>Inquiry<br>form</h3>
    							<p>See what we are all about.</p>
    							'.$this->contact->contactForm().'
    						</div>
    						<div id="selfPromoThree">
    							<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted"><img style="diplay: block" src="/rsrc/common/what-we-collect.gif" /></a>
    						</div>';
    		$theHtml .= '	<div id="staticBadges">
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
							</div>';
    						

    		$theHtml .= '</div>';
    		$theHtml .= '<div class="clear"></div>';
		
		return $theHtml;
	}


	function getFaqs() {

		$i=0;
		foreach ($this->faqs as $faq) {
		
			//$question = $faq['question'];
			//$answer = $faq['answer'];
			
			$theHtml .='<div class="faq">';
			$theHtml .='	<div class="faq-question">'.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($faq['question']))).'</div>';
			$theHtml .='	<div class="faq-answer">'.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($faq['answer']))).'</div>';
			$theHtml .='</div>';
			
		}
		
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
	
	function splitTitle($title) {
		$limit=25;
		$length = strlen($title);
		
		if ($length < $limit) {
				$newtitle['one'] = $title;
			} else {
				$titleTemp = substr($title,0,$limit);
     			$newtitle['one'] = substr($titleTemp,0,strrpos($titleTemp," "));
				$newtitle['two'] = str_replace($newtitle['one'], "", $title);
			}
			
			return $newtitle;
		
		
	}
	
	function trimString($limit,$string) {

		$length = strlen($string);
			
			if ($length < $limit) {
				$content = $string;
			} else {
				$newString = substr($string,0,$limit);
     			$newString = substr($newString,0,strrpos($newString," "));
				$content = stripslashes($newString)." ...";
			}
			return $content;
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