<div ng-app="notifApp">
    <div ng-controller="notifCtrl">
        <!--        <ng-view></ng-view>-->
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 notifications">
            <div ng-show="loading" class="background-overlay"></div>
            <h1 class="text-center">Your notifications</h1>
            <hr/><br/>
            <div class="list-group">
                <div class="notification list-group-item" ng-repeat="notification in notifications">
                    <div class="row">
                        <span class="date col-lg-3 col-md-3 col-xs-3 col-sm-3" ng-bind="notification.date * 1000 | date:'yyyy-MM-dd HH:mm:ss'"></span>
                        <a class="col-lg-8 col-md-8 col-xs-8 col-sm-8" href="{{notification.uri}}" ng-click="see_behavior($index, notification.id)"><span class="message" ng-bind="notification.message"></span></a>
                        <a class="delete col-lg-1 col-md-1 col-xs-1 col-sm-1" href="#" ng-click="delete($index, notification.id)"><i class="green glyphicon glyphicon-ok-sign"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div ng-show="!loading && pagination.total > 10" class="col-md-12 col-xs-12 col-ms-12">
            <uib-pagination total-items="pagination.total" ng-model="pagination.current" max-size="pagination.maxSize" class="pagination-sm" boundary-links="true" rotate="false" num-pages="numPages"></uib-pagination>
            <pre>Page: <span ng-bind="pagination.current"></span> / <span ng-bind="numPages"></span></pre>
        </div>
    </div>
</div>