<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<style>
  @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');

  .badge-pill {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 120px;
  }

  .dashicons {
    font-size: inherit;
    width: 12px;
    height: 12px;
    cursor: pointer;
  }
</style>

<div class="container py-5" ng-app="main-app" ng-controller="main-ctrl">
  <div class="spinner-border text-primary" role="status" ng-if="dnm.loading">
    <span class="visually-hidden">Loading...</span>
  </div><!-- Loading -->
  <div ng-if="!dnm.loading">
    <div class="d-flex">
      <select class="form-select" ng-model="dnm.page" ng-change="dnm.onPageChange()">
        <option value="">-- เลือก Page --</option>
        <option ng-repeat="page in dnm.pages track by $index" ng-value="{{page.value}}" ng-bind="page.label"></option>
      </select>
      <a class="btn btn-outline-secondary" ng-href="{{dnm.getViewLink('<?php echo get_site_url(); ?>')}}" target="_blank" ng-if="!!dnm.page" style="margin-left:0.5rem">
        View
      </a>
    </div>
    <table class="table table-sm mt-5" ng-if="dnm.isTableVisible()">
      <tr ng-repeat="panel in dnm.panels track by $index">
        <td style="width:60px;">
          <span class="dashicons dashicons-admin-settings" ng-click="dnm.onEditPanel($index)"></span>
          <span class="dashicons dashicons-trash" ng-click="dnm.onRemovePanel(panel.id)"></span>
        </td>
        <td>
          <div ng-repeat="(key,value) in panel.value">
            <strong ng-bind="key.toUpperCase()"></strong>:&nbsp;<span ng-bind="value"></span>
          </div>
        </td>
      </tr>
    </table>
    <div><button class="btn btn-outline-primary btn-size-small" ng-click="dnm.onAddSection()">Add Section</button></div>
    <div ng-if="dnm.isEditVisible()">
      <h6 class="card-subtitle mt-5 mb-2 text-muted">Edit Section</h6>
      <table class="table" style="width:100%">
        <tr>
          <td>Type</td>
          <td width="100%"><select class="form-control" ng-model="dnm.editValue.type">
              <option value="slide">Slide</option>
              <option value="card">Card</option>
              <option value="cover">Cover</option>
              <option value="text">Text</option>
              <option value="square">Square</option>
              <option value="cardslide">Card Slide</option>
              <option value="highlight">Highlight</option>
              <option value="jpaenc">สารานุกรม (only JP-Arts)</option>
            </select></td>
        </tr>
        <tr>
          <td>From</td>
          <td><select class="form-control" ng-model="dnm.editValue.from" ng-change="dnm.onEditChangeFrom()">
              <option value="category">Category</option>
              <option value="id">ID</option>
            </select></td>
        </tr>
        <tr>
          <td>Items</td>
          <td>
            <div class="d-flex align-items-center">
              <div>
                <label for="exampleDataList" class="form-label">เลือก item และกด Add Item</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." ng-disabled="!dnm.editValue.from" ng-model="dnm.editItemSelect">
                <datalist id="datalistOptions">
                  <option ng-repeat="item in dnm.items[dnm.editValue.from]" ng-value="{{item.value}}" ng-bind="item.label"></option>
                  <option value="San Francisco">
                  <option value="New York">
                  <option value="Seattle">
                  <option value="Los Angeles">
                  <option value="Chicago">
                </datalist>
              </div>
              <div class="flex-grow-1"></div>
              <button class="btn btn-outline-secondary" ng-if="!!dnm.editItemSelect" ng-click="dnm.onAddItem()">Add Item</button>
            </div>
            <ul class="list-group mt-2" ng-if="!!dnm.editValue.items.length">
              <li class="list-group-item d-flex align-items-center mb-0" ng-repeat="item in dnm.editValue.items">
                <span class="dashicons dashicons-trash" style="margin-right:0.5rem" ng-click="dnm.onRemoveItem(item.id)"></span>
                &nbsp;
                <span>({{item.id}}) {{item.label}}</span>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <td>Num:</td>
          <td>
            <input class="form-control form-control-sm" type="number" ng-model="dnm.editValue.num">
            <small class="form-text text-muted">จำนวน Post ต่อ Section</small>
          </td>
        </tr>
        <tr>
          <td>Label:</td>
          <td>
            <input class="form-control form-control-sm" type="text" ng-model="dnm.editValue.label">
            <small class="form-text text-muted">ชื่อหัวเรื่อง สำหรับ Type Card</small>
          </td>
        </tr>
        <tr>
          <td>Order:</td>
          <td>
            <select class="form-control" ng-model="dnm.editValue.orderby">
              <option value="">-- select order --</option>
              <option value="title">Title</option>
              <option value="date">Date</option>
              <option value="modified">Modified</option>
            </select>
            <select class="form-control" ng-model="dnm.editValue.order">
              <option value="">-- select sort --</option>
              <option value="ASC">ASC</option>
              <option value="DESC">DESC</option>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <button class="btn btn-outline-primary" ng-click="dnm.onSave()">Save</button>
            <button class="btn btn-outline-secondary" ng-click="dnm.onEditCancel()">Cancel</button>
          </td>
        </tr>
      </table>
    </div>
  </div><!-- IF !dnm.loading -->
</div>

<script src="<?php echo get_template_directory_uri() . "/core/pages/dynamic/class.js?time=" . time(); ?>"></script>
<script>
  const app = angular.module("main-app", []);
  app.controller("main-ctrl", ["$scope", "$sce", async function($scope, $sce) {
    $scope.dnm = new Dynamic(() => $scope.$apply());
    $scope.dnm.pageLoad()
  }]);
</script>

<!-- milkkuntiranont@gmail.com -->