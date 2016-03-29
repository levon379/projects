<div id="content" class="col-xs-12 col-sm-10"><!--CONTENT--><div class="panel panel-gridview panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Product</div>
        <div class="panel-body gridview-table-product">
            <!-- Table -->
            <table class="table">
                <tbody><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach($products as $product):?>
                    <tr>
                        <td><?php echo $product['id']?></td>
                        <td><a href="/Product/update/<?php echo $product['id']?>" ><?php echo $product['name']?></a></td>
                        <td><?php if($product['type'] == 1):?>Twitter design<?php else: ?>Facebook design<?php endif;?></td>
                        <td><?php echo sprintf('€ %.2f',$product['price'])?></td>
                        <td><a href="/Product/delete/<?php echo $product['id']?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody></table>

            <div id="gridview-pagination" class="pull-right"><ul class="pagination bootpag"><li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li><li data-lp="1" class="active"><a href="javascript:void(0);">1</a></li><li data-lp="2"><a href="javascript:void(0);">2</a></li><li data-lp="3"><a href="javascript:void(0);">3</a></li><li data-lp="2" class="next"><a href="javascript:void(0);">»</a></li></ul></div>

            <script type="text/javascript">
                $(document).ready(function () {
                    OGridview.init_pagination({
                        page: '1',
                        total: '3',
                        selector: 'gridview-table-product',
                    });
                })
            </script>
            <!-- /Table -->
        </div>

    </div></div>