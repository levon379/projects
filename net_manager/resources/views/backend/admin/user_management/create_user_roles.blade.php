@extends('layouts.app_backend')

@section('content')

    <!-- start sidenav-->
    @include('backend.partials.sidenav')
    <!-- START settings nav-->
    @include('backend.partials.settingsnav')
    <!-- END Off Sidebar (right)-->
    <!-- Main section-->

<section>
    <!-- Page content-->
    <h3>Roles and permissions
    </h3>
        <div class="content-wrapper">

            <div class="clearfix"></div>
                <div class="panel panel-default">

                    {{--<div class="panel-heading">{{trans('backend.admin.create_new_role')}}</div>--}}
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <!-- START panel-->
                            <div class="panel panel-default">
                                <div class="panel-heading">Permissions</div>
                                <div class="panel-body">
                                    {!! Form::open(array('route' => 'b::admin::save_role', 'method' => 'POST', 'class' => 'panel-default')) !!}

                                    <div class="form-group">
                                            <label>Name</label>
                                            <input placeholder="Enter email" name=name"" class="form-control" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Display name</label>
                                            <input placeholder="" class="form-control" name="display_name" type="password">
                                        </div>

                                        <button type="submit" class="btn btn-md btn-default">Create</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <!-- END panel-->
                        </div>
                        <div class="col-sm-6">
                            <!-- START panel-->
                            <div class="panel panel-default">
                                <div class="panel-heading">Roles</div>
                                <div class="panel-body">
                                    {!! Form::open(array('route' => 'b::admin::save_role', 'method' => 'POST', 'class' => 'panel-default')) !!}

                                    <div class="form-group">
                                        <label>Role Name</label>
                                        <input placeholder="Enter email" name=name"" class="form-control" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Display name</label>
                                        <input placeholder="" class="form-control" name="display_name" type="password">
                                    </div>

                                    <button type="submit" class="btn btn-md btn-default">Create</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <!-- END panel-->
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection

{{--test--}}


