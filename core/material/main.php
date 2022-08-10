<?php
if (function_exists("phrain_material") == false) {
  /**
   * MATERIAL MENU
   */
  function phrain_material_menu()
  {
    add_menu_page("Material", "Material", "manage_options", "phra_in_material", 'phra_in_material_function', "dashicons-admin-appearance", '60');
  }
  add_action('admin_menu', 'phrain_material_menu');
  /**
   * MATERIAL SETTING PAGE
   */
  function phra_in_material_function()
  {
    require_once get_template_directory() . "/core/material/setting.php";
  }

  /**
   * 
   * 
   * 
   * 
   * QUERY ZONE
   * 
   * 
   * 
   * 
   */
  // QUERY PAGES, POSTS AND CATEGORIES
  function material_page_list()
  {
    header('Content-Type: application/json');
    $pages = get_pages(array(
      'meta_key' => '_wp_page_template',
      'meta_value' => 'page-material.php'
    ));
    $categories = get_categories(array('hide_empty' => false));
    $posts = get_posts(array('post_type' => 'any', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'post_title', 'order' => 'ASC'));
    echo json_encode(array("posts" => $posts, "categories" => $categories, "pages" => $pages), JSON_UNESCAPED_UNICODE);
    wp_die();
  }
  add_action('wp_ajax_material_page_list', 'material_page_list');
  // GET POST META
  function material_page_data()
  {
    header('Content-Type: application/json');
    $data = get_post_meta($_GET["id"], "phrain_material");
    echo json_encode($data[0]);
    wp_die();
  }
  add_action('wp_ajax_material_page_data', 'material_page_data');
  // UPDATE POST META
  function material_update()
  {
    header('Content-Type: application/json');
    if (isset($_POST["data"]["value"]) && isset($_POST["data"]["id"])) {
      $res = update_post_meta(
        $_POST["data"]["id"],
        "phrain_material",
        $_POST["data"]["value"]
      );
      echo json_encode($res);
    } else {
      echo json_encode(array("error" => "data or id not found"), JSON_UNESCAPED_UNICODE);
    }
    wp_die();
  }
  add_action('wp_ajax_material_update', 'material_update');
  add_action('wp_ajax_nopriv_material_update','material_update');
}
