<?php

require_once 'database.class.inc';
require_once "error.inc";




class Projects extends Default_Table
{

    // additional class variables go here
    function Projects ()
    {
        $this->tablename      	= 'projects';
        $this->dbname          	= 'stratodev';
        require_once "categories.class.inc";
		$this->cats				= new Categories;
		require_once "tags.class.inc";
		$this->tags				= new Tags;
        $this->rows_per_page   	= 15;
        $this->orderby			= 'title';
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        //$this->projectItems		= Default_Table::getData();
        
        $this->projectCount		= Default_Table::getCount();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    function getHtml($selector, $selectValue) {
    $this->projectItems = $this->showWhat($selector, $selectValue);
    	$adjustedProfileCount = ceil($this->projectCount / 2);
    	$scrollWidth = $adjustedProfileCount * 710 . "px";
    	
    	$theHtml = '<script type="text/javascript">
						

						var counter = 0;
						
						function increase() {
       						counter++;
        					return false;
						}
						function decrease() {
       						counter--;
        					return false;
						}
						
						function toggle() {

							
						if (counter == ' . $adjustedProfileCount . ') {
							counter = 0;
							}
							
							var link = document.getElementById(\'crap\');
							
							var src = link.getAttribute(\'onclick\');
							
							var curAttrib = src.match(/default.*/);
							
							curAttrib = curAttrib[0];
							
							var cleanit = curAttrib.replace("\');","");
							
							
								//link.setAttribute(\'onclick\',src.replace(/default.*/g,"default-" + counter));
								link.setAttribute(\'onclick\',src.replace(cleanit,"default-" + counter));
							
						var left = document.getElementById("photoprev");
						var right = document.getElementById("photonext");
							if(counter > 0) {
    							left.style.display = "block";
  							} else {
  								left.style.display = "none";
  							}
  							
  	  					}
					</script>';
		
		
		$theHtml .= '
					<div id="project-container">
						<div style="cursor:pointer;display:none;" id="photoprev" onclick="decrease();toggle();">
							<img src="/rsrc/projects/left_arrow.png" alt="left">
						</div>
						<div id="projects">
							<ul id="scrollable" style="width:' . $scrollWidth . '">';
							
			
			$proj			= 0;
			$col 			= 1;
		
			while ($proj <= $this->projectCount) {
 
   				$column = $this->changeNumbers($col);
   				$theHtml .= $this->displayProjectDetails($proj, $column, $col);
   				$projB = $proj + 1;
   				$theHtml .= $this->displayProjectDetailsB($projB, $column, $col);
   				$theHtml .= '<li id="' . $column . '" class="column">'."\n";

   				$theHtml .= $this->displayProject($proj, $column, '', $col);
   				$proj++;
   				
   				$theHtml .= $this->displayProject($proj, $column, 'b-', $col);
   				$proj++;
   			
   				$theHtml .= '</li>'; // END COLUMN
   				
   				$col++;

   			}
		
		$theHtml .= '<li class="profile">';
		
		$theHtml .= '		</ul>
						<div class="clear"></div>
						</div>	
						<div style="cursor:pointer;display:block;" id="photonext" onclick="increase();toggle();">
							<img src="/rsrc/projects/right_arrow.png" alt="right">
						</div>
						<div class="clear"></div>
					</div>
		';
		
		return $theHtml;
	}

	function changeNumbers($string) {
		$numbers = array();
			for($counter =0; $counter <= 10; $counter++) {
				$numbers[$counter] = $counter;
			}
			
		$replacements = array("zero","one","two","three","four","five","six","seven","eight","nine");
		$string = str_replace($numbers, $replacements, $string);
        return $string;
    	}

	
	function limitWords($string, $word_limit) {
    			$words = explode(" ",$string);
    		return implode(" ",array_splice($words,0,$word_limit));
		}
		
	function displayProject($proj, $column, $ab, $col) {
		$whereCat = "id = '" . $this->projectItems[$proj]['categories'][0] . "'";
		$category = $this->cats->getData($whereCat);
		if (!$this->projectItems[$proj]['title']) {
			$theHtml = '';
		} else {
		
			$theHtml .= '<div style="height:401px;width:491px;background-color:#CCCCCC"><div class="project">'."\n";
   			$theHtml .= '<div class="project-top">'."\n";
   			$theHtml .= '<div class="project-image">'."\n";
   			
   			$theHtml .= '<a id="crap" href="#" onclick="showDetails(\'project-details-' . $ab . '' . $column . '\', \'' . $col.'\', \'' . $this->projectItems[$proj]['id'] . '\', \'default' . $col . '\');"><img class="project-image" src="/rsrc/projects/' . $this->projectItems[$proj]['mediaPath1'] . '" title="' . $this->projectItems[$proj]['mediaTitle1'] . '" alt="' . $this->projectItems[$proj]['mediaTitle1'] . '"></a>'."\n";
   			
   			$theHtml .= '</div>'."\n";
   			$theHtml .= '</div>'."\n";
   			$theHtml .=	'<div class="project-bottom">'."\n";
   			$theHtml .= '<div class="project-title"><a href="">' . $this->projectItems[$proj]['title'] . '</a></div>'."\n";
   			$theHtml .= '<div class="project-cat"><a href="/home/categories-' . strtolower($category[0]['slug']) . '">' . strtolower($category[0]['name']) . '</a></div>'."\n";
   			$theHtml .= '<div class="clear"></div>'."\n";
   			$theHtml .= '<div class="project-body">' . $this->limitWords($this->projectItems[$proj]['introText'], '35') . '</div>'."\n";
   			$theHtml .= '</div>'."\n"; // END PROJECT-BOTTOM
   			$theHtml .= '</div></div>'."\n\n"; // END PROJECT
   		}
   			return $theHtml;
	
	}

	function displayProjectDetails($proj, $column, $col) {
		$whereCat = "id = '" . $this->projectItems[$proj]['categories'][0] . "'";
		$category = $this->cats->getData($whereCat);
		
		$whereTag = "id = '" . $this->projectItems[$proj]['tags'][0] . "'";
		$tags = $this->tags->getData($whereTags);
		
		$theHtml = '<div id="project-details-' . $column . '" class="details">';
		$theHtml .= '<div class="project-details-top">';
		$theHtml .= '<div class="click-to-close"><a href="#" onclick="hideDetails();"><img src="/rsrc/image-slider/slider-close.gif" alt="close"></a></div>';
   		$theHtml .= '<div class="project-detail-image">';
		$theHtml .= '<div id="quote-project-details-' . $column . '"></div>';
		$theHtml .= '</div>'; // END PROJECT-DETAIL-IMAGE
   		$theHtml .= '</div>'; // END PROJECT TOP
   		$theHtml .=	'<div class="project-detail-bottom">';
   		$theHtml .=	'<div class="project-detail-bottom-left">';
   		$theHtml .= '<div class="project-detail-title"><a href="">' . $this->projectItems[$proj]['title'] . '</a></div>';
   		$theHtml .= '<div class="project-cat-name"><a href="">' . strtolower($category[0]['name']) . '</a></div>';
   		$theHtml .= '</div>'; //END BOTTOM LEFT
   		$theHtml .=	'<div class="project-detail-bottom-right">';
   		$theHtml .= '<div class="project-detail-text">' . $this->projectItems[$proj]['allText'] . '';
   		if ($this->projectItems[$proj]['website']) {
   			$theHtml .= '<div class="project-detail-website">
   							<a href="http://' . $this->projectItems[$proj]['website'] . '" target="_blank" alt="' . $this->projectItems[$proj]['website'] . '">Visit the Site</a></div>';
   		}
   		if ($this->projectItems[$proj]['tags']) {
   				$theHtml .= '<div class="project-detail-tags">';
   			foreach ($tags as $tag) {
   				$theHtml .= '<div class="project-detail-tag"><a href="/home/tags-' . strtolower($tag['slug']) . '">' . strtolower($tag['name']) . ',&nbsp;</a></div>';
   			}
   				$theHtml .= '</div>';
   		}
   		$theHtml .= '</div>'; //END BOTTOM RIGHT
   		$theHtml .= '</div><div class="clear"></div></div>'."\n"; // END PROJECT-BOTTOM
		$theHtml .= '</div>'."\n"; // END PROJECT
		return $theHtml;
		
	}
	
	function displayProjectDetailsB($proj, $column, $col) {
		$whereCat = "id = '" . $this->projectItems[$proj]['categories'][0] . "'";
		$category = $this->cats->getData($whereCat);
		
		$whereTag = "id = '" . $this->projectItems[$proj]['tags'][0] . "'";
		$tags = $this->tags->getData($whereTags);
		
		$theHtml = '<div id="project-details-b-' . $column . '" class="details">';
		$theHtml .= '<div class="project-details-top">';
		$theHtml .= '<div class="click-to-close"><a href="#" onclick="hideDetails();"><img src="/rsrc/image-slider/slider-close.gif" alt="close"></a></div>';
   		$theHtml .= '<div class="project-detail-image">';
		$theHtml .= '<div id="quote-project-details-b-' . $column . '"></div>';
		$theHtml .= '</div>'; // END PROJECT-DETAIL-IMAGE
   		$theHtml .= '</div>'; // END PROJECT TOP
   		$theHtml .=	'<div class="project-detail-bottom">';
   		$theHtml .=	'<div class="project-detail-bottom-left">';
   		$theHtml .= '<div class="project-detail-title"><a href="">' . $this->projectItems[$proj]['title'] . '</a></div>';
   		$theHtml .= '<div class="project-cat-name"><a href="">' . strtolower($category[0]['name']) . '</a></div>';
   		$theHtml .= '</div>'; //END BOTTOM LEFT
   		$theHtml .=	'<div class="project-detail-bottom-right">';
   		$theHtml .= '<div class="project-detail-text">' . $this->projectItems[$proj]['allText'] . '';
   		if ($this->projectItems[$proj]['website']) {
   			$theHtml .= '<div class="project-detail-website">
   							<a href="http://' . $this->projectItems[$proj]['website'] . '" target="_blank" alt="' . $this->projectItems[$proj]['website'] . '">Visit the Site</a></div>';
   		}
   		if ($this->projectItems[$proj]['tags']) {
   				$theHtml .= '<div class="project-detail-tags">';
   			foreach ($tags as $tag) {
   				$theHtml .= '<div class="project-detail-tag"><a href="/home/tags-' . strtolower($tag['slug']) . '">' . strtolower($tag['name']) . ',&nbsp;</a></div>';
   			}
   				$theHtml .= '</div>';
   		}
   		$theHtml .= '</div>'; //END BOTTOM RIGHT
   		$theHtml .= '</div><div class="clear"></div></div>'."\n"; // END PROJECT-BOTTOM
		$theHtml .= '</div>'."\n"; // END PROJECT
		return $theHtml;
		
	}

	 function showWhat($selector, $selectValue) {
	 	//echo "<br> The Selector is = ".$selector;
		//echo "<br> The Select Value is = ".$selectValue;
		
		
		if ($selector) {
			
			if ($selector == 'categories') {
				// GET CAT SLUG AND CONVERT TO ID
				$whereCat = "slug= '" . $selectValue . "'";
   				$catName = $this->cats->getData($whereCat);
				// GET ALL POSTS WITH THAT CAT ID
				$where = $selector . " LIKE '%" . $catName[0]['id'] . "%'";
				$projects = Default_Table::getData($where);
				
			} elseif ($selector == 'tags') {
				// GET TAG SLUG AND CONVERT TO ID
				$whereTag = "slug= '" . $selectValue . "'";
   				$tagName = $this->tags->getData($whereTag);
				// GET ALL POSTS WITH THAT CAT ID
				$where = $selector . " LIKE '%" . $tagName[0]['id'] . "%'";
				$projects = Default_Table::getData($where);
			
			} elseif ($selector == 'author'){
				$where = $selector .   " LIKE '%" . $selectValue . "%'";
				$blog = Default_Table::getData($where);
				$theHtml .= Blogs::postStructure($blog, 0);
			} else {
				$projects = Default_Table::getData();
			}
		} else {
			$projects = Default_Table::getData();
		}
			
			return $projects;

	 }
	
	
} // end class
?>