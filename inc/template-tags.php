<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package CMK_Phra.in
 */

if ( ! function_exists( 'cmk_pi_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function cmk_pi_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'cmk_pi' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cmk_pi_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function cmk_pi_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'cmk_pi' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cmk_pi_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cmk_pi_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'cmk_pi' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'cmk_pi' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'cmk_pi' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'cmk_pi' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'cmk_pi' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'cmk_pi' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'cmk_pi_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function cmk_pi_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail"><?php
        the_post_thumbnail();
      ?></div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/* ======================================================================
# From Phra.in
====================================================================== */
if ( ! function_exists( 'phra_in_post_thumbnail' ) ) :
	function phra_in_post_thumbnail($options=null) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
			?>
			<div class="post-thumbnail<?php echo isset($options["class"]) ? " $options[class]" : "" ?>"><?php
        the_post_thumbnail();
        
        $attach_id = get_post_thumbnail_id( get_the_ID() );
        $img_web = get_post_meta($attach_id,"web",true);
        $img_credit = get_post_meta($attach_id,"credit",true);
        if( !!$img_web ){
          echo '<span class="photo-credit"><a href="'.$img_web.'" target="_blank"><i class="fas fa-globe"></i>&nbsp;Photo Source</a></span>';
        } elseif( !!$img_credit ) {
          echo '<span class="photo-credit"><i class="far fa-camera"></i>&nbsp;'.$img_credit.'</span>';
        }
      ?></div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;
if ( ! function_exists( 'phra_in_posted_on' ) ) :
	function phra_in_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'phra_in' ),
			'<i class="fas fa-pencil"></i>&nbsp;<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	}
endif;
if ( ! function_exists( 'phra_in_posted_by' ) ) :
	function phra_in_posted_by() {
		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'phra_in' ),
			'<span class="author vcard"><i class="fas fa-user"></i>&nbsp;<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	}
endif;
if(!function_exists('phra_in_social_button')):
  $phra_in_social_script = false;
  function phra_in_social_button($post_id=null,$rt=false){
    $script = $GLOBALS["$phra_in_social_script"];
    $social_button = '';
    if($script==false){
      $social_button .= '<div id="fb-root"></div>
      <script>
      (function(d,s,id){
        var js,fjs=d.getElementsByTagName(s)[0];
        if(d.getElementById(id))return;
        js=d.createElement(s);
        js.id=id;
        js.src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=1850069591980854&autoLogAppEvents=1";
        fjs.parentNode.insertBefore(js,fjs)
      }(document,"script","facebook-jssdk"));
      window.twttr=(function(d,s,id){
        var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};
        if(d.getElementById(id))return t;
        js=d.createElement(s);js.id=id;
        js.src="https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js,fjs);
        t._e=[];t.ready=function(f){t._e.push(f)};
        return t
      }(document,"script","twitter-wjs"));
      </script>';
      $GLOBALS["$phra_in_social_script"] = true;
    }
    $post_id = $post_id ?: get_the_ID();
    $post = get_post($post_id, ARRAY_A);
    $actual_link = get_permalink($post_id);
    $social_button .= '<div class="social-buttons" style="display:flex;align-items:flex-start;">
      <!-- Facebook Comment & Share -->
      <div class="fb-share-button" data-href="'.$actual_link.'" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($actual_link).'&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>&nbsp;
      <!-- Line -->
      <div class="line-it-button" data-lang="en" data-type="share-a" data-url="'.$actual_link.'" style="display: none;"></div>&nbsp;
      <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
      <!-- Twitter -->
      <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text='.urlencode($post["post_title"]).'&url='.urlencode($actual_link).'" data-size="small">Tweet</a>&nbsp;
    </div>';
    if($rt){ return $social_button; } else { echo $social_button; }
  }
  function phra_in_facebook_comment(){
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo '<div class="fb-comments" data-href="'.$actual_link.'" data-width="100%" data-numposts="5"></div>';
  }
endif;