<?php
foreach(get_categories() as $cat){
  $category[] = array("label"=>$cat->cat_name,"value"=>$cat->term_id);
}
$query = get_posts(array('post_type'=>'any','post_status'=>'publish','numberposts'=>-1,'orderby'=>'post_title','order'=>'ASC'));
foreach($query as $post){ $posts[] = array("label"=>$post->post_title,"value"=>$post->ID); }
wp_die();
?>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<style>
.card { background:white;padding:1rem;border-radius:.25rem;padding:1rem;border:solid 1px #ddd; width:100%; max-width:480px; margin-right:1rem; }
.card>header { font-size:24px; text-align:center; margin-bottom:1.5rem; }
.flex { display:flex; align-items:center; margin-bottom:.25rem; }
.flex>*:not(:last-child){ margin-right:.25rem; }
.item-contain>span { border:solid 1px #ddd; border-radius:.25rem; padding:0 .25rem; display:inline-block; margin-right:.25rem; margin-bottom:.25rem; }
.item-contain>span>.dashicons { margin-left:.125rem; text-decoration:none; font-style:normal; cursor:pointer; font-size:16px; }
select,input { display:block; width:100%; }

table th, table td { padding:.25rem .5rem; }
</style>

<div style="padding:1rem;display:flex;flex-wrap:wrap;align-items:flex-start;" ng-app="main-app" ng-controller="main-ctrl">
  <!-- About -->
  <div class="card"><table border="1" style="border-collapse:collapse;width:100%;">
    <tr><th></th><th>Type</th><th>From</th><th>Items</th></tr>
    <tr ng-repeat="section in home.sections track by $index">
      <td><span class="dashicons dashicons-trash" ng-click="home.sections.splice($index,1);home.postAjax()" style="cursor:pointer;"></span></td>
      <td ng-bind="section.type"></td>
      <td ng-bind="section.from"></td>
      <td><span ng-repeat="item in section.items" ng-bind="item.label+($last?'':', ')"></span></td>
    </tr>
  </table></div>
  <!-- Control Box -->
  <div class="card">
    <header>Home Page Setting</header>
    <div class="flex">
      <select ng-model="home.type">
        <option value="slide">Slide</option>
        <option value="card">Card</option>
        <option value="cover">Cover</option>
        <option value="text">text</option>
        <option value="square">Square</option>
      </select>
    </div>
    <div class="flex">
      <select ng-model="home.from" ng-change="home.fromChange()">
        <option value="id">ID</option>
        <option value="category">Category</option>
      </select>
    </div>
    <div class="flex">
      <select ng-model="home.list">
        <option ng-repeat="list in home.lists" ng-value="list.value">{{ list.label }}</option>
      </select>
      <button class="button" ng-click="home.addArr()">Add</button>
    </div>
    <div class="item-contain">
      <span ng-repeat="(key,item) in home.items track by $index">
        <span ng-bind="item.label"></span>
        <span class="dashicons dashicons-trash" ng-click="home.items.splice(key,1)"></span>
      </span>
    </div>
    <button class="button button-primary" ng-click="home.saveSection()">Save</button>
  </div>
</div>

<script>
const lists = {
  id: <?php echo json_encode($posts); ?>,
  category: <?php echo json_encode($category); ?>,
};
const app = angular.module("main-app",[]);
app.controller("main-ctrl",["$scope","$sce",function($scope,$sce){
  $scope.home = new homeManage($scope,$sce);
}]);
function homeManage($scope,$sce){
  this.dList = lists; // List From Global Lists
  this.sections = <?php echo get_theme_mod("home_setting","[]"); ?>;
  const reset = ()=>{
    this.type = "slide";
    this.from = "category";
    this.lists = this.dList[this.from];
    this.items = [];
    
  };
  reset();
  this.fromChange = ()=>{this.items=[];this.lists=lists[this.from]};
  this.addArr = ()=>{
    if(!!this.list){
      let lists = {};
      Object.keys(this.lists).map(index=>{ lists[this.lists[index].value] =  this.lists[index].label });
      this.items.push({id:this.list,label:lists[this.list]});
      this.list = "";
    }
  };
  this.saveSection = ()=>{
    let section = { "type":this.type, "from":this.from, "items":this.items, };
    if(section.items.length>0){
      this.sections.push(section);
    }
    this.postAjax();
  };
  this.postAjax = ()=>{
    jQuery.post(ajaxurl,{action:"save_home_options",data:this.sections},res => {
      location.reload();
    });
  }
}
</script>