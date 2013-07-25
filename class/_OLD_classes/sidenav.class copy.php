<?php

require_once 'database.class.inc';
require_once "error.inc";
require_once "people.class.php";



class Sidenav extends Default_Table
{

    // additional class variables go here
    function Sidenav ()
    {
       	require_once "class/settings.php";
       	$this->site				= $site;
       	require_once "categories.class.inc";
       	$this->category			= new Categories; 	
        $this->tablename      	= 'pages';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 100;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
        $this->pageItems		= Default_Table::getData();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml($pageTitle,$category,$subcategory,$itemCount) {
           		// GET PAGE ID
           		$thisPageId = $this->getPageId();
           		// GET CURRENT PAGE LINK
           		$thePage = $this->getPage();
    			// GET THE PAGE CATEGORY NAME FOR THIS PAGE FROM PAGE LINK
    			$theSection = $this->getSection($thePage['page']);
    			// SELECT PAGES THAT HAVE THE SAME CATEGORY ID
    			$where = "categories = '".$theSection['id']."'";
    			$pagesInSection = Default_Table::getData($where);
    			
    			
    			$theHtml = '<div id="left-column-nav">
    							<div id="page-title">'.$theSection['name'].'</div>
    							<div class="thin-seperator1">&nbsp;</div>
    							<div id="side-nav">';
    			$theHtml .= '<ul>'."\n";
    						foreach ($pagesInSection as $page){
    							
    							// CHECK TO SEE IF PAGE BELONGS ON ANY SIDE NAV 3
    							if ($page['onNav'] == 3){
    								
    								// CHECK TO SEE IF WE ARE ON A SIDE NAV PAGE AND ACTIVATE
    								if ($page['link'] == $thePage['page']){
    									$theHtml .= '<li class="active">';
    									$theHtml .= '<a class="active" href="' . $page['link'] . '">' . $page['title'] . '</a>';
    									$theHtml .= '</li>'."\n";
    									$theHtml .= $this->getSideSubNav($page['link'],$itemCount,$thisPageId);
    								} else {
    									$theHtml .= '<li><a href="' . $page['link'] . '">' . $page['title'] . '</a></li>'."\n";
    								}
    							}
    						}
    			$theHtml .= '</ul>'."\n".'</div></div>';
    			
		//echo "<pre>";
        //print_r($theSection);
        //echo "</pre>";
        //echo "<pre>";
        print_r($thePage);
        //echo "</pre>";
        //echo "<pre>";
       	//print_r($stuff);
        //echo "</pre>";
        
		
		return $theHtml;

	}
	
	function getSideSubNav($page,$itemCount,$thisPageId){
           		
			$theHtml = '';
			$halfCount = ceil($itemCount / 2);
			// PEOPLE SUB NAV
			if ($page == "people") {
				$profileList	= new People;
           		$stuff = $profileList->getData();

				$i=1;
				foreach($stuff as $profiles) {
					if ($profiles['displayProfile'] == 1){
					if ($i <= $halfCount){
						$column1head = '<div id="side-sub-nav-col1"><ul id="profile-nav">';
    					$column1list .= '<li><a href="#profile-' . $profiles['id'] . '">' . $profiles['name'] . '</a></li>';
    					$column1foot = '</ul></div>';
    					$i++;
					} else {
						$column2head = '<div id="side-sub-nav-col2"><ul id="profile-nav">';
						$column2list .= '<li><a href="#profile-' . $profiles['id'] . '">' . $profiles['name'] . '</a></li>';
						$column2foot = '</ul></div>';
    					$i++;
					}
					}
				}		
				
    			$theHtml .= $column1head .''.$column1list.''.$column1foot.''.$column2head .''.$column2list.''.$column2foot.'<div class="clear"></div>';
    			
			} elseif ($page == "investment-banking") {

				$theHtml .= '<div id="side-sub-nav-col1">
		<ul id="profile-nav">
			<li><a href="mergers-acquisitions">Merger and Acquisition</a></li>
			<li><a href="capitol-formation">Capitol Formation</a></li>
			
		</ul>
	</div>
	<div id="side-sub-nav-col2">
		<ul id="profile-nav">
			<li><a href="financial-advisory">Financial Advisory</a></li>
		</ul>
	</div><div class="clear"></div>';
			
			}
			
			if ($page == "") {
				$theHtml = '';
			
			}
			
			if ($page == "") {
				$theHtml = '';
			
			}
			
			if ($page == "") {
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
   	
   	function getPageId() {
   		$pageLink = $this->getPage();
   		$pageLink = $pageLink['page'];
   		$where = "link = '" . $pageLink . "'";
		$pageInfo = Default_Table::getData($where);
		$pageId = $pageInfo[0]['id'];
		return $pageId;
   	
   	}
	
	function getSection($thePage) {
		$where = "link = '" . $thePage . "'";
		$pageInfo = Default_Table::getData($where); 
		$whereCat = "id = '" . $pageInfo[0]['categories'] . "'";
		$catInfo = $this->category->getData($whereCat);
		$theSection['name'] = $catInfo[0]['name'];
		$theSection['id'] = $pageInfo[0]['categories'];
   		return $theSection;
   	}
   	
   	function catIdToName($id) {
   		$whereCat = "id = '" . $id . "'";
		$catInfo = $this->category->getData($whereCat);
		$catName = $catInfo[0]['name'];
		
		return $catName;
   	
   	}

	
	function countProfiles() {
		$numProfiles = Default_Table::getCount();
		return $numProfiles;
	}
	
	
} // end class
?>