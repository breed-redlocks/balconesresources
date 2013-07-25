<?php
// GET SITE SETTINGS
	require_once('admin/includes/settings.php');
// TURN ERRORS ON OR OFF
	$debug = false;

// INSTANCIATE REQUIRED OBJECT
	require_once 	"class/pages.class.php";
	$pageInfo 		= new Pages;
	
// IDENTIFY PAGE
	$page = $pageInfo->parseUrl();
	
	
// LOAD COMPONENT
	if ($page[0]['component']) {
		require_once 	'class/' . $page[0]['component'] . '.class.php';
		$constructor 	= ucwords($page[0]['component']);
		$componentInfo = new $constructor;
	
		$content = $componentInfo->getHtml($page[0]['selector'],$page[0]['selectValue']);
		
	} else {
		$content.= '<link media="screen, print" href="/css/page-layouts/internal-common.css " type="text/css" rel="stylesheet">
<link media="screen, print" href="/css/page-layouts/internal-blue.css " type="text/css" rel="stylesheet">';
		$content .= '<div id="left-rail">
						<div id="side-nav">	
							<ul>
								<li style="background-image: url(/rsrc/common/active-arrow-29-internal-blue.png);background-position: 130px 0;" class="section-active"><a href="/">Not Found</a></li>	
							</ul>
						</div>
					</div>
						<div id="content">
							<div id="two-column-center">
								<div id="block2">
									<h1>Sorry, the page you are looking for has moved. You will be redirected to the home page of balconesresources.com</h1>
								</div>
						
							</div>
							<div id="two-column-right">
    						<div id="selfPromo"><div id="promoOne">
    				
    								<a href="http://balconesshred.com">
    									<img src="/rsrc/self-promo/balcones-shred.gif">
    								</a>
    							</div>	</div>
        					<div id="selfPromoThree">
    						<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted">
    								<img src="/rsrc/common/what-we-collect.gif" style="diplay: block">
    							</a>
    					</div><div id="staticBadges">
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
							</div></div>
						</div>';
		
		
		$content .= '	<style>
							#footer-wrapper {
    							left: 143px;
  								}
						</style>';


		$content .= '<script type="text/javascript">
						<!--
							function redirect() {
							window.location = "http://www.balconesresources.com/"
							}
							setTimeout(\'redirect()\', 1500)
						//-->
					</script>';

	}

// CREATE PAGE	
	$thisPage = $pageInfo->setPage($page, $content);
	echo $thisPage;
	
	if ($debug) {
		echo "_GET<br>";
			print_r($_GET);
		echo "<hr>";
		echo "_POST<br>";
			print_r($_POST);
		echo "<hr>";
		echo "PAGE<br>";
			print_r($page);
		echo "<hr>";
	}
	
