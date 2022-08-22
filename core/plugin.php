<?php
function get_complete_meta( $post_id, $meta_key ) {
  global $wpdb;
  $mid = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $meta_key) );
  if( $mid != '' )
    return $mid;

  return false;
}

function ajax_enqueuescripts() {
  wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', ajax_enqueuescripts);

// Home Setting
if(function_exists("phrain_theme_menu")==false){
  // Home Setting Menu
  function phrain_theme_menu(){
    add_menu_page("Phra.In Settine","Phra.in Setting","manage_options","phra_in_theme",'phra_in_theme_function',"dashicons-admin-appearance",'60');
  }
  add_action( 'admin_menu', 'phrain_theme_menu' );
  function phra_in_theme_function(){ include(__DIR__.'/pages/main.php'); }
  // Save Home Options
  function pi_theme_mod_change(){
    header('Content-Type: application/json');
    if(isset($_POST["data"])){
      $res = set_theme_mod($_POST["data"]["key"],$_POST["data"]["value"]);
      echo json_encode($res);
    }
    wp_die();
  }
  add_action('wp_ajax_pi_theme_mod_change','pi_theme_mod_change');
  add_action('wp_ajax_nopriv_pi_theme_mod_change','pi_theme_mod_change');
}

// Dynamic Setting
if(function_exists("phrain_dynamic_menu")==false){
  // Dynamic Setting Menu
  function phrain_dynamic_menu(){
    add_submenu_page("phra_in_theme","Dynamic Setting","Dynamic Setting","manage_options","dynamic_setting","phra_in_dynamic_function");
  }
  add_action( 'admin_menu', 'phrain_dynamic_menu' );
  function phra_in_dynamic_function(){ include(__DIR__.'/pages/dynamic.php'); }


  // Dynamic Page List
  function dynamic_page_list(){
    header('Content-Type: application/json');
    $query = get_posts(array('post_type'=>'page','numberposts'=>-1,'orderby'=>'post_title','order'=>'ASC'));
    foreach($query as $post){ $pages[] = array("label"=>$post->post_title,"value"=>$post->ID); }
    echo json_encode($pages);
    wp_die();
  }
  add_action('wp_ajax_dynamic_page_list','dynamic_page_list');
  add_action('wp_ajax_nopriv_dynamic_page_list','dynamic_page_list');


  // Dynamic Page Load
  function dynamic_page_load(){
    header('Content-Type: application/json');
    // $metas = get_post_meta($_POST["data"],'dnm_section');
    $metas = get_complete_meta($_POST["data"],'dnm_section');
    foreach($metas as $key=>$meta){ $metas[$key] = array( "value"=>json_decode($meta->meta_value,true), "prev_value"=>$meta->meta_value, "id"=>$meta->meta_id ); }
    echo json_encode($metas);
    wp_die();
  }
  add_action('wp_ajax_dynamic_page_load','dynamic_page_load');
  add_action('wp_ajax_nopriv_dynamic_page_load','dynamic_page_load');


  // Dynamic Items Load
  function dynamic_items_load(){
    $args = array(
      'hide_empty' => false,
    );
    foreach(get_categories($args) as $cat){
      $category[] = array("label"=>$cat->cat_name,"value"=>$cat->term_id);
    }
    $query = get_posts(array('post_type'=>'any','post_status'=>'publish','numberposts'=>-1,'orderby'=>'post_title','order'=>'ASC'));
    foreach($query as $post){ $posts[] = array("label"=>$post->post_title,"value"=>$post->ID); }
    echo json_encode(array("category"=>$category,"id"=>$posts));
    wp_die();
  }
  add_action('wp_ajax_dynamic_items_load','dynamic_items_load');
  add_action('wp_ajax_nopriv_dynamic_items_load','dynamic_items_load');

  // Dynamic Add
  function dynamic_add(){
    header('Content-Type: application/json');
    if(isset($_POST["data"]["section"]["prev_value"])){
      $prev_value = stripslashes($_POST["data"]["section"]["prev_value"]);
      $res = update_post_meta(
        $_POST["data"]["id"],
        "dnm_section",
        json_encode($_POST["data"]["section"]["value"],JSON_UNESCAPED_UNICODE),
        $prev_value
      );
      echo json_encode($res);
    } else {
      $res = add_post_meta($_POST["data"]["id"],"dnm_section",json_encode($_POST["data"]["section"]["value"],JSON_UNESCAPED_UNICODE));
      echo json_encode($res);
    }
    wp_die();
  }
  add_action('wp_ajax_dynamic_add','dynamic_add');
  add_action('wp_ajax_nopriv_dynamic_add','dynamic_add');


  // Dynamic Update
  function dynamic_update(){
    header('Content-Type: application/json');
    if(isset($_POST["data"]["section"]["prev_value"])){
      $prev_value = stripslashes($_POST["data"]["section"]["prev_value"]);
      $res = update_post_meta(
        $_POST["data"]["id"],
        "dnm_section",
        json_encode($_POST["data"]["section"]["value"],JSON_UNESCAPED_UNICODE),
        $prev_value
      );
      echo json_encode($res);
    } else {
      $res = add_post_meta($_POST["data"]["id"],"dnm_section",json_encode($_POST["data"]["section"]["value"],JSON_UNESCAPED_UNICODE));
      echo json_encode($res);
    }
    wp_die();
  }
  add_action('wp_ajax_dynamic_update','dynamic_update');
  add_action('wp_ajax_nopriv_dynamic_update','dynamic_update');

  // Dynamic Update
  function dynamic_panel_update(){
    header('Content-Type: application/json');
    $res = update_metadata_by_mid('post', $_POST["data"]["id"], json_encode($_POST["data"]["value"],JSON_UNESCAPED_UNICODE));
    echo json_encode($res);
    wp_die();
  }
  add_action('wp_ajax_dynamic_panel_update','dynamic_panel_update');
  add_action('wp_ajax_nopriv_dynamic_panel_update','dynamic_panel_update');


  // Dynamic Remove
  function dynamic_section_remove(){
    header('Content-Type: application/json');
    $res = delete_post_meta($_POST["data"]["id"],"dnm_section",$_POST["data"]["prev_value"]);
    echo json_encode($res);
    wp_die();
  }
  add_action('wp_ajax_dynamic_section_remove','dynamic_section_remove');
  add_action('wp_ajax_nopriv_dynamic_section_remove','dynamic_section_remove');

  // Dynamic Remove
  function dynamic_panel_remove(){
    header('Content-Type: application/json');
    $res = delete_metadata_by_mid('post', $_POST["data"]["id"]);
    echo json_encode($res);
    wp_die();
  }
  add_action('wp_ajax_dynamic_panel_remove','dynamic_panel_remove');
  add_action('wp_ajax_nopriv_dynamic_panel_remove','dynamic_panel_remove');
}
