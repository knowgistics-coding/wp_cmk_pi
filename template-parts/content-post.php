<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Phra.in
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php phra_in_post_thumbnail(array("class"=>'cover-contain-md')); ?>
  <div class="reading-area">
    <header class="entry-header">
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <div class="entry-meta">
        <span class="mr-2"><i class="fas fa-pencil"></i>&nbsp;<?php echo date("F d, Y | H:i", get_post_modified_time()); ?></span>
        <?php
				phra_in_posted_by();
        phra_in_social_button();
				?>
      </div>
    </header><!-- .entry-header -->
    <div class="entry-content">
      <?php
      the_content();

      wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'phra_in' ),
        'after'  => '</div>',
      ) );
      
      $gallery = get_post_meta(get_the_ID(),"gallery",false);
      if(!empty($gallery) ? json_decode($gallery[0],true) : false){
        $gallery = json_decode($gallery[0],true);
        $thumb = '';
        $swiper = '';
        foreach($gallery as $index=>$photo){
          $thumb .= '<div class="photo" onclick="change_slide('.($index + 1).')"><img src="'.$photo.'"></div>';
          $swiper .= '<div class="swiper-slide"><img class="contain" src="'.$photo.'"></div>';
        }
        echo '<div class="post-gallery">'.$thumb.'</div>';
        echo '<div class="post-swiper"><div class="swiper-container">
          <div class="swiper-wrapper">'.$swiper.'</div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <button class="swiper-close" onclick="$(\'.post-swiper\').toggle()"><i class="fas fa-times"></i></button>
        </div></div>';
        echo '<script>
        var postSwiper;
        function change_slide(index){
          $(".post-swiper").css("display","block");
          if(!!postSwiper==false){
            postSwiper = new Swiper (".swiper-container", {
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
          postSwiper.slideTo(index);
        }
        </script>';
      }
      
      // Category
      $cats = get_the_category();
      $toggle_category = get_theme_mod("toggle_category",true);
      if(!empty($cats) && $toggle_category){
        echo '<div class="entry-category" style="margin-top:3rem;border-top:solid 1px #bbb;padding-top:1rem;">';
        foreach($cats as $cat){
          echo '<a class="badge badge-pill badge-primary" href="'.get_category_link($cat->term_id).'" target="_blank">'.$cat->name.'</a>';
        }
        echo '</div>';
      }
      
      ?>
    </div><!-- .entry-content -->
    <footer class="entry-footer"><?php
    if( get_theme_mod("comment_display",true) ){
      if ( comments_open() || get_comments_number() ) :
        echo '<div id="sharing"></div>';
        if( !function_exists("wpsites_modify_comment_form_text_area") ){
          function wpsites_modify_comment_form_text_area($arg) {
            // echo '<pre>'.print_r($arg,true).'</pre>';
            $arg['fields'] = array(
              "author" => '<p class="comment-form-author"><label for="author">Name <span class="required">*</span></label> <input id="author" class="form-control" name="author" type="text" value="" size="30" maxlength="245" required="required" /></p>',
              "email" => '<p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input id="email" class="form-control" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" required="required" /></p>',
              "url" => '<p class="comment-form-url"><label for="url">Website</label> <input id="url" class="form-control" name="url" type="url" value="" size="30" maxlength="200" /></p>',
            );
            $arg['title_reply'] = __('ความคิดเห็น');
            $arg['comment_notes_before'] = __('<span class="notes">ที่อยู่อีเมลของท่านจะถูกซ่อนไว้ กรุณากรอกทุกช่องที่มีเครื่องหมาย * </span>');
            $arg['comment_field'] = __('<p class="comment-form-comment"><label for="comment">Comment</label> <textarea id="comment" class="form-control" name="comment" cols="45" rows="2" maxlength="65525" required="required"></textarea></p>');
            $arg['label_submit'] = __('ส่งความเห็น');
            $arg['submit_button'] = __('<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-success" value="%4$s" />');
            return $arg;
          }
          add_filter('comment_form_defaults', 'wpsites_modify_comment_form_text_area');
        }
        comments_template();
      endif;
    }
    ?></footer>
    </div>
  </div>
</article><!-- #post-<?php the_ID(); ?> -->

<script>
$(function(){
  $('.entry-content img').each(function(k,v){add_credit(v)});
  $('.swiper-slide img').each(function(k,v){
    let id = get_image_id($(v).attr('src'));
    firebase.database().ref(`photoDB/${id}`).once("value", snap => {
      let srcset = "";
      for(let k in snap.val()){
        if(!isNaN(k)){ srcset += `${snap.val()[k]} ${k}w,` }
      }
      if(!!srcset){ $(v).attr('srcset',srcset); }
    });
  });
});
</script>
