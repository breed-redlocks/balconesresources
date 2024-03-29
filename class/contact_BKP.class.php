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
		
		if (isset($_POST['submitted-waste-audit'])) { 
			//$this->insertData($_POST);
			$theResponse = $this->sendEmailWasteAudit($_POST); 
		}
		

    	
    	$theHtml .= '<div id="two-column-center">';
    	
		$topImage = $_SERVER['DOCUMENT_ROOT']."/rsrc/top/".$thisPage[0]['link']."-top.jpg";
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
			
			
			
		
		$theHtml .= '	<div id="block1">
							<div class="block-title"><h1>'.stripslashes($pageItems[0]['blockTitle1']).'</h1></div>
							'.stripslashes($pageItems[0]['block1']).'
						</div>';
		$theHtml .= 	$this->contactFormWasteAudit($theResponse,$thePage['page']);
		
				
		$theHtml .= '</div>';
		
		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';
    	$theHtml .= '			<div id="contact">
    								<h3>Inquiry<br>form</h3>
    								<p>See what we are all about.</p>';
    	$theHtml .= 				$this->contactForm('',$thePage['page']);
    	$theHtml .= '			</div>';
    	$theHtml .= '		</div>';
    	$theHtml .= '    	<div id="selfPromoThree">
    							<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted">
    								<img src="/rsrc/common/what-we-collect.gif" style="diplay: block">
    							</a>
    						</div>';
    	$theHtml .= '		<div id="staticBadges">
								<div id="social">
   									<div id="facebook">
   										<a target="_blank" href="http://www.facebook.com/Balcones.Resources">
   											<img alt="" src="/rsrc/common/facebook.gif">
   										</a>
   									</div>
   									<div id="twitter">
   										<a target="_blank" href="https://twitter.com/balconesrecycle">
   											<img alt="" src="/rsrc/common/twitter.gif">
   										</a>
   									</div>
   									<div id="googlePlus">
   										<a target="_blank" href="https://plus.google.com/107020083238084999697/about">
   											<img alt="" src="/rsrc/common/googlePlus.gif">
   										</a>
   									</div>
   									<div id="pintrest">
   										<a target="_blank" href="http://pinterest.com/balconesrecycle/">
   											<img alt="" src="/rsrc/common/pintrest.gif">
   										</a>
   									</div>
   								</div>
							</div>';
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
	function contactFormWasteAudit($response,$url) {
		$theHtml = '<div id="wasteAuditWrapper" style="margin: 30px;">';
		
		
				if (isset($response)){
					$theHtml .= '<div class="contact-message"><h1>'.$response.'</h1></div>';
				}

		
		
		$theHtml .='		<form action="#" method="post" id="form1" name="form1">
							<input type="hidden" value="1" name="seenform">
							<input name="submitted-waste-audit" value="true" type="hidden" />
							<input type="hidden" value="Please fill out your contact name." name="r_au_name">
							<input type="hidden" value="Please fill out your phone number." name="r_au_phone">
							<table width="100%" cellspacing="0" cellpadding="3" border="0">
							<tbody>
							<tr>
								<td width="30%">Name of Contact</td>
								<td width="70"><input type="text" id="au_name" name="au_name"></td>
							</tr>
							<tr>
								<td>Position at Company</td>
								<td><input type="text" id="au_position" name="au_position"></td>
							</tr>
							<tr>
								<td>Company Name</td>
								<td><input type="text" id="au_company" name="au_company"></td>

  </tr>

  <tr>

    <td>Phone Number</td>

    <td><input type="text" id="au_phone" name="au_phone"></td>

  </tr>

  <tr>

    <td height="17">Email </td>

    <td><input type="text" id="au_email" name="au_email"></td>

  </tr>
  <tr>

    <td height="17">City </td>

    <td><input type="text" id="au_city" name="au_city"></td>

  </tr>
  <tr>

    <td height="17">State </td>

    <td><input type="text" size="2" id="au_state" name="au_state"></td>

  </tr>
  <tr>
    <td height="9"><strong>Materials</strong></td>
    <td><strong>Approximate Weekly Quantity</strong></td>
  </tr>
  <tr>
    <td height="8"><input type="checkbox" value="yes" name="au_cardboard">
      Cardboard</td>
    <td><input type="text" size="10" name="au_cardboardAmount"></td>
  </tr>
<tr>
    <td height="8"><input type="checkbox" value="yes" id="au_plastics" name="au_plastics">
      Plastics</td>
    <td><input type="text" size="10" id="au_plasticsAmount" name="au_plasticsAmount"></td>
  </tr>
  <tr>
    <td height="8"><input type="checkbox" value="yes" id="au_wood" name="au_wood">
      Wood</td>
    <td><input type="text" size="10" id="au_woodAmount" name="au_woodAmount"></td>
  </tr>
  <tr>
    <td height="8"><input type="checkbox" value="yes" id="au_paper" name="au_paper">
      Paper</td>
    <td><input type="text" size="10" id="au_paperAmount" name="au_paperAmount"></td>
  </tr>
  <tr>
    <td height="8"><input type="checkbox" value="yes" id="au_food" name="au_food">
      Industrial Food Waste</td>
    <td><input type="text" size="10" id="au_foodAmount" name="au_foodAmount"></td>
  </tr>
  <tr>
    <td height="8"><input type="checkbox" value="yes" id="au_liquids" name="au_liquids">
      Liquids and Oils</td>
    <td><input type="text" size="10" id="au_liquidsAmount" name="au_liquidsAmount"></td>
  </tr>
  <tr>

    <td valign="top" height="34">Comment </td>

    <td><textarea id="au_comment" rows="5" cols="40" name="au_comment"></textarea></td>

  </tr>

</tbody></table>

          <p>

			        <input type="submit" onclick="check(form,form.elements.length);" value="Send now!" name="btn_submit">

		    </p>

		  </form></div>';
		   	
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
	function sendEmailWasteAudit($post) {
		$message = 	'Name: ' 					. $post['au_name'] 	. "\n\n";
		$message .= 'Position at Company: ' 	. $post['au_position'] 	. "\n\n";
		$message .= 'Company: ' 				. $post['au_company'] 	. "\n\n";
		$message .= 'Phone: ' 					. $post['au_phone'] 	. "\n\n";
		$message .= 'Email: ' 					. $post['au_email'] 	. "\n\n";
		$message .= 'City: ' 					. $post['au_city'] 		. "\n\n";
		$message .= 'State: ' 					. $post['au_state'] 		. "\n\n";
		$message .= 'Comments: ' 				. $post['au_comment'] 		. "\n\n";
		$message .= 'Cardboard: ' 				. $post['au_cardboardAmount'] 		. "\n\n";
		$message .= 	'Plastics: ' 				. $post['au_plasticsAmount'] 	. "\n\n";
		$message .= 	'Wood: ' 					. $post['au_woodAmount'] 	. "\n\n";
		$message .= 	'Paper: ' 					. $post['au_paperAmount'] 	. "\n\n";
		$message .= 	'Industrial Food Waste: ' 	. $post['au_foodAmount'] 	. "\n\n";
		$message .= 	'Liquids and Oils: ' 		. $post['au_liquidsAmount'] 	. "\n\n";
		
		
		
		// print_r($post);
		$insertData = $this->insertData($post);
		//mail("bgetter@balconesresources.com,courtney@balconesresources.com,jack@70kft.com", "Contact Form from Balcones Resources", $message, "From: Balcones Resources Website");
		mail("jack@70kft.com", "Resource Audit Form from Balcones Resources", $message, "From: Balcones Resources Website");
		$response = '<h6>Thank You - Your request has been sent.</h6>';
		return $response;
	}
		
} // END CONTACT CLASS
?>