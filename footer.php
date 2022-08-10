<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CMK_Phra.in
 */

function get_menu_name($name){
  $theme_locations = get_nav_menu_locations();
  $navItems = wp_get_nav_menu_object($theme_locations[$name]);
  echo $navItems->name;
}
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container"><?php
    foreach(range(1,4) as $i){
      if(is_active_sidebar("footer-{$i}")){
        echo '<div class="footer-section-'.$i.'">';
        dynamic_sidebar("footer-{$i}");
        echo '</div>';
      }
    }
    ?></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
const body_class = <?php echo json_encode(get_body_class()); ?>;
function get_image_id(url){
  let exp = url.split(/%2F|\.s|\.m|\.l|\.jpg/i);
  if(!!exp[1] ? exp[1].length==32 : false){ return exp[1] } else { return false; }
}
function add_credit(v){
  let parent = $(v).parent();
  let url = $(v).attr("src");
  if(url.indexOf("firebasestorage")>-1){
    let id = get_image_id(url);
    if(!!id){
      firebase.database().ref(`photoDB/${id}`).once("value",snap=>{
        let photocredit = "";
        if(!!snap.val().web){
          photocredit = `<a href="${snap.val().web}" target="_blank"><i class="fas fa-globe"></i> Photo Source</a>`;
        } else if(!!snap.val().credit) {
          photocredit = `<i class="far fa-copyright"></i> ${snap.val().credit}`;
        }
        if(!!photocredit){
          parent.append(`<span class="photo-credit">${photocredit}</span>`);
          if(parent.css('position')=="static"){
            parent.css('position','relative');
            if(body_class.indexOf("single-post")){
              let img = new Image();
              img.onload = function(){
                parent.css({
                  "width":$(v).width() || "100%",
                  "max-width":"100%",
                  "margin":"0 auto",
                  "display": "block",
                });
                $(v).css({ "width":"100%", "height":"auto" });
              };
              img.src = $(v).attr("src");
            }
          }
        }
      });
    }
  }
}
</script>

<?php
$fb_app_id = get_theme_mod("fb_app_id",null);
$fb_msg_head = get_theme_mod("fb_msg_head",null);
if(!!$fb_app_id && !!$fb_msg_head){
  echo '<div id="fb-root"></div><script>window.fbAsyncInit=function(){FB.init({appId:"'.$fb_app_id.'",autoLogAppEvents:true,xfbml:true,version:"v2.11"});};</script>'.$fb_msg_head;
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>
