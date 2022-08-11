<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<style>
  @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css");

  .dashicons-btn {
    cursor: pointer;
  }
</style>

<section ng-app="main-app" ng-controller="main-ctrl" class="p-2 py-5">
  <div class="container">
    <div class="row pb-4">
      <div class="col">
        <select class="form-control form-control-lg" ng-model="mat.pageId" ng-change="mat.pageChange()">
          <option value="">-- Select Page --</option>
          <option ng-repeat="page in mat.state.pages" ng-value={{page.ID}}>{{page.post_name}} (ID: {{page.ID}})</option>
        </select>
      </div>
    </div>
    <div class="row mb-3" ng-repeat="(index,item) in mat.items">
      <!-- START REPEAT (mat.items) -->
      <div class="col-2">
        #{{index+1}}
        <span class="dashicons dashicons-btn dashicons-admin-settings" ng-click="mat.editItem(index)"></span>
        <span class="dashicons dashicons-btn dashicons-trash" ng-click="mat.removeItem(index)"></span>
      </div>
      <div class="col-10">
        <div ng-if="mat.store.edit === index">
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-control" id="formFile" ng-model="item.type">
              <option value="">-- Select Type --</option>
              <option value="slide">Slide</option>
              <option value="card">Card</option>
              <option value="cover">Cover</option>
              <option value="text">Text</option>
              <option value="square">Square</option>
              <option value="cardslide">Card Slide</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">From</label>
            <select class="form-control" ng-model="item.from">
              <option value="">-- Select From --</option>
              <option value="category">Category</option>
              <option value="id">ID</option>
            </select>
          </div>
          <div class="mb-3" ng-if="!!item.from">
            <div style="display:flex;">
              <div>
                <label for="exampleDataList" class="form-label">Items</label>
                <div style="display:flex;align-items:center">
                  <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." ng-disabled="!item.from" ng-model="mat.store.select">
                  &nbsp;
                  <button class="btn btn-outline-secondary" ng-click="mat.addToItem(item.from, index)" style="width:15ch">Add Item</button>
                </div>
                <datalist id="datalistOptions">
                  <option ng-repeat="opt in mat.state[item.from]" ng-value="{{opt.value}}" ng-bind="opt.label"></option>
                </datalist>
                <small class="form-text text-muted">Select item and Click Add Item</small>
              </div>
            </div>
            <ul class="list-group mt-2" ng-if="!!item.items.length">
              <li class="list-group-item d-flex align-items-center mb-0" ng-repeat="(iindex,opt) in item.items">
                <span class="dashicons dashicons-btn dashicons-trash" style="margin-right:0.5rem" ng-click="mat.removeItemItems(index, iindex)"></span>
                &nbsp;
                <span>{{opt.label}} (ID: {{opt.id}})</span>
              </li>
            </ul>
          </div>
          <div class="mb-1">
            <label class="form-label">Amount</label>
            <input class="form-control form-control-sm" type="number" ng-model="item.amount">
            <small class="form-text text-muted">Item amount per Section (set to -1 for all items)</small>
          </div>
          <div class="mb-1">
            <label class="form-label">Label</label>
            <input class="form-control form-control-sm" type="number" ng-model="item.label">
            <small class="form-text text-muted">Label of section</small>
          </div>
          <div>
            <button class="btn btn-primary" ng-click="mat.editItem(-1)">Done</button>
          </div>
        </div>
        <div ng-if="mat.store.edit !== index">
          <div ng-repeat="(key,value) in item">{{key}}: {{value}}</div>
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-11"></div>
    </div> <!-- End Repeat (mat.items) -->
    <div class="row mt-5" ng-if="mat.pageId !== ''">
      <div class="col">
        <button class="btn btn-outline-secondary" ng-click="mat.addItem()">Add</button>
        <button class="btn btn-outline-primary" ng-click="mat.save()">Save</button>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/core/material/material.js?time=202208111559"></script>
<script>
  const app = angular.module("main-app", []);
  app.controller("main-ctrl", ["$scope", "$sce", function($scope, $sce) {
    $scope.mat = new Material($scope);
    $scope.mat.init();
  }]);
</script>