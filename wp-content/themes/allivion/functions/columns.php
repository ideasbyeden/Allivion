<?php

// third width column
function third_div( $atts, $content = null ) {
	return '<div class="thirdcol">'. do_shortcode($content) . '</div>';
}

add_shortcode( 'third', 'third_div' );


// two thirds width column
function twothirds_div( $atts, $content = null ) {
	return '<div class="twothirdscol">'. do_shortcode($content) . '</div>';
}

add_shortcode( 'two_thirds', 'twothirds_div' );


// half width column
function half_div( $atts, $content = null ) {
	return '<div class="halfcol">'. do_shortcode($content) . '</div>';
}

add_shortcode( 'half', 'half_div' );


// quarter width column
function qtr_div( $atts, $content = null ) {
	return '<div class="qtrcol">'. do_shortcode($content) . '</div>';
}

add_shortcode( 'qtr', 'qtr_div' );

?>