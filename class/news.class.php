<?php

require_once 'database.class.inc';
require_once "error.inc";

class News extends Default_Table
{

    // CLASS VARIABLES
    function News ()
    {
    	//require_once "pages.class.php";
		//$this->pages		= new Pages;
        $this->tablename      	= 'news';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10000;
        $this->fieldlist       	= array(	'id', 'firstname', 'lastname', 'phone', 'email', 'interest', 'message');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		//require_once "users.class.inc";
		//$this->users			= new Users;
        $this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";        
        require_once "contact.class.php";
       	$this->contact			= new Contact;
       	
        $this->news		= Default_Table::getData();
        

				
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
        	
			if ($_POST) {
				//echo $selector;
				$theHtml .= '<div id="thank-u">'.$this->contact->sendEmail($_POST).'</div>';
			} 
			    		
    		$theHtml .= '	<div id="dynamicBadges">'.$this->getNews().'
    						<div class="clear"></div>
							</div>';

			$theHtml .= '	<script type="text/javascript">
    							$(function() {
        							$(\'#dynamicBadges a\').lightBox();
    							});
    						</script>';
    						
       		$theHtml .= '</div>';
       		
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';	

 			$theHtml .= '		<div id="promoOne">    								
    								<a href="/Resource-Audit"><img src="/rsrc/self-promo/news-and-events.gif"></a>
    							</div>';    			
   							
    		$theHtml .= '	</div>';
    		
    		$theHtml .= '	<div id="contact">
    							<h3>Inquiry<br>form</h3>
    							<p>See what we are all about.</p>
    							'.$this->contact->contactForm().'
    						</div>
    						<div id="selfPromoThree">
    							<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted">
    								<img style="diplay: block" src="/rsrc/common/what-we-collect.gif" />
    							</a>
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


	function getNews() {
		//print_r($this->news);
		//$date = date('d-m-Y',strtotime($news['date']));
		$i=0;
		foreach ($this->news as $news) {
		
		//echo $news['body']."<br>";
		
		//$newsTitle = $this->splitTitle($news['title']);
		$readMore = $news['sourceLink'];
			
		if ($readMore!="") {
			if (stristr($readMore, 'http://') === FALSE) {
  				if (stristr($readMore, 'https://') === FALSE) {
    				$readMore = 'http://'.$readMore;
  				}
  			}
  		}
		//echo $readMore.'<br>';
		$imageTitleData = $this->convert_high_bytes($this->convert_smart_quotes(strip_tags($news['body'], '<a><div><p><br><iframe><param>')));
		
		$month = date('F',strtotime($news['date']));
		$day = date('j',strtotime($news['date']));
		$year = date('Y',strtotime($news['date']));
		
		$date= $month.' '.$day.', '.$year;
		
		$sideDate = '<ul><li>&nbsp;</li><li class=\'cal-month\'>'.$month.'</li><li class=\'cal-day\'>'.$day.'</li><li class=\'cal-year\'>'.$year.'</li>	</ul><img src=\'/rsrc/common/side-nav-bottom.gif\'>';
		
		$imageTitleData = 	stripslashes($imageTitleData).'##'
							.$date.'<br>'.$news['sourceText'].'##'
							.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($news['title']))).'##'
							.urlencode('/rsrc/news/thumbs/'.$news['mediaPath1']).'##'
							.$readMore.'##'
							.$sideDate.'##'
							.urlencode(htmlspecialchars($this->trimString('250',$this->convert_high_bytes($this->convert_smart_quotes($news['body']))), ENT_QUOTES));
							//htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES)
							
							//echo $news['body']."<br>///==><br>".urlencode(htmlspecialchars($this->convert_high_bytes($this->convert_smart_quotes($this->trimString('250',strip_tags($news['body']))), ENT_QUOTES)))."<br>///=====>>>>><br>";
		
			if ($i < 10000) {
				$theHtml .='<div class="badges">
								<div class="badgeImage">
									<a href="/rsrc/news/'.$news['mediaPath1'].'" id="'.preg_replace('/"/', '&quot;', $imageTitleData).'">
										<img src="/rsrc/news/thumbs/'.$news['mediaPath1'].'" alt="">
									</a>
								</div>
								<div class="badgeTitle">
									'.$this->trimString('35', stripslashes($news['title'])).'
								</div>
								<div class="badgeSubText">
									<div class="badgeDate">'.$date.'</div>
									<div class="badgeSource">'.$this->trimString('14', $news['sourceText']).'</div>
									<div class="clear"></div>
								</div>
							</div>';
			}
			$i++;
		}
		
		return $theHtml;
	}


	
	function getHomeNews() {
		//print_r($this->news);
		//$date = date('d-m-Y',strtotime($news['date']));
		$i=0;
		foreach ($this->news as $news) {
		
		//$newsTitle = $this->splitTitle($news['title']);
		$readMore = $news['sourceLink'];
		
		if ($readMore!="") {
			if (stristr($readMore, 'http://') === FALSE) {
  				if (stristr($readMore, 'https://') === FALSE) {
    				$readMore = 'http://'.$readMore;
  				}
  			}
  		}
  		
		//echo $readMore.'<br>';
		$imageTitleData = $this->convert_high_bytes($this->convert_smart_quotes(strip_tags($news['body'], '<div><span><strong><em><blockquote><b><i><u><li><ul><ol><p><br><iframe><param>')));
		//$date = date('F d, Y',strtotime($news['date']));
		//$imageTitleData = $imageTitleData.'##'.$date.' - '.$news['sourceText'].'##'.$newsTitle['one'].'##'.$newsTitle['two'].'##'.$readMore;
		
		$month = date('F',strtotime($news['date']));
		$day = date('j',strtotime($news['date']));
		$year = date('Y',strtotime($news['date']));
		
		$date= $month.' '.$day.', '.$year;
		
		$sideDate = '<ul><li>&nbsp;</li><li class=\'cal-month\'>'.$month.'</li><li class=\'cal-day\'>'.$day.'</li><li class=\'cal-year\'>'.$year.'</li>	</ul><img src=\'/rsrc/common/side-nav-bottom.gif\'>';
		
		$imageTitleData = 	stripslashes($imageTitleData).'##'
							.$date.'<br>'.$news['sourceText'].'##'
							.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($news['title']))).'##'
							.urlencode('/rsrc/news/thumbs/'.$news['mediaPath1']).'##'
							.$readMore.'##'
							.$sideDate.'##'
							.urlencode(htmlspecialchars($this->trimString('250',$this->convert_high_bytes($this->convert_smart_quotes(strip_tags($news['body'])))), ENT_QUOTES));
		
		
			if ($i < 4) {
			//'.$imageTitleData.'
				$theHtml .='<div class="badges">
								<div class="badgeImage">
									<a href="/rsrc/news/'.$news['mediaPath1'].'" id="'.preg_replace('/"/', '&quot;', $imageTitleData).'" />
										<img src="/rsrc/news/thumbs/'.$news['mediaPath1'].'" alt="">
									</a>
								</div>
								<div class="badgeTitle">
									'.$this->trimString('35', $news['title']).'
								</div>
								<div class="badgeSubText">
									<div class="badgeDate">'.$date.'</div>
									<div class="badgeSource">'.$this->trimString('14', $news['sourceText']).'</div>
									<div class="clear"></div>
								</div>
							</div>';
			}
			$i++;
		}
		
		return $theHtml;
	}
/*
									<!--[if IE 7]>
										<div class="badgeSourceIE7">'.$news['sourceText'].'</div>
									<![endif]-->
									<!--[if IE 8]>
										<div class="badgeSource">'.$news['sourceText'].'</div>
									<![endif]-->									
									<!--[if !IE]> -->
										<div class="badgeSource">'.$news['sourceText'].'</div>
									<!-- <![endif]-->

*/
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
     			//$newString = substr($newString,0,strrpos($newString," "));
     			$newString = strrpos($newString," ") ? substr($newString,0,strrpos($newString," ")) : $newString;
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
