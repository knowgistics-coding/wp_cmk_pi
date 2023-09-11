<?php
require_once(get_template_directory() . "/core/elem/encyclomedia.php");
require_once(get_template_directory() . "/core/elem/highlight.php");

class DNM
{
  /* =============================================
  # QUERY POSTS
  ============================================= */
  protected function query($section)
  {
    $posttype = array_diff(array_values(get_post_types()), array("page", "attachment", "revision", "nav_menu_item", "custom_css", "customize_changeset", "oembed_cache", "user_request", "wp_block"));
    $args = array(
      'numberposts'       => isset($section["num"]) ? $section["num"] : 8,
      'orderby'           => isset($section["orderby"]) ? $section["orderby"] : 'post_date',
      'order'             => isset($section["order"]) ? $section["order"] : 'DESC',
      'post_type'         => $posttype,
      'post_status'       => array('publish', 'private'),
    );
    if (isset($section["thumbnail"])) {
      $args['meta_query'] = array(array('key' => '_thumbnail_id'));
    }
    if ($section["from"] == "category" && !empty($section["items"])) { // By Category
      foreach ($section["items"] as $item) {
        $args["category__in"][] = $item["id"] ?: $item;
      }
      return wp_get_recent_posts($args, ARRAY_A);
    } elseif ($section["from"] == "id" && !empty($section["items"])) { // By ID
      $posts = array();
      foreach ($section["items"] as $item) {
        $posts[] = get_post($item["id"], ARRAY_A);
      }
      return $posts;
    } else {
      return wp_get_recent_posts($args, ARRAY_A);
    }
  }
  /* =============================================
  # Generate Sections
  ============================================= */
  public function slide($posts, $section)
  {
    $id = $this->rand_id();
    $slides = '';
    foreach ($posts as $post) {
      $post = $this->get_thumbnail($post, "post-thumbnail");
      $slides .= '<div class="swiper-slide">
        ' . $post["thumbnail"] . '
        <div class="cover-meta">
          <div class="catag">' . implode(" | ", $this->get_post_category_link($post["ID"])) . '</div>
          <h2>' . $post["post_title"] . '</h2>
          <div class="readmore"><a href="' . get_permalink($post["ID"]) . '?skip" target="_blank">
            <div class="th">อ่านต่อ</div>
            <div class="en">READ MORE</div>
          </a></div>
        </div>
      </div>';
    }
    echo '<div class="slide-container cover-contain-lg"><div id="' . $id . '" class="swiper-container">
      <div class="swiper-wrapper">' . $slides . '</div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div></div>
    <script>
    var mySwiper = new Swiper ("#' . $id . '", {speed:600,loop:!0,centeredSlides:!0,grabCursor:!0,lazy:!0,autoplay:{delay:5000,disableOnInteraction:!1,},pagination:{el:".swiper-pagination",dynamicBullets:!0,},navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev",},scrollbar:{el:".swiper-scrollbar"},});
    </script>';
  }
  public function text($posts, $section)
  {
    foreach ($posts as $key => $post) {
      echo '<div class="custom-text"><div class="container">' . $post["post_content"] . '</div></div>';
    }
  }
  public function card($posts, $section)
  {
    echo '<style>
    .text-clamp {
      /*
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      */
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    </style>';
    echo '<div class="card-container">
      ' . (isset($section["label"]) ? '<h2 style="text-align:center;font-weight:bold;margin-bottom:36px;font-size:var(--font-xxl);">' . $section["label"] . '</h2>' : '') . '
      <div class="container wrap">';
    foreach ($posts as $key => $post) {
      $post = $this->get_thumbnail($post, "medium");
      $secondary = get_post_meta($post["ID"], 'phrain_secondaryTitle');
      echo '<div class="custom-card">
        <a class="post-thumbnail" href="' . get_permalink($post["ID"]) . '" target="_blank" style="filter:brightness(95%)">' . ($post["thumbnail"] ?: '') . '</a>
        <div class="entry-content"><div class="inner">
          <h2><a href="' . get_permalink($post["ID"]) . '" target="_blank" title="' . strip_tags(preg_replace("/\"|\'/", "", $post["post_title"])) . '">
            ' . $this->slice_text($post["post_title"], null, 50) . '
            ' . (count($secondary) > 0 ? '<span class="text-clamp" style="display:block;font-weight:normal;">' . $secondary[0] . '</span>' : '') . '
          </a></h2>
          <div class="category">' . implode(" | ", $this->get_post_category_link($post["ID"])) . '</div>
        </div></div>
      </div>';
    }
    echo '</div></div>';
  }
  public function cover($posts, $section)
  {
    foreach ($posts as $key => $post) {
      $post = $this->get_thumbnail($post, "full");
      echo '<div class="cover-contain-md">
        ' . ($post["thumbnail"] ?: '') . '
        <div class="cover-meta">
          <div class="catag">' . implode(" | ", $this->get_post_category_link($post["ID"])) . '</div>
          <h2>' . $post["post_title"] . '</h2>
          <div class="readmore"><a href="' . get_permalink($post["ID"]) . '?skip" target="_blank">
            <div class="th">อ่านต่อ</div>
            <div class="en">READ MORE</div>
          </a></div>
        </div>
      </div>';
    }
  }
  public function square($posts, $section)
  {
    echo '<div class="square-container">';
    foreach ($posts as $key => $post) {
      $post = $this->get_thumbnail($post, "large");
      echo '<div class="square">
        ' . ($post["thumbnail"]) . '
        <a class="cover-meta" href="' . get_permalink($post["ID"]) . '?skip" target="_blank">
          <h2>' . $this->slice_text($post["post_title"]) . '</h2>
        </a>
      </div>';
    }
    echo '</div>';
  }
  public function cardslide($posts, $section)
  {
    $id = $this->rand_id();
    $slides = '';
    foreach ($posts as $post) {
      $post = $this->get_thumbnail($post, "post-thumbnail");
      $slides .= '<div class="swiper-slide">
        <div class="swiper-card">
          <div class="inner">
            ' . $post["thumbnail"] . '
            <div class="content">
              <a
                class="card-title"
                href="' . get_permalink($post["ID"]) . '"
                target="_blank"
                title="' . strip_tags(preg_replace("/\"|\'/", "", $post["post_title"])) . '"
              >
                ' . $this->icon[$post["post_type"]] . ' ' . $this->slice_text($post["post_title"], null, 50) . '
              </a>
              <div class="category">
                ' . implode(" | ", $this->get_post_category_link($post["ID"])) . '
              </div>
            </div>
          </div>
        </div>
      </div>';
    }
    echo '<div class="card-slide-container">
      ' . (isset($section["label"]) ? '<h2 style="text-align:center;font-weight:bold;margin-bottom:36px;">' . $section["label"] . '</h2>' : '') . '
      <div class="wrapper">
        <div id="' . $id . '" class="swiper">
          <div class="swiper-wrapper">' . $slides . '</div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
    <script>
      new Swiper("#' . $id . '", {
        slidesPerView: 4,
        spaceBetween: 10,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    </script>';
  }
  public function highlight($posts, $section)
  {
    if (count($posts)) {
      render_hignlight_css();
      echo '<div class="container px-3 py-5">';
      foreach ($posts as $post) {
        echo render_hignlight($this->get_thumbnail($post));
      }
      echo '</div>';
    }
  }
  public function jpaenc($posts, $section)
  {
    if (count($posts) > 0) {
      $post = $this->get_thumbnail($posts[0], "full");
      render_jp_encyclopedia_searchbox($post["get_thumbnail"]);
    }
  }

  /* =============================================
  # Other Functions
  ============================================= */
  protected function get_thumbnail($post, $size = null)
  {
    $img_thumb = get_the_post_thumbnail($post["ID"], $size);
    if (!!$img_thumb) {
      $web = get_post_meta(get_post_thumbnail_id($post["ID"]), "web", true);
      $credit = get_post_meta(get_post_thumbnail_id($post["ID"]), "credit", true);
      $photoCredit = '';
      if (!!$web) {
        $photoCredit = '<span class="photo-credit"><a href="' . $web . '" target="_blank"><i class="fas fa-globe"></i>&nbsp;Photo Source</a></span>';
      } elseif (!!$credit) {
        $photoCredit = '<span class="photo-credit"><i class="far fa-camera"></i> ' . $credit . '</span>';
      }
      $post["thumbnail"] = $img_thumb . $photoCredit;
      $post["get_thumbnail"] = get_the_post_thumbnail_url($post["ID"], $size);
    } elseif (isset($post["post_content"])) {
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post["post_content"], $matches);
      $first_img = $matches[1][0];
      if (!empty($first_img)) {
        $post["thumbnail"] = '<img src="' . $first_img . '">';
        $post["get_thumbnail"] = $first_img;
      }
    }
    if (!!$post["thumbnail"] == false) {
      $post["thumbnail"] = '<img src="' . get_template_directory_uri() . '/assets/imgs/sakura.jpeg">';
      $post["get_thumbnail"] = get_template_directory_uri() . '/assets/imgs/sakura.jpeg'; // no-image
    }
    return $post;
  }
  protected function rand_id()
  {
    $str = hash("sha256", rand(1, 1000000));
    return substr($str, 0, 6);
  }
  protected function get_post_category_link($id)
  {
    if (get_theme_mod("toggle_category", true) == false) {
      return array();
    }
    $post_cats = wp_get_post_categories($id);
    $cats = array();
    foreach ($post_cats as $post_cat) {
      $cat = get_category($post_cat, ARRAY_A);
      $cats[] = '<a href="' . get_category_link($cat["term_id"]) . '" target="_blank">' . $cat["name"] . '</a>';
    }
    return $cats;
  }
  public function slice_text($text, $start = 0, $num = 64)
  {
    if (mb_strlen($text, 'UTF-8') <= $num) {
      return $text;
    } else {
      return iconv_substr($text, $start, $num, "UTF-8") . "...";
    }
  }
}
class dnm_gen extends DNM
{
  public function __construct()
  {
    $sections = get_post_meta(get_the_ID(), "dnm_section");
    if (!empty($sections)) {
      echo '<script>window.sections = '.json_encode(array_map(function($row){
        return json_decode($row, true);
      }, $sections)).';</script>';
      foreach ($sections as $json_section) {
        $section = json_decode($json_section, true);
        $posts = $this->query($section);
        if (method_exists($this, $section["type"]) && !empty($posts)) {
          $type = "$section[type]";
          $this->$type($posts, $section);
        } else {
          echo '<script>console.log("No Section: ' . $section["type"] . '");</script>';
        }
      }
    }
  }
}
class home_gen extends DNM
{
  public function __construct()
  {
    $json_home_setting = get_theme_mod("home_setting", "[]");
    $home_setting = json_decode($json_home_setting, true);
    if (!empty($home_setting)) {
      foreach ($home_setting as $section) {
        $posts = $this->query($section);
        if (method_exists($this, $section["type"]) && !empty($posts)) {
          $this->$section["type"]($posts, $section);
        } else {
          echo '<script>console.log("No Section: ' . $section["type"] . '");</script>';
        }
      }
    }
  }
  protected function query($section)
  {
    $args = array(
      'numberposts'       => $section["num"] ?: 8,
      'orderby'           => $section["orderby"] ?: 'post_date',
      'order'             => $section["orderby"] ?: 'DESC',
      'post_type'         => "any",
      'post_status'       => array('publish', 'private'),
    );
    if (isset($section["thumbnail"])) {
      $args['meta_query'] = array(array('key' => '_thumbnail_id'));
    }
    // By Category
    if ($section["from"] == "category" && !empty($section["items"])) {
      foreach ($section["items"] as $item) {
        $args["category__in"][] = $item["id"];
      }
      return wp_get_recent_posts($args, ARRAY_A);
    }
    // By ID
    if ($section["from"] == "id" && !empty($section["items"])) {
      $posts = array();
      foreach ($section["items"] as $item) {
        $posts[] = get_post($item["id"], ARRAY_A);
      }
      return $posts;
    }
  }
}
