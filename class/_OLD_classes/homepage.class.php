<?php

require_once 'database.class.inc';
require_once "error.inc";




class Homepage extends Default_Table
{

    // additional class variables go here
    function Homepage ()
    {
        $this->tablename      	= 'projects';
        $this->dbname          	= 'brdevdb';
        require_once "blocks.class.php";
		$this->blocks				= new Blocks;
		
		//require_once "tags.class.inc";
		//$this->tags				= new Tags;
        $this->rows_per_page   	= 15;
        $this->sql_orderby = 'sortBy';
  		$this->sql_orderby_seq = "ASC";
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->projectItems		= Default_Table::getData();
        
        $this->projectCount		= Default_Table::getCount();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    function getHtml($selector, $selectValue) {

    	$this->allBlocks = $this->blocks->getBlocks($this->getPage());

    	$theHtml .= '	<div id="home-page-headline">
    						<h1>Your Web Development and SEO / SEM Team in the Cloud</h1>
    					</div>';
    				
    	$theHtml .= '	<div class="slider-wrapper theme-default">';
    	$theHtml .= '		<div class="ribbon"></div>';
    	$theHtml .= '		<div id="slider" class="nivoSlider">	';
		foreach ($this->projectItems as $project) {
    			//$theHtml .= '	<li class="main-project-image"><img src="/rsrc/projects/'.$project['mediaPath1'].'"></li>';
    	$theHtml .= '			<a href="/projects/id-'.$project['id'].'">
    								<img src="/rsrc/projects/'.$project['mediaPath1'].'" 
    								alt="'.$project['mediaTitle1'].'" 
    								title="'.stripslashes($project['introText']).'" />
    							</a>';
    		}
		$theHtml .= '	 	</div>';
    	$theHtml .= '   	<div id="htmlcaption" class="nivo-html-caption">';
    	$theHtml .= '		<div class="clear"></div>';
		$theHtml .= '	</div>';
		
		$theHtml .= '	<div id="home-page-blocks">';
		$theHtml .= '		<div class="home-page-block">';
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
		
		$theHtml .= '	</div>';	
		$theHtml .= '	<script type="text/javascript" src="/js/jquery.nivo.slider.pack.js"></script>
    					<script type="text/javascript">
    						$(window).load(function() {
        						$(\'#slider\').nivoSlider({
        						controlNav: true,
        						controlNavThumbs: true,
        						controlNavThumbsFromRel: true,
        						animSpeed: 500,
        						pauseTime: 5000,
        						directionNavHide: false
        						});
        						
   							 });
    					</script>';
    			
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
   		
   		return $thePage['page'];
   	}
   	
	
} // end class
?>