<?php

function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
}

function generatetwitter($twittername){

	$username = $twittername; // Your twitter username.
	if ($username == ""){
		$username = "discorax";
	}
	$limit = "15"; // Number of tweets to pull in.
	/* These prefixes and suffixes will display before and after the entire block of tweets. */
	$prefix = ""; // Prefix - some text you want displayed before all your tweets.
	$suffix = ""; // Suffix - some text you want displayed after all your tweets.
	$tweetprefix = "<li>"; // Tweet Prefix - some text you want displayed before each tweet.
	$tweetsuffix = "</li> \r"; // Tweet Suffix - some text you want displayed after each tweet.
	$feed_string = "http://twitter.com/#!/" . $username;  
	echo $feed_string;

 function parse_feed($feed, $prefix, $tweetprefix, $tweetsuffix, $suffix, $username) {
		$feed = str_replace("<", "<", $feed);   		$feed = str_replace(">", ">", $feed);
		$clean = explode("<content type=\"html\">", $feed);
		$link = explode("search.twitter.com,2005:", $feed);
		$amount = count($clean) - 1;
		echo $prefix;
			for ($i = 1; $i <= $amount; $i++) {   				$cleaner = explode("</content>", $clean[$i]);
				$linker = explode("</id>", $link[$i+1]);
				$this_tweets = str_replace("&apos;", "'", $cleaner[0]);
				$this_tweets = str_replace("&gt;", ">", $this_tweets);
				$this_tweets = preg_replace('!<a href.*?>!', '', $this_tweets);
				$this_tweets = preg_replace('!</a>!', '', $this_tweets);
				echo $tweetprefix.'<a href="http://twitter.com/'.$username.'/status/';
				echo $linker[0];
				echo '" target="_blank">'.$this_tweets.'</a>';
				echo $tweetsuffix;
			}
		echo $suffix;
	}

	$twitter_cache_file = 'twittercache.xml';

	$mtime= null;

	if($mtime== null ||(time()-$mtime)>(1000000*60)){// 9 minutes or older?
		$content=get_url_contents($feed_string);
		if(strlen($content)>0){
			$cache_static=fopen($twitter_cache_file,'w+');
			fwrite($cache_static,$content);
			fclose($cache_static);
		}
	}else{
		$mtime=filemtime($twitter_cache_file);
		}

	if (!@file_get_contents($twitter_cache_file)){
		  echo __('Oops, something went wrong. Did you rename the cache folder? The cache file? You shouldn\'t have done that...', 'jfr_theme');
	}else {
		  $twitterFeed = file_get_contents($twitter_cache_file);
	}

	parse_feed($twitterFeed, $prefix, $tweetprefix, $tweetsuffix, $suffix, $username);  

}
?>