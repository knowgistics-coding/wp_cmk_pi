<?php
function render_hignlight_css()
{
  echo '<style>
  .dnm-highlight-container {
    max-width: 720px;
  }
  .dnm-highlight {
    display: block;
    position: relative;
    background-color: white;
    color: #333;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 0 0 rgba(0,0,0,0);
  }
  .dnm-highlight:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 8px rgba(0,0,0,0.125);
  }
  .dnm-highlight:before {
    content: "";
    display: block;
    padding-top: calc(100% / 2);
  }
  .dnm-highlight:not(:last-child) {
    margin-bottom: 1rem;
  }
  .dnm-highlight>div {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    border: solid 1px #DDD;
  }
  .dnm-highlight .thumbnail {
    flex: 1;
    background-position: center center;
    background-size: cover;
    filter: brightness(90%);
  }
  .dnm-highlight .content {
    flex: 1;
    box-sizing: border-box;
    border-style: solid;
    border-width: 0 1.5rem;
    border-color: transparent;
    text-align: center;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .dnm-highlight .content h1 {
    font-size:var(--font-xxl, 48px);
  } 
  .dnm-highlight .content img {
    display: none;
  }
  .dnm-highlight .content .body {
    font-size: var(--font-l);
  }
  @media screen and (max-width: 960px) and (min-width: 768px){
    .dnm-highlight .content h1 {
      font-size:var(--font-xl);
    }
    .dnm-highlight .content .body {
      font-size: var(--font-m);
    }
  }
  @media screen and (max-width: 767.99px){
    .dnm-highlight>div {
      flex-direction: column;
    }
    .dnm-highlight:before {
      padding-top: calc(100% * 2);
    }
    .dnm-highlight .content h1 {
      font-size:var(--font-xl);
    }
    .dnm-highlight .content .body {
      font-size: var(--font-m);
    }
  }
  </style>';
}
function render_hignlight($post)
{
  $secondary = get_post_meta($post["ID"], 'phrain_secondaryTitle');
  $author = get_post_meta($post["ID"], 'phrain_author');
  echo '<div class="dnm-highlight" onclick="' . (count($author) > 0 ? 'window.location.href=\'' . esc_url($author[0]) . '\'' : "") . '">
    <div>
      <div class="thumbnail" style="background-image:url(\'' . $post["get_thumbnail"] . '\')"></div>
      <div class="content">
        <div class="mb-3">
          <h1 style="color:#EA4335"><b>' . $post["post_title"] . '</b></h1>
          ' . (count($secondary) > 0 ? '<h1>' . esc_html($secondary[0]) . '</h1>' : ``) . '
        </div>
        <div class="body">' . ($post["post_content"]) . '</div>
      </div>
    </div>
  </div>';
}