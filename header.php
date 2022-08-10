<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CMK_Phra.in
 */

$masthead_search_display = get_theme_mod("masthead_search_display","true");

if(is_single() || is_page()){
  $redirect = get_post_meta(get_the_ID(),"redirect",true);
  wp_redirect($redirect);
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body oncontextmenu="return false;" <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'cmk_pi' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-start"><?php
      echo isset($mastheadStart) ? $mastheadStart : "" ;
    ?></div><!-- .site-start -->
    <div class="site-end">
      <?php if($masthead_search_display=="true"){
        echo '<button class="menu-toggle" onclick="sm_toggle(\'#site-search\',true)">
          <span class="text thsarabunnew">
            <span class="primary">ค้นหา</span>
            <span class="primary" style="font-size:var(--font-xxs);">SEARCH</span>
          </span>
          <i class="fas fa-search"></i>
        </button>';
      } ?>
      <button class="menu-toggle" onclick="sm_toggle('#site-navigation')">
        <span class="text">
          <span class="primary">เมนู</span>
          <?php if($masthead_search_display=="true"): ?>
            <span class="primary" style="font-size:var(--font-xxs);">MENU</span>
          <?php else: ?>
            <span class="primary" style="font-size:var(--font-xs);">ค้นหา</span>
          <?php endif; ?>
          <!--<span class="secondary">MENU</span>-->
        </span>
        <i class="fas fa-chevron-down"></i>
      </button>
    </div><!-- .site-end -->
    
		<div class="site-branding"><?php
      $site_branding_icon = get_theme_mod('site_branding_icon', '');
      echo '<a href="'.get_site_url().'" rel="home">'.$site_branding_icon.'</a>';
    ?></div><!-- .site-branding -->

    <nav id="site-search" class="main-navigation"><div class="nav-content">
      <form class="search-wrap" action="<?php echo get_site_url(); ?>" target="_blank" method="get">
        <input type="text" name="s" placeholder="ค้นหา" autocomplete="off" required oninvalid="this.setCustomValidity('กรุณากรอกคำค้นหา')">
        <button><i class="fas fa-search"></i></button>
      </form>
    </div></nav><!-- #site-navigation -->
		<nav id="site-navigation" class="main-navigation"><div class="nav-content">
      <?php if($masthead_search_display=="false"){
        echo '<form class="search-wrap" action="'.get_site_url().'" target="_blank" method="get">
            <input type="text" name="s" placeholder="ค้นหา" autocomplete="off" required oninvalid="this.setCustomValidity(\'กรุณากรอกคำค้นหา\')">
            <button><i class="fas fa-search"></i></button>
          </form>';
      } ?>
    <?php
      wp_nav_menu(array(
        'theme_location'  => 'menu-1',
        'menu_id'         => 'primary-menu',
        'link_before'     => '<i class="fas fa-chevron-right"></i>&nbsp;',
      ));
    ?>
    </div></nav><!-- #site-navigation -->
	</header><!-- #masthead -->
  
  <script>
  function sm_toggle(id,f=false){
    $('.main-navigation:not('+id+')').removeClass("show");
    $(id).toggleClass("show");
    if(f){ $(id).find('[name="s"]').focus() }
  }
  </script>

	<div id="content" class="site-content">
