<div ng-app="companyApp">
    <div ng-show="loading" class="col-xs-12">
        <span class="word-preloader"></span>
    </div>
    <div ng-hide="loading" ng-switch="statusCode" class="col-md-12 company-container">
        <div ng-switch-when="200">
            <div ui-view></div>
        </div>
        <div ng-switch-when="403">
            <div ng-repeat="error in errors" ng-cloak ng-show="hasError" class="alert alert-warning" role="alert">
                <span class="glyphicon glyphicon-warning-sign pull-left" aria-hidden="true"><strong>Warning:&nbsp;</strong></span>
                <div ng-bind-html="error"></div>
            </div>
        </div>
        <div ng-switch-when="500">
            <div ng-cloak class="alert alert-danger" role="alert">
                <p>Unknown error occurred</p>
            </div>
        </div>
    </div>
</div>