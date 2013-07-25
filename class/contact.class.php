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
        $this->fieldlist       	= array(	'id', 'name', 'company', 'address', 'state', 'zipcode', 'contactname', 'phone', 'email', 'details', 'message','postDate');
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
    	
		$topImage = $_SERVER['DOCUMENT_ROOT']."/domains/dev.balconesresources.com/rsrc/top/".$thisPage[0]['link']."-top.jpg";
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

	function contactForm($response,$url)
	{
		$theDate = date('Y-m-d');

		//	<input name="postDate" value="'.$theDate.'" type="hidden" />
		$theHtml = '
<div id="contact-form">
	<form class="contact" action="" method="post" name="contactUs">
		<input type="hidden" name="encoding" value="UTF-8" />
		<input type="hidden" name="oid" value="00DG0000000gQuq" />
		<input type="hidden" name="retURL" value="http://balconesresources.com' . htmlentities($_SERVER['REQUEST_URI']) . '" />
		<input type="hidden" id="00NG0000009GAoF" maxlength="255" name="00NG0000009GAoF" value="http://balconesresources.com' . htmlentities($_SERVER['REQUEST_URI']) . '" />

		<input name="submitted" value="true" type="hidden" />

		<div id="contact-form-col-1">
			<div class="contact-form-row">	
				<div class="contact-form-field">
					<input type="text" class="field" name="first_name" id="first_name" maxlength="40" value="First Name" />
				</div>
			</div>

			<div class="contact-form-row">	
				<div class="contact-form-field">
					<input type="text" class="field" name="last_name" id="last_name" maxlength="80" value="Last Name" />
				</div>
			</div>
		
			<div class="contact-form-row">	
				<div class="contact-form-field">
					<input type="text" class="field" name="company" id="company" maxlength="40" value="Company" />
				</div>
			</div>
		
			<div class="contact-form-row">	
				<div class="contact-form-field">
					<input type="text" name="street" class="field" value="Address" />
				</div>
			</div>
			<div class="contact-form-row">	
				<div class="contact-form-field">
					<input type="text" name="city" id="city" class="field" maxlength="40" value="City" />
				</div>
			</div>		
			<div class="contact-form-row-hidden">	
				<div class="contact-form-field">
					<input type="text" name="state" id="state" class="field" maxlength="20" value="State" />
				</div>
			</div>
			<div class="contact-form-row-hidden">	
				<div class="contact-form-field">
					<input type="text" name="zip" id="zip" class="field" maxlength="20" value="ZIP Code" />
				</div>
			</div>
			<div class="contact-form-row-hidden">	
				<div class="contact-form-field">
					<input type="text" name="phone" id="phone" class="field" maxlength="40" value="Phone Number" />
				</div>
			</div>
			<div class="contact-form-row-hidden">	
				<div class="contact-form-field">
					<input type="text" name="email" id="email" class="field" maxlength="100" value="Email" />
				</div>
			</div>
			<div class="contact-form-row-hidden">	
				<div class="contact-form-field">
					<textarea name="description" class="field">Details</textarea>
				</div>
			</div>
			
			<div id="contact-button-row" class="contact-form-row-hidden" style="text-align:right;">	
				<div class="contact-form-button">
					<input value="" type="submit" class="button" />
				</div>
			</div>
		</div>	
	</form>
	
	<style type="text/css">
		#contact { max-height: none; }
	</style>
	<script type="text/javascript">
		$("form.contact input, form.contact textarea")
			.focus(function(e){
				if($(this).val() == this.defaultValue){
					$(this).val("");
				}
			})
			.blur(function(){
				if($(this).val() == ""){
					$(this).val(this.defaultValue);
				}
			});

		$("form.contact #city").focus(function(){
			$(".contact-form-row-hidden").show();
			$("#selfPromoThree").hide();
		});

		$("form.contact").submit(function(e){
			var firstName = $(this).find("#first_name"),
				lastName = $(this).find("#last_name"),
				email = $(this).find("#email");

			if(firstName.val() == firstName[0].defaultValue) {
				alert("First name is required");
				e.preventDefault();
				return;
			}
			if(lastName.val() == lastName[0].defaultValue) {
				alert("Last name is required");
				e.preventDefault();
				return;
			}
			if(email.val() == email[0].defaultValue) {
				alert("Email address is required");
				e.preventDefault();
				return;
			}

			if(!e.isDefaultPrevented()) {
				e.preventDefault();

				$.ajax({
					type: "POST",
					url: "https://www.salesforce.com/servlet/servlet.WebToLead",
					data: $(this).serialize()
				});
				$("#thankyou").attr("src","http://www.balconesresources.com/thanks"); 
				$(this).find("#contact-form-col-1").html("<p>Thank you!</p>");
			}
		});
	</script>
	
</div>';

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
	//print_r($post);
		$theEmail['postDate'] 			= mysql_real_escape_string($post['postDate']);
		$theEmail['name'] 			= mysql_real_escape_string($post['name']);
		$theEmail['address'] 		= mysql_real_escape_string($post['address']);
		$theEmail['state'] 			= mysql_real_escape_string($post['state']);
		$theEmail['zipcode'] 		= mysql_real_escape_string($post['zipcode']);
		$theEmail['contactname'] 	= mysql_real_escape_string($post['contactname']);
		$theEmail['phone'] 			= mysql_real_escape_string($post['phone']);
		$theEmail['email'] 			= mysql_real_escape_string($post['email']);
		$theEmail['details'] 		= mysql_real_escape_string($post['details']);
		$theEmail['company'] 		= mysql_real_escape_string($post['company']);
		Default_Table::insertRecord($theEmail);
	}
	function sendEmail($post) {
		$message = 	'Date: ' 			. $post['postDate'] 	. "\n\n";
		$message = 	'Name: ' 			. $post['name'] 	. "\n\n";
		$message .= 'Address: ' 		. $post['address'] 	. "\n\n";
		$message .= 'City: ' 			. $post['city'] 	. "\n\n";		
		$message .= 'State: ' 			. $post['state'] 	. "\n\n";
		$message .= 'Zip: ' 			. $post['zipcode'] 	. "\n\n";
		$message .= 'Phone Number: ' 	. $post['phone'] 		. "\n\n";
		$message .= 'Email: ' 			. $post['email'] 		. "\n\n";
		$message .= 'Company: ' 		. $post['company'] 		. "\n\n";
		$message .= 'Details: ' 		. $post['details'] 		. "\n\n";
		 //print_r($post);
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