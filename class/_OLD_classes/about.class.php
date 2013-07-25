<?php

require_once 'database.class.inc';
require_once "error.inc";




class About extends Default_Table
{

    // additional class variables go here
    function About ()
    {
        $this->tablename      	= 'about';
        $this->dbname          	= 'devjackw';
        require_once "categories.class.inc";
		$this->cats			= new Categories;
        require_once "sidenav.class.php";
		$this->sidenav		= new Sidenav;
        $this->rows_per_page   	= 15;
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body', 'sortBy');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby		= 'sortBy';
        $this->sql_orderby_seq 	= 'ASC';
        $this->profiles		= Default_Table::getData();
				
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml() {
    	$sidenav = $this->sidenav;
    			$theHtml = '';
    			$theHtml .= $sidenav->getHtml('Who We Are','','');
		
		return $theHtml;
	}
	
	function displayIntro($id) {
		
		$where = "id = '" . $id . "'";
		$intro = Default_Table::getData($where);
		
		$theHtml = '<li class="profile">
			<div class="about-intro-left">
				<div class="about-intro-head">
					' . $intro[0]['name'] . '
				</div>';
				$introImage[0] = 'intro-image-blank.gif';
				$introImage[1] = 'intro-image-blank.gif';
				$introImage[2] = 'intro-image-blank.gif';
				$introImage[3] = 'intro-image-blank.gif';
				$introImage[4] = 'intro-image-blank.gif';
				$introImage[5] = 'intro-image-blank.gif';
				$introImage[6] = 'intro-image-blank.gif';
				$introImage[7] = 'intro-image-blank.gif';

				$i = 0;
				foreach ($this->profiles as $profile) {
					if ($profile['id'] != 5) {
							$introImage[$i] = $profile['mediaPath1'];
						$i++;
					}
				}
				
		$theHtml .= '<div class="intro-image-1">
					<a href="#1"><img src="/rsrc/about/' . $introImage[0] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				<div class="intro-image-2">
					<a href="#2"><img src="/rsrc/about/' . $introImage[1] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				<div class="intro-image-5">
					<a href="#5"><img src="/rsrc/about/' . $introImage[4] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				<div class="intro-image-6">
					<a href="#6"><img src="/rsrc/about/' . $introImage[5] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				
				
			</div>
			<div class="about-intro-right">
			<div class="about-intro-bio">
					' . $intro[0]['info'] . '
				</div>
				<div class="intro-image-3">
					<a href="#3"><img src="/rsrc/about/' . $introImage[2] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				<div class="intro-image-4">
					<a href="#4"><img src="/rsrc/about/' . $introImage[3] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				
				<div class="intro-image-7">
					<a href="#7"><img src="/rsrc/about/' . $introImage[6] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				<div class="intro-image-8">
					<a href="#8"><img src="/rsrc/about/' . $introImage[7] . '" height="100" width="230" alt="Intro Image"></a>
				</div>
				
			</div>	
		</li>';
		
		return $theHtml;
	
	}
	
	function getProfile($profile) {
	
		$theHtml = '
		<li class="profile" id="' . $profile['id'] . '">
			<div class="profile-left">
				<div class="profile-name-title">
					' . $profile['name'] . '
						<br>
					' . $profile['title'] . '
				</div>
				<div class="profile-info">
					' . $profile['info'] . '
				</div>
			</div>
			<div class="profile-right">
				<div class="profile-image-1">
					<img src="/rsrc/about/' . $profile['mediaPath1'] . '" width="455" alt="Profile Image">
				</div>
				<div class="profile-image-2">
					<img src="/rsrc/about/' . $profile['mediaPath2'] . '" alt="Profile Image">
				</div>
				<div class="profile-image-3">
					<img src="/rsrc/about/' . $profile['mediaPath3'] . '" height="120" width="265" alt="Profile Image">
				</div>
				<div class="profile-image-4">
					<img src="/rsrc/about/' . $profile['mediaPath4'] . '" height="120" width="265" alt="Profile Image">
				</div>
			</div>	
		</li>
		';
		
		return $theHtml;
	
	}	
	
	function countProfiles() {
		$numProfiles = Default_Table::getCount();
		return $numProfiles;
	}
	
	
} // end class
?>