<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package CMK_Phra.in
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses cmk_pi_header_style()
 */
function cmk_pi_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'cmk_pi_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'cmk_pi_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'cmk_pi_custom_header_setup' );

if ( ! function_exists( 'cmk_pi_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see cmk_pi_custom_header_setup().
	 */
	function cmk_pi_header_style() {
		$header_text_color = get_header_textcolor();
    $mods = get_theme_mods();
    // echo '<pre>'.print_r($mods,true).'</pre>';
    ?>


<script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-database.js"></script>
<script>
var config = {
  apiKey: "AIzaSyA0fkeZmoVeTDLnrAYpZaOvcrQmIUT4dEI",
  authDomain: "johnjadd-3524a.firebaseapp.com",
  databaseURL: "https://johnjadd-3524a.firebaseio.com",
  projectId: "johnjadd-3524a",
  storageBucket: "johnjadd-3524a.appspot.com",
  messagingSenderId: "1091789743614"
};
firebase.initializeApp(config);
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/css/swiper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/fa/css/all.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/core/style.css?202208102029">
<style type="text/css">
:root {
  --body-bg: #<?php echo get_theme_mod('background_color','FFFFFF'); ?>;
  
  --masthead-bg: <?php echo get_theme_mod('masthead_bg','#5BBFDD'); ?>;
  --masthead-color: <?php echo get_theme_mod('masthead_color','#FFFFFF'); ?>;
  --site-branding-width: <?php echo get_theme_mod('site_branding_width','120'); ?>px;
  --masthead-border-color: <?php echo get_theme_mod('masthead_border_color','#DDDDDD'); ?>;
  --masthead-border-width: <?php echo get_theme_mod('masthead_border_width','1'); ?>px;
  --masthead-menu-color: <?php echo get_theme_mod('masthead_menu_color','#333333'); ?>;
  
  --colophon-bg: <?php echo get_theme_mod('colophon_bg','#333333'); ?>;
  --colophon-color: <?php echo get_theme_mod('colophon_color','#FFFFFF'); ?>;
  --colophon-justify: <?php echo get_theme_mod('colophon_justify','center'); ?>;
  
  --cover-brightness: <?php echo get_theme_mod('cover_brightness',70); ?>%;
  
  --hilight-color: <?php echo get_theme_mod('hilight_color','#007bff'); ?>;
}
<?php
$site_branding_width = get_theme_mod('site_branding_width','120');
$site_branding_width_mb = get_theme_mod('site_branding_width_mb', $site_branding_width);
echo '@media screen and (max-width: 768px){
  :root {
    --site-branding-width: '.$site_branding_width_mb.'px;
  }
}
';

$masthead_bgimage = get_theme_mod('masthead_bgimage','');
$masthead_bgimage_mb = get_theme_mod('masthead_bgimage_mb',$masthead_bgimage);
if(!!$masthead_bgimage){
  echo '.site-branding { background-image:url("'.$masthead_bgimage.'"); }
@media screen and (max-width: 768px){
  .site-branding {
    background-image:url("'.$masthead_bgimage_mb.'");
  }
}';
}
?>
</style>  
    <?php
    
		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
