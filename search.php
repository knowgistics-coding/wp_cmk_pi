<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Thai_Studies_Chula
 */

get_header();
?>
<style>
.nav-links a { background-color:var(--secondary); font-size:var(--font-xs); color:white; padding:.25rem 1rem; border-radius:13px; display:inline-block; text-decoration:none; }
.page-header h1 { font-size:var(--font-l); font-family:"Prompt"; font-weight:bold; }
.table { border:none; }
.table td { padding:.25rem .5rem; border-left:none; border-right:none; }
.table td a { color:var(--blue); }
</style>

	<section id="primary" class="content-area">
		<main id="main" class="site-main container px-3 py-5">

    <header class="page-header">
      <h1 class="page-title text-center m-0 mb-5">
        <?php
        /* translators: %s: search query. */
        printf( esc_html__( 'Search Results for: %s', 'itschula' ), '<span>' . get_search_query() . '</span>' );
        ?>
      </h1>
    </header><!-- .page-header -->

		<?php if ( have_posts() ) : ?>
      
      <?php the_posts_navigation(); ?>
      <table class="table table-bordered table-sm">
        <tbody>
        <?php
        while ( have_posts() ) :
          the_post();
          get_template_part( 'template-parts/content', "category" );
        endwhile;
        ?>
        </tbody>
      </table>
      <?php the_posts_navigation(); ?>

			<?php else: ?>
      
      <p>ไม่พบผลการค้นหา Not found <strong>"<?php echo get_search_query(); ?>"</strong></p>
      
			<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
