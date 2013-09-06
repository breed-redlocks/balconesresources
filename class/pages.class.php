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
       	require_once "class/funfact.class.php";
       	$this->funfacts			= new Funfact;
       	       	
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

	function createNav($navNum) {
	
		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);
   		// CHECK TO SEE IF WE ARE GETTING A SELECTVALUE AND SELECTOR
   		$theIdentifier = $this->getSelector($path_parts);
   		
   		if (!$path_parts['basename']) {
   			$thePage['page'] = "home";
   		} elseif ($theIdentifier) {
   				$thePage['page'] = substr(strrchr($path_parts['dirname'], '/'), 1);
   		} else {
   			$thePage['page'] = $path_parts['basename'];
   			$thePage['section'] = $path_parts['dirname'];
   		}
   		
   		
   		
   		$theHtml .= '	<div id="nav-'.$navNum.'">'."\t\n";
   			
   		$where1 = "onNav = ".$navNum."";
   		$navItems = Default_Table::getData($where1);
   		$navItems1 = array_reverse($navItems);

   			foreach ($navItems1 as $nav1) {
   				$section = $this->getSection($nav1['link']);
				if ($section['id']) {
					if ($section['parent'] > 0) {
    					$cat = $this->catIdToSlug($section['parent']).'/'.$section['slug'];
    					$theHtml .= $this->navToNum($navNum,$cat,$nav1,$thePage['page']);
					} else {
						$cat = $section['slug'];
						$theHtml .= $this->navToNum($navNum,$cat,$nav1,$thePage['page']);
					}
				} else {
					$cat = '';
					$theHtml .= $this->navToNum($navNum,$cat,$nav1,$thePage['page']);
				}

   				
   			}
   			if ($navNum == 2) {
   				$theHtml .= '<div id="searchBox">
   							<form id="headerSearch" action="/search-results/search-term" method="post">
   								<input type="text" name="searchTerm">
   							</form>
   							</div>';
   			}
   		$theHtml .= '<div class="clear"></div>'."\n";
   		$theHtml .= '	</div>'."\n";	
   		
   		return $theHtml;
	}
	
	function navToNum($num,$cat,$nav1,$thePage) {
		if ($num == 1) {
			$theHtml .= $this->navOne($cat,$nav1,$thePage);
		} elseif ($num == 2) {
			$theHtml .= $this->navTwo($cat,$nav1,$thePage);
		} elseif ($num == 3) {
			$theHtml .= $this->navThree($cat,$nav1,$thePage);
		} else {
			echo "NAV NUMBER NOT SPECIFIED IN PAGE MANAGER";
		}
		return $theHtml;
	}
	
	function checkForSideNavItems($page,$layout) {
		$section = $this->getSection($page);
		//print_r($page);
		if ($section['id']) {
			if ($section['parent']) {
				// WE ARE NOT AT THE TOP - GET TOP LEVEL CAT / SECTION
				
				$whereParent = "id = ".$section['parent']."";
				$catInfo = $this->category->getData($whereParent);
				$section = $catInfo[0];
			} 
			$theHtml .= $this->buildSideNav($section,$page,$layout);
		}
		return $theHtml;
	}
	
	function buildSideNav($section,$here,$layout) {
		//print_r($section);
		$whereParent = "parent = ".$section['id']."";
		$catInfo = $this->category->getData($whereParent);
		$theHtml = '';
		
		if ($here != 'mills-and-reprocessors') {
		
			if ($here != 'news-and-events') {
			
				if (!$catInfo) { // THE PAGES ARE ASSIGNED TO THE SECTION
					$where = "categories = ".$section['id']."";
					$this->sql_orderby = 'sortBy';
  					$this->sql_orderby_seq = "ASC";
					$pages = Default_Table::getData($where);
					//print_r($pages);
				if ($section['slug'] == $here) {
					$sectionClass = 'section-active';
				} else {
					$sectionClass= 'section';
				}
				$theHtml .= '<div id="left-rail">';
				$theHtml .= '<div id="side-nav">';
				$theHtml .= '	<ul>';
				
				$titleLength = $this->string_length(strip_tags($this->convert_high_bytes(stripslashes($section['name']))));

				if (($titleLength < 14) || ($section['slug'] != $here)) {
					$style = '';
						
				} else {
					$style = 'style="background-image: url(/rsrc/common/active-arrow-42-'.$layout.'.png);background-position: 130px 0;"';
						
				}
				
				$theHtml .= '<li class="'.$sectionClass.'" '.$style.'><a href="'.$section['slug'].'">'.strip_tags($this->convert_high_bytes(stripslashes($section['name']))).'</a></li>';
			
				$i=0;
				foreach ($pages as $child) {
				
					if (($child['title'] != $section['name']) && ($child['title'] != 'Shred') && ($child['title'] != 'Mills & Reprocessors') && ($child['title'] != 'Sitemap')) {
						$titleLength = $this->string_length(strip_tags($this->convert_high_bytes(stripslashes($child['title']))));
						//echo $child['link'].' - '.$here.'<br>';
						if (($titleLength < 19) || ($child['link'] != $here)) {
							$style = '';
						
						} else {
							$style = 'style="background-image: url(/rsrc/common/active-arrow-36-'.$layout.'.png);background-position: 130px 0;"';
						
						}
						if ($child['link'] == $here) {
							$catClass = 'subCat-active';
						} else {
							$catClass= 'subCat';
						}
						//print_R($child);
						$theHtml .= '<li class="'.$catClass.'" '.$style.'><a href="'.$child['link'].'">'.strip_tags($this->convert_high_bytes(stripslashes($child['title']))).'</a></li>';
				
						$i++;
					}
				}// end foreach
				
			} else {
		
				$where = "categories = ".$section['id']."";
				$pages = Default_Table::getData($where);
				
				if ($section['slug'] == $here) {
					$sectionClass = 'section-active';
				} else {
					$sectionClass= 'section';
				}
				$theHtml .= '<div id="left-rail">';
				$theHtml .= '<div id="side-nav">';
				$theHtml .= '	<ul>';
				
				$titleLength = $this->string_length(strip_tags($this->convert_high_bytes(stripslashes($section['name']))));

				if (($titleLength < 14) || ($section['slug'] != $here)) {
					$style = '';
						
				} else {
					$style = 'style="background-image: url(/rsrc/common/active-arrow-42-'.$layout.'.png);background-position: 130px 0;"';
						
				}
				
				$theHtml .= '<li class="'.$sectionClass.'" '.$style.'><a href="/'.$section['slug'].'/'.$section['slug'].'">'.strip_tags($this->convert_high_bytes(stripslashes($section['name']))).'</a></li>';
				//$theHtml .= '<li class="'.$sectionClass.'" '.$style.'><a href="'.$section['slug'].'">'.strip_tags(stripslashes($section['name'])).'</a></li>';
			
				$i=0;
				foreach ($catInfo as $child) {
					$titleLength = $this->string_length(strip_tags($this->convert_high_bytes(stripslashes($child['name']))));
					if (($titleLength > 19) || ($child['name'] != $here)) {
						$style = '';
					} else {
						$style = 'style="background-image: url(/rsrc/common/active-arrow-42-'.$layout.'.png);background-position: 130px 0;"';						
					}
					if ($child['slug'] == $here) {
						$catClass = 'cat-active';
					} else {
						$catClass= 'cat';
					}
					//print_R($child);
					$theHtml .= '<li class="'.$catClass.'"><a href="'.$child['slug'].'">'.strip_tags($this->convert_high_bytes(stripslashes($child['name']))).'</a></li>';
					$whereChild = "categories = ".$child['id']."";
					$this->sql_orderby = 'sortBy';
  					$this->sql_orderby_seq = "ASC";
					$childPages = Default_Table::getData($whereChild);
					
					foreach ($childPages as $children) {
						$titleLength = $this->string_length(strip_tags($this->convert_high_bytes(stripslashes($children['title']))));
						//if (($titleLength > 19) || ($children['link'] != $here)) {
						if (($titleLength < 19) || ($children['link'] != $here)) {
							$style = '';
						} else {
							$style = 'style="background-image: url(/rsrc/common/active-arrow-36-'.$layout.'.png);background-position: 130px 0;"';						
						}
					
						if ($children['link'] == $here) {
							$subCatClass = 'subCat-active';
						} else {
							$subCatClass= 'subCat';
						}
						$theHtml .= '<li class="'.$subCatClass.'" '.$style.'><a href="/'.$section['slug'].'/'.$child['slug'].'/'.$children['link'].'">'.strip_tags($this->convert_high_bytes(stripslashes($children['title']))).'</a></li>';
					}
					//echo $childPages
					$i++;
				}
			} // END CHECK TO SEE IF PAGES ARE ASSIGNED DIRECTLY TO SECTION
		
		} else { // ENDS ($here != 'news-and-events') WE ARE IN NEWS-AND-EVENTS, DISPLAY TODAY'S DATE
		
			$theHtml .= '<div id="left-rail">';
			$theHtml .= '<div id="side-nav">';
			$theHtml .= '	<ul>';
			$theHtml .= '<li>&nbsp;</li>';
			$theHtml .= '<li class="cal-month">'.date("F").'</li>';
			$theHtml .= '<li class="cal-day">'.date("j").'</a></li>';
			$theHtml .= '<li class="cal-year">'.date("Y").'</a></li>';
		
		
		} // END WE ARE IN NEWS-AND-EVENTS
		
		$theHtml .= '	</ul>';
		$theHtml .= '<img src="/rsrc/common/side-nav-bottom.gif">';
		$theHtml .= '</div>';
		$funfact = $this->funfacts->getRandomFact();
		$theHtml .= '<div id="fun-fact">
						<div id="fun-fact-image">
							<img src="/rsrc/common/'.$layout.'-fun-fact.png" onclick="$(\'#fun-fact-text\').slideToggle();">
						</div>
						<div id="fun-fact-text" onclick="$(\'#fun-fact-text\').slideToggle();">'.$this->convert_high_bytes($this->convert_smart_quotes(stripslashes($funfact['fact'])));
			if ($funfact['mediaPath1']) {
				$theHtml .= '<br><img src="/rsrc/funfact/'.$funfact['mediaPath1'].'" />';
			}			
		
		$theHtml .= '	</div>
					</div>';
		$theHtml .= '</div>';
		
		} // ENDS ($here != 'mills-and-brokers') AND WE ARE DISPLAYING NO SIDENAV
		
		//	return $theHtml;
    return 'NOOOO';
		
	}// END BUILDSIDENAV
	
	
		function navOne($cat,$nav,$here) {

				$section = $this->getSection($here);
				if ($section['parent'] > 0) {
					$section = $this->getSection($section['slug']);
				}
			
				if ( ($here == $nav['link']) OR ($section['slug'] == $cat) ) {
   					$class = 'main-nav-item-active';
   						
   				} else {
   						$class = 'main-nav-item';
   				}
   				if ($cat) {
   					
   					if ($cat=="how-why") $title = 'How <span class="hw-plus">+</span> Why';
   					else $title = strip_tags(stripslashes($nav['title']));
   					
   					$theHtml .= '<div class="' . $class . '-1">'."\n";
   					$theHtml .= '<a title="'.strip_tags($nav['metaTitle']).'" href="/' .$cat . '/' . $nav['link'] . '">' . $title . '</a>'."\n";
   					$theHtml .= '</div>'."\n"; 
   					 
   		 		} else {
   		 			$theHtml .= '<div class="' . $class . '-1">'."\n";
   					$theHtml .= '<a title="'.strip_tags($nav['metaTitle']).'" href="/' . $nav['link'] . '">' . strip_tags(stripslashes($nav['title'])) . '</a>'."\n";
   					$theHtml .= '</div>'."\n";
   		 		}
   		 		
   		 		return $theHtml;		
		}
		
		function navTwo($cat,$nav,$here,$count,$curNum) {

				$section = $this->getSection($here);
				if ($section['parent'] > 0) {
					$section = $this->getSection($section['slug']);
				}
				
				if (($here == $nav['link']) OR ($section['slug'] == $cat)) {
   						$class = 'main-nav-item-active-2';
   				} else {
   						$class = 'main-nav-item-2';
   				}
   				if ($cat) {

   					//$theHtml .= '<div class="nav-spacer">'."\n".'<img src="/rsrc/common/' . $arrow . '" alt="nav-arrow" />'."\n".'</div>'."\n";
   					$theHtml .= '<div class="'.$class.'">'."\n".'<a href="/' .$cat . '/' . $nav['link'] . '">' . strip_tags(stripslashes($nav['title'])) . '</a>'."\n".'</div>'."\n";  
   		 		} else {

   					$theHtml .= '';
   		 			$theHtml .= '<div class="main-nav-item-2">'."\n".''."\n".'<div class="nav-text-2">'."\n".'<a href="/' . strip_tags($nav['link']) . '">' . strip_tags(stripslashes($nav['title'])) . '</a>'."\n".'</div>'."\n";
   					if ($curNum < $count){
   						$theHtml .= '<div class="nav-spacer">'."\n".'&nbsp;'."\n".'</div>'."\n";
   					}				
   					$theHtml .= '</div>'."\n";
   		 		}
   		 		
   		 		return $theHtml;
		
		}
		
		function createHeader() {
   			$theHtml = '<div id="header">'."\n";
   			$theHtml .= '	<div id="logo">'."\n".'<a href="/' . $homePage[0]['link'] . '">'."\n".''."\n".'<img src="/rsrc/common/' . 
   								$this->site['logo-file'] . 
   								'" alt="' . $this->site['logo-alt'] . 
   								'" title="' . strip_tags($this->site['logo-title']) . 
   								'" />
   							</a>'."\n".'
   						</div>'."\n";
   			$theHtml .= '<div id="main-nav-area">'."\n";
   			$theHtml .= $this->createNav(1);
   			$theHtml .= $this->createNav(2);
   			$theHtml .= '	<div class="clear"></div>'."\n";
   			$theHtml .= '</div>'."\n";
   			$theHtml .= '<div class="clear"></div>'."\n";
   			$theHtml .= '</div>'."\n";
   		
   	
   		return $theHtml;
	}
	
	function createFooter($layout) {
	//echo $layout;
		if ($layout == 'home') {
			$theHtml .= '<div id="footer-wrapper-home">
   						<div id="footer">
							<div id ="footer-left">
   								<p>&copy; 1999 - 2012 Balcones Resources, Inc. | <a href="/privacy-policy">Privacy Policy</a> | <a href="/visual-sitemap">Site Map</a></p>
   							</div>
							<div class="clear"></div>
						</div>
						<div id="footerArrow"></div>
   					</div>';
				$theHtml .= '<script type="text/javascript">

 							var _gaq = _gaq || [];
  							_gaq.push([\'_setAccount\', \'UA-17462677-1\']);
  							_gaq.push([\'_trackPageview\']);

  							(function() {
    							var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    							ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    							var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  							})();

						</script>';
   
		} else {
			$theHtml .= '<div id="footer-wrapper">
   						<div id="footer"><iframe id ="thankyou" name="thankyou" width="0px" height="0px" src="http://www.balconesresources.com/wait.php" style="display:none;visibility:hidden"></iframe>
							<div id ="footer-left">
   								<p>&copy; 1999 - 2012 Balcones Resources, Inc. | <a href="/privacy-policy">Privacy Policy</a> | <a href="/visual-sitemap">Site Map</a></p>
   							</div>
							<div class="clear"></div>
						</div>
						<div id="footerArrow"></div>
   					</div>';

			   			$theHtml .= '<script type="text/javascript">

 							var _gaq = _gaq || [];
  							_gaq.push([\'_setAccount\', \'UA-17462677-1\']);
  							_gaq.push([\'_trackPageview\']);

  							(function() {
    							var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    							ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    							var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  							})();

						</script>';
   		
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
				
				$pageTitle = strip_tags($page[0]['metaTitle']).' - '.$project[0]['title'];
			
			} else {
				$pageTitle = strip_tags($page[0]['metaTitle']);
			}
			
		} else {
			$pageTitle = strip_tags($page[0]['metaTitle']);
		}
   		$theHtml = '<!DOCTYPE HTML>'."\n";
   		$theHtml .= '<html>'."\n";
   		$theHtml .= '<head>'."\t\n";
   		$theHtml .= '<meta charset="UTF-8" />'."\n";
   		$theHtml .= '<meta name="description" content="'.$page[0]['metaDesc'].'" />'."\t\n";
		$theHtml .= '<meta name="keywords" content="'.$page[0]['metaKeys'].'" />'."\t\n";
		$theHtml .= '<meta name="google-site-verification" content="uBgWdURmPwQFKXIfIrUIxDlP7QYnuEn48o7vH3sfR0Q" />'."\t\n";
		$theHtml .= '<meta name="msvalidate.01" content="2914DA7CA92458CF6BA9DB3CC033EC1B" />'."\t\n";
		$theHtml .= '<meta property="og:title" content="Balcones Resources" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://balconesresources.com" />
<meta property="og:image" content="http://balconesresources.com/rsrc/common/fb-logo.gif" />
<meta property="og:site_name" content="BalconesResources.com" />
<meta property="fb:admins" content="451074914933947" />'."\t\n";
		$theHtml .= '<link rel="shortcut icon" type="image/x-icon" href="http://balconesresources.com/favicon.ico" />'."\t\n";
   		$theHtml .= '<title>' . $pageTitle . '</title>'."\t\n";   		
   		$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/main.css" media="screen, print">'."\t\n";
   		$theHtml .= '<script type="text/javascript" src="//use.typekit.net/vsl7ure.js"></script>
						<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
  		
   		if ($page[0]['layout']) {
   		
   			if (($pageItems[0]['component'] == "homepage") || ($pageItems[0]['component'] == "millsandbrokers")) {
   				$theLayout ='';   			
   			} else {
   				$theLayout = '<link rel="stylesheet" type="text/css" href="/css/page-layouts/internal-common.css " media="screen, print">'."\t\n";
   			}
   			$theLayout .= '<link rel="stylesheet" type="text/css" href="/css/page-layouts/' . $page[0]['layout'] . '.css " media="screen, print">'."\t\n";
   			
   		} else {
   			$theLayout = '';
   		}
   		
   		$theHtml .= '<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js" ></script>'."\t\n";
		
		if ($pageItems[0]['component'] == "homepage") {
			$theHtml .='<link rel="stylesheet" href="/css/default-slider.css" type="text/css" media="screen" />';
   			$theHtml .= '<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" media="screen" />';
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.nivo.slider.js"></script>'."\t\n";
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.lightbox-0.5.js"></script>'."\t\n";
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css">'."\t\n";
    	}		
		if ($pageItems[0]['component'] == "millsandbrokers") {
			$theHtml .='<link rel="stylesheet" href="/css/default-slider.css" type="text/css" media="screen" />';
   			$theHtml .= '<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" media="screen" />';
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.nivo.slider.js"></script>'."\t\n";
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.lightbox-0.5.js"></script>'."\t\n";
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css">'."\t\n";
    	}
    	if ($pageItems[0]['component'] == "people") {
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.lightbox-0.5-people.js"></script>'."\t\n";
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5-people.css">'."\t\n";
    	}

    	if ($pageItems[0]['component'] == "news") {
   			$theHtml .= '<script type="text/javascript" src="/js/jquery.lightbox-0.5-news.js"></script>'."\t\n";
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5-news.css">'."\t\n";
    	}
    	
    	if ($pageItems[0]['component'] == "search") {
   			//$theHtml .= '<script type="text/javascript" src="/js/jquery.lightbox-0.5-news.js"></script>';
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/page-layouts/search.css">'."\t\n";
    	}    
    	
    	if ($pageItems[0]['component'] == "faqs") {
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/page-layouts/faqs.css">'."\t\n";
    	}
    	
    	$theHtml .= '<script type="text/javascript" src="/js/main.js" ></script>'."\t\n";
   		$theHtml .= $theLayout."\n";
   		/*
   		$theDevice = $this->detectDevice();
   		if ($theDevice) {
   			$theHtml .= '<link rel="stylesheet" type="text/css" href="/css/page-layouts/' . $page[0]['layout'] . '-'.$theDevice.'.css " media="screen, print">';
   		}
   		*/
   		$theHtml .= '</head>'."\n";
		$theHtml .= '<body>'."\n";
   		$theHtml .= '<div id="canvas">'."\n";

   		$theHtml .= 	$this->createHeader();
   		// CHECK FOR SIDE NAV ITEMS
   		$theHtml .= '	<div id="content-wrapper">'."\t\n";
   		$theHtml .= $this->checkForSideNavItems($page[0]['link'],$page[0]['layout']);
   		$theHtml .= '	<div id="content">'."\t\n";
   		$theHtml .= 		$content;
   		
   		$theHtml .= 	$this->createFooter($page[0]['layout']);
   		//$theHtml .= '		<div class="clear"></div>'."\t\n";
   		
   		//$theHtml .= '		<div class="clear"></div>'."\t\n";
   		$theHtml .= '	</div>'."\n"; // END CONTENT
   		//$theHtml .= '		<div class="clear"></div>'."\t\n";


   		$theHtml .= '</div>'."\n"; // END CANVAS   		
   		
   		$theHtml .= '	</div>'."\n"; // END CONTENT-WRAPPER


/*  
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
*/
   		$theHtml .= '</body>'."\n";
   		$theHtml .= '</html>'."\n";
   		
   		return $theHtml;
   
   }
   
   function parseUrl() {
   		$theUrl = $_SERVER['REQUEST_URI'];
   		$path_parts = pathinfo($theUrl);
   		// CHECK FOR SELECTOR AND SELECT VALUE
   		$theIdentifier = $this->getSelector($path_parts);

   		if (!$path_parts['basename']) {
   			$where = "isHome = 1";
   		} else {
   		
   			if ($path_parts['dirname'] == "/") {
   				$where = "link = '" . $path_parts['basename'] . "'";
   			} elseif ($theIdentifier) {
   				$where = "link = '" . substr(strrchr($path_parts['dirname'], '/'), 1) . "'";
   			} else {
   				$where = "link = '" . preg_replace('/[^a-zA-Z0-9-]/', '', $path_parts['basename']) . "'";
   			}
   		}
 		
   		$thePage = Default_Table::getData($where);
   		
   		$thePage[0]['selectValue'] = $theIdentifier[0]['selectValue'];
   		$thePage[0]['selector'] = $theIdentifier[0]['selector'];
   		return $thePage;
   
   }
   
   function getSelector($path_parts) {
   	if (preg_match("/categories-/i", $path_parts['basename'], $matches)) {
   			$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
		} elseif (preg_match("/title-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);	
    	} elseif (preg_match("/industry-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    	} elseif (preg_match("/id-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    	} elseif (preg_match("/video-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);		
    	} elseif (preg_match("/section-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);		
		} elseif (preg_match("/tags-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);	
		} elseif (preg_match("/search-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]);
    	} elseif (preg_match("/submit-/i", $path_parts['basename'], $matches)) {
   		 	$theMatch = "/" . $matches[0] . "/";
    		$thePage[0]['selectValue'] 	=  preg_replace($theMatch, '', $path_parts['basename']);
    		$thePage[0]['selector']		= preg_replace('/-/', '', $matches[0]); 
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
		//print_r($catInfo);
		$catSlug = $catInfo[0]['slug'];
		
		return $catSlug;
   	
   	}
   
        function detectDevice() {
   	
   		$device = "";
   		$isiPad 	= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
		$isiPhone 	= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
		$isIe7 		= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.');
		$isIe8 		= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.');
		$isIe9 		= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9.');
		$isSafari 	= (bool) strpos($_SERVER['HTTP_USER_AGENT'],'AppleWebKit');
		
		if ($isiPad) {
			$device = "iPad";
		}
		
		return $device;
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
	
	function string_length($string) {
	
		$less = 0;	
		if (preg_match('/&copy;/', $string)) 	$less += 5;
		if (preg_match('/&reg;/', $string))  	$less += 4;	
		if (preg_match('/&trade;/', $string)) $less += 6;	
		//echo $less." ".$string."<br>";
		return (strlen($string)-$less);
	}
			
} // end class
?>