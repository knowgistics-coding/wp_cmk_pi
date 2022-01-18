<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JohnJadd
 */
?>

<?php
$json_item = get_post_meta(get_the_ID(), "item", true);
$item = json_decode($json_item, true);
function rand_id(){ $str = hash("sha256", rand(1,1000000)); return substr($str,0,6); }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> ng-app="book-app" ng-controller="book-ctrl">
  <aside class="entry-menu sidebar-aside">
    <section class="main">
      <ul data-catag="title">
        <header class="item">
          <span class="sb-label" ng-click="book.read='cover'"><i class="fas fa-book"></i> <?php the_title() ?></span>
        </header>
        <li class="mb-3"><?php phra_in_social_button(); ?></li>
      </ul>
    <?php
    $allPosts = array();
    if(!empty($item)){
      foreach($item as $i){
        if($i["type"]=="page"){
          echo '<ul data-catag="page">
            <li class="item" ng-class="book.read=='.$i["id"].' ? \'active\' : \'\'">
              <span class="sb-label" ng-click="book.open('.$i["id"].')">'.$i["label"].'</span>
            </li>
          </ul>';
          $allPosts[] = $i["id"];
        } elseif($i["type"]=="folder"){
          $inner = '';
          foreach($i["item"] as $si){
            $inner .= '<li class="item" ng-class="book.read=='.$si["id"].' ? \'active\' : \'\'">
              <span class="sb-label" ng-click="book.open('.$si["id"].')">'.$si["label"].'</span>
            </li>';
            $allPosts[] = $si["id"];
          }
          echo '<ul data-catag="folder">
            <header class="item">
              <span class="sb-label" onclick="book_menu_folder_toggle(this)">'.$i["label"].'</span>
            </header>
            <div class="inner">'.$inner.'</div>
          </ul>';
        } else { print_r($i); }
      }
    }
    ?></section>
  </aside>
  
	<header class="entry-header full-cover" ng-if="book.read=='cover'">
    <?php phra_in_post_thumbnail(); ?>
    <div class="entry-meta cover-meta">
      <?php
        if( get_theme_mod("toggle_category",true) ){
          $cats = wp_get_post_categories(get_the_ID());
          $cats_link = array();
          foreach($cats as $cat_ID){
            $cat = get_category($cat_ID);
            if(!empty($cat)){ $cats_link[] = '<a href="'.get_category_link($cat_ID).'" target="_blank">'.$cat->name.'</a>'; }
          }
          echo '<p class="catag">'.implode(", ", $cats_link).'</p>';
        }
      ?>
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <p><i class="fas fa-chevron-circle-right" ng-click="book.open(<?php echo !empty($allPosts) ? $allPosts[0] : '' ; ?>)"></i></p>
    </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
    <?php
      if(!empty($allPosts)){
        $allPosts = array_unique($allPosts);
        foreach($allPosts as $key=>$post_id){
          $post = get_post($post_id);
          setup_postdata($post);
          $thumbnail = get_the_post_thumbnail($post_id);
          if( !!get_post_thumbnail_id() ){
            $attach_id = get_post_thumbnail_id();
            $img_web = get_post_meta($attach_id,"web",true);
            $img_credit = get_post_meta($attach_id,"credit",true);
            if( !!$img_web ){
              $thumbnail .= '<span class="photo-credit"><a href="'.$img_web.'" target="_blank"><i class="fas fa-globe"></i>&nbsp;Photo Source</a></span>';
            } elseif( !!$img_credit ) {
              $thumbnail .= '<span class="photo-credit"><i class="far fa-camera"></i>&nbsp;'.$img_credit.'</span>';
            }
          }
          echo '<section class="page-container'.( $key==0 ? ' show' : '' ).'" data-catag="page" ng-class="book.read==\''.$post_id.'\' ? \'show\' : \'\'">
            '.( !!$thumbnail ? "<div class=\"post-thumbnail\">{$thumbnail}</div>" : '' ).'
            <div class="post-content">
              <h1><a href="'.get_permalink($post_id).'" target="_blank">'.$post->post_title.'</a></h1>
              <div class="post-meta">
                <span class="mr-2"><i class="fas fa-pencil"></i> '.date("F d, Y | H:i", strtotime($post->post_modified)).'</span>
                <span><i class="fas fa-user"></i> '.get_the_author_meta("display_name", $post->post_author).'</span>
                <div style="margin-top:.5rem;">'.phra_in_social_button($post_id,true).'</div>
              </div>
              <div class="post-body">';
          the_content();
          echo '</div>';
          
          $uniq_id = rand_id();
          $json_gallery = get_post_meta($post_id,"gallery",true);
          if(!!$json_gallery){
            $gallery = json_decode($json_gallery, true);
            $gallery_img = ''; $swiper = '';
            foreach($gallery as $index=>$photo){
              $gallery_img .= '<div class="photo" onclick="openGallery(\''.$uniq_id.'\','.($index+1).')"><img src="'.$photo.'"></div>';
              $swiper .= '<div class="swiper-slide"><img class="contain" src="'.$photo.'" style="filter:brightness(100%)"></div>';
            }
            echo '<div class="post-gallery">'.$gallery_img.'</div>';
            echo '<div class="post-swiper '.$uniq_id.'"><div id="'.$uniq_id.'" class="swiper-container">
              <div class="swiper-wrapper">'.$swiper.'</div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
              <button class="swiper-close" onclick="$(\'.post-swiper\').css(\'display\',\'none\')"><i class="fas fa-times"></i></button>
            </div></div>';
          }

          $cats = get_the_category($post_id);
          $toggle_category = get_theme_mod("toggle_category",true);
          if(isset($cats) && $toggle_category){
            echo '<div style="margin-top:3rem;border-top:solid 1px #bbb;padding-top:1rem;">';
            foreach($cats as $cat){
              echo '<a class="badge badge-pill badge-primary" href="'.get_category_link($cat->term_id).'" target="_blank" style="color:white;">'.$cat->name.'</a> ';
            }
            echo '</div>';
          }

          echo '</div>
            <div class="post-nav">
              <button class="fas fa-chevron-square-left" ng-click="book.prev()" ng-class="allPosts.indexOf(book.read)==0 ? \'disabled\' : \'\'"></button>
              <div class="page-current" ng-bind="(allPosts.indexOf(book.read)+1)+\'\/\'+allPosts.length"></div>
              <button class="fas fa-chevron-square-right" ng-click="book.next()" ng-class="(allPosts.indexOf(book.read)+1)==allPosts.length ? \'disabled\' : \'\'"></button>
            </div>
          </section>';
          
        }
        // $post = get_post
      }
      wp_link_pages(array('before'=>'<div class="page-links">'.esc_html__('Pages:','johnjadd'),'after'=>'</div>',));
    ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<script>
const app = angular.module("book-app",["ngSanitize"]);
app.controller("book-ctrl",["$scope","$sce",function($scope,$sce){
  $scope.allPosts = <?php echo json_encode(array_values($allPosts)); ?>;
  $scope.book = {
    read: <?php echo isset($_GET["skip"]) ? array_values($allPosts)[0] : '"cover"' ; ?>,
    open: (id)=>{
      $("html,body").animate({scrollTop:0},250,'swing');
      $scope.book.read=id;
      if($(window).width()<992){ $('.entry-menu').css('display','none') }
    },
    next: ()=>{
      let cur = $scope.allPosts.indexOf($scope.book.read);
      if(cur!==-1 ? !!$scope.allPosts[cur+1] : false){
        $scope.book.open($scope.allPosts[cur+1]);
      }
    },
    prev: ()=>{
      let cur = $scope.allPosts.indexOf($scope.book.read);
      if(cur!==-1 ? !!$scope.allPosts[cur-1] : false){
        $scope.book.open($scope.allPosts[cur-1]);
      }
    },
  };
  $('#sidebar-toggle').on("click", ()=>{
    if($scope.book.read=="cover"){
      $scope.book.open($scope.allPosts[0]);
      $('.entry-menu').css('display','block');
      $scope.$apply();
    } else {
      $('.entry-menu').slideToggle('fast');
    }
  });
  
  $(window).on("resize", ()=>{
    if( $(window).width() > 992 ){
      $('.entry-menu').css('display','block');
    }
  });
}]);
function book_menu_folder_toggle(that){$(that).closest('ul[data-catag="folder"]').children(".inner").slideToggle('fast')}
let postSwiper = {};
function openGallery(id,index){
  $('.'+id).css("display","block");
  if(!!postSwiper[id]==false){
    postSwiper[id] = new Swiper ("#"+id,{
      speed: 600,
      loop: true,
      centeredSlides: true,
      grabCursor: true,
      lazy: true,
      pagination: { el: ".swiper-pagination", dynamicBullets: true, },
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev", },
      scrollbar: { el: ".swiper-scrollbar", },
    });
  }
  postSwiper[id].slideTo(index);
}
$(function(){
  $('article img').each(function(k,v){ add_credit(v) });
});
</script>