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
        $this->dbname          	= 'brdevdb';
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
    
    
    
    function getHtml($selector,$selectValue,$subcategory,$itemCount) {
           		// GET PAGE ID
           		$thisPageId = $this->getPageId();
           		
           		// GET CURRENT PAGE LINK
           		$thePage = $this->getPage();
           		if ($thePage['section'] == "/people") {
           			$thePage['page'] = "people";
           			$activeId = $selectValue;
           		}
    			
    			// GET THE PAGE CATEGORY NAME FOR THIS PAGE FROM PAGE LINK
    			$theSection = $this->getSection($thePage['page']);
    			
    			// SELECT PAGES THAT HAVE THE SAME CATEGORY ID
    			
    			if ($theSection['parent'] > 15) {
    				$where = "categories = '".$theSection['parent']."'";
    				$theSection['name'] = $this->catIdToName($theSection['parent']);
       			} else {
    				$where = "categories = '".$theSection['id']."'";
    			}
    			
    			$subNavItems = $this->getSubNavItems($thePage['page']);

    			$pagesInSection = Default_Table::getData($where);	
    			
    			$theHtml = '<div id="left-column-nav">
    							<div id="page-title">'.$theSection['name'].'</div>
    							<div class="thin-seperator1">&nbsp;</div>
    							<div id="side-nav">';
    			$theHtml .= '<ul>'."\n";
    						
    				foreach ($pagesInSection as $page){
    					
    					if ($page['onNav'] !=2) {
    									
    						// CHECK TO SEE IF WE ARE ON A SIDE NAV PAGE AND ACTIVATE
    						if ($page['link'] == $thePage['page']){
    							if ((isset($subNavItems)) || ($thePage['page'] == "people")) {
    								$theHtml .= '<li class="active">';
    								$theHtml .= '<a class="active" href="/' . $page['link'] . '">' . $page['title'] . '</a>';
    								$theHtml .= '</li>'."\n";
       								$theHtml .= '<div id="side-sub-navs">'.$this->getSideSubNav($page['link'],$itemCount,$theSection['slug'],$subNavItems,$thePage['page'],$activeId).'</div>';
    							} else {
    								$theHtml .= '<li class="active">';
    								$theHtml .= '<a class="active" href="/' . $page['link'] . '">' . $page['title'] . '</a>';
    								$theHtml .= '</li>'."\n";
    							}			
    							
    						
    						} elseif ($page['onNav'] == $thePage['onNav']) {
    							if ($page['onNav'] == "3") {
    								$theHtml .= '<li><a href="/' . $page['link'] . '">' . $page['title'] . '</a></li>'."\n";
    							} else {
    							
    							
    								$theHtml .= '<li class="active">';
    								$theHtml .= '<a class="active" href="/' . $page['link'] . '">' . $page['title'] . '</a>';
    								$theHtml .= '</li>'."\n";
       								$theHtml .= '<div id="side-sub-navs">'.$this->getSideSubNav($page['link'],$itemCount,$thePage['section'],$subNavItems,$thePage['page'],$activeId).'</div>';
    							}
    									
    						} else {
    										
    							$theHtml .= '<li><a href="/' . $page['link'] . '">' . $page['title'] . '</a></li>'."\n";
							}
    									
    					}
    							
    				}
    			$theHtml .= '</ul>'."\n".'</div></div>';
    		
		//echo "Section<pre>";
        //print_r($theSection);
        //echo "</pre>";
        //echo "Page<pre>";
        //print_r($thePage);
        //echo "</pre>";
       
		
		return $theHtml;

	}
	
	function getSideSubNav($page,$itemCount,$thisSection,$subNavItems,$activePage,$activeId){
								//echo "SUB NAV ITEMS<pre>";
    							//print_r($subNavItems);
    							//echo "</pre>";
    							//print_r($page);
    							//echo $activeId."<br>";
           		
			$theHtml = '';
			$halfCount = ceil($itemCount / 2);
			
			// PEOPLE SUB NAV
			
			if ($page == "people") {
				$profileList	= new People;
				$this->sql_orderby = 'lastName';
  				$this->sql_orderby_seq = "DESC";
           		$stuff = $profileList->getData();

				$i=1;
				foreach($stuff as $profiles) {
					if ($profiles['id'] == $activeId) {
						$active = "active";
					} else {
						$active = '';
					}
					
					if ($profiles['displayProfile'] == 1){
					if ($i <= $halfCount){
						$column1head = '<div id="side-sub-nav-col1"><ul id="profile-nav">';
    					$column1list .= '<li><a class= "'.$active.'" href="/people/id-' . $profiles['id'] . '">' . $profiles['name'] . ' ' . stripslashes($profiles['lastName']) . '</a></li>';
    					$column1foot = '</ul></div>';
    					$i++;
					} else {
						$column2head = '<div id="side-sub-nav-col2"><ul id="profile-nav">';
						$column2list .= '<li><a class= "'.$active.'" href="/people/id-' . $profiles['id'] . '">' . $profiles['name'] . ' ' . stripslashes($profiles['lastName']) . '</a></li>';
						$column2foot = '</ul></div>';
    					$i++;
					}
					}
				}		
				
    			$theHtml .= $column1head .''.$column1list.''.$column1foot.''.$column2head .''.$column2list.''.$column2foot.'<div class="clear"></div>';
    			
			} elseif ($subNavItems){
				$fullCount = count($subNavItems);
				$halfCount = ceil(count($subNavItems) / 2);
				if ($fullCount > 4){
					$i=1;
				foreach($subNavItems as $pageItem) {
				
					if ($pageItem['link'] == $activePage) {
						$active = "active";
					} else {
						$active = "";
					}
					
					if ($i <= $halfCount){
						$column1head = '<div id="side-sub-nav-col1"><ul id="profile-nav">';
    					$column1list .= '<li><a class="'.$active.'" href="' . $pageItem['link'] . '">' . $pageItem['title'] . '</a></li>';
    					$column1foot = '</ul></div>';
    					$i++;
					} else {
						$column2head = '<div id="side-sub-nav-col2"><ul id="profile-nav">';
						$column2list .= '<li><a class="'.$active.'" href="' . $pageItem['link'] . '">' . $pageItem['title'] . '</a></li>';
						$column2foot = '</ul></div>';
    					$i++;
					}
				}	
				$theHtml .= $column1head .''.$column1list.''.$column1foot.''.$column2head .''.$column2list.''.$column2foot.'<div class="clear"></div>';
				} else {
					$i=1;
				foreach($subNavItems as $pageItem) {
				
					if ($pageItem['link'] == $activePage) {
						$active = "active";
					} else {
						$active = "";
					}
					
	
						$column1head = '<div id="side-sub-nav-col1"><ul id="profile-nav">';
    					$column1list .= '<li><a class="'.$active.'" href="' . $pageItem['link'] . '">' . $pageItem['title'] . '</a></li>';
    					$column1foot = '</ul></div>';
    					$i++;
				
				}	
				$theHtml .= $column1head .''.$column1list.''.$column1foot.'<div class="clear"></div>';
				}
				
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
   		$where = "link = '".$thePage['page']."'";
   		$pageData = Default_Table::getData($where);
   			$thePage['onNav'] = $pageData[0]['onNav'];
   		
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
		$theSection['id'] = $catInfo[0]['id'];
		$theSection['slug'] = $catInfo[0]['slug'];
		$theSection['parent'] = $catInfo[0]['parent'];
 
			/*if ($theSection['parent'] > 15) {
				$whereCat2 = "id = '" . $theSection['parent'] . "'";
				$catInfo2 = $this->category->getData($whereCat2);
				$theSection['name'] = $catInfo2[0]['name'];
				$theSection['id'] = $catInfo[0]['parent'];
				$theSection['slug'] = $catInfo2[0]['slug'];
				$theSection['parent'] = $catInfo2[0]['parent'];
			}
			*/
   		return $theSection;
   	}
   	
   	function catIdToName($id) {
   		$whereCat = "id = '" . $id . "'";
		$catInfo = $this->category->getData($whereCat);
		$catName = $catInfo[0]['name'];
		
		return $catName;
   	
   	}
   	
   	function getSubNavItems($page) {
   		//echo "<br>PAGE PASSED TO GETSUBNAVITEMS()".$page."<br>";
   	
   		if (($page == "investment-banking") || 
   			($page == "mergers-acquisitions") || 
   			($page == "capital-formation") || 
   			($page == "financial-advisory")) {
   			
   				$where = "onNav = 'investment-banking'";
   				$pageInfo = Default_Table::getData($where);
   				
   				$i=0;
				foreach ($pageInfo as $items) {
					if ($items['link'] != "investment-banking") {
						$pageItems[$i]['title'] = $items['title'];
						$pageItems[$i]['link'] = $items['link'];
		
						$i++;
					}
		
				}
   		
   		} elseif (($page == "merchant-banking") || ($page == "headwaters-capital-partners") || ($page == "rio-grande-investors-fund")) {
   			$where = "onNav = 'merchant-banking'";
   			$pageInfo = Default_Table::getData($where);
   			
   				$i=0;
				foreach ($pageInfo as $items) {
					if ($items['link'] != "merchant-banking") {
							$pageItems[$i]['title'] = $items['title'];
							$pageItems[$i]['link'] = $items['link'];
		
							$i++;
					}
		
				}
		} elseif (($page == "integrated-business-advisory-services") || ($page == "growth-strategy") || ($page == "business-acquisitions") || ($page == "company-capitalization") || ($page == "business-governance") || ($page == "value-monitoring") ||  ($page == "shareholder-liquidity") ||  ($page == "generational-stewardship")) {
   			$where = "onNav = 'integrated-business-advisory-services'";
   			$pageInfo = Default_Table::getData($where);
   			
   				$i=0;
				foreach ($pageInfo as $items) {
					if ($items['link'] != "integrated-business-advisory-services") {
							$pageItems[$i]['title'] = $items['title'];
							$pageItems[$i]['link'] = $items['link'];
		
							$i++;
					}
		
				}
		
   		} else {
   		}

		return $pageItems;
   	}

	
	function countProfiles() {
		$numProfiles = Default_Table::getCount();
		return $numProfiles;
	}
	
	
} // end class
?>