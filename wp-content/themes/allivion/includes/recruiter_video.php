<?php
		
	$iframe_height = 350;
	if(is_numeric($employer['video'])) { // is Vimeo
					
	$vimeo_xml = simplexml_load_string(file_get_contents('http://vimeo.com/api/oembed.xml?url=http://vimeo.com/'.$employer['video']));
	$vimeo_width = $vimeo_xml->width;
	$vimeo_height = $vimeo_xml->height;
	$iframe_width = ($iframe_height/$vimeo_height)*$vimeo_width;

	//echo '<div class="imageholder videoholder" id="video_'.$employer['video'].'">';
	echo '<iframe width="'.$iframe_width.'" height="150" src="http://player.vimeo.com/video/'.$employer['video'].'" frameborder="0"></iframe>';
	//echo '</div>';
					
} else { // is Youtube

	$yt_xml = simplexml_load_string(file_get_contents('https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$employer['video'].'&format=xml'));
	$yt_width = $yt_xml->width;
	$yt_height = $yt_xml->height;
	$iframe_width = ($iframe_height/intval($yt_height))*intval($yt_width);
	
	//echo '<div class="imageholder videoholder" id="video_'.$employer['video'].'">';
	echo '<iframe width="100%"	height="100%" style="margin-top: 10px;" src="http://www.youtube.com/embed/'.$employer['video'].'?rel=0&wmode=opaque" frameborder="0"></iframe>';
	//echo '</div>';
}