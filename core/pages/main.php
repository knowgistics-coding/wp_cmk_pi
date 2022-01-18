<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<div class="container d-flex flex-wrap align-items-start p-3">
  <div class="card p-0" style="max-width:320px;width:100%;margin:.5rem;">
    <div class="card-body">
      <h5 class="card-title">MastHead</h5>
      <div class="form-group">
        <label><input class="form-control" type="checkbox"
          <?php echo get_theme_mod("masthead_search_display","true")=="true" ? "checked" : "" ; ?>
          onchange="mod_change('masthead_search_display',jQuery(this).is(':checked'))">
          <span>แสดงปุ่ม "ค้นหา"</span>
        </label>
      </div>
    </div>
  </div>
  <div class="card p-0" style="max-width:320px;width:100%;margin:.5rem;">
    <div class="card-body">
      <h5 class="card-title">About</h5>
      <div class="form-group">
        <input class="form-control" value="<?php echo get_theme_mod("colophon_address_title",""); ?>" onchange="mod_change('colophon_address_title',this.value)">
        <small class="form-text text-muted">Address Title</small>
      </div><div class="form-group">
        <textarea class="form-control" rows="5" onchange="mod_change('colophon_address',this.value)"><?php echo get_theme_mod("colophon_address",""); ?></textarea>
        <small class="form-text text-muted">Address</small>
      </div><div class="form-group">
        <input class="form-control" value="<?php echo get_theme_mod("colophon_map",""); ?>" onchange="mod_change('colophon_map',this.value)">
        <small class="form-text text-muted">Map Link</small>
      </div><div class="form-group">
        <input class="form-control" value="<?php echo get_theme_mod("colophon_facebook",""); ?>" onchange="mod_change('colophon_facebook',this.value)">
        <small class="form-text text-muted">facebook Link</small>
      </div>
    </div>
  </div>
</div>

<script>
function mod_change(key,value){
  jQuery.post(ajaxurl,{
    action:"pi_theme_mod_change",
    data:{ key:key, value:value },
  },(res)=>{
    // console.log(res);
    let rand_id = Math.floor((Math.random()*100)+1);
    jQuery('.container').append('<div id="alert-'+rand_id+'" class="saved" style="position:fixed;bottom:1rem;right:1rem;background-color:rgba(255,255,255,0.9);z-index:999;border:solid 1px #ccc; padding:.25rem .5rem;display:block;border-radius:.25rem;font-size:12px;"><span class="dashicons dashicons-yes"></span>&nbsp;Saved</div>');
    setTimeout(()=>{ jQuery('#alert-'+rand_id).remove(); },1500);
  });
}
</script>