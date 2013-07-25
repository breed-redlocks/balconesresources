<?php
header("Cache-Control: no-cache");
require_once 'projects.class.php';


$id 		= $_GET['divId'];
$projectId 	= $_GET['projectId'];
$where = "id = '" . $projectId . "'";
$data = new Projects;
$images = $data->getData($where);
$imageParts = buildImageArray($images);
//echo "<pre>";
//print_r ($imageParts);
//echo "</pre>";

		$theHtml = '<div id="slider-wrapper">
        
            	<div id="slider-' . $id . '" class="nivoSlider">';
            	
            	foreach ($imageParts as $image) {
            		$theHtml .= '<img src="/rsrc/projects/large/' . $image['path'] . '" alt="' . $image['title'] . '" /></a>';
            	}
                

            	$theHtml .= '</div></div></div>';
 
        echo $theHtml;
        
        function buildImageArray ($images) {
			if ($images[0]['mediaTitle1']) {
				$image[1]['title'] = $images[0]['mediaTitle1'];
				$image[1]['path'] = $images[0]['mediaPath1'];
			}
			if ($images[0]['mediaTitle2']) {
				$image[2]['title'] = $images[0]['mediaTitle2'];
				$image[2]['path'] = $images[0]['mediaPath2'];
			}
			if ($images[0]['mediaTitle3']) {
				$image[3]['title'] = $images[0]['mediaTitle3'];
				$image[3]['path'] = $images[0]['mediaPath3'];
			}
			if ($images[0]['mediaTitle4']) {
				$image[4]['title'] = $images[0]['mediaTitle4'];
				$image[4]['path'] = $images[0]['mediaPath4'];
			}
			if ($images[0]['mediaTitle5']) {
				$image[5]['title'] = $images[0]['mediaTitle5'];
				$image[5]['path'] = $images[0]['mediaPath5'];
			}
			if ($images[0]['mediaTitle6']) {
				$image[6]['title'] = $images[0]['mediaTitle6'];
				$image[6]['path'] = $images[0]['mediaPath6'];
			}
			if ($images[0]['mediaTitle7']) {
				$image[7]['title'] = $images[0]['mediaTitle7'];
				$image[7]['path'] = $images[0]['mediaPath7'];
			}
			if ($images[0]['mediaTitle8']) {
				$image[8]['title'] = $images[0]['mediaTitle8'];
				$image[8]['path'] = $images[0]['mediaPath8'];
			}
			if ($images[0]['mediaTitle9']) {
				$image[9]['title'] = $images[0]['mediaTitle9'];
				$image[9]['path'] = $images[0]['mediaPath9'];
			}
			if ($images[0]['mediaTitle10']) {
				$image[10]['title'] = $images[0]['mediaTitle10'];
				$image[10]['path'] = $images[0]['mediaPath10'];
			}
        
			return $image;
    }

?>
<!-- <div id="htmlcaption" class="nivo-html-caption">
                <strong>Stratosphere Creative:</strong><a href="#"> At 70,000 feet up, the world looks very different.</a>.-->
