@extends('layouts.backend')

@section('content')
<div class="content-wrapper">
	<div class="pull-right">
		<a href="{{ route('b::user::create') }}" class="btn btn-labeled btn-success">
       		<span class="btn-label"><i class="fa fa-plus"></i></span>CREATE PLAYER
       	</a>
    </div>
	<h3>Users <span class="label label-default" style="margin-left: 10px;">5</span></h3>
	<div class="table-responsive" style="margin: 0 -20px;">
		<table class="table table-striped" role="grid">
         	<thead>
            	<tr role="row">
            		<th>ID</th>
            		<th>Name</th>
            		<th>Email</th>
            		<th>Phone</th>
            		<th>Status</th>
            		<th>ID</th>
            		<th></th>
                </tr>
        	</thead>
        	<tfoot>
        		<tr>
        			<th colspan="7">
        				<nav>
                              <ul class="pagination m0">
                                 <li>
                                    <a href="#" aria-label="Previous">
                                       <span aria-hidden="true">«</span>
                                    </a>
                                 </li>
                                 <li><a href="#">1</a>
                                 </li>
                                 <li><a href="#">2</a>
                                 </li>
                                 <li class="active"><a href="#">3</a>
                                 </li>
                                 <li><a href="#">4</a>
                                 </li>
                                 <li><a href="#">5</a>
                                 </li>
                                 <li>
                                    <a href="#" aria-label="Next">
                                       <span aria-hidden="true">»</span>
                                    </a>
                                 </li>
                              </ul>
                           </nav>
        			</th>
        		</tr>
        	</tfoot>
        	<tbody>
          		<tr role="row">
	            	<td>0006</td>
	                <td>Product 6</td>
	                <td>Description for Product</td>
	                <td>$ 17.20</td>
	                <td>283</td>
	                <td class="text-center">
	                   <span class="label label-success">Stock</span>
	                </td>
	                <td class="text-right">
	                	<a href="#" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
	                	<button type="button" class="btn btn-sm btn-danger">
	                    	<i class="fa fa-trash"></i>
	                	</button>
	                </td>
	            </tr>
	            <tr role="row">
	            	<td>0007</td>
	                <td>Product 7</td>
	                <td>Description for Product</td>
	                <td>$ 18.20</td>
	                <td>293</td>
	                <td class="text-center">
	                   <span class="label label-danger">Removed</span>
	                </td>
	                <td class="text-right">
	                	<a href="#" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
	                	<button type="button" class="btn btn-sm btn-danger">
	                    	<i class="fa fa-trash"></i>
	                	</button>
	                </td>
	            </tr>
            </tbody>
       </table>
    </div>
</div>
@stop