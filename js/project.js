$(document).ready(function(){
    				
    				//Swap Image on Click
					$("ul.thumb-nav li a").click(function() {
						var mainImage = $(this).attr("href"); //Find Image Name
						
						$('#main-image img').attr({ src: mainImage });
						
						return false;
					}); 
    				
    				$("ul.thumb li").hover(function() {
						$(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
						$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
						.animate({
							marginTop: '-55px', /* The next 4 lines will vertically align this image */ 
							marginLeft: '-55px',
							top: '50%',
							left: '50%',
							width: '120px', /* Set new width */
							height: '65px', /* Set new height */
							padding: '10px'
						}, 500); /* this value of "2000" is the speed of how fast/slow this hover animates */

						} , function() {
							$(this).css({'z-index' : '0'});
							$(this).find('img').removeClass("hover").stop()
								.animate({
									marginTop: 	'0',
									marginLeft: '0',
									top: 		'0',
									left: 		'0',
									width: 		'100px',
									height: 	'55px',
									padding:	'5px'
								}, 200);
						});
						$("ul.thumb-nav li").hover(function() {
						$(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
						$(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
						.animate({
							marginTop: '-75px', /* The next 4 lines will vertically align this image */ 
							marginLeft: '-70px',
							top: '50%',
							left: '50%',
							width: '175px', /* Set new width */
							height: '87px', /* Set new height */
							padding: '10px'
						}, 500); /* this value of "2000" is the speed of how fast/slow this hover animates */

						} , function() {
							$(this).css({'z-index' : '0'});
							$(this).find('img').removeClass("hover").stop()
								.animate({
									marginTop: 	'0',
									marginLeft: '0',
									top: 		'0',
									left: 		'0',
									width: 		'100px',
									height: 	'55px',
									padding:	'5px'
								}, 200);
						});
});
					