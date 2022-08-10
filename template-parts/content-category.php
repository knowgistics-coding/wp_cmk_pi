<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Thai_Studies_Chula
 */
if(function_exists(category_parse)==!1){
  function category_parse($post_id){
    $current = get_queried_object()->term_id;
    $list = array();
    foreach(get_the_category($post_id) as $cat){
      if($cat->term_id !== $current){
        $list[] = '<a href="'.get_category_link($cat->term_id).'" target="_blank">'.$cat->name.'</a>';
      }
    }
    echo implode(" | ",$list);
  }
}
?>
<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<td><?php the_title( '<a href="' . esc_url( get_permalink() ) . '" target="_blank" style="color:#333"><i class="fas fa-chevron-right" style="color:var(--hilight-color);"></i> ', '</a>' ); ?></td>
  <td><?php category_parse(get_the_ID()); ?></td>
</tr><!-- #post-<?php the_ID(); ?> -->