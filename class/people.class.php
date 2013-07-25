<?php

require_once 'database.class.inc';
require_once "error.inc";




class People extends Default_Table
{

    // additional class variables go here
    function People ()
    {
        $this->tablename      	= 'people';
        $this->dbname          	= 'brdevdb';
        require_once "categories.class.inc";
		$this->cats			= new Categories;
        $this->rows_per_page   	= 100;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body', 'sortBy');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
        
        $where = "displayProfile = '1'";
        $this->profiles		= Default_Table::getData($where);
        
        require_once "contact.class.php";
       	$this->contact			= new Contact;
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    

    function getHtml($selector,$selectValue,$pageTitle,$category,$subcategory) {
    
   		
    		$theHtml .= '<div id="two-column-center">';
         	
			if ($_POST) {
				//echo $selector;
				$theHtml .= '<div id="thank-u">'.$this->contact->sendEmail($_POST).'</div>';
			} 
			
    		$theHtml .= '<div id="profiles">';
    		
    		// PULL UP THE PROFILES FROM THE DATABASE
    			
    		$count = count($this->profiles);
    		
    		switch ($count%3) {
    		
    			case 0: // ENOUGH TO FILL THE TEMPLATE
    		
					foreach ($this->profiles as $profile) {
						$theHtml .= $this->getProfile($profile['id']);
					} 
					break;   		
    		
    			case 2:	// THE LAST WILL BE A BLANK PROFILE	
    				
    				$needed = (floor($count/3)+1)*3;
					foreach ($this->profiles as $profile) {
						$theHtml .= $this->getProfile($profile['id']);
						$needed--;
					}
			
					// FILL THE TEMPLATE WITH EMPTY PROFILES
					for ($i=$needed; $i>0; $i--) {
  						$theHtml .= $this->getEmptyProfile();
  					}
  					break;
  							
				case 1:	// THE LAST PROFILE WILL BE IN THE MIDDLE OF TWO BLANK PROFILES	
			
					for ($i=0; $i<($count-1); $i++) {

						$profile = $this->profiles[$i];
						$theHtml .= $this->getProfile($profile['id']);
					}
			
					// FILL THE TEMPLATE WITH EMPTY PROFILES
					$theHtml .= $this->getEmptyProfile();
					$profile = $this->profiles[$count-1];
					$theHtml .= $this->getProfile($profile['id']);
					$theHtml .= $this->getEmptyProfile();
					break;
				
			}
			
			
					
			$theHtml .= '<div class="clear"></div>';
			$theHtml .= '</div>';
							
							
			$theHtml .= '<script type="text/javascript">
    					$(function() {
        					$(\'#profiles a\').lightBox();
    					});
    				</script>';
    			
    
    		$theHtml .= '</div>';
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';	
      		$theHtml .= '<div id="promoOne">    				
    								
    						<a href=""><img src="/rsrc/self-promo/leadership.gif"></a>
    					</div>';
    							
    		$theHtml .= '	</div>';
    		$theHtml .= '<div id="contact">
    						<h3>Inquiry<br>form</h3>
    						<p>See what we are all about.</p>
    						'.$this->contact->contactForm().'
    					</div>
    					<div id="selfPromoThree">
    						<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted"><img style="diplay: block" src="/rsrc/common/what-we-collect.gif" /></a>
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


	function getProfile($profileId) {
		$where = "id = '".$profileId."'";
		$profile = Default_Table::getData($where);		
		//echo $where;

    	if (strlen($profile[0]['mediaPath1']) == 0) {
			$picture .= 'profile-pic.jpg';
    						
    	} else {
    		$picture .= $profile[0]['mediaPath1'];
    	}
    	
    	$imageTitleData = 	'<div>'.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($profile[0]['info']))).'</div>##'
    						.urlencode('/rsrc/people/thumbs/'.$picture).'##'
    						.$profile[0]['name'].' '.stripslashes($profile[0]['lastName']).'##'
    						.stripslashes($profile[0]['title']).'##'
							.urlencode($this->trimString('250',$this->convert_high_bytes($this->convert_smart_quotes(strip_tags($profile[0]['info'])))));
    	
		$theHtml .= '	<div class="profile">';
    	$theHtml .=	'		<div class="profile-pic">
    							<a id="'.preg_replace('/"/', '&quot;', $imageTitleData).'" href="/rsrc/people/'.$picture.'" />
    								<img src="/rsrc/people/thumbs/'.$picture.'">
    							</a>
    						</div>
    						<div class="profile-name">'.$profile[0]['name'].' '.stripslashes($profile[0]['lastName']).'</div>
    						<div class="profile-title">'.$profile[0]['title'].'</div>
    					</div>';
   		
		return $theHtml;
	
	}

	function getEmptyProfile() {
   	
		$theHtml .= '	<div class="profile">';
    	$theHtml .=	'		<div class="profile-pic"></div>
    						<div class="profile-name"></div>
    						<div class="profile-title"></div>
    					</div>';
   		
		return $theHtml;
	
	}	
/*	
		
	function getProfile($profileId) {
		$where = "id = '".$profileId."'";
		$profile = Default_Table::getData($where);
	
		$theHtml .= '	<div class="profile-left">
    						<div class="profile-name">'.$profile[0]['name'].' '.stripslashes($profile[0]['lastName']).'</div>
    						<div class="profile-title">'.$profile[0]['title'].'</div>
    						<div class="profile-intro">'.stripslashes($profile[0]['intro']).'</div>
    					</div>
    					<div class="profile-right">
    						<div class="profile-info">
    							<p>';
    							
    					if (strlen($profile[0]['mediaPath1']) == 0) {
							$theHtml .= '';
    						
    					} else {
    						$theHtml .= '<img class="profile-pic" src="/rsrc/people/'.$profile[0]['mediaPath1'].'" align="right">';
    					}
    					
    					$theHtml .= stripslashes($profile[0]['info']).'
    							</p>
    						</div>
    						<div class="profile-email-phone">';
    			
    					if (strlen($profile[0]['email']) == 0) {
    							$theHtml .= '';
    					} else {
    							$theHtml .= '<b>Email: </b> '.$profile[0]['email'].'<br>';
    					}
    			
    					if (strlen($profile[0]['telephone']) == 0) {
    							$theHtml .= '';
    					} else {
    							$theHtml .= '<b>Telephone (direct):</b> '.$profile[0]['telephone'];
    					}
    			
    			$theHtml .= '</div>
    					</div>
    					<div class="clear"></div>';
   		
		return $theHtml;
	
	}	
*/	
	function countProfiles() {
		$numProfiles = Default_Table::getCount();
		return $numProfiles;
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