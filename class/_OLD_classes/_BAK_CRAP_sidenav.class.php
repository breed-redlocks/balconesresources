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
        $this->dbname          	= 'headwatersmb';
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
           		//$thisPageId = $this->getPageId();
           		// GET CURRENT PAGE LINK
           		$page = $this->getPage();
    			// GET THE PAGE CATEGORY NAME FOR THIS PAGE FROM PAGE LINK
    			$section = $this->getSection($page);
    			// SELECT PAGES THAT HAVE THE SAME CATEGORY ID
    			$where = "categories = '".$section['id']."'";
    			$pagesInSection = Default_Table::getData($where);
  
				
    			
    			$theHtml = '<div id="left-column-nav">
    							<div id="page-title">'.$section['name'].'</div>
    							<div class="thin-seperator1">&nbsp;</div>
    							<div id="side-nav">';
    			$theHtml .= '<ul>';
    						// CREATE SECTION SUB NAV
    						foreach ($pagesInSection as $item){
    							$pagesInCat = $this->createArray($item['link']);
    							
    							foreach ($pagesInCat as $catPages) {
    								if ($catPages == $page['link']) {
    									$theHtml .= '<li class="active">
    													<a class="active" href="' . $item['link'] . '">
    														' . $item['title'] . '
    													</a>
    												</li>';
    									$theHtml .= $this->getSideSubNav($item['link'],$itemCount,$thisPageId);
    								}
    							}
    							
    								if ($item['link'] == $page['link']){
    									$theHtml .= '<li class="active">
    													<a class="active" href="' . $item['link'] . '">
    														' . $item['title'] . '
    													</a>
    												</li>';
    									$theHtml .= $this->getSideSubNav($item['link'],$itemCount,$thisPageId);
       								
       								} else {
    									$theHtml .= '<li><a href="' . $item['link'] . '">' . $item['title'] . '</a></li>';
    								}
    							
    						}
    			$theHtml .= '</ul></div></div>';
    	
    	
    	echo "SECTION<br>";		
		echo "<pre>";
        print_r($section);
        echo "</pre>";
        
        echo "PAGE<br>";
        echo "<pre>";
        print_r($page);
        echo "</pre>";
        
        echo "CHILDREN<br>";
        echo "<pre>";
       	print_r($children);
        echo "</pre>";
        
		
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
    			
			} else {
				//echo "SUBNAV - link".$page;
				$catInfo = $this->catIdFromSlug($page);
				$where = "categories = '".$catInfo[0]['id']."'";
				$pageList = Default_Table::getData($where);
				$itemCount = count($pageList);
				$halfCount = ceil($itemCount / 2);
				$i=1;
				foreach($pageList as $profiles) {
					if ($i <= $halfCount){
						$column1head = '<div id="side-sub-nav-col1"><ul id="profile-nav">';
    					$column1list .= '<li><a href="/' . $profiles['link'] . '">' . $profiles['title'] . '</a></li>';
    					$column1foot = '</ul></div>';
    					$i++;
					} else {
						$column2head = '<div id="side-sub-nav-col2"><ul id="profile-nav">';
						$column2list .= '<li><a href="/' . $profiles['link'] . '">' . $profiles['title'] . '</a></li>';
						$column2foot = '</ul></div>';
    					$i++;
					}
				}
				
				$theHtml .= $column1head .''.$column1list.''.$column1foot.''.$column2head .''.$column2list.''.$column2foot.'<div class="clear"></div>';

			}

			
			return $theHtml;
	}
	
	function getPage() {
		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);

   		if ($path_parts['dirname'] == "/") {
   			if (!$path_parts['basename']) {
   				$thePage['link'] = "home";
   			} else {
   				$thePage['link'] = $path_parts['basename'];
   			}
   		} else {
   			$thePage['link'] = $path_parts['basename'];
   			$thePage['section'] = $path_parts['dirname'];
   		}
   		
   		$where 			= "link = '".$thePage['link']."'";
   		//echo $where;
   		$pageData 		= Default_Table::getData($where);
   		//print_r($pageData);
   		$thePage['cat'] = $pageData[0]['categories'];
   		
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
	//print_r($thePage);
		// USING URL AND GETPAGE GET THE LINK FOR PAGE DATA
		$where = "slug = '" . $thePage['link'] . "'";
		$catInfo = $this->category->getData($where);
		//$theSection['id'] = $catInfo[0]['id'];
		
		if (isset($catInfo[0]['parent'])){
		
			if ($catInfo[0]['parent'] > 15){
				$where2 = "id = '" . $catInfo[0]['parent'] . "'";
				$catInfo2 = $this->category->getData($where2);
				//print_r($catInfo2);
				$theSection['id'] = $catInfo2[0]['id'];
				$theSection['name'] = $catInfo2[0]['name'];
			
			} else {
			
			
			
				$theSection['id'] = $catInfo[0]['id'];
				$theSection['name'] = $catInfo[0]['name'];
			}
			
		} else {
				
				$where2 = "id = '" . $thePage['cat'] . "'";
				$catInfo2 = $this->category->getData($where2);
				$parent = $catInfo2[0]['parent'];
				$where3 = "id = '" . $parent . "'";
				$catInfo3 = $this->category->getData($where3);
				$theSection['id'] = $catInfo3[0]['id'];
				$theSection['name'] = $catInfo3[0]['name'];
	
		}
		
		
		
   		return $theSection;
   	}
   	
   	function createArray($slug) {
   		$pageArray = array();

   		$catId = $this->catIdFromSlug($slug);
   		//print_r($catId);
   		$catId = $catId[0]['id'];
   		//echo "<br>".$catId;
   		$where = "categories = '".$catId."'";
   		$pages = Default_Table::getData($where);
   		foreach ($pages as $page) {
   			$pageArray[] .=$page['link'];
   		}
   		return $pageArray;
   	
   	}
   	
   	function catIdFromSlug($slug){
   		$whereCat = "slug = '" . $slug . "'";
		$catInfo = $this->category->getData($whereCat);
		return $catInfo;
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