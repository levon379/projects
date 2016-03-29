<div class="col-xs-12" ng-if="company.errors.length">
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p ng-repeat="error in company.errors">{{error}}</p>
    </div>
</div>
<div class="clearfix"></div>
<div class="panel panel-gridview panel-default">
    <div ng-show="content_loading" class="background-overlay"></div>
    <!-- Default panel contents -->
    <div class="panel-heading">
        <strong>Companies</strong>
        <a ui-sref="create" class="pull-right green" data-toggle="tooltip" data-placement="top" title="Create company"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
    </div>
    <div class="panel-body">
        <!-- Table -->
        <table class="table" ng-show="!content_loading && company.listData.models.length">
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Create date</td>
                <td></td>
            </tr>
            <tr ng-repeat="item in company.listData.models">
                <td>{{item.id}}</td>
                <td><a ui-sref="update({companyId: item.id})">{{item.name}}</a></td>
                <td>{{item.date * 1000 | date:"h:mm:ss a 'on' d/MM/yyyy"}}</td>
                <td><a href="#" class="red"><i class="fa fa-times" ng-click="delete(item, $index)"></i></a></td>
            </tr>
        </table>
        <div ng-show="!company.listData.models.length">You have no companies yet. You can <a ui-sref="create">add this one.</a></div>
    </div>
    <div ng-show="!content_loading && pagination.total > pagination.perPage">
        <gridpagin total="{{pagination.total}}" perpage="{{pagination.perPage}}"></gridpagin>
    </div>

</div>