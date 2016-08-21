@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Statistics Generator Tool<small> </small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('success') !!}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('error') !!}
</div>
@endif

<div class="main-div">
	<form action="/admin/statistics" method="GET">	
		<ul class="list-inline list-unstyled switch-button-row text-white">
			<input type="hidden" id="provider-ids" name="pr" value="1,2,3">
			<li>GoSeek Adventures
				<div class="btn-group toggle-button toggle-option" data-id="1">
					<button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
					<button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
				</div>
			</li>
			<li>Rome By Segway 
				<div class="btn-group toggle-button toggle-option" data-id="2">
					<button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
					<button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
				</div>
			</li>
			<li>EcoArt Travel
				<div class="btn-group toggle-button toggle-option" data-id="3">
					<button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
					<button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
				</div>
			</li>
			<li>Select All 
				<div class="btn-group toggle-button toggle-all" data-id="0">
					<button class="btn btn-success btn-sm" type="button" data-value="1">Yes</button>
					<button class="btn btn-default btn-sm" type="button" data-value="0">No</button>
				</div>
			</li>
		</ul>
	
		<div class="panel panel-default panel-success">
		<div class="panel-heading">Select Data to Include:</div>

		<div class="panel-body">

		<div class="panel panel-default no-margn generate-statistics-panel">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6 form-horizontal">
						<div class="form-group">
							

						<label for="1" class="col-sm-3 control-label text-left">
						Booking Dates</label>
						<div class="col-lg-4">
							<div  class="input-group date datetimepicker" id="booking-date-from">
								<input type="text" class="form-control" name="bf" value="{{ Input::get('bf') }}" autocomplete="off">
								<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
								</span>
							</div>
						</div>
						<label for="2" class="col-sm-1 control-label"><strong class="lead"><i class="fa fa-long-arrow-right"></i></strong></label>
						<div class="col-lg-4">
							<div  class="input-group date datetimepicker" id="booking-date-to">
								<input type="text" class="form-control" name="bt" value="{{ Input::get('bt') }}" autocomplete="off">
								<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
								</span>
							</div>
						</div>
							
						</div>
				</div>
				
				<div class="col-lg-6 form-horizontal">
						<div class="form-group">

						<label for="3" class="col-sm-2 control-label">Product</label>
						<div class="col-lg-4">
							
							<select class="form-control select2-clear" id="product-id" name="pd">
								<option value=""></option>
								@foreach ($products as $product)
									<option value="{{$product->id }}" {{ Input::get('pd') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
								@endforeach
							</select>
							
						</div>
						<label for="4" class="col-sm-2 control-label">Option</label>
						<div class="col-lg-4">
							
							<select class="form-control select2-clear" id="product-option-id" name="po">
								<option value=""></option>
							</select>
							
						</div>
							
						</div>
				</div>
			 </div>
			
			<div class="row">
				<div class="col-lg-6 form-horizontal">
					<div class="form-group">
					<label for="1" class="col-sm-3 control-label text-left">
					Travel Dates</label>
					<div class="col-lg-4">
						<div  class="input-group date datetimepicker" id="travel-date-from">
							<input type="text" class="form-control" name="tf" value="{{ Input::get('tf') }}" autocomplete="off">
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
							</span>
						</div>
					</div>
					<label for="6" class="col-sm-1 control-label"><strong class="lead"><i class="fa fa-long-arrow-right"></i></strong></label>
					<div class="col-lg-4">
						<div  class="input-group date datetimepicker" id="travel-date-to">
							<input type="text" class="form-control" name="tt" value="{{ Input::get('tt') }}" autocomplete="off">
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span>
							</span>
						</div>
					</div>
					</div>
				</div>
				
				<div class="col-lg-6 form-horizontal">
						<div class="form-group">

						<label for="7" class="col-sm-2 control-label">Payment Method</label>
						<div class="col-lg-4">
							
							<select class="form-control select2-clear" name="pm">
								<option value=""></option>
								@foreach($paymentMethods as $paymentMethod)
									<option value="{{$paymentMethod->id }}" {{ Input::get('pm') == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->name }}</option>
								@endforeach
							</select>
							
						</div>
						<label for="8" class="col-sm-2 control-label">Paid?</label>
						<div class="col-lg-4">
							
							<select class="form-control select2" name="pa">
								<option value="" {{ Input::get('pa') == "" ? 'selected' : '' }}>All</option>
								<option value="1" {{ Input::get('pa') == "1" ? 'selected' : '' }}>Yes</option>
								<option value="0" {{ Input::get('pa') == "0" ? 'selected' : '' }}>No</option>
							</select>
							
						</div>
							
						</div>
				</div>
			 </div>
			 
			 <div class="row">
				<div class="col-lg-4 form-horizontal">
						<div class="form-group">
						<label for="9" class="col-sm-5 control-label text-left">Source Group</label>
						<div class="col-lg-7">
							
							<select class="form-control select2-clear" id="source-group-id" name="sg">
								<option value=""></option>
								@foreach ($sourceGroups as $sourceGroup)
									<option value="{{$sourceGroup->id }}" {{ Input::get('sg') == $sourceGroup->id ? 'selected' : '' }}>{{ $sourceGroup->name }}</option>
								@endforeach
							</select>
							
						</div>
						
						</div>
				</div>
				<div class="col-lg-4 form-horizontal">
						<div class="form-group">
						<label for="10" class="col-sm-5 control-label">Source Name</label>
						<div class="col-lg-7">
							
							<select class="form-control select2-clear" id="source-name-id" name="sn">
								<option value=""></option>
							</select>
							
						</div>
						</div>
				</div>
				<div class="col-lg-4 form-horizontal">
						<div class="form-group">

						<div class="col-lg-12">
							<div class="input-group form-control-static"><label for="11">Include Packages? &nbsp;</label>
								<div class="switch-button sm switch-button">
									<input type="hidden" id="show-packages-value" name="pk" value="{{ Input::get('pk',1) }}">
									<input type="checkbox" @if (Input::get('pk',1)) {{"checked"}} @endif id="show-packages">
									<label for="show-packages"></label>
								</div>
							</div>
						</div>
							
						</div>
				</div>
			 </div> 
			
		</div>
		</div>

		</div>
	</div>
	
		<div class="panel panel-default panel-success">
		<div class="panel-heading">Select Chart/Graph Layout:</div>
		<div class="panel-body">


		  <div class="panel panel-default">
			<div class="panel-body">

			<div class="row">
				<div class="col-lg-4 form-horizontal">
						<div class="form-group">
							<label for="11" class="col-sm-6 control-label">Column 1/X-Axis</label>
							<div class="col-lg-5">
								
								  <select class="form-control select2" id="11" name="xa">
									  <option value="pr" {{ Input::get('xa') == "pr" || Input::get('xa') == "" ? 'selected' : '' }}>Product</option>
									  <option value="po" {{ Input::get('xa') == "po" ? 'selected' : '' }}>Product Option</option>
									  <option value="sg" {{ Input::get('xa') == "sg" ? 'selected' : '' }}>Source Group</option>
									  <option value="sn" {{ Input::get('xa') == "sn" ? 'selected' : '' }}>Source Name</option>
									  <option value="pm" {{ Input::get('xa') == "pm" ? 'selected' : '' }}>Payment Method</option>
									  <option value="pv" {{ Input::get('xa') == "pv" ? 'selected' : '' }}>Provider</option>
									  <option value="mn" {{ Input::get('xa') == "mn" ? 'selected' : '' }}>Month</option>
									  <option value="yr" {{ Input::get('xa') == "yr" ? 'selected' : '' }}>Year</option>
								  </select>
								  
							</div>
							<div class="col-lg-1 form-control-static" style="padding-left:0px;">
								<i class="fa fa-info-circle tooltip-btn" data-placement="top" data-toggle="tooltip" data-original-title="Tip: Don't select the same item for both the X and Y axis"></i>
							</div>
						</div>
				</div>
				<div class="col-lg-3 form-horizontal">		
						<div class="form-group">
							<label for="12" class="col-sm-6 control-label">Row 1/Y-Axis</label>
							<div class="col-lg-6">
								  <select class="form-control select2" id="12" name="ya">
									  <option value="pr" {{ Input::get('ya') == "pr" || Input::get('ya') == "" ? 'selected' : 'selected' }}>Product</option>
									  <option value="po" {{ Input::get('ya') == "po" ? 'selected' : '' }}>Product Option</option>
									  <option value="sg" {{ Input::get('ya') == "sg" ? 'selected' : '' }}>Source Group</option>
									  <option value="sn" {{ Input::get('ya') == "sn" ? 'selected' : '' }}>Source Name</option>
									  <option value="pm" {{ Input::get('ya') == "pm" ? 'selected' : '' }}>Payment Method</option>
									  <option value="pv" {{ Input::get('ya') == "pv" ? 'selected' : '' }}>Provider</option>
									  <option value="mn" {{ Input::get('ya') == "mn" ? 'selected' : '' }}>Month</option>
									  <option value="yr" {{ Input::get('ya') == "yr" ? 'selected' : '' }}>Year</option>
								  </select>
							</div>
						</div>
				</div>
				
				<div class="col-lg-5 form-horizontal">
						<div class="form-group">

						<label for="13" class="col-sm-2 control-label">Data</label>
						<div class="col-lg-4">
							
							  <select class="form-control" id="13" name="dt">
								  <option value="0" {{ Input::get('dt') == "0" || Input::get('dt') == "" ? 'selected' : '' }}>Pax</option>
								  <option value="1" {{ Input::get('dt') == "1" ? 'selected' : '' }}>Revenue</option>
							  </select>
							
						</div>
						{{-- <label for="14" class="col-sm-2 control-label"></label> --}}
						<div class="col-lg-6">
							
							  <select class="form-control" id="14" name="btd" multiple="multiple">
								  <option value="bd" {{ Input::get('btd') == "" ? '' : 'selected' }}>Booking Date</option>
								  <option value="td" {{ Input::get('btd') == "" ? '' : 'selected' }}>Travel Date</option>
							  </select>
							
						</div>
							
						</div>
				</div>
			 </div>
			 
		
			 <div class="row">
				<div class="col-lg-4 col-lg-offset-4">
					<div class="form-group"><button class="btn btn-purple btn-block">Generate</button></div>
				</div>
			 </div>
	
			 </div>
			 </div>
	
			<div class="">
				<div class="text-">
					{{--  --}}
				</div>
				<div class="table-responsive">
					<table class="table text-center rounded-custom table-striped">
						@foreach ($data as $key => $element)
							@if ($key == "x_axis")
								<thead>
									<tr>
										<th></th>
										@foreach ($element as $e)
											<th class="text-center">{{ $e }}</th>
										@endforeach
									</tr>
								</thead>
							@else
								<tr>
									<td>{{ $key }}</td>
									@foreach ($element as $e)
										<td>{{ $e }}</td>
									@endforeach
								</tr>
							@endif
						@endforeach
					</table>
				</div>
			</div>
			 <div class="table-responsive">
			 
			 <table class="table text-center rounded-custom">
				<thead>
					<th></th>
					<th class="text-center">2012</th>
					<th class="text-center">2013</th>
					<th class="text-center">2014</th>
					<th class="text-center">2015</th>
					<th class="text-center">2016</th>
				</thead>
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
				
				<tr>
					<td>Select</td>
					<td><span>300</span> <span class="text-gray">100%</span></td>
					<td><span>300</span> <span class="text-green">100%</span></td>
					<td><span class="text-danger">300</span> <span>100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
					<td><span>300</span> <span class="text-danger">100%</span></td>
				</tr>
			</table>
			</div>


			<div class="panel panel-default">
			  <div class="panel-body">
				
				<div id="line-chart" style="height:250px;"></div>
				
				<hr>
				
				<div class="table-responsive">
				<table class="table text-center table-striped">
					<thead>
						<th class="no-br-white-bg"></th>
						<th class="text-center">Label</th>
						<th class="text-center">Label</th>
						<th class="text-center">Label</th>
						<th class="text-center">Label</th>
						<th class="text-center">Label</th>
					</thead>
					<tr>
						<td class="no-br-white-bg"><i class="fa fa-circle text-danger showcase-switch-button"></i> 2012</td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
					</tr>
					<tr>
						<td class="no-br-white-bg"><i class="fa fa-circle text-warning showcase-switch-button"></i> 2013</td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
					</tr>
					<tr>
						<td class="no-br-white-bg"><i class="fa fa-circle text-success showcase-switch-button"></i> 2014</td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
						<td>300 </td>
					</tr>
				</table>
				</div>
				<div class="form-horizontal text-center">
						  <div class="form-group">
							<div class="col-lg-3"></div>
							<div class="col-lg-3"><button class="btn btn-purple btn-block" type="button"><i class="fa fa-file-image-o"></i> Export to PDF</button></div>
							<div class="col-lg-3"><button class="btn btn-purple btn-block" type="button"><i class="fa fa-file-image-o"></i> Export to Excel</button></div>
							<div class="col-lg-3"></div>
						  </div>
						  
						  <div class="form-group">
							<div class="col-lg-3"></div>
							<div class="col-lg-3"><button class="btn btn-purple btn-block" type="button"><i class="fa fa-file-image-o"></i> Export to JPG</button></div>
							<div class="col-lg-3"><button class="btn btn-warning btn-block" type="button"><i class="fa fa-heart"></i> Save Chart to Favorites</button></div>
							<div class="col-lg-3"></div>
						  </div>
				</div>


				</div>
			</div>



		</div>
		
		</div>  
	</form>	<!--end form-->
</div>    

@stop

@section('script')
<script>
    $(document).ready(function(){
		var productId = $("#product-id").val();
        var sourceGroupId = $("#source-group-id").val();

        var productOptionId = getParameterByName('po');
        var sourceNameId = getParameterByName('sn');
        var pageSize = getParameterByName('ps');

        $("#13, #14").multiselect();


        loadProductOptions(true);
        loadSourceNames(true);
		
		initSwitches();
		
		$("#booking-date-from").datetimepicker({
			format: 'DD/MM/YYYY'
		});
		$("#booking-date-to").datetimepicker({
			format: 'DD/MM/YYYY'
		});
		
		$("#booking-date-from").on("dp.change",function (e) {
			$('#booking-date-to').data("DateTimePicker").minDate(e.date);
		});
		$("#booking-date-to").on("dp.change",function (e) {
			$('#booking-date-from').data("DateTimePicker").maxDate(e.date);
		});
		
		$("#travel-date-from").datetimepicker({format: 'DD/MM/YYYY' });
		$("#travel-date-to").datetimepicker({format: 'DD/MM/YYYY' });

		$("#travel-date-from").on("dp.change",function (e) {
			$('#travel-date-to').data("DateTimePicker").minDate(e.date);
		});
		$("#travel-date-to").on("dp.change",function (e) {
			$('#travel-date-from').data("DateTimePicker").maxDate(e.date);
		});
		
		function initSwitches(){
            var group = $('ul.switch-button-row');
            var input = $('#provider-ids');

            var providerString = getParameterByName('pr');

            if(providerString){
                input.val(providerString);
            }

            var providerIds = input.val().split(",");

            toggleAll(providerIds.length > 2);

            $('.toggle-option', group).each(function () {
                var buttonGroup = $(this);
                var buttonValue = buttonGroup.data("id");
                $('button',buttonGroup).each(function(){
                    var button = $(this);
                    var bool = button.data("value");
                    bool = bool > 0 ? true : false;

                    if($.inArray(buttonValue+"",providerIds) >= 0 ){
                        if(bool){
                            activateButton(button);
                        }
                    } else {
                        if(!bool){
                            activateButton(button);
                        }
                    }

                    button.on('click',function(){
                        activateButton(button);
                        if(bool){
                            providerIds.push(buttonValue+"");
                            providerIds = cleanArray(providerIds);
                            if(providerIds.length > 2){
                                toggleAll(true);
                            }
                        } else {
                            providerIds = removeArrayElement(buttonValue,providerIds);
                            toggleAll(false);
                        }
                        input.val(providerIds.join());
                    })
                });
            });
            $('ul.switch-button-row .toggle-all button').on('click',function(){
                var button = $(this);
                var value = button.data("value");
                value = value > 0 ? true : false;
                if(value){
                    input.val("1,2,3");
                    providerIds = input.val().split(",");
                    toggleOptions(true);
                } else {
                    input.val("");
                    providerIds = [];
                    toggleOptions(false);
                }

                activateButton(button);
            });

        }

        function activateButton(button){
            button.siblings().removeClass("btn-success").addClass("btn-default");
            button.removeClass("btn-default");
            button.addClass("btn-success");
        }

        function toggleOptions(on){
            var group = $('ul.switch-button-row .toggle-option');
            toggleButton(on, group);
        }

        function toggleAll(on){
            var group = $('ul.switch-button-row .toggle-all');
            toggleButton(on, group);
        }

        function toggleButton(on,group){
            $('button', group).each(function () {
                var button = $(this);
                var buttonValue = button.data("value");
                buttonValue = buttonValue > 0 ? true : false;
                if(buttonValue == on){
                    activateButton(button);
                }
            });
        }

		$(".generate-statistics-panel").on("change","#show-packages",function(){
            var isChecked  = $(this).is(':checked');
            var checkValue = $(this).closest(".switch-button").find("#show-packages-value");
            var value = isChecked ? 1 : 0;
            checkValue.val(value);
            console.log(checkValue.val());
        });
        
		$(".generate-statistics-panel").on("change","#source-group-id",function(){
            sourceGroupId = this.value;
            loadSourceNames();
        });


        function loadSourceNames(setvar){
            setvar = typeof setvar !== 'undefined' ? setvar : false;
            if(!setvar){
                loadSelectData("#source-name-id","sources/names/group",{ source_group_id : sourceGroupId });
            } else {
                loadSelectDataSet("#source-name-id","sources/names/group",{ source_group_id : sourceGroupId },sourceNameId);
            }
        }

        $(".generate-statistics-panel").on("change","#product-id",function(){
            productId = this.value;
            loadProductOptions();
        });


        function loadProductOptions(setvar){
            setvar = typeof setvar !== 'undefined' ? setvar : false;
            if(!setvar){
                loadSelectData("#product-option-id","products/options/product",{ product_id : productId  });
            } else {
                loadSelectDataSet("#product-option-id","products/options/product",{ product_id : productId  },productOptionId);
            }
        }

    });
</script>
@stop
