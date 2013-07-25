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
      return '<br><a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
statusHTML.push('<li id="tweet"><p id="tweet_text">'+status+'</p></li>');
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

function theRotator() {
	//Set the opacity of all images to 0
	$('div.rotator ul li').css({opacity: 0.0});
	
	//Get the first image and display it (gets set to full opacity)
	$('div.rotator ul li:first').css({opacity: 1.0});
		
	//Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
	
	setInterval('rotate()',6000);
	
}

function rotate() {	
	//Get the first image
	var current = ($('div.rotator ul li.show')?  $('div.rotator ul li.show') : $('div.rotator ul li:first'));

    if ( current.length == 0 ) current = $('div.rotator ul li:first');

	//Get next image, when it reaches the end, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('div.rotator ul li:first') :current.next()) : $('div.rotator ul li:first'));
	
	//Un-comment the 3 lines below to get the images in random order
	
	//var sibs = current.siblings();
        //var rndNum = Math.floor(Math.random() * sibs.length );
        //var next = $( sibs[ rndNum ] );
			

	//Set the fade in effect for the next image, the show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
};