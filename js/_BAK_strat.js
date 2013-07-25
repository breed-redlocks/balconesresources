$(document).ready(function(){
	// FADE IN PROJECT COLUMNS
	$(".column").each(function(i) {
  		$(this).delay(i * 500).fadeIn(1000);
	});	
	$('#projects').serialScroll({
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
		
}); // END DOCUMENT READY


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

			var cTime=500;
			hideDetails();
		if (col == 2) {
			$("#one").toggle(cTime);
  			$("#two").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
		} else if (col == 3) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
  			$("#three").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
		} else if (col == 4) {
			$("#one").toggle(cTime);
			$("#two").toggle(cTime);
			$("#three").toggle(cTime);
  			$("#four").toggle(cTime, '', function(){
  			show(id,col,projectid);
  			});
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