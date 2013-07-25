<?php

require_once 'database.class.inc';
require_once "error.inc";

class Contact extends Default_Table
{

    // CLASS VARIABLES
    function Contact ()
    {
    	require_once "pages.class.php";
		$this->pages		= new Pages;
        $this->tablename      	= 'contact';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'name', 'company', 'address', 'state', 'zipcode', 'contactname', 'phone', 'email', 'details', 'message');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		//require_once "users.class.inc";
		//$this->users			= new Users;
        $this->blogList		= Default_Table::getData();
				
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
		
		if (isset($_POST['submitted'])) { 
			$this->insertData($_POST);
			$theResponse = $this->sendEmail($_POST); 
		}
		

    	
    	$theHtml .= '<div id="two-column-center">';
    	
		$topImage = $_SERVER['DOCUMENT_ROOT']."/domains/balconesresources.com/rsrc/top/".$thisPage[0]['link']."-top.jpg";
    		//echo $topImage;
    		if (file_exists($topImage)) {
    			$theHtml .= '<div id="top-image">
    							<img src="/rsrc/top/'.$thisPage[0]['link'].'-top.jpg">
    						</div>';
			} else {
    			$theHtml .= '<div id="top-image">
    							<img src="/rsrc/top/default-top.jpg">
    						</div>';
			}
			
			
			
		$theHtml .= 	$this->contactForm($theResponse,$thePage['page']);
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle1']).'</div>
							'.stripslashes($pageItems[0]['block1']).'
						</div>';
		
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle2']).'</div>
							'.stripslashes($pageItems[0]['block2']).'
						</div>';
		
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle3']).'</div>
							'.stripslashes($pageItems[0]['block3']).'
						</div>';
		
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle4']).'</div>
							'.stripslashes($pageItems[0]['block4']).'
						</div>';
		
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle5']).'</div>
							'.stripslashes($pageItems[0]['block5']).'
						</div>';
		
		$theHtml .= '	<div class="block-small">
							<div class="block-title">'.stripslashes($pageItems[0]['blockTitle6']).'</div>
							'.stripslashes($pageItems[0]['block6']).'
						</div>';
				
		$theHtml .= '</div>';
		
		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';
    	$theHtml .= '       	<div id="contact">
    								<h3>Inquiry<br>form</h3>
    								<p>See what we are all about.</p>';
    	$theHtml .= 				$this->contactForm('',$thePage['page']);
    	$theHtml .= '			</div>';
    	$theHtml .= '		</div>';
    	$theHtml .= '</div>';
    	$theHtml .= '</div>';
    		$theHtml .= '<div class="clear"></div>';
	
	return $theHtml;
		
	}
	function contactForm($response,$url) {
		$theHtml = '
<div id="contact-form">
	<form class="contact" action="" method="post" onsubmit="return validateForm()" name="contactUs">
	<input name="submitted" value="true" type="hidden" />';
	//	if (isset($response)){
	//		$theHtml .= '<div class="contact-message"><h1>'.$response.'</h1></div>';
	//	}
	//$theHtml .= '<div class="contact-message"><h1>'.$response.'</h1></div>';
	$theHtml .= '
	<div id="contact-form-col-1">
	
		<div class="contact-form-row">	
			<div class="contact-form-field">
				<input name="name" class="field" value="Name" type="text" onfocus="if (this.value == \'Name\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Name\';}" />
			</div>
		</div>
	
		<div class="contact-form-row">	
			<div class="contact-form-field">
				<input name="company" class="field" value="Company" type="text" onfocus="if (this.value == \'Company\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Company\';}" />
			</div>
		</div>
	
		<div class="contact-form-row">	
			<div class="contact-form-field">
				<input name="address" class="field" value="Address" type="text" onfocus="if (this.value == \'Address\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Address\';}" />
			</div>
		</div>
		<div class="contact-form-row">	
			<div class="contact-form-field">
				<input name="state" class="field" value="State" type="text" onfocus="$(\'.contact-form-row-hidden\').show();$(\'#selfPromoThree\').hide();if (this.value == \'State\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'State\';}" />
			</div>
		</div>
		<div class="contact-form-row-hidden">	
			<div class="contact-form-field">
				<input name="zipcode" class="field" value="ZIP Code" type="text" onfocus="if (this.value == \'ZIP Code\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'ZIP Code\';}" />
			</div>
		</div>
		<div class="contact-form-row-hidden">	
			<div class="contact-form-field">
				<input name="contactname" class="field" value="Contact Name" type="text" onfocus="if (this.value == \'Contact Name\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'Contact Name\';}" />
			</div>
		</div>		
		<div class="contact-form-row-hidden">	
			<div class="contact-form-field">
				<input name="phone" class="field" value="Phone Number" type="text" onfocus="if (this.value == \'Phone Number\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'Phone Number\';}" />
			</div>
		</div>
		<div class="contact-form-row-hidden">	
			<div class="contact-form-field">
				<input name="email" class="field" value="Email" type="text" onfocus="if (this.value == \'Email\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'Email\';}" />
			</div>
		</div>
		<div class="contact-form-row-hidden">	
			<div class="contact-form-field">
				<textarea name="details" class="field" onfocus="if (this.value == \'Details\') {this.value = \'\';};" onblur="if (this.value == \'\') {this.value = \'Details\';}" >Details</textarea>
			</div>
		</div>
		
		<div id="contact-button-row" class="contact-form-row-hidden" style="text-align:right;">	
			<div class="contact-form-button">
				<input value="" type="submit" class="button" />
			</div>
		</div>
	</div>	


	</form>
</div>
<script type="text/javascript" src="/js/formValidation.js"></script>';
		   	
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
	
	function insertData($post) {
		$theEmail['name'] 	= mysql_real_escape_string($post['name']);
		$theEmail['address'] 	= mysql_real_escape_string($post['address']);
		$theEmail['state'] 	= mysql_real_escape_string($post['state']);
		$theEmail['zipcode'] 	= mysql_real_escape_string($post['zipcode']);
		$theEmail['contactname'] 	= mysql_real_escape_string($post['contactname']);
		$theEmail['phone'] 		= mysql_real_escape_string($post['phone']);
		$theEmail['email'] 		= mysql_real_escape_string($post['email']);
		$theEmail['details'] 	= mysql_real_escape_string($post['details']);
		$theEmail['company'] 	= mysql_real_escape_string($post['company']);
		Default_Table::insertRecord($theEmail);
	}
	function sendEmail($post) {
		$message = 	'Name: ' 			. $post['name'] 	. "\n\n";
		$message .= 'Address: ' 		. $post['address'] 	. "\n\n";
		$message .= 'State: ' 			. $post['state'] 	. "\n\n";
		$message .= 'Zip: ' 			. $post['zipcode'] 	. "\n\n";
		$message .= 'Contact Name: ' 	. $post['contactname'] 	. "\n\n";
		$message .= 'Phone Number: ' 	. $post['phone'] 		. "\n\n";
		$message .= 'Email: ' 			. $post['email'] 		. "\n\n";
		$message .= 'Company: ' 		. $post['company'] 		. "\n\n";
		$message .= 'Details: ' 		. $post['details'] 		. "\n\n";
		// print_r($post);
		$insertData = $this->insertData($post);
		mail("bgetter@balconesresources.com,courtney@balconesresources.com,jack@70kft.com", "Contact Form from Balcones Resources", $message, "From:".$post['email']);
		
		$response = '<h6>Thank You - Your request has been sent.</h6>';
		return $response;
	}
	
		
} // END CONTACT CLASS
?>