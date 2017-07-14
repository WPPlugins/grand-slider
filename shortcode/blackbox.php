<?php
$wpconfig = realpath("../../../../wp-load.php");

if (!file_exists($wpconfig))  {
	echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;	
	die;	
}
require_once($wpconfig);
require_once( GRAND_SLIDER_DIR . 'plugin-data.php' );

global $wpdb;
$ease = array("swing","easeInSine","easeOutSine", "easeInOutSine", "easeInCubic", "easeOutCubic", "easeInOutCubic", "easeOutInCubic", "easeInQuint", "easeOutQuint", "easeInOutQuint", "easeOutInQuint", "easeInCirc", "easeOutCirc", "easeInOutCirc", "easeOutInCirc", "easeInBack", "easeOutBack", "easeInOutBack", "easeOutInBack", "easeInQuad", "easeOutQuad", "easeInOutQuad", "easeOutInQuad", "easeInQuart", "easeOutQuart", "easeInOutQuart", "easeOutInQuart", "easeInExpo", "easeOutExpo", "easeInOutExpo", "easeOutInExpo", "easeInElastic", "easeOutElastic", "easeInOutElastic", "easeOutInElastic", "easeInBounce", "easeOutBounce", "easeInOutBounce", "easeOutInBounce");

$move = array(	
	'slide-top'		=> esc_attr__( 'Slide Top', 'grand_slider' ), 
	'slide-left'	=> esc_attr__( 'Slide Left', 'grand_slider' ),
	'slide-right'	=> esc_attr__( 'Slide Right', 'grand_slider' ),
	'slide-bottom'	=> esc_attr__( 'Slide Bottom', 'grand_slider' ) 
);

// echo $_GET['formVar'];

header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e("Grand Slider", 'grand_slider'); ?></title>
	<!-- <meta http-equiv="Content-Type" content="<?php// bloginfo('html_type'); ?>; charset=<?php //echo get_option('blog_charset'); ?>" /> -->
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<?php
		wp_admin_css( 'global', true );
		wp_admin_css( 'wp-admin', true );
	?>
	<link rel="stylesheet" id="shortcode-style"  href="<?php echo GRAND_SLIDER_URL . 'css/shortcode.css'; ?>" type="text/css" media="all" />
	<script language="javascript" id="function-js" type="text/javascript" src="<?php echo GRAND_SLIDER_URL . 'shortcode/function.js'; ?>"></script>
	<base target="_self" />
<?php if ( is_rtl() ) : ?>
<style type="text/css">
	#wphead, #tabs {
		padding-left: auto;
		padding-right: 15px;
	}
	#flipper {
		margin: 5px 0 3px 10px;
	}
	.keys .left, .top, .action { text-align: right; }
	.keys .right { text-align: left; }
	td b { font-family: Tahoma, "Times New Roman", Times, serif }
</style>
<?php endif; ?>
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
	
	<!-- <form onsubmit="insertLink();return false;" action="#"> -->	
	<ul id="tabs">
		<li><a id="tab1" href="javascript:flipTab(1)" title="<?php _e('Create Slider') ?>" accesskey="1" tabindex="1" class="current"><?php _e('Slider Options') ?></a></li>
		<li><a id="tab2" href="javascript:flipTab(2)" title="<?php _e('Create Slide Animation') ?>" accesskey="2" tabindex="2"><?php _e('Sliding Options') ?></a></li>
		<li><a id="tab3" href="javascript:flipTab(3)" title="<?php _e('Shortcode Helper') ?>" accesskey="3" tabindex="3"><?php _e('Help') ?></a></li>
		<li><a id="tab4" href="javascript:flipTab(4)" title="<?php _e('About Grand Slider') ?>" accesskey="4" tabindex="4"><?php _e('About') ?></a></li>
	</ul>

	<div id="flipper" class="wrap">
		<div id="content1">
			<div class="columns-2">
				<p>
					<label for="slider-id"><?php _e("Slider ID", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="slider-id" name="slider-id" value="" />
				</p>
				<p>
					<label for="items"><?php _e("Items", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="items" name="items" value="3" />
				</p>
				<p>
					<label for="slide-id"><?php _e("Slide ID", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="slide-id" name="slide-id" value="" />
				</p>
				<p>
					<label for="posts-id"><?php _e("Post ID", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="posts-id" name="posts-id" value="" />
				</p>
				<p>
					<label for="fadespeed"><?php _e("Fade Speed", 'grand_slider'); ?></label>
					<input class="smallfat" class="fadespeed" type="text" id="fadespeed" name="fadespeed" value="1000" />
				</p>
				<p>
					<label for="height"><?php _e("Height <span>(px)</span>", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="height" name="thumbnail-height" value="240" />
				</p>
				<p>
					<label for="width"><?php _e("Width <span>(px)</span>", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="width" name="thumbnail-width" value="640" />
				</p>
				<p>
					<label for="speed"><?php _e("Speed", 'grand_slider'); ?></label>
					<input class="smallfat" class="speed" type="text" id="speed" name="speed" value="800" />
				</p>
				<p>
					<label for="ease"><?php _e("Easing", 'grand_slider'); ?></label>
					<select id="ease" name="move">
						<?php foreach ( $ease as $ease_value ) { ?>
							<option value="<?php echo esc_attr( $ease_value ); ?>"><?php echo esc_html( $ease_value ); ?></option>
						<?php } ?>	
					</select>
				</p>
				<p>
					<label for="pause"><?php _e("Pause", 'grand_slider'); ?></label>
					<input class="smallfat"  type="text" id="pause" name="pause" value="2000" />
				</p>
				<p>
					<label for="slideCount"><?php _e("Slide Count", 'grand_slider'); ?></label>
					<input class="smallfat" type="text" id="slideCount" name="slideCount" value="1" />
				</p>
			</div>
			
			<div class="columns-2 column-last">
				<p>
					<label><input name="controlsShow" id="controlsShow" type="checkbox" checked="checked" /><?php _e("Control", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="prevNext" id="prevNext" type="checkbox" checked="checked" /><?php _e("PrevNext", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="dots" id="dots" type="checkbox" /><?php _e("Dots", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="vertical" id="vertical" type="checkbox" /><?php _e("Vertical", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="thumbnail" id="thumbnail" type="checkbox" checked="checked" /><?php _e("Thumbnail", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="auto" id="auto" type="checkbox" checked="checked" /><?php _e("Auto", 'grand_slider'); ?></label>
				</p>
				<p>
					<label><input name="fade" id="fade" type="checkbox" /><?php _e("Fade", 'grand_slider'); ?></label>
				</p>
			</div>
			
			<div class="clear"></div><!-- clearing the hole -->
			
			<div class="mceActionPanel" style="overflow: hidden; margin-top: 20px;">
				<div style="float: left">
					<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'grand_slider'); ?>" onclick="tinyMCEPopup.close();" />
				</div>
				<div style="float: right">
					<button onclick="insertSlidercode();" value="<?php _e("Insert", 'grand_slider'); ?>" class="button" type="button"><?php _e("Insert", 'grand_slider'); ?></button>
				</div>
			</div>
		</div>

		<div id="content2" class="hidden">
			<div class="shortcode-controls">
				<p>
					<label for="move"><?php _e("Move", 'grand_slider'); ?></label>
					<select id="move" name="move" style="width: 65%; float: right;" onchange="document.getElementById('query').value=this.value; this.form.submit();">
						<?php foreach ( $move as $option_value => $option_label ) { ?>
							<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $_GET['formVar'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
						<?php } ?>	
					</select>
				</p>
				<p>
					<label for="g-ease"><?php _e("Easing", 'grand_slider'); ?></label>
					<select id="g-ease" name="g-ease">
						<?php foreach ( $ease as $ease_value ) { ?>
							<option value="<?php echo esc_attr( $ease_value ); ?>"><?php echo esc_html( $ease_value ); ?></option>
						<?php } ?>
					</select>
				</p>
				<p>
					<label for="speed"><?php _e("Speed", 'grand_slider'); ?></label>
					<input style="width: 48%; float: right;" type="text" id="speed" name="speed" value="400" />
				</p>
				<p>
					<label for="distance"><?php _e("Slide Distance (px)", 'grand_slider'); ?></label>
					<input style="width: 48%; float: right;" type="text" id="distance" name="distance" value="20" />
				</p>
				<p>
					<label for="top"><?php _e("Top", 'grand_slider'); ?></label>
					<input style="width: 48%; float: right;" type="text" id="top" name="before-comment" value="20" />
				</p>
				<p>
					<label for="left"><?php _e("Left", 'grand_slider'); ?></label>
					<input style="width: 48%; float: right;" type="text" id="left" name="after-comment" value="20" />
				</p>
			</div>
			<div class="mceActionPanel" style="overflow: hidden; margin-top: 20px;">
				<div style="float: left">
					<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'grand_slider'); ?>" onclick="tinyMCEPopup.close();" />
				</div>
				<div style="float: right">
					<button onclick="insertSlidecode();" value="<?php _e("Insert", 'grand_slider'); ?>" class="button" type="button"><?php _e("Insert", 'grand_slider'); ?></button>
				</div>
			</div>
		</div>

		<div id="content3" class="hidden">

			<h2><?php _e('Slider Options', 'grand_slider'); ?></h2>

			<h3><?php _e('Slider ID', 'grand_slider'); ?></h3>
			<p><?php _e('The slider needs a spesific id to run the shortcode. Leave the field blank if you want this plugin creates that for you. Actually, the spesific id created by this plugin is generated by a php function <code>mt_rand</code>, so id is in number format.') ?></p>
			<h3><?php _e('Slide ID', 'grand_slider'); ?></h3>
			<p><?php _e('Give a grand slide ID separated with comma to display the slide. Example: 2, 5, 7. ') ?></p>
			<h3><?php _e('Post ID', 'grand_slider'); ?></h3>
			<p><?php _e('Give a post ID separated with comma to display post content and uncheck the thumbnail option. Example: 81, 458, 354. This post id will be overrided if user insert the slide id') ?></p>
			<h3><?php _e('Fade Speed', 'grand_slider'); ?></h3>
			<p><?php _e('The speed of each fading transition. Default to 1000') ?></p>
			<h3><?php _e('Height', 'grand_slider'); ?></h3>
			<p><?php _e('Slider height in pixel. All the slide image will be cropped into this size.') ?></p>
			<h3><?php _e('Width', 'grand_slider'); ?></h3>
			<p><?php _e('Slider width in pixel. All the slide image will be cropped into this size.') ?></p>
			<h3><?php _e('Speed', 'grand_slider'); ?></h3>
			<p><?php _e('Slides transition speed in milisecond.') ?></p>
			<h3><?php _e('Easing', 'grand_slider'); ?></h3>
			<p><?php _e('Transition easing effect, for some cases the easing options not working properly in visuality regarding to the distance and speed.') ?></p>
			<h3><?php _e('Pause', 'grand_slider'); ?></h3>
			<p><?php _e('Delay time between each slide transition.') ?></p>
			<h3><?php _e('Slide Count', 'grand_slider'); ?></h3>
			<p><?php _e('Total slide for in a list element.') ?></p>
			<h3><?php _e('Control', 'grand_slider'); ?></h3>
			<p><?php _e('Display the slider control if enable.') ?></p>
			<h3><?php _e('PrevNext', 'grand_slider'); ?></h3>
			<p><?php _e('Display the slider previous and next control if enable.') ?></p>
			<h3><?php _e('Dots', 'grand_slider'); ?></h3>
			<p><?php _e('Display the dots for each slide, it is clickable and the slide can be viewed directly.') ?></p>
			<h3><?php _e('Vertical', 'grand_slider'); ?></h3>
			<p><?php _e('If checked, this function will give you a vertical sliding transition for each slide, else the slides will moved in horizontal transition.') ?></p>
			<h3><?php _e('Thumbnail', 'grand_slider'); ?></h3>
			<p><?php _e('This option will display the post thumbnail or post featured image if enable, else it only show the slide or post content.') ?></p>
			<h3><?php _e('Auto', 'grand_slider'); ?></h3>
			<p><?php _e('Will start the slider in ready function.') ?></p>
			<h3><?php _e('Fade', 'grand_slider'); ?></h3>
			<p><?php _e('This function will override the vertical or horizontal sliding. If this enabled, you will have the slides fadein-fadeout transition, else you will have the slides in moving transition.') ?></p>
			<br /><br />

			<h2><?php _e('Sliding Options', 'grand_slider'); ?></h2>

			<h3><?php _e('Slide Top', 'grand_slider'); ?></h3>
			<p><?php _e('The slide-top is a shortcode for creating HTML elements that move from top to bottom in certain pixels') ?></p>
			<h3><?php _e('Slide Left', 'grand_slider'); ?></h3>
			<p><?php _e('The slide-left is a shortcode for creating HTML elements that move from left to right in certain pixels') ?></p>
			<h3><?php _e('Slide Right', 'grand_slider'); ?></h3>
			<p><?php _e('The slide-right is a shortcode for creating HTML elements that move from right to left in certain pixels') ?></p>
			<h3><?php _e('Slide Bottom', 'grand_slider'); ?></h3>
			<p><?php _e('The slide-bottom is a shortcode for creating HTML elements that move from bottom to top in certain pixels') ?></p>
			<h3><?php _e('Easing', 'grand_slider'); ?></h3>
			<p><?php _e('Sliding easing effect, for some cases the easing options not working properly in visuality regarding to the distance and speed.') ?></p>
			<h3><?php _e('Speed', 'grand_slider'); ?></h3>
			<p><?php _e('Sliding speed in ms, default to 400 ms.') ?></p>
			<h3><?php _e('Slide Distance', 'grand_slider'); ?></h3>
			<p><?php _e('Sliding distance in pixels, default to 20 ms.') ?></p>
			<h3><?php _e('Top', 'grand_slider'); ?></h3>
			<p><?php _e('Top position of HTML element. The element may not shown if it not in the slider height and width range.') ?></p>
			<h3><?php _e('Left', 'grand_slider'); ?></h3>
			<p><?php _e('Left position of HTML element. The element may not shown if it not in the slider height and width range') ?></p>

			<div class="mceActionPanel" style="overflow: hidden; margin-top: 20px;">
				<div style="float: left">
					<input type="button" id="cancel" name="cancel" value="<?php _e("Close", 'grand_slider'); ?>" onclick="tinyMCEPopup.close();" />
				</div>
			</div>
		</div>

		<div id="content4" class="hidden">
			<?php $plugin_data = get_plugin_data_gs( GRAND_SLIDER_DIR . 'index.php'); ?>
			<h2><?php printf(__('About %s'), $plugin_data['Name'] ) ?></h2>
			<p><?php _e('Version:'); ?> <?php echo $plugin_data['Version']; ?></p>
			<p><?php echo $plugin_data['Description']; ?></p>
			<p><?php printf(__('Copyright &copy; 2011, <a href="%s" target="_blank">%s</a>, All rights reserved.'), $plugin_data['AuthorURI'], $plugin_data['Author'] ); ?></p>
			<p><?php printf(__('For more information about this plugin please visit the <a href="%s" target="_blank">%s</a> website.'), $plugin_data['PluginURI'], $plugin_data['Name'] ); ?></p>
			<div class="mceActionPanel" style="overflow: hidden; margin-top: 20px;">
				<div style="float: left"><input type="button" id="cancel" name="cancel" value="<?php _e("Close", 'grand_slider'); ?>" onclick="tinyMCEPopup.close();" /></div>
			</div>
		</div>
	</div>
</body>
</html>