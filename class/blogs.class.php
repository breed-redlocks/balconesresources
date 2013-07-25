<?php

require_once 'database.class.inc';
require_once "error.inc";

class Blogs extends Default_Table
{

    // CLASS VARIABLES
    function Blogs ()
    {
        $this->tablename      	= 'blogs';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 10000;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        require_once "categories.class.inc";
		$this->cats			= new Categories;
		//require_once "users.class.inc";
		//$this->users			= new Users;
		//require_once "tags.class.inc";
		//$this->tags				= new Tags;
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
		$urlParts = explode('.', $_SERVER['HTTP_HOST']);
		$subDomain = $urlParts[0];
		
		$theHtml = '<div id="blogs">';
   		$theHtml .= '<div id="blogs-body">';
		
		if ($selector) {
			
			if ($selector == 'categories') {
				$whereCat = "slug= '" . $selectValue . "'";
   				$catName = $this->cats->getData($whereCat);
				$where = $selector . " LIKE '%" . $catName[0]['id'] . "%'";
				$limit = 0;
			} elseif ($selector == 'title') {
				$where = "titleSlug LIKE '%" . $selectValue . "%'";
				$limit = 1;
			} elseif ($selector == 'author'){
				$where = $selector .   " LIKE '%" . $selectValue . "%'";
				$limit = 0;
			}		
			
			$blog = Default_Table::getData($where);
			$theHtml .= Blogs::postStructure($blog, $limit);
			
			
		} else {

   			$blog = Default_Table::getData($where);
   			$theHtml .= Blogs::postStructure($blog, 0);
		}
   		$theHtml .= '</div>';
   		
   		$theHtml .= '<div id="blogs-siderail">';
   		//$theHtml .= Blogs::blogCats();
   		$theHtml .= Blogs::recentPosts();
   		//$theHtml .= Blogs::blogAuthors();
   		$theHtml .= '</div>';
   		$theHtml .= '<div class="clear"></div>';
   		$theHtml .= '</div>'; // END OF BLOGS
   	
   		return $theHtml;
	}
	
	function postStructure($blog, $limit) {
	//print_r($blog);
		$urlParts = explode('.', $_SERVER['HTTP_HOST']);
		$subDomain = $urlParts[0];
		if ($limit > 0) {
		//echo "LIMIT IS SET ".$limit;
			$i=0;
			$postHtml = '';
   			while ($i < $limit) {
   				$theDate = date("l F, d Y ", strtotime(substr($blog[$i]['date'], 0, 15)));
   				$theDate = strtolower($theDate);
   				$postHtml .= '<div class="blog-post">';
   				$postHtml .= '	<div class="blog-post-title"><a href="">' . stripslashes($blog[$i]['title']) . '</a></div>';
   				$postHtml .= '	<div class="blog-post-date">' . $theDate . '</div>';
   				$postHtml .= '	<div class="blog-post-body"><p class="blog-body">' . stripslashes($blog[$i]['body']) . '</p></div>';
   				$postHtml .= '	<div class="blog-post-image"><img src="/rsrc/blogs/' . $blog[$i]['mediaPath1'] . '" alt="' . $blog[$i]['mediaTitle1'] . '"></div>';
   				$postHtml .= '	<div class="blog-post-image-title">' . $blog[$i]['mediaTitle1'] . '</div>';
				$postHtml .= '	<div class="blog-post-body"><p class="blog-body">' . stripslashes($blog[$i]['bodyBelow']) . '</p></div>';
   				$postHtml .= '	<div class="blog-post-cats">Post Categories: ';
   				$selectedIds = explode("::", $blog[$i]['categories']);
   				$numCat = count($selectedIds);
   				$x=1;
   					foreach ($selectedIds as $catId) {
   						$where = "id = '" . $catId . "'";
   						$catName = $this->cats->getData($where);
   						if ($x == $numCat) {
   							$postHtml .= '<a href="/blog/categories-' . $catName[0]['slug'] . '">' . strtolower($catName[0]['name']) . '</a>   ';
   						} else {
   							$postHtml .= '<a href="/blog/categories-' . $catName[0]['slug'] . '">' . strtolower($catName[0]['name']) . ', </a>   ';
   						}
   						$x++;
   					}
				$postHtml .= '</div>'; // END BLOG CATS
				$title=urlencode($blog[$i]['title']);
				$url=urlencode('http://balconesresources.com/blog/title-'.$blog[$i]['titleSlug']);
				$summary=urlencode($blog[$i]['title']);
				$image=urlencode('http://balconesresources.com/rsrc/blogs/'.$blog[$i]['mediaPath1']);	
   			if ($subDomain != "dev") {
   			$postHtml .= '<div class="fb_share">
    						<a onClick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$title.'&amp;p[summary]='.$summary.'&amp;p[url]='.$url.'&amp;&amp;p[images][0]='.$image.'\',\'sharer\',\'toolbar=0,status=0,width=548,height=325\');" href="javascript: void(0)"><img src="../rsrc/common/facebook.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;

    <a href="http://twitter.com/home?status=Currently reading http://balconesresources.com/blog/title-'.$blog[$i]['titleSlug'].' " title="Click to share this post on Twitter"><img src="../rsrc/common/twitter.jpg"></a>
</div>';
   			} else {
   			$postHtml .= '<div class="fb_share">
    						<a onClick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$title.'&amp;p[summary]='.$summary.'&amp;p[url]='.$url.'&amp;&amp;p[images][0]='.$image.'\',\'sharer\',\'toolbar=0,status=0,width=548,height=325\');" href="javascript: void(0)">share on facebook</a>&nbsp;&nbsp;&nbsp;&nbsp;

    <a href="http://twitter.com/home?status=Currently reading http://balconesresources.com/blog/title-'.$blog[$i]['titleSlug'].' " title="Click to share this post on Twitter">share on twitter</a>
</div>';
   			}
   				$postHtml .= '<div class="clear"></div>';
   				$postHtml .= '</div>'; // END BLOG POST
   				$i++;
   			}
   		} else {
   		//echo "NO LIMIT IS SET ".$limit;
   		
   			foreach ($blog as $post) {
   				//$whereTag = "id = '" . $this->projectItems[$proj]['tags'][0] . "'";
				//$tags = $this->tags->getData($whereTags);

   				$theDate = date("l F, d Y ", strtotime(substr($post['date'], 0, 15)));
   				$theDate = strtolower($theDate);
   				$postHtml .= '<div class="blog-post">';
   				$postHtml .= '	<div class="blog-post-title"><a href="">' . stripslashes($post['title']) . '</a></div>';
   				$postHtml .= '	<div class="blog-post-date">' . $theDate . '</div>';
   				$postHtml .= '	<div class="blog-post-body"><p class="blog-body">' . stripslashes($post['body']) . '</p></div>';
   				$postHtml .= '	<div class="blog-post-image">
   									<img src="/rsrc/blogs/' . $post['mediaPath1'] . '" alt="' . $blog[$i]['mediaPath1'] . '">
   								</div>';
   				$postHtml .= '	<div class="blog-post-image-title">' . $post['mediaTitle1'] . '</div>';
				$postHtml .= '	<div class="blog-post-body"><p class="blog-body">' . stripslashes($post['bodyBelow']) . '</p></div>';
   				$postHtml .= '	<div class="blog-post-cats">';
   				$selectedIds = explode("::", $post['categories']);
   				$catNum = count($selectedIds);
   				$x=1;
   					foreach ($selectedIds as $catId) {
   						$where = "id = '" . $catId . "'";
   						$catName = $this->cats->getData($where);
   						if ($x == $catNum) {
   							$postHtml .= '<a href="/blog/categories-' . $catName[0]['slug'] . '">' . strtolower($catName[0]['name']) . '</a>';
   						} else {
   							$postHtml .= '<a href="/blog/categories-' . $catName[0]['slug'] . '">' . strtolower($catName[0]['name']) . '</a>, ';
   						}
   						$x++;
   						
   					}
				$postHtml .= '</div>'; // END BLOG CATS
   				$postHtml .= '<div class="clear"></div>';
   				$postHtml .= '</div>'; // END BLOG POST
   			}
   		}
   		//echo $post;
   		return $postHtml;
	}
	
	function recentPosts() {
		$postList 	= '<div class="blog-side-header">Last 10 Posts</div>';
		$blogPosts 	= $this->blogList;
		//print_r($blogPosts);
		$i 			= 0;
			while ($i < 10) {
			if ($blogPosts[$i]['id']) {
				$postList .= '<div class="blog-side-list">
								<a href="/blog/title-' . $blogPosts[$i]['titleSlug'] . '">' . stripslashes($blogPosts[$i]['title']) . '</a>
								<br>
							</div>';
				$i++;
			} else {
				$i++;
			}
				
			}
			
			$postList .= '<div class="blog-side-list"><a href="">View Archive</a></div>';
			//$postList .= '</div>';
		return $postList;
	}
	
	function blogCats() {
		$where = "parent = 11";
		$cats = $this->cats->getData($where);
		$catList = '<div class="blog-side-header">categories</div>';
			foreach ($cats as $cat) {
				$catList .= '<div class="blog-side-list"><a href="/blog/categories-' . $cat['slug'] . '">&nbsp;' . $cat['name'] . '&nbsp;</a><br></div>';
			}
		$catList .= '<br>';
		return($catList);
	}
	
	function blogAuthors() {
		$authors = $this->users->getData();
		$authorList = '<br><div class="blog-side-header">authors</div>';
			foreach ($authors as $author) {
				$authorList .= '<div class="blog-side-list"><a href="/blog/author-' . $author['id'] . '">&nbsp;' . $author['firstName'] . ' ' . $author['lastName'] .'&nbsp;</a><br></div>';
			}
		$authorList .= '<br>';
		return($authorList);
	}
	
} // END BLOGS CLASS
?>