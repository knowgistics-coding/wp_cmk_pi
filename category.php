<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Thai_Studies_Chula
 */

get_header();
$cat_args = $wp_query->get_queried_object();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main px-3 py-5">
<style>
.nav-links a { background-color:var(--secondary); font-size:var(--font-xs); color:white; padding:.25rem 1rem; border-radius:13px; display:inline-block; text-decoration:none; }
.page-header h1 { font-size:var(--font-l); font-family:"Prompt"; font-weight:bold; }
.table { border:none; }
.table td { padding:.25rem .5rem; border-left:none; border-right:none; }
.table td a { color:var(--blue); }
</style>
		<?php if ( have_posts() ) : ?>
			<header class="page-header text-center mb-5">
				<?php the_archive_title( '<h1 class="page-title text-align m-0 mb-5"><strong>', '</strong></h1>' ); ?>
			</header><!-- .page-header -->
      <div class="container px-0">
        <?php the_posts_navigation(); ?>
        <table class="table table-bordered table-sm">
          <tbody>
          <?php
          $args = array("cat"=>$cat_args->term_id,"post_type"=>array("post","book"));
          $the_query = new WP_Query($args);
          while ( $the_query->have_posts() ) :
            $the_query->the_post();
            get_template_part( 'template-parts/content', "category" );
          endwhile;
          ?>
          </tbody>
        </table>
        <?php the_posts_navigation(); ?>
      </div>
    <?php else: ?>
      <header class="page-header text-center mb-5">
				<?php the_archive_title( '<h1 class="page-title text-align m-0 mb-5"><strong>', '</strong></h1>' ); ?>
			</header><!-- .page-header -->
      <div class="container px-0">
        <p>ไม่พบผลการค้นหา Not found <strong>"<?php echo the_archive_title(); ?>"</strong></p>
      </div>
    <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
