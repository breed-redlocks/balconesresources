<?php

require_once 'database.class.inc';
require_once "error.inc";
require_once "pages.class.php";
require_once "pressreleases.class.php";

class News extends Default_Table
{

    // CLASS VARIABLES
    function News ()
    {
    	$this->press 			= new Pressreleases;
        $this->tablename      	= 'news';
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
	$pressEight = $this->press->getEight();
	$pressAll = $this->press->getAll();
	//print_r($pressEight);
	$this->page 	= new Pages;
	$thisPage 		= $this->page->getData("id = 29");
	
		if (isset($selectValue)) {
			
			if ($selectValue == "archive") {
			//echo "ARCHIVE";
				$theHtml .= $this->getLeftRail();
				$theHtml .= '<div id="two-column-right">';
    			$theHtml .= '	<div class="thin-seperator2">&nbsp;</div>';
    			$theHtml .= '	<div id="center-rail">';
				$theHtml .= 		$this->getCenterRail('no');
				$theHtml .= '	</div>';
				$theHtml .= '	<div id="right-rail">';
				$theHtml .= 		$this->getRightRail('no',$pressEight,$pressAll);
				$theHtml .= '	</div>';
				$theHtml .= '	<div class="clear"></div>
					</div>';
			
			} else {
		
		$theHtml .= $this->getLeftRail();
		$theHtml .= '<div id="two-column-right">';
    	$theHtml .= '	<div class="thin-seperator2">&nbsp;</div>';
    	$theHtml .= '	<div id="detail-box">';
		$theHtml .= 		$this->getNewsDetails($selectValue);
		$theHtml .= '	</div>
						<div class="clear"></div>
					</div>';
			}
		
		} else {
	
		$theHtml .= $this->getLeftRail();
		$theHtml .= '<div id="two-column-right">';
    	$theHtml .= '	<div class="thin-seperator2">&nbsp;</div>';
    	$theHtml .= '	<div id="center-rail">';
		$theHtml .= 		$this->getCenterRail('');
		$theHtml .= '	</div>';
		$theHtml .= '	<div id="right-rail">';
		$theHtml .= 		$this->getRightRail('',$pressEight,$pressAll);
		$theHtml .= '	</div>';
		$theHtml .= '	<div class="clear"></div>
					</div>';
		
		}
		
		return $theHtml;
		
	}
	
	function getNewsDetails($itemId) {
		$where = "id = '".$itemId."'";
		$news = Default_Table::getData($where);
		//print_r($news);
		$theHtml .= '<div id="detail-title" class="large-white-scala">'.$news[0]['title'].'</div>';
		$theHtml .= '<div id="detail-subtitle">'.$news[0]['subtitle'].'</div>';
		$theHtml .= '<div id="">'.$news[0]['author'].'</div>';
		$theHtml .= '<div id="source-date">'.$news[0]['source'].' - '.date("F d, Y", strtotime($news[0]['date'])).'</div>';
		$theHtml .= '<div id=""><p>'.nl2br(stripslashes($news[0]['body'])).'</p></div>';
		$theHtml .= '<div id="detail-blurb">'.$news[0]['blurb'].'</div>';
		//$theHtml .= '<div id="">'.$news[0]['title'].'</div>';

		return $theHtml;
	}
	
	function getRightRail($limit,$pressEight,$pressAll) {
		$theHtml .= '<div class="box-title">Press Releases</div>';
			if ($limit == "no") {
				$theHtml .= $this->getPress($pressAll);
			} else {
				$theHtml .= $this->getPressEight($pressEight);
			}
		
		return $theHtml;
	}

	
	function getCenterRail($limit) {
		$theHtml .= '<div class="box-title">News</div>';
			if ($limit == "no") {
				$theHtml .= $this->getNewsAll();
			} else {
				$theHtml .= $this->getNewsEight();
			}

		return $theHtml;
	}
	
	function getLeftRail() {
		$this->page 	= new Pages;
		$thisPage 		= $this->page->getData("id = 29");
	
		$theHtml .= '<div id="left-column-nav">
    					<div id="page-title">'.stripslashes($thisPage[0]['title']).'</div>
    					<div class="thin-seperator1">&nbsp;</div>
    					<div id="side-nav">';
    					
    	$theHtml .=  		'<div id="news-intro" class="large-white-scala">'.
    	       					stripslashes($thisPage[0]['block1']).'
    						</div>';
    	$theHtml .=  		'<div id="media-inquries">
    								<div class="box-title">'.stripslashes($thisPage[0]['blockTitle2']).'</div>'.
    	       					stripslashes($thisPage[0]['block2']).'
    						</div>';
    	$theHtml .=  		'<div id="media-downloads">
    							<div class="box-title">'.stripslashes($thisPage[0]['blockTitle3']).'</div>'.
    	       					stripslashes($thisPage[0]['block3']).'
    						</div>';
    							
    	$theHtml .= '	</div>
    				</div>';
		
		return $theHtml;
	}
	
	function getPressEight($press) {
		//print_r($press);
		foreach ($press as $pr) {
			$theHtml .= '<div class="date">'.$pr['date'].' [PDF]</div>';
			$theHtml .= '<div class="title"><a href="/rsrc/pressreleases/'.$pr['mediaPath1'].'">'.$pr['title'].'</a></div>';
		}
			$theHtml .= '<div class="title"><a href="/news-views/id-archive"><b>Press Release Archive</b></a></div>';
		return $theHtml;
		
	}
	
	function getPress($press) {
		//print_r($press);
		foreach ($press as $pr) {
			$theHtml .= '<div class="date">'.$pr['date'].' [PDF]</div>';
			$theHtml .= '<div class="title"><a href="/rsrc/pressreleases/'.$pr['mediaPath1'].'">'.$pr['title'].'</a></div>';
		}
		
		return $theHtml;
		
	}
	
	function getNewsEight($press) {
		$this->rows_per_page   	= 8;
		$this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";
		$newsEight = Default_Table::getData();
		foreach ($newsEight as $news) {
			$theHtml .= '<div class="date">'.$news['date'].'</div>';
			$theHtml .= '<div class="title"><a href="/news-views/id-'.$news['id'].'">'.$news['title'].'</a></div>';
		}
			$theHtml .= '<div class="title"><a href="/news-views/id-archive"><b>News Archive</b></a></div>';
		return $theHtml;
		
	}
	
	function getNewsAll($press) {
		$this->rows_per_page   	= 10000;
		$this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";
		$newsEight = Default_Table::getData();
		foreach ($newsEight as $news) {
			$theHtml .= '<div class="date">'.$news['date'].'</div>';
			$theHtml .= '<div class="title"><a href="/news-views/id-'.$news['id'].'">'.$news['title'].'</a></div>';
		}
		
		return $theHtml;
		
	}
	
	function footerMostRecent() {
        
		$this->sql_orderby = 'date';
  		$this->sql_orderby_seq = "DESC";
		$this->rows_per_page = 1;
		$this->newsList		= Default_Table::getData();
		$news = $this->newsList;
		
		$theHtml = '<div class="click-box">'."\n";
		$theHtml .= $news[0]['title'];
		$theHtml .= '<br /><br /><a class="more-link" href="/news-views">More</a>'."\n";
		$theHtml .= '</div>'."\n";
		return $theHtml;
	}
	} // END CONTACT CLASS
?>