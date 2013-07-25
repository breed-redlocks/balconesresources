<?php

require_once 'database.class.inc';
require_once "error.inc";

class Twittercombo extends Default_Table
{

    // CLASS VARIABLES
    function Twittercombo ()
    {
        $this->tablename      	= 'twittercombo';
        $this->dbname          	= 'devjackw';
        $this->rows_per_page   	= 10;
        $this->fieldlist       	= array(	'id', 'description', 'date', 'username');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
        $this->orderby			= 'sortBy';
        $this->list		= Default_Table::getData();
				
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
	}
	
	function getTweet() {
		$theHtml = '';
		foreach ($this->list as $tweet){
			$theHtml .= '<li id="tweet">
							<div class="tweet-text">'.$tweet['description'].'</div>
							<div class="more-link"><a href="http://twitter.com/#!/'.$tweet['username'].'" target="_blank">More from @'.$tweet['username'].'</a></div>
						</li>';
		}
		return $theHtml;
	}
	
	function getTweetByUsername($username) {
		$where = "username = '".$username."'";
		$usersTweets = Default_Table::getData($where);
		$theHtml = '';
		foreach ($this->list as $tweet){
			$theHtml .= '<li id="tweet">
							<div class="tweet-text">'.$tweet['description'].'</div>
						</li>';
		}
		return $theHtml;
	}

	function getUsername() {
		foreach ($this->list as $tweet){
			$theHtml = $tweet['username'];
		}
		return $theHtml;
	}
	} // END CONTACT CLASS
?>