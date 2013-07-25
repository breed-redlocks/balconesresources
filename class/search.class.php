<?php

require_once 'database.class.inc';
require_once "error.inc";
//require_once "people.class.php";



class Search extends Default_Table
{

    // additional class variables go here
    function Search ()
    {
       	require_once "class/settings.php";
       	$this->site				= $site;
       	require_once "categories.class.inc";
       	$this->category			= new Categories;
       	require_once "contact.class.php";
       	$this->contact			= new Contact;
        $this->tablename      	= 'pages';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 15;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby = 'sortBy';
  		$this->sql_orderby_seq = "DESC";
        $this->pageItems		= Default_Table::getData();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml($selector,$selectValue,$pageTitle,$category,$subcategory) {
    	$theHtml .= '<div id="two-column-center">';
    	if ((!$_POST['searchTerm']) && (!$_POST['name'])) {
    		$theHtml .= '<h6>No search term was entered. Please try again.</h6>';
		} elseif ($_POST['name']) {
			$theHtml .= '<div id="thank-u">'.$this->contact->sendEmail($_POST).'</div>';
    	} else {
    		//print_r($_POST);
    		$whereTitle = "title LIKE '%".$_POST['searchTerm']."%'";
    		$whereBlock1 = "block1 LIKE '%".$_POST['searchTerm']."%'";
    		$whereBlockTitle1 = "blockTitle1 LIKE '%".$_POST['searchTerm']."%'";
    		
    		$where = "display = '1' AND ".$whereTitle." OR ".$whereBlock1." OR ".$whereBlockTitle1;
    		//echo $where;
    		//$results = Default_Table::getData($where);
    		
    		$results = Default_Table::getResults("SELECT DISTINCT id,title,block1,link FROM $this->tablename WHERE $where ORDER BY id DESC");
    		
   		   	if (!$results) {
   		   		$theHtml .= '<div class="search-result">Sorry, the term you searched for was not found. Please try again</div>';
   		   	} else {
    		foreach ($results as $result) {
    		//print_r($result);
    			$theHtml .= '<div class="search-result"><a href="/'.$result['link'].'">'.$result['title'].'</a> - '.$this->convert_high_bytes($this->convert_smart_quotes($this->trimString(300,strip_tags(stripslashes($result['block1']))))).'</div>';
    		}
    		//print_r($results);
    		}
    	}
    	$theHtml .= '</div>';
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';	
    			if (($thisPage[0]['categories'] == 23) ||  ($thisPage[0]['categories'] == 25) || ($thisPage[0]['categories'] == 26)) {
    				$theHtml .= '<div id="promoOne">
    								<a href="/balcones-recycling/commercial/residential">
    									<img src="/rsrc/recycling/res-recycle.gif">
    								</a>
    							</div>
    							<div id="promoTwo">
    								<a href="/balcones-recycling/commercial/commercial">
    									<img src="/rsrc/recycling/comm-recycle.gif">
    								</a>
    							</div>';
    			} else {
    				//echo $thisPage[0]['link'];
    				$theHtml .= '<div id="promoOne">
    				
    								<a href="/contact-us/contact-us">
    									<img src="/rsrc/self-promo/'.$thisPage[0]['link'].'.gif">
    								</a>
    							</div>';
    			
    			}			
    							
    		$theHtml .= '	</div>';
    		$theHtml .= '<div id="contact">
    						<h3>Request a<br>quote inquiry<br>form</h3>
    						<p>See what we are all about.</p>
    						'.$this->contact->contactForm().'
    					</div>
    					<div id="selfPromoThree">
    						<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted">
    								<img style="diplay: block" src="/rsrc/common/what-we-collect.gif" />
    							</a>
    					</div>';
    			$theHtml .= '<div id="staticBadges">
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
	
	function trimString($limit,$string) {

		$length = strlen($string);
			
			if ($length < $limit) {
				$content = $string;
			} else {
				$newString = substr($string,0,$limit);
     			$newString = substr($newString,0,strrpos($newString," "));
				$content = stripslashes($newString)."...";
			}
			return $content;
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

			
} // end class
?>