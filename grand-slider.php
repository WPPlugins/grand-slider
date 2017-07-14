<?php
/*
    Grans Slider Main Function
    http://zourbuth.com/plugins/grand-slider
    Copyright 2011  zourbuth.com  (email : zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function grand_slider_func($atts, $content) {
	extract(shortcode_atts(array( //extract short code attr
		'id' 				=> '',
		'items' 			=> 3,
		'slide_id' 			=> '',
		'posts_id' 			=> '',
		'thumbnail' 		=> true,
		'height' 			=> 240,
		'width' 			=> 640,
		'controlsshow' 		=> true,
		'controlsFadeSpeed' => 400,
		'controlsFade' 		=> true,
		'insertAfter' 		=> true,
		'firstShow'			=> false,
		'lastShow' 			=> false, 
		'vertical' 			=> false,
		'speed' 			=> 800,
		'ease' 				=> 'swing',
		'auto' 				=> true,
		'pause' 			=> 2000,
		'continuous' 		=> false,
		'prevnext' 			=> true,
		'dots' 			=> false,
		'numericAttr' 		=> 'class="controls"',
		'numericText' 		=> '[]',
		'clickableAni' 		=> false,
		'history' 			=> false,
		'speedhistory' 		=> 400,
		'autoheight' 		=> true,
		'customLink' 		=> false,
		'fade' 				=> false,
		'crossFade' 		=> true,
		'fadespeed' 		=> 1000,
		'updateBefore' 		=> false,
		'ajax' 				=> false,
		'preloadAjax' 		=> 100,
		'startSlide' 		=> false,
		'ajaxLoadFunction'	=> false,
		'beforeAniFunc' 	=> false,
		'afterAniFunc'  	=> false,
		'uncurrentFunc' 	=> false,
		'currentFunc'   	=> false,
		'prevHtml'			=> '<a href="#" class="prevBtn"> previous </a>',
		'nextHtml'			=> '<a href="#" class="nextBtn"> next </a>',
		'loadingText'		=> 'Loading Content...',
		'firstHtml'			=> '<a href="#" class="firstBtn"> first </a>',
		'controlsAttr'		=> 'id="controls"',
		'lastHtml'			=> '<a href="#" class="lastBtn"> last </a>',
		'autowidth'			=> true,
		'slidecount'		=> 1,
		'resumePause'		=> false,
		'moveCount'			=> 1
	), $atts));

	if ( !empty( $id ) )
		$slider_id =  $id;
	else
		$slider_id = mt_rand();
	
	$w = $width / $slidecount;
	$h = $height / $slidecount;

	$html .= '<div style="margin-bottom: 40px; position:relative; width:' . $width . 'px; height: ' . $h . 'px;">';
	$html .= '<div id="' . $slider_id . '" class="grand-slider" style="width:' . $width . 'px;">';
	$html .= 	'<ul style="width:' . $width . 'px;">';

	// if the slide id is inserted, overwrite the post id
	
	if ( !empty ( $slide_id ) ) :
		$slider_arr = get_posts('numberposts=' . $items . '&order=' . $slider_sort . '&orderby=date&post_type=grand_slides&include=' . $slide_id);
	else :
		if ( !empty ( $posts_id ) ) :
			$slider_arr = get_posts('numberposts=' . $items . '&order=' . $slider_sort . '&orderby=date&post_type=post&include=' . $posts_id);
		else :
			$slider_arr = get_posts('numberposts=' . $items . '&order=' . $slider_sort . '&orderby=date&post_type=grand_slides');
		endif;
	endif;	
	
	// start processing post
	foreach($slider_arr as $key => $slide) {
		$image_url = '';
	
		if ( has_post_thumbnail( $slide->ID, 'large' ) ) {
			$image_id = get_post_thumbnail_id( $slide->ID );
			$image_url = wp_get_attachment_image_src( $image_id, 'large', true );
		}

		$html .= '<li style="position:relative; width:' . $w . 'px;">';
			if ( $thumbnail == 'true' ) {
				$html .= '<img class="slide" src="' . GRAND_SLIDER_URL . 'timthumb.php?src=' . $image_url[0] . '&amp;h=' . $h . '&amp;w=' . $w . '" alt="' . $gallery_item->ID . '" title="' . $gallery_item->post_title . '" />';
			}

			if ( !empty ( $posts_id ) && empty ( $slide_id ) ) :
				$html .= '<div class="grand-caption" style="height: ' . $height . 'px; width:' . $width . 'px;"></div>';
				$html .= '<div class="grand-captions" style="display: none">';
				$html .= 	'<div class="grandBlock">';
				$html .= 		'<div class="grandOverlay"></div>';
				$html .= 		'<a href=' . get_permalink( $slide->ID ) . '>' . $slide->post_title . '</a>';
				$html .= 	'</div>';
				$html .= '</div>';
			else :
				$html .= '<div class="grand-caption" style="height: ' . $height . 'px; width:' . $width . 'px;"></div>';
				$html .= '<div class="grand-captions" style="display: none">';
				$html .= 	do_shortcode( $slide->post_content );
				$html .= '</div>';
			endif;
			
		$html .= '</li>';
	}

	$html .= 	'</ul>';
	$html .= '</div>';
	$html .= '</div>';
	
	$vertical 		= '"' . $vertical . '"'; 
	$controlsshow 	= '"' . $controlsshow . '"'; 
	$prevnext 		= '"' . $prevnext . '"';
	$fade 			= '"' . $fade . '"';
	$auto 			= '"' . $auto . '"';
	$dots 			= '"' . $dots . '"';
	
	add_action('wp_footer', create_function ( '$slider_id' , 'return grand_slider_script(' . 
													$slider_id . ', ' . 
													$controlsshow . ', ' . 
													$vertical . ', ' . 
													$speed . ', ' . 
													$fade . ', ' . 
													$fadespeed . ', ' . 
													$ease . ', ' . 
													$auto . ', ' . 
													$pause . ', ' . 
													$prevnext . ', ' . 
													$dots . ', ' . 
													$slidecount . 
													');' ));
	
	return $html;
}
add_shortcode('grand-slider', 'grand_slider_func');

function grand_slider_script( $slider_id, $controlsshow, $vertical, $speed, $fade, $fadespeed, $ease, $auto, $pause, $prevnext, $dots, $slidecount ) { ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var auto = true;
		var autostopped = false;
		var sudoSlider = jQuery("#<?php echo $slider_id; ?>").sudoSlider({
			controlsShow : <?php echo $controlsshow; ?>,
			vertical : <?php echo $vertical; ?>,
			speed : <?php echo $speed; ?>,
			fade : <?php echo $fade; ?>,
			fadespeed : <?php echo $fadespeed; ?>,
			autowidth:false,
			auto : <?php echo $auto; ?>,
			pause : <?php echo $pause; ?>,
			continuous : true,
			ease : '<?php echo $ease; ?>',
			prevNext : <?php echo $prevnext; ?>,
			numeric : <?php echo $dots; ?>,
			slideCount : <?php echo $slidecount; ?>,
			beforeAniFunc: function(t){ 
				jQuery(".grand-caption div").fadeOut();
			},
			afterAniFunc: function(t){
				jQuery(this).onwerDocument();
			}
		})
		.mouseenter(function() {
			auto = sudoSlider.getValue('autoAnimation');
			if (auto)
				sudoSlider.stopAuto();
			else
				autostopped = true;
		}).mouseleave(function() {
			if (!autostopped)
				sudoSlider.startAuto();
		});
	});
</script><?php
}


function grand_slide_top($atts, $content) {

	extract(shortcode_atts(array( //extract short code attr
		'top' 		=> '',
		'left' 		=> '',
		'speed' 	=> 400,	
		'distance' 	=> 20,
		'easing' 	=> 'swing'
	), $atts));
	
	$html .= '<div class="slide-top" slide-speed="' . $speed . '" slide-distance="' . $distance . '" slide-easing="' . $easing . '" style="top: ' . $top . 'px; left: ' . $left . 'px;">' . do_shortcode($content) . '</div>';
	return $html;
}
add_shortcode('slide-top', 'grand_slide_top');

function grand_slide_left($atts, $content) {

	extract(shortcode_atts(array( //extract short code attr
		'top' 		=> '',
		'left' 		=> '',
		'speed' 	=> 400,	
		'distance' 	=> 20,
		'easing' 	=> 'swing'
	), $atts));
	
	$html .= '<div class="slide-left" slide-speed="' . $speed . '" slide-distance="' . $distance . '" slide-easing="' . $easing . '" style="top: ' . $top . 'px; left: ' . $left . 'px;">' . do_shortcode($content) . '</div>';
	return $html;
}
add_shortcode('slide-left', 'grand_slide_left');

function grand_slide_right($atts, $content) {

	extract(shortcode_atts(array( //extract short code attr
		'top' 		=> '',
		'left' 		=> '',
		'speed' 	=> 400,	
		'distance' 	=> 20,
		'easing' 	=> 'swing'
	), $atts));
	
	$html .= '<div class="slide-right" slide-speed="' . $speed . '" slide-distance="' . $distance . '" slide-easing="' . $easing . '" style="top: ' . $top . 'px; left: ' . $left . 'px;">' . do_shortcode($content) . '</div>';
	return $html;
}
add_shortcode('slide-right', 'grand_slide_right');

function grand_slide_bottom($atts, $content) {

	extract(shortcode_atts(array( //extract short code attr
		'top' 		=> '',
		'left' 		=> '',
		'speed' 	=> 400,	
		'distance' 	=> 20,
		'easing' 	=> 'swing'
	), $atts));
	
	$html .= '<div class="slide-bottom" slide-speed="' . $speed . '" slide-distance="' . $distance . '" slide-easing="' . $easing . '" style="top: ' . $top . 'px; left: ' . $left . 'px;">' . do_shortcode($content) . '</div>';
	return $html;
}
add_shortcode('slide-bottom', 'grand_slide_bottom');
?>