@extends('layouts.backend')

@section('content')
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3>{{trans('backend.static_pages.static_pages')}}
            <small>{{trans('backend.static_pages.all_created_pages')}}</small>
        </h3>
        <!-- START row-->
        <div class="row">
            <div class="col-lg-12">
                <!-- START panel-->
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('backend.static_pages.pages')}}</div>
                    <div class="panel-body">
                        <!-- START table-responsive-->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('backend.static_pages.title')}}</th>
                                        <th>{{trans('backend.static_pages.status')}}</th>
                                        <th>{{trans('backend.static_pages.created_at')}}</th>
                                        <th>{{trans('backend.static_pages.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($static_pages as $page)
                                    <tr>
                                        <td>{{ $page->id }}</td>
                                        <td>{{ $page->title }}</td>
                                        <td>
                                            @if($page->status == 1)
                                                Active
                                            @else
                                                Unactive
                                            @endif
                                        </td>
                                        <td> {{ date('Y-m-d H:i:s',$page->created_by) }}</td>
                                        <td>
                                            <a href="{{ URL::to('admin/pages/edit') }}/{{ $page->id }}" class="btn btn-labeled btn-info">
                                                </span>{{trans('backend.static_pages.edit')}}</a>
                                            <a href="{{ URL::to('admin/pages/delete') }}/{{ $page->id }}" class="btn btn-labeled btn-danger">
                                                </span>{{trans('backend.static_pages.delete')}}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END table-responsive-->
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="input-group">
                                        <input type="text" placeholder="Search" class="input-sm form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-default">{{trans('backend.static_pages.search')}}</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-8"></div>
                                <div class="col-lg-2">
                                    <div class="input-group pull-right">
                                        <a href="{{ URL::to('admin/pages/create') }}" class="mb-sm btn btn-success">{{trans('backend.static_pages.create_new_page')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END panel-->
            </div>
        </div>

        <!-- END row-->
    </div>
</section>
@stop