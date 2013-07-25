<?php

require_once 'database.class.inc';
require_once "error.inc";

class Projects extends Default_Table
{

    // additional class variables go here
    function Projects ()
    {
        $this->tablename      	= 'projects';
        $this->dbname          	= 'brdevdb';
        require_once "blocks.class.php";
		$this->blocks			= new Blocks;
		require_once 'categories.class.inc';
		$this->cats				= new Categories;
		//require_once "tags.class.inc";
		//$this->tags				= new Tags;
        $this->rows_per_page   	= 15;
        
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby = 'sortBy';
  		$this->sql_orderby_seq = "ASC";
        $this->projectItems		= Default_Table::getData();
        
        $this->projectCount		= Default_Table::getCount();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    function getHtml($selector, $selectValue) {
    	$theHtml .= '<script type="text/javascript" src="/js/project.js"></script>';
    	$this->allBlocks		= $this->blocks->getBlocks("projects");
    	
    	if ($selectValue) {
    	
    		$theHtml .= $this->displayProject($selectValue);
    	
    	} else {
    		$theHtml .= '	<ul class="thumb">';
				foreach ($this->projectItems as $project) {
    				$theHtml .= '<li>
    							<a href="/projects/id-'.$project['id'].'">
    								<img src="/rsrc/projects/'.$project['mediaPath1'].'" width="100" alt="'.$project['mediaTitle1'].'" title="'.$project['mediaTitle1'].'" />
    							</a>
    						</li>';
    			}
			$theHtml .= '	</ul>';

			$theHtml .= '	<div class="clear"></div>';
		
			$theHtml .= '	<div id="project-blocks">';
			$theHtml .= '		<div class="project-block">';
			$theHtml .= '			<h1>'.$this->allBlocks[1]['title'].'</h1>';
			$theHtml .= 			$this->allBlocks[1]['content'].'';
			$theHtml .= '		</div>';
			$theHtml .= '		<div class="home-page-block">';
			$theHtml .= '			<h1>'.$this->allBlocks[2]['title'].'</h1>';
			$theHtml .= 			$this->allBlocks[2]['content'].'';
			$theHtml .= '		</div>';
			$theHtml .= '		<div class="home-page-block-last">';
			$theHtml .= '			<h1>'.$this->allBlocks[3]['title'].'</h1>';
			$theHtml .= 			$this->allBlocks[3]['content'].'';
			$theHtml .= '		</div>';
			$theHtml .= '		<div class="clear"></div>';
			$theHtml .= '	</div>';

    	} // END IF SELECTED
		return $theHtml;
	}
	
	function displayProject($selectValue) {
			$project = Default_Table::getData("id = '".$selectValue."'");
    		//echo $selector.'--'.$selectValue;
    		//print_r($project);
    		$theHtml .= '<div id="project-detail">';
    		$theHtml .= '	<div id="project-detail-left">';
    		$theHtml .= '		<div id="project-detail-title">'.$project[0]['title'].'</div>';
    		$theHtml .= '		<div id="project-gallery">
    								<div id="main-image">
    									<a href="/rsrc/projects/'.$project[0]['mediaPath1'].'" target="blank">
    										<img src="/rsrc/projects/'.$project[0]['mediaPath1'].'" alt="'.$project[0]['mediaTitle1'].'" width="600">
    									</a>
    								</div>';
    		$theHtml .= '			<div id="gallery-nav">	
    									<ul class="thumb-nav">';
    							if ($project[0]['mediaPath1']) {
    								$theHtml .= '<li>
    												<a href="/rsrc/projects/'.$project[0]['mediaPath1'].'">
    													<img src="/rsrc/projects/'.$project[0]['mediaPath1'].'" alt="'.$project[0]['mediaTitle1'].'">
    												</a>
    											</li>';
    							}
    							if ($project[0]['mediaPath2']) {
    								$theHtml .= '<li>
    												<a href="/rsrc/projects/'.$project[0]['mediaPath2'].'">
    													<img src="/rsrc/projects/'.$project[0]['mediaPath2'].'" alt="'.$project[0]['mediaTitle2'].'">
    												</a>
    											</li>';
    							}
    							if ($project[0]['mediaPath3']) {
    								$theHtml .= '<li>
    												<a href="/rsrc/projects/'.$project[0]['mediaPath3'].'">
    													<img src="/rsrc/projects/'.$project[0]['mediaPath3'].'" alt="'.$project[0]['mediaTitle3'].'">
    												</a>
    											</li>';
    							}
    							if ($project[0]['mediaPath4']) {
    								$theHtml .= '<li>
    												<a href="/rsrc/projects/'.$project[0]['mediaPath4'].'">
    													<img src="/rsrc/projects/'.$project[0]['mediaPath4'].'" alt="'.$project[0]['mediaTitle4'].'">
    												</a>
    											</li>';
    							}
    							if ($project[0]['mediaPath5']) {
    								$theHtml .= '<li>
    												<a href="/rsrc/projects/'.$project[0]['mediaPath5'].'">
    													<img src="/rsrc/projects/'.$project[0]['mediaPath5'].'" alt="'.$project[0]['mediaTitle5'].'">
    												</a>
    											</li>';
    							}
    								

    							
    		$theHtml .= '				</ul>
    								</div>';
    		$theHtml .='		</div></div>';
    		$theHtml .= '		<div id="project-detail-right">';
    		$theHtml .= '			<div id="project-company">'.$project[0]['companyName'].'</div>';
    		$theHtml .= '			<div id="project-website">
    									<a href="http://'.$project[0]['website'].'" target="blank">'.$project[0]['website'].'</a>
    								</div>';
    		
    		if ($project[0]['categories']) {
    			$theHtml .= '		<div id="project-cats">';
    			$cats = explode("::", $project[0]['categories'] );
    			$catCount = count($cats);
    			$i=1;
    			foreach ($cats as $cat) {
    				$where = "id = '" . $cat . "'";
   					$catName = $this->cats->getData($where);
   					if ($i == $catCount) {
   						$theHtml .= $catName[0]['name'];
   					} else {
   						$theHtml .= $catName[0]['name'].',&nbsp;';
   					}
    				
    				
    				$i++;
    			}
    			$theHtml .= '		</div>';
    		}
    		
    		
    		$theHtml .= '			<div id="project-intro">'.stripslashes($project[0]['introText']).'</div>';
    		$theHtml .= '			<div id="project-text">'.stripslashes($project[0]['allText']).'</div>';
    		$theHtml .= '		</div>';
    		$theHtml .= '	<div class="clear"></div>';
    		$theHtml .= '</div>';
    		return $theHtml;
	}
	
	function limitWords($string, $word_limit) {
    			$words = explode(" ",$string);
    		return implode(" ",array_splice($words,0,$word_limit));
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