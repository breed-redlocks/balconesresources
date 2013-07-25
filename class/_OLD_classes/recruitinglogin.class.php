<?php

require_once 'database.class.inc';
require_once "error.inc";

class Recruitinglogin extends Default_Table
{

    // CLASS VARIABLES
    function Recruitinglogin ()
    {
    	require_once "pages.class.php";
		$this->pages		= new Pages;
        $this->tablename      	= 'recruitinglogin';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'firstname', 'lastname', 'phone', 'email', 'interest', 'message');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		require_once "users.class.inc";
		$this->users			= new Users;
        $this->loginList		= Default_Table::getData();
				
    } // END CLASS CONSTRUCTOR
    
    // HANDLE ERRORS 
    function getErrors() {
    	echo errorHandler();
    }
	
	// CREATE HTML TO SEND TO PAGE
	//
	// GET HTML
	//////////////////////////////
	
	function getHtml($selector, $selectValue) {
		$thePage = $this->getPage();
		$where = "link = '".$thePage['page']."'";
		$pageItems = $this->pages->getData($where);
		
		$logins = $this->loginList;
		
		$theHtml .= '<div id="left-column-nav">
    					<div id="page-title">Recruiting Login</div>
    					<div class="thin-seperator1">&nbsp;</div>
    						<div id="block1">';
    	//$theHtml .= 			stripslashes($pageItems[0]['block1']);
    	$theHtml .= '		</div>
    				</div>';
    	
    	$theHtml .= '<div id="two-column-right">';
    	$theHtml .= '	<div class="thin-seperator2">&nbsp;</div>';
		
		if (isset($_POST['submitted'])) { 
			
			$theResponse = $this->checkLogin($_POST,$logins);
			echo "XXX - ".$theResponse;
			if ($theResponse < 2){
				$theMessage = "Incorrect username or password";
				$theHtml .= 	$this->contactForm($theMessage,$thePage['page'],$pageItems[0]['block1']);
			} else {
				$theHtml .= $this->getContent($pageItems);
			}
			
		} else {
		
			$theHtml .= 	$this->contactForm($theResponse,$thePage['page'],$pageItems[0]['block1']);				
	
		}
	
		$theHtml .= '</div>';
		
	return $theHtml;
		
	}
	
	function getContent($pageItems) {
		$theHtml = '';
		$theHtml .= '	
						<div id="colright">
							<div id="block3">
								'.$pageItems[0]['block3'].'
							</div>
							'.$pageItems[0]['block4'].'
						</div>
						<div id="link-block">
							<div class="block-title">
								'.$pageItems[0]['blockTitle2'].'
							</div>
							'.stripslashes($pageItems[0]['block2']).'
						</div>
						<div class="clear"></div>';
		
		return $theHtml;
	}
	
	function contactForm($response,$url,$text) {
		$theHtml = '
					<form class="contact" action="/'.$url.'" method="post">
						<input name="submitted" value="true" type="hidden" />
						<div id="contact-form">
							<div class="contact-head">';
								$theHtml .= '<p class="contact-form-response">'.$response.'</p>';
		$theHtml .= '		</div>
							<div id="contact-form-col-1">
	
								<div class="contact-form-row">	
									<div class="contact-form-lable">
										Username 
									</div>
									<div class="contact-form-field">
										<input name="username" class="field" size="48" value="" type="text" />
									</div>
									<div class="clear"></div>
								</div>
		
								<div id="contact-button-row">	
									<div class="contact-form-button">
										<input value="Submit" type="submit" class="button" />
									</div>
								</div>
							</div>	

							<div id="contact-form-col-1">	
	
								<div class="contact-form-row">	
									<div class="contact-form-lable">
										Password
									</div>
									<div class="contact-form-field">
										<input name="password" class="field" size="48" value="" type="password" />
									</div>
									<div class="clear"></div>
								</div>	
							</div>	
							<div class="clear"></div>
							<div id="login-form-text">'.$text.'</div>

						</div>
					</form>';
		   	
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
	
	function checkLogin($post,$logins) {
		$sucess = 0;
		foreach ($logins as $login) {
			if ($post['username'] == $login['username']) {
				$sucess++;
					if ($post['password'] == $login['password']) {
						$sucess++;
					} else {

					}
					
			} else {

			}
		}
		return $sucess;
	}
		
		
} // END CONTACT CLASS
?>