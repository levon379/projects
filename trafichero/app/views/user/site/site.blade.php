@extends('layout.user')

@section('content')
<div class="content-sec">
    <div class="breadcrumbs">
        <ul>
            <li><a href="/admin/dashboard" title=""><i class="fa fa-home"></i></a>/</li>
            <li><a title="">User List</a></li>
        </ul>
    </div><!-- breadcrumbs -->

    <div class="container">
        <div class="row">
            @if (Session::get('errors'))
            <p class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @foreach (Session::get('errors')->all() as $error)
                {{ $error }}
                @endforeach
            </p>
            @endif

            <div class="col-md-12">

                <div class="col-md-12">

                    <!--
                <div class="widget-area"><h2 class="widget-title"><strong>Wizard</strong> Form</h2>-->
                    <!--                       <div class="wizard-form-h">
                                               <div id="wizard" class="swMain">
                                                   <ul class="anchor">
                                                       <li><a href="#step-1" class="selected" isdone="1" rel="1">Step<span class="stepDesc">1</span></a></li>
                   
                                                   </ul>
                                                   <div class="stepContainer" style="height: 171px;"><div id="step-1" class="content" style="display: block;">	
                                                           <h2 class="StepTitle">Site Information</h2>
                                                           <div class="col-md-6">
                                                               <div class="inline-form">
                                                                   <label class="c-label">Site Name</label><input class="input-style" type="text" name="site_name" placeholder="Site Name">
                                                               </div>
                                                           </div>
                                                           <div class="col-md-6">
                                                               <div class="inline-form">
                                                                   <label class="c-label">Site Url</label><input class="input-style" type="text" name="site_url" placeholder="Site Url">
                                                               </div>
                                                           </div>
                                                           <div class="col-md-6">
                                                               <div class="inline-form">
                                                                   <label class="c-label">EXCLUDED IPS</label><input type="text" name="ip" placeholder="EXCLUDED IPS">
                                                               </div>
                                                           </div>
                                                           <div class="col-md-6">
                                                               <div class="inline-form">
                                                                   <label class="c-label">TIME ZONE</label>
                                                                   <select></select>
                                                               </div>
                                                           </div>
                   
                                                       </div>
                   
                   
                                                   </div>
                                               </div>-->
                    <a href="javascript:;" onclick="fill_userId('{{{88}}}');" class="btn btn-sm btn-info " data-toggle='modal' data-target ='#myModalNew' style="float: right;">Add New Site</a>
                    <div class="modal fade" id="myModalNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="margin-top: 65px;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add New Site</h4>
                                </div>

                                {{ Form::open(array('action' => 'user_create_site', 'method' => 'post', 'class'=>'form-signin')) }}
                                <div class="modal-body">
                                    <div style="overflow: hidden;">
                                        <div class="form-group form_item @if ($errors->has('new_site_name')) has-error @endif">
                                            {{ Form::label('new_site_name','Site Name*',array('id'=>'','class'=>'col-sm-4 control-label')) }}
                                            <div class="col-sm-6">
                                                {{ Form::text('new_site_name', '', array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"2", 'data-parsley-maxlength'=>"55")) }}
                                                @if ($errors->has('new_site_name')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('new_site_name') }}</p> @endif
                                            </div>
                                        </div>
                                        <div class="form-group form_item @if ($errors->has('new_site_main_url')) has-error @endif">
                                            {{ Form::label('new_site_main_url','Site Main Url*',array('id'=>'','class'=>'col-sm-4 control-label')) }}
                                            <div class="col-sm-6">
                                                {{ Form::text('new_site_main_url', '', array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"4", 'data-parsley-maxlength'=>"85")) }}
                                                @if ($errors->has('new_site_main_url')) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('new_site_main_url') }}</p> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                                    {{ Form::submit("Save changes", array('class'=>'btn btn-primary')) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($code) && $code != "")

            <div class="modal fade" id="myModal_code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="margin-top: 95px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <textarea  class="form-control" rows="5">{{$code}}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @endif

            <table class="table">
                <tbody>


                <div class="streaming-table">
                    <!--  <div class="progress progress-striped active w-tooltip">
                          <div id="record_count" class="progress-bar progress-bar-success pink large-progress" style="width:5%">5%</div>
                      </div>
                      <span id="found" class="label label-info" style="display: none;"></span>
                      <input name="search" type="text" id="st_search" class="st_search" placeholder="Search Here">
                      <select size="1" name="per_page" class="st_per_page "><option value="10">10</option>
                          <option value="25">25</option><option value="50">50</option></select>-->
                    <table id="stream_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Site Name</th>
                                <th>Site Url</th>
                                <th>Visits</th>
                                <th>Pageviews</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_sites as $y => $site)
                            <tr id="row_{{{$site->idsite}}}">
                                <td>{{{$site->idsite}}}</td>
                                <td>{{$site->name}}</td>
                                <td><a href="{{$site->main_url}}">{{$site->main_url}}</a></td>
                                <td></td>
                                <td></td>

                                <td>{{date("Y m d H:s:i",strtotime($site->ts_created))}}</td>
                                <td>
                                    <a href="javascript:;" onclick="fill_userId('{{{$site->idsite}}}');" class="btn btn-sm btn-info " data-toggle='modal' data-target ='#myModal{{$site->idsite}}'><i class="fa fa-edit"></i></a>
                                    <div class="modal fade" id="myModal{{$site->idsite}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="margin-top: 65px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">{{$site->main_url}}</h4>
                                                </div>
                                                {{ Form::open(array('action' => array('SiteController@updateSiteById', $site->idsite), 'method' => 'post', 'class'=>'form-signin')) }}
                                                <div class="modal-body">
                                                    <div style="overflow: hidden;">
                                                        <div class="form-group form_item @if ($errors->has('name') && Session::get('editable') == $site->idsite) has-error @endif">
                                                            {{ Form::label('name','Site Name*',array('id'=>'','class'=>'col-sm-4 control-label')) }}
                                                            <div class="col-sm-6">
                                                                {{ Form::text('name', $site->name, array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"2", 'data-parsley-maxlength'=>"55")) }}
                                                                @if ($errors->has('name') && Session::get('editable') == $site->idsite) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('name') }}</p> @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group form_item @if ($errors->has('main_url') && Session::get('editable') == $site->idsite) has-error @endif">
                                                            {{ Form::label('main_url','Site Main Url*',array('id'=>'','class'=>'col-sm-4 control-label')) }}
                                                            <div class="col-sm-6">
                                                                {{ Form::text('main_url', $site->main_url, array('class'=>'form-control', 'required', 'autofocus' => '', 'data-parsley-minlength'=>"4", 'data-parsley-maxlength'=>"85")) }}
                                                                @if ($errors->has('main_url') && Session::get('editable') == $site->idsite) <p class="help-block" style="line-height: 14px ;">{{ $errors->first('main_url') }}</p> @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                                                    {{ Form::submit("Save changes", array('class'=>'btn btn-primary')) }}
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?php echo route('user_delete_site', ['id' => $site->idsite]); ?>" onclick="return confirm('Are You sure You want to delete this site from Your site list?')" class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <!--<div class="st_pagination">
                            <ul class="pagination ">
                                    <li><a href="#" class="first">First</a></li>
                                    <li><a href="#" class="prev">← Previous</a></li>
                                    <li data-page="0"><a href="#">1</a></li>
                                    <li class="active" data-page="1"><a href="#" class="">2</a></li>
                                    <li data-page="2"><a href="#">3</a></li>
                                    <li data-page="3"><a href="#">4</a></li><li data-page="4"><a href="#">5</a></li>
                                    <li><a href="#" class="next">Next →</a></li>
                                    <li><a href="#" class="last">Last</a></li>
                            </ul>
                    </div>
<div id="summary">11 to 20 of 100 entries</div>-->
                </div>


        </div>




    </div>
</div>
@stop
@section('scripts')
{{HTML::script('js/jquery.smartWizard.js')}}
<script type="text/javascript">
                    $(window).load(function(){
            $('#myModal_code').modal('show');
            });
                    $(document).ready(function(){



            $('.form-group').each(function() {
            if ($(this).hasClass('has-error')) {
            $(this).closest("[id*='myModal']").modal('show'); //$("[id*=myModal]")
            }
            });
                    // Smart Wizard 	
                    $('#wizard').smartWizard();
                    function onFinishCallback(){
                    $('#wizard').smartWizard('showMessage', 'Finish Clicked');
                            alert('Finish Clicked');
                    }
            });
                    function fill_userId(user_id) {
                    $('#user_id').val(user_id);
                    }
</script>
@stop