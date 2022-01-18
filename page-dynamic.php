<?php
/**
 * Template Name: Dynamic
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CMK_Phra.in
 */

get_header();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php new dnm_gen(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<script>$(function(){ $('.site-main img').each((k,v)=>{add_credit(v)}) });</script>
<?php
// get_sidebar();
get_footer();