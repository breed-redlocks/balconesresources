<?php

require_once 'database.class.inc';
require_once "error.inc";
//require_once "people.class.php";



class None extends Default_Table
{

    // additional class variables go here
    function None ()
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
    
			$thePage = $this->getPage();
    		$where = "link = '".$thePage['page']."'";
    		$thisPage = Default_Table::getData($where);

    		//print_r($thisPage);
    		
    		if ($thisPage[0]['noLeftNav'] == 1) {
    			$nav = "no";
    			$limit = 5000;
    			$blocks = $this->getBlocks($thisPage, $nav, $limit);
    			$newOne = array_shift($blocks);
    			//print_r($newOne);
    			$theHtml .= '<div id="left-column-nav">
    							<div id="page-title">'.$thisPage[0]['title'].'</div>
    							<div class="thin-seperator1">&nbsp;</div>
    							<div id="side-nav">';
    			$theHtml .= stripslashes($thisPage[0]['block1']);
    			$theHtml .= '</div></div>';
    		} else {
    			$nav = "yes";
    			$limit = 125;
    			$sidenav = $this->sidenav;
    			$blocks = $this->getBlocks($thisPage, $nav, $limit);
    		}
    		
    		$theHtml .= '<div id="two-column-center">';
    		$topImage = $_SERVER['DOCUMENT_ROOT']."/rsrc/top/".$thisPage[0]['link']."-top.jpg";
    		//echo $topImage;
    		if (file_exists($topImage)) {
    			$theHtml .= '<div id="top-image">
    						<img src="/rsrc/top/'.$thisPage[0]['link'].'-top.jpg">
    					</div>';
			} else {
    			$theHtml .= '<div id="top-image">
    						<img src="/rsrc/top/default-top.jpg">
    					</div>';
			}
			
        	$i=1;
        	
			if ($_POST) {
				//echo $selector;
				$theHtml .= '<div id="thank-u">'.$this->contact->sendEmail($_POST).'</div>';
			} 

			foreach ($blocks as $block) {
				/*
    			if ((empty($block['content'])) || ($block['content'] == '<br>')) {
    				$theHtml .= '';
    			} else { 
    			*/ 
    				if ((empty($block['content'])) || ($block['content'] == '<br>')) {
    					$block['content'] = '';
    				}  					
    				if (empty($block['title'])) {
    					if (empty($block['link'])) {
    						$theHtml .= '<div id="block'.$i.'">'.$this->convert_smart_quotes($block['content']).'</div>';
    					} else {
    						$theHtml .= '<div id="block'.$i.'">'.$this->convert_smart_quotes($block['content']).'<div class="block-link"><a href="'.$block['link'].'">More</a></div></div>';
    					}
					} else {
						if (empty($block['link'])) {
    						$theHtml .= '<div id="block'.$i.'"><div class="block-title"><h1>'.$block['title'].'</h1></div>'.$block['content'].'</div>';
    					} else {
    						$theHtml .= '<div id="block'.$i.'"><div class="block-title"><h1>'.$block['title'].'</h1></div>'.$block['content'].'<div class="block-link"><a href="'.$block['link'].'">More</a></div></div>';
    					}
    				}
    			//}
    			$i++;
    		}
 
    			
    
    		$theHtml .= '</div>';
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';
    						
    						
    						
    		if ("/".$thePage['page'] == $thePage['section']) { // IT'S A SECTION			
    							
    			if ($thisPage[0]['categories'] == 23) {
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
    			} elseif (($thisPage[0]['categories'] == 25) || ($thisPage[0]['categories'] == 26)) {
    			
    				$theHtml .= '';
    			} elseif ($thisPage[0]['categories'] == 27) {	
    				$theHtml .= '<div id="promoOne">
    				
    								<a href="http://balconesshred.com">
    									<img src="/rsrc/self-promo/'.$thisPage[0]['link'].'.gif">
    								</a>
    							</div>';
    			
    			} else {
    				//echo $thisPage[0]['link'];
    				$theHtml .= '<div id="promoOne">
    				
    								<a href="/Resource-Audit">
    									<img src="/rsrc/self-promo/'.$thisPage[0]['link'].'.gif">
    								</a>
    							</div>';
    			
    			}
    		} else { // IT'S NOT A SECTION
    		
    			$theHtml .= '';
    		
    		}			
    							
    		$theHtml .= '	</div>';
    		$theHtml .= '<div id="contact">
    						<h3>Inquiry<br>form</h3>
    						<p>See what we are all about.</p>
    						'.$this->contact->contactForm('',$thePage['page']).'
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
	
	function getBlocks($pageItems, $nav, $limit) {

    			foreach ($pageItems[0] as $key => $value) {
    				//echo $key."<br>";
    				//echo $i."<br>";
    				if ($key == "block1") {
    					$blocks[1]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				} elseif ($key == "block2"){
						$blocks[2]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block3"){
						$blocks[3]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
						//$blocks[3]['content'] = stripslashes($value);
					} elseif ($key == "block4"){
						$blocks[4]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block5"){
						$blocks[5]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block6"){
						$blocks[6]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				} elseif ($key == "block7"){
						$blocks[7]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block8"){
						$blocks[8]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block9"){
						$blocks[9]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "block10"){
						$blocks[10]['content'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				}
    				//
    				if ($key == "blockTitle1") {
    					$blocks[1]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				} elseif ($key == "blockTitle2"){
						$blocks[2]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle3"){
						$blocks[3]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle4"){
						$blocks[4]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle5"){
						$blocks[5]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle6"){
						$blocks[6]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				} elseif ($key == "blockTitle7"){
						$blocks[7]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle8"){
						$blocks[8]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle9"){
						$blocks[9]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
					} elseif ($key == "blockTitle10"){
						$blocks[10]['title'] = $this->convert_high_bytes($this->convert_smart_quotes(stripslashes($value)));
    				}
    				//
    				if ($key == "blockLink1") {
    					$blocks[1]['link'] = $value;
    				} elseif ($key == "blockLink2"){
						$blocks[2]['link'] = $value;
					} elseif ($key == "blockLink3"){
						$blocks[3]['link'] = $value;
					} elseif ($key == "blockLink4"){
						$blocks[4]['link'] = $value;
					} elseif ($key == "blockLink5"){
						$blocks[5]['link'] = $value;
					} elseif ($key == "blockLink6"){
						$blocks[6]['link'] = $value;
    				} elseif ($key == "blockLink7"){
						$blocks[7]['link'] = $value;
					} elseif ($key == "blockLink8"){
						$blocks[8]['link'] = $value;
					} elseif ($key == "blockLink9"){
						$blocks[9]['link'] = $value;
					} elseif ($key == "blockLink10"){
						$blocks[10]['link'] = $value;
    				}
    				
    			}
    			return $blocks;		
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
		
} // end class
?>