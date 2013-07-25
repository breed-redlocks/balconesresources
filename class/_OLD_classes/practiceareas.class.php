<?php

require_once 'database.class.inc';
require_once "error.inc";




class Practiceareas extends Default_Table
{

    // additional class variables go here
    function Practiceareas ()
    {
        $this->tablename      	= 'practiceareas';
        $this->dbname          	= 'devjackw';
        require_once "twittercombo.class.php";
       	$this->tweets			= new Twittercombo;
        require_once "categories.class.inc";
		$this->cats			= new Categories;
        require_once "sidenav.class.php";
		$this->sidenav		= new Sidenav;
		require_once "people.class.php";
		$this->members		= new People;
		require_once "research.class.php";
		$this->research		= new Research;
		require_once "transactions.class.php";
		$this->transaction		= new Transactions;
        $this->rows_per_page   	= 100;
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body', 'sortBy');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
       // $this->profiles		= Default_Table::getData();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml() {
    	$sidenav = $this->sidenav;
    	$pageLink = $this->getPage();
    	$where = "slug = '".$pageLink['page']."'";
    	$thePAData = Default_Table::getData($where);
    	//echo $thePAData[0]['id'];
    	if (isset($thePAData[0]['id'])) {
    			
    			$theHtml = '';
    			$theHtml .= $sidenav->getHtml('Who We Are','','',$profileCount);
    			$theHtml .= '<div id="two-column-right">
    							<div class="thin-seperator2">&nbsp;</div>
    							<div id="pa-title">'.$thePAData[0]['name'].'</div>
    							<div id="pa-left">
    								<div id="pa-intro"><h2>'.$thePAData[0]['intro'].'</h2></div>
    								<div id="pa-info">'.$thePAData[0]['info'].'</div>
    							</div>
    							<div id="pa-right">';
    							
    						if ($thePAData[0]['twitter_username']){
    			$theHtml .= '		<div id="pa-twitter">
    									<div id="pa-twitter-title">Top News Stories</div>
    									<div id="tweets">
    										<ul id="latest_tweet">';
    			$theHtml .=						$this->tweets->getTweetByUsername($thePAData[0]['twitter_username']);
    									
    			$theHtml .= '				</ul>
    									</div>
    									<div id="tweet-nav">
    										<div class="pa-more-link">
    											<a href="http://twitter.com/#!/'.$thePAData[0]['twitter_username'].'" target="_blank">More from @'.$thePAData[0]['twitter_username'].'</a>
    										</div>
    										<div id="pa-arrows">
							 					<div id="photoprev"><img src="/rsrc/common/LEFT-ARROW.png"></div>
							 					<div id="photonext"><img src="/rsrc/common/RIGHT-ARROW.png"></div>
							 					<div class="clear"></div>
							 				</div>
							 				<div class="clear"></div>
							 			</div>
							 			
    								</div>';		
    						}	
    								
    			$theHtml .= '      <div id="pa-team">
    									<div class="block-title">Team Members</div>
    									';
    									
    			$theHtml .=			$this->getTeam($thePAData[0]['teammembers']);
    			$theHtml .= 		$this->getResearch($thePAData[0]['id']);
    			$theHtml .= '		</div>';
    			$theHtml .= 		$this->getTransactions($thePAData[0]['id']);
    								
    							
    			
    			$theHtml .= '		
    								
    							</div>
    							<div class="clear"></div>
    						</div>
    						
    						';
    	} else {
    		$theData = Default_Table::getData();
    		
    			$theHtml = '';
    			$theHtml .= $sidenav->getHtml('Who We Are','','',$profileCount);
    			$theHtml .= '<div id="two-column-right">
    							<div class="thin-seperator2">&nbsp;</div>
    							<div id="block1">
    								<h1>A national middle market investment bank must effectivly handle transactions ie every industry segment.
    								</h1>
    							</div>
    							<div id="block2">Lorem ipsum dolor sit amet, equidem rationibus cu pri, ea mea atomorum intellegebat disputationi, mel eius equidem inimicus id. Id qui probo persius, ius an decore menandri. Ipsum nusquam voluptatibus eu pro. Has ut minimum complectitur, veritus salutandi intellegam ne has. Possit veritus temporibus nec ea, ea probo summo ridens vis.
    							</div>
    							<div class="clear"></div>';
    			$theHtml .= $this->getIntroBlocks($theData);				
    			$theHtml .= '<div class="clear"></div></div>';
    	}
		
		return $theHtml;
		
	}
	
	function getIntroBlocks($pas) {
		$limit = 120;
		foreach($pas as $pa) {
			$theHtml .= '	<div class="small-block">
								<div class="block-title-main">'.$pa['name'].'</div>';
									$length = strlen($pa['intro']);
										if ($length < $limit) {
											$content = $pa['intro'];
										} else {
											$string = substr($pa['intro'],0,$limit);
     										$string = substr($string,0,strrpos($string," "));

											//$trimmed = substr($pa['intro'], 0, $limit);
											$content = $string."...";
										}
									
			$theHtml .= 				$content;
			$theHtml .= '				<div class="pa-more-link">
											<a href="/'.$pa['slug'].'">More</a>
										</div>';				
			$theHtml .= '				</div>';
		}
		return $theHtml;
	}
	
		
	function getTeam($ids) {
		$theHtml = '';
		$ids = explode("::", $ids);
		
		foreach ($ids as $member) {
			$where = "id = '".$member."'";
			$memberData = $this->members->getData($where);
			//$memberName = $memberData[0]['name'];
			//$memberId 	= $memberData[0]['id'];
			$theHtml .= '<a href="/people/id-'.$memberData[0]['id'].'">'.$memberData[0]['name'].' '.$memberData[0]['lastName'].'</a><br>';
		
		}
	
		
		return $theHtml;
	
	}	
	
	function getResearch($paId) {
		$theHtml = '';
		$theList = '';
		$match = 0;
		$allResearch = $this->research->getData();
		//print_r($allResearch);
			foreach ($allResearch as $research) {
				$researchIds = explode("::", $research['practiceAreas']);
					foreach ($researchIds as $id) {
						if ($id == $paId) {
							$theList .= '<a href="/rsrc/research/'.$research['mediaPath1'].'">'.$research['title'].'</a><br>';
							$match++;
						}
					
					}
			}
			
		if ($match > 0) {
			$theHtml .= '<div id="pa-research">
    								<div class="block-title">Research</div>';
    		$theHtml .= $theList;		
			$theHtml .= '</div>';
		
		} else {
			$theHtml = '';
		}
			
		return $theHtml;
	
	}
	
	function getTransactions($paId) {

		$theHtml = '';
		$badges = '';
		$match = 0;
		$allTransactions = $this->transaction->paBadges($paId);
		//print_r($allTransactions);
		foreach ($allTransactions as $badges) {
			$badges .= '<img src="/rsrc/transactions/'.$badges['path'].'" alt="'.$badges['path'].'"><br>';
		}
		if (isset($allTransactions)) {
			$theHtml = '			<div id="pa-transactions">
    									<div class="block-title">Transactions</div>
    									<div class="rotator">
    										<ul>
    											'.$allTransactions.'
    										</ul>
    									</div>
    								</div><div class="clear"></div>';
		} else {
			$theHtml = '';
		}

		
						
		return $theHtml;
	
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
	
	function countProfiles() {
		$numProfiles = Default_Table::getCount();
		return $numProfiles;
	}
	
	
} // end class
?>