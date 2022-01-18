<?php
/**
 * Template Name: Home
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

class Encyclopedia {
  public function __construct(){
    $posts = $this->query();
    $this->render($posts);
  }
  
  protected function render($posts){
    $this->EnhanceSearchBox();
    $this->EnhanceResult($posts);
    
    // $args = array(
    //   'parent'      => 2,
    //   'orderby'     => 'slug',
    //   'order'       => 'ASC',
    //   'hide_empty'  => false,
    // );
    // $categories = get_categories($args);
    // // echo '<pre>'; print_r($categories); echo '</pre>';
    // echo '<div class="shortcut-cat-search"><div class="container">';
    // foreach ($categories as $key => $cat) {
    //   echo '<a href="'.get_site_url().'/encyclopedia/?cat='.$cat->term_id.'" class="cat-link">';
    //   if(!!$cat->description){
    //     echo '<i class="big-icon far fa-'.$cat->description.'"></i>&nbsp;';
    //   }
    //   echo '<span>'.$cat->name.'</span>';
    //   echo '</a>';
    // }
    // echo '</div></div>';
      
  }
  
  protected function EnhanceSearchBox(){
    echo '<div class="cover-contain-md">
      '.get_the_post_thumbnail().'
      <div class="cover-meta" style="background-color:#faf7e8;padding: 1rem;">
        <h2 style="color:#333;font-family:\'Noto Sans JP\',\'Prompt\';font-weight:bold;">สารานุกรมวัฒนธรรมญี่ปุ่น<br />日本文化百科事典</h2>
        <form class="search-wrap-body" action="/encyclopedia/" method="post">
          <input
            type="text"
            name="search"
            placeholder="ค้นหา"
            autocomplete="off"
            required=""
            oninvalid="this.setCustomValidity(\'กรุณากรอกคำค้นหา\')"
          >
          <button class="btn-submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>';
  }
  
  protected function EnhanceResult($posts){
    if( isset($_POST['search']) ){
      echo '<div class="px-3 py-5">';
      echo '<h1 class="mb-3 text-center container" style="font-size: var(--font-l);">
        '.(
          $posts==null
            ? '<b>ไม่พบผลลัพท์ จากการค้นหาคำสำคัญ: `'.$_POST['search'].'`</b>'
            : '<b>ผลการค้นหาคำสำคัญ: `'.$_POST['search'].'`</b>'
        ).'
      </h1>';
    } elseif( isset($_GET['cat']) ) {
      $term = get_term( $_GET['cat'] );
      echo '<div class="px-3 py-5">';
      echo '<h1 class="mb-3 text-center container" style="font-size: var(--font-l);">
        '.(
          $posts==null
            ? '<b>ไม่พบผลลัพท์ จากการค้นหาหมวดหมู่: `'.$term->name.'`</b>'
            : '<b>ผลการค้นหาหมวดหมู่: `'.$term->name.'`</b>'
        ).'
      </h1>';
    } else {
      return false;
    }
    
    echo '<div class="container">
        <table id="result-table" class="table table-bordered table-sm">
          <tbody>';
    foreach($posts as $post){
      $titleBold = $post["post_title"];
      if(isset($_POST["search"])){
        $titleBold = str_ireplace($_POST["search"], "<b>$_POST[search]</b>", $titleBold);
      }
      echo '<tr id="post-'.$post["title"].'">
        <td>
          <a href="'.esc_url( get_permalink($post["ID"]) ).'" target="_blank" style="color:#333">
            <i class="fas fa-chevron-right" style="color:var(--blue);"></i> 
            '.$titleBold.'
          </a>
        </td>
      </tr>';
    }
    echo '</tbody>
        </table>
      </div>
    </div>';
  }
  
  protected function query(){
    if( isset($_POST['search']) ){
      $category = get_post_meta( get_the_ID(), 'cat', true );
      $args = array(
        "orderby"       => "post_title",
        "order"         => "ASC",
        "post_status"   => array('publish'),
        "category__in"  => [ $category ],
      );
      if(isset($_POST['search'])){
        $args["s"] = $_POST['search'];
      }
      $posts = wp_get_recent_posts($args, ARRAY_A);
      return $posts;
    } elseif( isset($_GET['cat']) ) {
      $args = array(
        "orderby"       => 'post_title',
        "order"         => "ASC",
        "post_status"   => array('publish'),
        "category__in"  => [ $_GET['cat'] ],
        "numberposts"	=> -1,
      );
      $posts = wp_get_recent_posts($args, ARRAY_A);
      return $posts;
      return $this->sortByTitle($posts);
    }
    return null;
  }
  
  protected function sortByTitle($posts){
    $test = uasort($posts, function ($a,$b) {
      print_r(strcmp($a["post_title"],$b["post_title"]));
      echo '<br>';
      return strcmp($a["post_title"],$b["post_title"]);
    });
    print_r($test);
    return array();
  }
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>
<style>
.search-wrap-body {
  border: solid 1px #333;
  display: flex;
  background-color: #fff;
}
.search-wrap-body input[type=text] {
  flex: 1;
  border: none;
  border-radius: 0;
  background: none;
  text-align: center;
  padding: .5rem;
  line-height: 1;
}
.search-wrap-body input[type=text]::placeholder {
  color: var(--hilight-color);
}
.search-wrap-body .btn-submit {
  border: none;
  background: none;
  color: var(--hilight-color);
}
#result-table,
#result-table td,
#result-table th {
  border-left: none;
  border-right: none;
}
.cover-meta {
  /* max-width: 480px; */
}
.shortcut-cat-search {
  margin: 3rem auto;
}
.shortcut-cat-search .container {
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-items: flex-start;
}
.shortcut-cat-search .cat-link {
  text-align: center;
  box-sizing: border-box;
  color: #333333;
  margin-right: 0.5rem;
  margin-bottom: 1.5rem;
  padding: 0.5rem;
  cursor: pointer;
  font-size: var(--font-m);
  font-family: "Noto Sans JP", Prompt;
  font-weight: bold;
}
.shortcut-cat-search .cat-link:hover {
  text-decoration: none;
}
.shortcut-cat-search .cat-link:hover span {
  text-decoration: underline;
}
.shortcut-cat-search .big-icon {
  color: #bfbfbf/*#2A445B*/;
  display: block;
  font-size: var(--font-xxl);
  margin-bottom: 1rem;
}
/* .card-container {
  padding: 0 0 3rem !important;
} */
.custom-text {
  background-color: white;
}
@media screen and (min-width: 992px){
  .shortcut-cat-search .cat-link {
    width: calc(100% / 5 - (2rem / 5));
  }
  .shortcut-cat-search .cat-link:nth-child(5n) {
    margin-right: 0;
  }
}
@media screen and (max-width: 991.98px) and (min-width: 768px){
  .shortcut-cat-search .cat-link {
    width: calc(100% / 4 - (1.5rem / 4));
  }
  .shortcut-cat-search .cat-link:nth-child(4n) {
    margin-right: 0;
  }
}
@media screen and (max-width: 767.98px) and (min-width: 576px){
  .shortcut-cat-search .cat-link {
    width: calc(100% / 3 - (1rem / 3));
  }
  .shortcut-cat-search .cat-link:nth-child(3n) {
    margin-right: 0;
  }
}
@media screen and (max-width: 575.98px){
  .shortcut-cat-search .cat-link {
    width: calc(100% / 2 - (0.5rem / 2));
  }
  .shortcut-cat-search .cat-link:nth-child(2n) {
    margin-right: 0;
  }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

    <?php $enc = new Encyclopedia(); ?>
		<?php new dnm_gen(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<script>$(function(){ $('.site-main img').each((k,v)=>{add_credit(v)}) });</script>
<?php
// get_sidebar();
get_footer();