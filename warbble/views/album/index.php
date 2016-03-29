<div ng-app="albumApp">
    <div ng-controller="AlbumCtrl">
<!--        <ng-view></ng-view>-->
        <div ng-if="attachments.length" class="col-md-12 attachments">
            <div ng-show="loading" class="background-overlay"></div>
            <div class="attachment" ng-repeat="attachment in attachments">
                <div class="image">
                    <a href="#" class="red delete" ng-click="delete($index, attachment.id)"><i class="fa fa-times-circle-o"></i></a>
                    <img ng-src="{{'/'+attachment.uri}}" alt="">
                </div>
            </div>
        </div>
        <h3 ng-if="!attachments.length">No items</h3>
        <div ng-show="!loading && pagination.total > 10" class="col-md-12 col-xs-12 col-ms-12">
            <uib-pagination total-items="pagination.total" ng-model="pagination.current" max-size="pagination.maxSize" class="pagination-sm" boundary-links="true" rotate="false" num-pages="numPages"></uib-pagination>
            <pre>Page: {{pagination.current}} / {{ numPages }}</pre>
        </div>
    </div>
</div>