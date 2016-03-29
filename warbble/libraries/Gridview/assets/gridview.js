var OGridview = function(config) {
    var that = this;

    that.selector    = config.selector,
    that.overlay     = false,
    that.config      = config,

    that.init_pagination = function(){
        $('.pagination-' + that.config.action).bootpag({
            total: config.total,
            maxVisible: 10,
            page: config.page,
        }).on("page", function(event, page){
            that.goto(page)
        });
    };

    that.goto = function(page){
        $('.panel-gridview .' + that.selector).prepend(that.overlay = $('<div class="gridview-overlay overlay-preloader"></div>'));
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                Gridview: {
                    page:   page,
                    action: that.config.action,
                }
            },
            success: that.update
        })
    };

    that.update = function(data){
        if (data.status) {
            $('.panel-gridview .'+data.target).html(data.html);
            if (that.overlay.length) that.overlay.remove();
        }
    };

    that.init_pagination();

}