$(document).ready(function(){
	// FADE IN PROJECT COLUMNS
	$(".column").each(function(i) {
  		$(this).delay(i * 500).fadeIn(1000);
	});	
/*	$('#projects').serialScroll({
			items:'li',
			prev:'#photoprev',
			next:'#photonext',
			offset:0,
			start:0,
			duration:500,
			//interval:4000,
			force:true,
			stop:true,
			lock:false,
			exclude:1,
			cycle:true, //don't pull back once you reach the end
			jump: false //click on the images to scroll to them
		});
		*/
		
		$("#test").load("/includes/twitter-combo.php");
		
		
		var username = 'HW_FDGroup';
    	$.getScript('http://twitter.com/statuses/user_timeline/' + username + '.json?callback=twitterCallback2&count=1');
		
}); // END DOCUMENT READY



$('.project-image').localScroll({
   target:'#scrollable'
});



// TOGGLE VISABILITY OF DETAILS BLOCK
	function hideDetails() {
	$('#scrollable').height(802);
	$(".details").each(function(i) {
  			$(this).delay(i * 1).fadeOut(400);
			});	

			$(".column").each(function(i) {
  				$(this).delay(i * 1).fadeIn(200);
			});
	}

	// HIDE ALL COLUMNS INCLUDING THE ONE CLICKED
	function showDetails(id,col,projectid,pos) {
	
			var p = $("#one");
  			var position = p.position();
  			//var offset = position.replace("-", "")
  			var offset = Math.abs(position.left);

			var cTime=500;
			hideDetails();
		if (col == 2) {
			$("#one").toggle(cTime);
  			$("#two").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
		} else if (col == 3) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
  			$("#three").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
		} else if (col == 4) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
  			$("#four").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
		} else if (col == 5) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
			$("#four").toggle(cTime);
  			$("#five").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
		} else if (col == 6) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
			$("#four").toggle(cTime);
			$("#five").toggle(cTime);
  			$("#six").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
  		} else if (col == 7) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
			$("#four").toggle(cTime);
			$("#five").toggle(cTime);
			$("#six").toggle(cTime);
  			$("#seven").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
  		} else if (col == 8) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
			$("#four").toggle(cTime);
			$("#five").toggle(cTime);
			$("#six").toggle(cTime);
			$("#seven").toggle(cTime);
  			$("#eight").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );
  		} else if (col == 9) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
			$("#four").toggle(cTime);
			$("#five").toggle(cTime);
			$("#six").toggle(cTime);
			$("#seven").toggle(cTime);
			$("#eight").toggle(cTime);
  			$("#nine").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
  			$('#' + id).css( { "margin-left":offset + "px" } );

		} else {

			$("#one").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
		}
		
		
	}
	
	// TOGGLE THE DETAILS DIVDOWN
	function show(id,col,projectid) {
	
		$('#scrollable').height($('#' + id).height());
	
		$('#' + id).toggle("slide");
		$("#quote-" + id).empty().html('<img src="/rsrc/common/loading.gif" />');
		$("#quote-" + id).load('/class/slideshow.class.php?divId='+id+'&projectId='+projectid, function() {
  			$('#slider-' +id).nivoSlider({
        		effect:'slideInRight',
        		directionNavHide:false,
        		controlNav:false
        	});
		});
		
		

		
	}
// END TOGGLE VISABILITY OF DETAILS BLOCK

function twitterCallback2(twitters) {
  var statusHTML = [];
  for (var i=0; i<twitters.length; i++){
    var username = twitters[i].user.screen_name;
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
statusHTML.push('<div style="width:330px"><div style="float:left;width:30px;"></div><div style="float:left;width:300px;"><p id="tweet_text">“'+status+'” – <small>'+relative_time(twitters[i].created_at)+'</small></p></div></div><div style="clear:both;"></div><hr color="#6192b9" size="1" width="100%">');
  }
$('.loading').fadeOut(750, function() {
    $('#latest_tweet').append($(statusHTML.join('')).hide().fadeIn(750));
});
}


function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}