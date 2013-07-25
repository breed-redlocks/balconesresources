<?php

require_once 'database.class.inc';


require_once "error.inc";


class Pages extends Default_Table
{

    // additional class variables go here
    function Pages () {
    	$this->debug			= false;
    	require_once "categories.class.inc";
       	$this->category			= new Categories;
       	require_once "class/settings.php";
       	$this->site				= $site;
       	require_once "class/projects.class.php";
       	$this->projects			= new Projects;
       	
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

	function createNav() {
	
		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);
   		
   		if ($path_parts['dirname'] == "/") {
   			if (!$path_parts['basename']) {
   				$thePage['page'] = "home";
   			} else {
   				$thePage['page'] = $path_parts['basename'];
   			}
   		} else {
   			$thePage['page'] = ltrim($path_parts['dirname'], "/");
   			$thePage['section'] = $path_parts['dirname'];
   			
   		}
  
   		//echo $thePage['page'];
   		$here = $this->getSection($thePage['page']);
 
   		//echo $this->pageItems[0]['link'];
       	
       	if ($here['parent'] > 15) {
    				$where = "categories = '".$here['parent']."'";
    				$here['slug'] = $this->catIdToSlug($here['parent']);
       			} else {
    				$where = "categories = '".$theSection['id']."'";
    				$here['slug'] = $thePage['page'];
    			}
       //	print_r($here);
       	
       	$category = $this->category;
   		$theHtml = '<div id="main-nav-area">'."\n";
   		$theHtml .= '	<div id="nav-1">'."\t\n";
   			
   			$where1 = "onNav = 1";
   			$navItems1 = Default_Table::getData($where1);
   			foreach ($navItems1 as $nav1) {
   			//print_r($nav1);
   				$theHtml .= $this->navOne($cat,$nav1,$here['slug']);
   			}
   		
   		$theHtml .= '	</div>'."\n";	
   		$theHtml .= '	<div class="clear"></div>'."\n";
   		$theHtml .= '</div>'."\n";
   	
   		return $theHtml;
	}
	
		function navOne($cat,$nav,$here) {
		//echo $here;
				if ($here == $nav['link']){
   						$class = 'main-nav-item-active';
   				} else {
   						$class = 'main-nav-item';
   				}
   				if ($cat[0]['slug']) {

   					$theHtml .= '<div class="' . $class . '-1">'."\n";
   					$theHtml .= '<a title="'.$nav['metaTitle'].'" href="/' .$cat[0]['slug'] . '/' . $nav['link'] . '">' . $nav['title'] . '</a>'."\n";
   					$theHtml .= '</div>'."\n";  
   		 		} else {

   		 			$theHtml .= '<div class="' . $class . '-1">'."\n";
   					$theHtml .= '<a title="'.$nav['metaTitle'].'" href="/' . $nav['link'] . '">' . $nav['title'] . '</a>'."\n";
   					$theHtml .= '</div>'."\n";
   		 		}
   		 		
   		 		return $theHtml;
		
		}
		
		function navTwo($cat,$nav,$here,$count,$curNum) {
		//echo "<br>count = ".$count." - - - Current num = ".$curNum;
				
				if ($here == $nav['link']){
   						$arrow = 'nav-2-arrow-active.png';
   				} else {
   						$arrow = 'nav-2-arrow.png';
   				}
   				if ($cat[0]['slug']) {

   					$theHtml .= '<div class="nav-spacer">'."\n".'<img src="/rsrc/common/' . $arrow . '" alt="nav-arrow" />'."\n".'</div>'."\n";
   					$theHtml .= '<div class="main-nav-item-2">'."\n".'<a href="/' .$cat[0]['slug'] . '/' . $nav['link'] . '">' . $nav['title'] . '</a>'."\n".'</div>'."\n";  
   		 		} else {

   					$theHtml .= '';
   		 			$theHtml .= '<div class="main-nav-item-2">'."\n".'<div class="nav-arrow-2">'."\n".'<img src="/rsrc/common/' . $arrow . '" alt="nav-arrow" />'."\n".'</div>'."\n".'<div class="nav-text-2">'."\n".'<a href="/' . $nav['link'] . '">' . $nav['title'] . '</a>'."\n".'</div>'."\n";
   					if ($curNum < $count){
   						$theHtml .= '<div class="nav-spacer">'."\n".'&nbsp;'."\n".'</div>'."\n";
   					}				
   					$theHtml .= '</div>'."\n";
   		 		}
   		 		
   		 		return $theHtml;
		
		}
		
		function createHeader() {

   		$where = "isHome = '1'";
   		$homePage = Default_Table::getData($where);
   		$theHtml = '<div id="header">'."\n";
   		$theHtml .= '	<div id="logo">'."\n".'<a href="/' . $homePage[0]['link'] . '">'."\n".''."\n".'<img src="/rsrc/common/' . 
   								$this->site['logo-file'] . 
   								'" alt="' . $this->site['logo-alt'] . 
   								'" title="' . $this->site['logo-title'] . 
   								'" />
   							</a>'."\n".'
   						</div>'."\n";
   		$theHtml .= $this->createNav();
   		
   		$theHtml .= '<div class="clear"></div>'."\n";
   		$theHtml .= '</div>'."\n";
   		
   	
   		return $theHtml;
	}
	
	function createFooter() {

   		$theHtml .= '<div id="footer">
   						<div id="footer-wrapper">
   							<div id ="footer-left">
   								&copy; 1998 - 2012 Williams World Wide Web | <a href="/privacy-policy">Privacy Policy</a> | <a href="/visual-sitemap">Site Map</a>
   							</div>
   							<div id="google1">
   								<!-- Place this tag where you want the +1 button to render -->
								<g:plusone annotation="inline"></g:plusone>

								<!-- Place this render call where appropriate -->
								<script type="text/javascript">
  									(function() {
    									var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    									po.src = \'https://apis.google.com/js/plusone.js\';
    									var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  										})();
								</script>
							</div>
							<div class="clear"></div>
						</div>
   					</div>';

   	
   		return $theHtml;
	}
	
	
    
    function getArrows($direction) {
    	if ($direction == "left") {
    		$theHtml = '<div id="' . $direction . '-arrow">
						<a onmouseover="scrollDiv(\'l\', 490)" href="#null">
							<img src="/rsrc/projects/' . $direction . '_arrow.png">
						</a>
					</div>';

		} elseif ($direction == "right") {
			$theHtml = '<div id="' . $direction . '-arrow">
						<a onmouseover="scrollDiv(\'r\', 490)" href="#null">
							<img src="/rsrc/projects/' . $direction . '_arrow.png">
						</a>
					</div>';
		}
		return $theHtml;
    }
   
   function setPage($page, $content) {
   		if ($this->debug) {
   			echo "<pre><br>PAGE - ";
   			print_r($page);
   			echo "</pre>";
   			echo "<pre><br>SITE - ";
   			print_r($this->site);
   			echo "</pre>";
   		}
   		// GET DATA ASSOCIATED WITH IDENTIFIED PAGE
   		$where 		= "title = '" . $page[0]['title'] . "'";
   		$pageItems 	= Default_Table::getData($where);
   		// WHICH, IF ANY, LAYOUT IS SPECIFIED 
   		if ($page[0]['layout']) {
   			$theLayout = '<link rel="stylesheet" type="text/css" href="/css/page-layouts/' . $page[0]['layout'] . '.css " media="screen, print">';
   		} else {
   			$theLayout = '';
   		}
   		if ($page[0]['theme']) {
   			$theLayout .= '<link rel="stylesheet" type="text/css" href="/css/themes/' . $page[0]['theme'] . '.css " media="screen, print">';
   		} else {
   			$theLayout .= '';
   		}
   		
   		$thePage = $this->parseUrl();
		if ($thePage[0]['selector'] == "title") {
			$pageTitle = $thePage[0]['selectValue'].' - '.$page[0]['metaTitle'];
			
		} elseif ($pageItems[0]['component'] == "projects") {
			if ($thePage[0]['selector'] == "id") {
				$where = "id = '".$thePage[0]['selectValue']."'";
				$project = $this->projects->getData($where);
				
				$pageTitle = $page[0]['metaTitle'].' - '.$project[0]['title'];
			
			} else {
				$pageTitle = $page[0]['metaTitle'];
			}
			
		} else {
			$pageTitle = $page[0]['metaTitle'];
		}
   		$theHtml = '<!DOCTYPE HTML>'."\n";
   		$theHtml .= '<html>'."\n";
   		$theHtml .= '<head>'."\t\n";
   		$theHtml .= '<meta charset="UTF-8" />'."\n";
   		$theHtml .= '<meta name="description" content="'.$page[0]['metaDesc'].'" />'."\t\n";
		$theHtml .= '<meta name="keywords" content="'.$page[0]['metaKeys'].'" />'."\t\n";
		$theHtml .= '<meta name="google-site-verification" content="V-gwWBFvU0gJhado1Nhindzqo2JN-ExG-ac8mrJIQ6E" />
						<meta name="msvalidate.01" content="9C40FBE15DD2711CCD1B6EDC2B0D4257" />';
   		$theHtml .= '<title>' . $pageTitle . '</title>'."\t\n";
   		$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/main.css" media="screen, print">'."\t\n";
   		$theHtml .= '<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js" ></script>'."\t\n";
		
		if ($pageItems[0]['component'] == "homepage") {
			$theHtml .='<link rel="stylesheet" href="/css/default-slider.css" type="text/css" media="screen" />';
   			$theHtml .= '<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" media="screen" />';
    	}
    
		$theHtml .= '<script type="text/javascript" src="/js/main.js" ></script>'."\t\n";
   		$theHtml .= $theLayout."\n";
   		
   		$theHtml .= '</head>'."\n";
   		// LOAD GOOGLE MAPS JS
		if ($pageItems[0]['component'] == "contact") {
   			$theHtml .= '<body onload="load()">'."\n";   		
		} else {
			$theHtml .= '<body>'."\n";
		}
   			$theHtml .= '<div id="canvas">'."\n";

   			$theHtml .= 	$this->createHeader();
   			$theHtml .= '	<div id="content">'."\t\n";
   			$theHtml .= 		$content;
   			$theHtml .= '		<div class="clear"></div>'."\t\n";
   			$theHtml .= '	</div>'."\n"; // END CONTENT
   			$theHtml .= 	$this->createFooter();
   			$theHtml .= '</div>'."\n"; // END CANVAS

   		$theHtml .= "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32394515-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
   		$theHtml .= '</body>'."\n";
   		$theHtml .= '</html>'."\n";
   		
   		return $theHtml;
   
   }
   
   function parseUrl() {
   		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);
   		// echo preg_replace('/[^a-zA-Z0-9-]/', '', $path_parts['dirname']);

   		
   		if (!$path_parts['basename']) {
   			$where = "isHome = 1";
   		} else {
   		
   			if ($path_parts['dirname'] == "/") {
   				$where = "link = '" . $path_parts['basename'] . "'";
   			} else {
   				$where = "link = '" . preg_replace('/[^a-zA-Z0-9-]/', '', $path_parts['dirname']) . "'";
   				
   				//$page['component'] = strrchr($path_parts['dirname'] , '/');
   			}
   		}
   		
   		$thePage = Default_Table::getData($where);
   		
   		if (preg_match("/categories-/i", $path_parts['basename'], $matches)) {
   			$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];

		} elseif (preg_match("/title-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];	
    	} elseif (preg_match("/industry-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];
    	} elseif (preg_match("/id-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];
    	} elseif (preg_match("/video-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];		
    	} elseif (preg_match("/section-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];		
		} elseif (preg_match("/tags-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];		
		} elseif (preg_match("/author-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    		//echo "<br> The selector = " . $thePage[0]['selector'];
    		//echo "<br> The select value = " . $thePage[0]['selectValue'];
   		 
   		}
   		
   		return $thePage;
   
   }
   
   function getSection($thePage) {
		$where = "link = '" . $thePage . "'";
		//echo $where."<br>";
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
   	
   	function catIdToSlug($id) {
   		$whereCat = "id = '" . $id . "'";
		$catInfo = $this->category->getData($whereCat);
		$catSlug = $catInfo[0]['slug'];
		
		return $catSlug;
   	
   	}
   
      		
} // end class
?>