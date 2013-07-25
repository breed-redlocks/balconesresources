<?php

require_once 'database.class.inc';
require_once "error.inc";
//require_once "people.class.php";
class Sitemap extends Default_Table
{

    // additional class variables go here
    function Sitemap ()
    {
       	require_once "class/settings.php";
       	$this->site				= $site;
       	require_once "blogs.class.php";
       	$this->blogs			= new Blogs;
       	require_once "projects.class.php";
       	$this->projects			= new Projects;
       	require_once "contact.class.php";
       	$this->contact			= new Contact;
        $this->tablename      	= 'pages';
        $this->dbname          	= 'brdevdb';
        //$this->rows_per_page   	= 15;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->sql_orderby = 'sortBy';
  		$this->sql_orderby_seq = "ASC";
        $this->pageItems		= Default_Table::getData();	
    } // end class constructor
    
    function getErrors() {
    	echo errorHandler();
    }
    
    
    
    function getHtml($selector,$selectValue,$pageTitle,$category,$subcategory) {
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
			$theHtml .= '<div id="sitemap">';
    		
    		//$pages = Default_Table::getData();
    		
    		//print_r($pages);
    		//echo count($pages);
    		//$theHtml .= 'Parameters: '.$selector.' '.$selectValue.' '.$pageTitle.' '.$category.' '.$subcategory.'<br>';
    		
    		$this->tablename      	= 'categories';
    		$cats = Default_Table::getData("1");
    		
    		//echo "CATS:<br><pre>".print_r($cats)."</pre><br><br>";
    		
    		
    		$this->tablename      	= 'pages';
    		
    		$theHtml .= '<ul>';
    		foreach ($cats as $cat) {
    		
    			if (($cat['id']!= 37) && ($cat['id']!= 35) && ($cat['slug']!='')) {
    			
					$pages = Default_Table::getData("categories = '".$cat['id']."'");
					//echo "Pages:<br><pre>".print_r($pages)."</pre><br><br>";
					$theHtml .= '<noindex>';
					$theHtml .= '<li class="topLevel"><a href="/'.$cat['slug'].'">'.$this->convert_high_bytes($cat['name']).'</a></li>';
					$theHtml .= '<ul>';
					foreach ($pages as $page) {	
						if ( $page['link'] != $cat['slug']) {				
    						$theHtml .= '<li class="aLevel"><a href="/'.$page['link'].'">'.$this->convert_high_bytes($page['title']).'</a></li>';
    					
    					/*
    						$this->tablename      	= 'categories';
    						$isCat = Default_Table::getData("slug = '".$page['link']."'");
    						$this->tablename      	= 'pages';
    					
    						if ($isCat) {
    						
    							$pages = Default_Table::getData("categories = '".$isCat['id']."'");
    							//echo "Pages:<br><pre>".print_r($pages)."</pre><br><br>";
    							$theHtml .= '<li class="topLevel"><a href="/'.$cat['slug'].'">'.$cat['name'].'</a></li>';
								$theHtml .= '<ul>';
							
								foreach ($pages as $page) {	
									if ( $page['link'] != $cat['slug']) {				
    									$theHtml .= '<li class="aLevel"><a href="/'.$page['link'].'">'.$page['title'].'</a></li>';
    								}
      							}
      							$theHtml .= '</ul>';
    						}
    					*/	
    					}
    					
    				}
    				//}
    				$theHtml .= '</ul>';
    					
    			} 
    		}
			$theHtml .= '</ul>';	 
			
			$theHtml .= '</noindex>';
   		
    		/*
    		foreach ($pages as $page) {
    		if ($page['display'] == 1) {
    			if ($page['component'] == 'blogs') {
    				$theHtml .= '<div class="topLevel"><a href="/'.$page['link'].'">'.$page['title'].'</a></div>';
    				$blogs = $this->blogs->getData();
    				//print_r($blogs);
    				foreach ($blogs as $blog) {
    					$theHtml .= '<div class="childPage"> - <a href="/blog/title-'.$blog['titleSlug'].'">'.stripslashes($blog['title']).'</a></div>';
    				}
    			} elseif ($page['component'] == 'projects') {
    				$theHtml .= '<div class="topLevel"><a href="/'.$page['link'].'">'.$page['title'].'</a></div>';
    				$projects = $this->projects->getData();
    				foreach ($projects as $project) {
    					$theHtml .= '<div class="childPage"> - <a href="/projects/id-'.$project['id'].'">'.stripslashes($project['title']).'</a></div>';
    				}

    			} elseif ($page['component'] != "sitemap"){
    				$theHtml .= '<div class="topLevel"><a href="/'.$page['link'].'">'.$page['title'].'</a></div>';
    			}
    		}
    		}
    		*/
    		$theHtml .= '</div>';
    		$theHtml .= '</div>';
    		$theHtml .= '<div id="two-column-right">
    						<div id="selfPromo">';
    		/*					
    			if (($thisPage[0]['categories'] == 23) ||  ($thisPage[0]['categories'] == 25) || ($thisPage[0]['categories'] == 26)) {
    				$theHtml .= '<div id="promoOne">
    								<a href="/balcones-recycling/commercial/residential">
    									<img src="/rsrc/recycling/res-recycle.gif">
    								</a>
    							</div>
    							<div id="promoTwo">
    								<a href="/balcones-recycling/commercial/commercial">
    									<img src="/rsrc/recycling/comm-recycle.gif">
    								</a>
    							</div>';
    			} else {
    					//echo $thisPage[0]['link'];
    				$theHtml .= '<div id="promoOne">
    				
    								<a href="/contact-us/contact-us">
    									<img src="/rsrc/self-promo/'.$thisPage[0]['link'].'.gif">
    								</a>
    							</div>';
    			
    			}			
    		*/					
    		$theHtml .= '	</div>';
    		$theHtml .= '<div id="contact">
    						<h3>Inquiry<br>form</h3>
    						<p>See what we are all about.</p>
    						'.$this->contact->contactForm().'
    					</div>
    					<div id="selfPromoThree">
    						<a href="/balcones-recycling/commercial/commercial-recycling-materials-accepted">
    								<img style="diplay: block" src="/rsrc/common/what-we-collect.gif" />
    							</a>
    					</div>';
    			$theHtml .= '<div id="staticBadges">
								<div id="social">
   									<div id="facebook">
   										<a href="http://www.www.facebook.com/Balcones.Resources" target="_blank">
   											<img src="/rsrc/common/facebook.gif" alt="">
   										</a>
   									</div>
   									<div id="twitter">
   										<a href="https://twitter.com/balconesrecycle" target="_blank">
   											<img src="/rsrc/common/twitter.gif" alt="">
   										</a>
   									</div>
   									<div id="googlePlus">
   										<a href="https://plus.google.com/107020083238084999697/about" target="_blank">
   											<img src="/rsrc/common/googlePlus.gif" alt="">
   										</a>
   									</div>
   									<div id="pintrest">
   										<a href="http://www.pinterest.com/balconesrecycle/" target="_blank">
   											<img src="/rsrc/common/pintrest.gif" alt="">
   										</a>
   									</div>
   								</div>
							</div>';
    						

    		$theHtml .= '</div>';
    		$theHtml .= '<div class="clear"></div>';
    		return $theHtml;
    		
     }
     
     function getXml() {
     
     	$pages = Default_Table::getData($where);
     	foreach ($pages as $page) {
     	if ($page['display'] == 1) {
     	if ($page['component'] == 'blogs') {
    				$theXML .= '<url>'."\n".
      								'<loc>http://www.balconesresources.com/'.$page['link'].'</loc>'."\n".
   								'</url>'."\n";
   			    	$blogs = $this->blogs->getData();
    				//print_r($blogs);
    				foreach ($blogs as $blog) {
    				$theXML .= '<url>'."\n".
      								'<loc>http://www.balconesresources.com/blog/title-'.$blog['titleSlug'].'</loc>'."\n".
   								'</url>'."\n";
    					//$theHtml .= '<div class="childPage"> - <a href="/blog/title-'.$blog['titleSlug'].'">'.$blog['title'].'</a></div>';
    				}
    			} elseif ($page['component'] == 'projects') {
    				$theXML .= '<url>'."\n".
      								'<loc>http://www.balconesresources.com/'.$page['link'].'</loc>'."\n".
   								'</url>'."\n";
    				$projects = $this->projects->getData();
    				foreach ($projects as $project) {
    					$theXML .= '<url>'."\n".
      								'<loc>http://www.balconesresources.com/projects/id-'.$project['id'].'</loc>'."\n".
   								'</url>'."\n";
    					//$theHtml .= '<div class="childPage"> - <a href="/projects/id-'.$project['id'].'">'.$project['title'].'</a></div>';
    				}

    			} elseif ($page['component'] != "sitemap"){
    				$theXML .= '<url>'."\n".
      								'<loc>http://www.balconesresources.com/'.$page['link'].'</loc>'."\n".
   								'</url>'."\n";
    			}

			//$theXML .= '<url>'."\n".
      		//				'<loc>http://www.balconesresources.com/'.$page['link'].'</loc>'."\n".
   			//			'</url>'."\n";
		}
		}
     
     
     return $theXML;
     }
     
	function convert_high_bytes($string) 	{ 	
   		$highByte = array( array('#COPY#','#REG#','#TM#'), array('&copy;','&reg;','&trade;') );
		return str_replace($highByte[0],$highByte[1],$string);
	}
		
} // end class
?>