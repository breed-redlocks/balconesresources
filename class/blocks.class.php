<?php

require_once 'database.class.inc';
require_once "error.inc";
//require_once "people.class.php";



class Blocks extends Default_Table
{

    // additional class variables go here
    function Blocks ()
    {
       	require_once "class/settings.php";
       	$this->site				= $site;
       	require_once "categories.class.inc";
       	$this->category			= new Categories;
        $this->tablename      	= 'pages';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 15;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby 		= 'sortBy';
  		$this->sql_orderby_seq 	= "DESC";
        $this->pageItems		= Default_Table::getData();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml($selector,$selectValue,$pageTitle,$category,$subcategory) {
    
			$thePage = $this->getPage();
    		$where = "link = '".$thePage['page']."'";
    		$thisPage = Default_Table::getData($where);
    		
    		
    		
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
    			//$theHtml .= $sidenav->getHtml($selector,$selectValue);
    			$blocks = $this->getBlocks($thisPage, $nav, $limit);
    		}
    		
    		//$sidenav = $this->sidenav;
    		//$theHtml .= $sidenav->getHtml('Who We Are','','');
    		$theHtml .= '<div id="two-column-right">';
    		$theHtml .= '<div class="thin-seperator2">&nbsp;</div>';
    		$i=1;
    		
    			//$blocks = $this->getBlocks($thisPage, $nav);
    		
    			//echo "<pre>";
    			//print_r($blocks);
    			//echo "</pre>";
    		
    		
    			//$i=1;
    			foreach ($blocks as $block) {
    				
    				if ((empty($block['content'])) || ($block['content'] == '<br>')) {
    					$theHtml .= '';
    				} else {
    				
    				//echo $block['content'];
    					if (empty($block['title'])) {
    						if (empty($block['link'])) {
    							$theHtml .= '<div id="block'.$i.'">'.$block['content'].'</div>';
    						} else {
    							$theHtml .= '<div id="block'.$i.'">'.$block['content'].'<div class="block-link"><a href="'.$block['link'].'">More</a></div></div>';
    						}
						} else {
							if (empty($block['link'])) {
    							$theHtml .= '<div id="block'.$i.'"><div class="block-title">'.$block['title'].'</div>'.$block['content'].'</div>';
    						} else {
    							$theHtml .= '<div id="block'.$i.'"><div class="block-title">'.$block['title'].'</div>'.$block['content'].'<div class="block-link"><a href="'.$block['link'].'">More</a></div></div>';
    						}
    					}
    				}
    				$i++;
    			}
    		
    			
    
    		$theHtml .= '</div>';
		
		return $theHtml;
	}
	
	function getBlocks($thePage) {
			$where = "link = '".$thePage."'";
    		$pageItems = Default_Table::getData($where);

    			foreach ($pageItems[0] as $key => $value) {
    				echo $key."<br>";
    				echo $i."<br>";
    				if ($key == "block1") {
    					$blocks[1]['content'] = stripslashes($value);
    				} elseif ($key == "block2"){
						$blocks[2]['content'] = stripslashes($value);
					} elseif ($key == "block3"){
						//$blocks[3]['content'] = $this->trimString($limit, $value);
						$blocks[3]['content'] = stripslashes($value);
					} elseif ($key == "block4"){
						$blocks[4]['content'] = stripslashes($value);
					} elseif ($key == "block5"){
						$blocks[5]['content'] = stripslashes($value);
					} elseif ($key == "block6"){
						$blocks[6]['content'] = stripslashes($value);
    				} elseif ($key == "block7"){
						$blocks[7]['content'] = stripslashes($value);
					} elseif ($key == "block8"){
						$blocks[8]['content'] = stripslashes($value);
					} elseif ($key == "block9"){
						$blocks[9]['content'] = stripslashes($value);
					} elseif ($key == "block10"){
						$blocks[10]['content'] = stripslashes($value);
    				}
    				//
    				if ($key == "blockTitle1") {
    					$blocks[1]['title'] = stripslashes($value);
    				} elseif ($key == "blockTitle2"){
						$blocks[2]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle3"){
						$blocks[3]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle4"){
						$blocks[4]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle5"){
						$blocks[5]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle6"){
						$blocks[6]['title'] = stripslashes($value);
    				} elseif ($key == "blockTitle7"){
						$blocks[7]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle8"){
						$blocks[8]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle9"){
						$blocks[9]['title'] = stripslashes($value);
					} elseif ($key == "blockTitle10"){
						$blocks[10]['title'] = stripslashes($value);
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