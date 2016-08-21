@extends('layouts.backend')

@section('content')
<section>
    <div class="content-wrapper">
        <h3>{{trans('backend.blog.blog')}}
            <small>{{trans('backend.blog.blog_list')}}</small>
        </h3>
        <div class="row">
            <!-- Blog Content-->
            <div class="col-lg-9">
                <div class="row">
                    @foreach ($blog_article as $blog)
                    <div class="col-lg-4">
                        @if($blog->featured_image != '')
                        <div class="panel">
                            <a href="">
                                <img src="{{ $blog->featured_image }}" class="img-responsive">
                            </a>
                            <div class="panel-body">
                                <p class="clearfix">
                                    <span class="pull-left">
                                        <small class="mr-sm">By <a href="">{!! $blog->author !!}</a>
                                        </small>
                                        <small class="mr-sm">{{ date('Y-m-d H:i:s',$blog->created_by) }}</small>
                                    </span>
                                    <span class="pull-right">
                                        <small>
                                            <strong>56</strong>
                                            <span>Comments</span>
                                        </small>
                                    </span>
                                </p>
                                <h4> <a href="">{{ $blog->title }}</a>
                                </h4>
                                <p>{!! $blog->content !!}</p>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <a href="{{ URL::to('admin/blog/edit') }}/{{ $blog->id }}" class="btn btn-pill-left btn-info">Edit</a>                                
                                </div>
                                <div class="pull-right">
                                    <a href="{{ URL::to('admin/blog/delete') }}/{{ $blog->id }}" class="btn btn-pill-right btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="panel">
                            <div class="panel-body bg-primary">
                                <h3 class="mv-lg">{!! $blog->content !!}</h3>
                            </div>
                            <div class="panel-body">
                                <p class="clearfix">
                                    <span class="pull-left">
                                        <small class="mr-sm">By <a href="">{!! $blog->author !!}</a>
                                        </small>
                                        <small class="mr-sm">{{ date('Y-m-d H:i:s',$blog->created_by) }}</small>
                                    </span>
                                    <span class="pull-right">
                                        <small>
                                            <strong>56</strong>
                                            <span>Comments</span>
                                        </small>
                                    </span>
                                </p>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <a href="{{ URL::to('admin/blog/edit') }}/{{ $blog->id }}" class="btn btn-pill-left btn-info">Edit</a>                                
                                </div>
                                <div class="pull-right">
                                    <a href="{{ URL::to('admin/blog/delete') }}/{{ $blog->id }}" class="btn btn-pill-right btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Blog Sidebar-->
            <div class="col-lg-3">
                <!-- Search-->
                <div class="panel panel-default">
                    <div class="panel-heading">Search</div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="input-group">
                                <input type="text" placeholder="Search for..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default">
                                        <em class="fa fa-search"></em>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Categories-->
                <div class="panel panel-default">
                    <div class="panel-heading">Categories</div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <li>
                                <a href="">
                                    <em class="fa fa-angle-right fa-fw"></em>Smartphones</a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-angle-right fa-fw"></em>Mobiles</a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-angle-right fa-fw"></em>Tech</a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-angle-right fa-fw"></em>Inpiration</a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-angle-right fa-fw"></em>Workspace</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Tag Cloud-->
                <div class="panel panel-default">
                    <div class="panel-heading">Tag Cloud</div>
                    <div class="panel-body">
                        <div id="jqcloud" class="center-block jqcloud" style="width: 240px; height: 200px;"><span id="jqcloud_word_0" class="w7" style="position: absolute; left: 63px; top: 78px;">Lorem</span><span id="jqcloud_word_1" class="w5" style="position: absolute; left: 88.1979px; top: 40.1728px;">Ipsum</span><span id="jqcloud_word_2" class="w4" style="position: absolute; left: 44.1646px; top: 124.171px;">Dolor</span><span id="jqcloud_word_3" class="w3" style="position: absolute; left: 144.367px; top: 126.223px;">Sit</span><span id="jqcloud_word_4" class="w3" style="position: absolute; left: 177.413px; top: 93.2496px;">Sit</span><span id="jqcloud_word_5" class="w2" style="position: absolute; left: 111.401px; top: 151.09px;">Amet</span><span id="jqcloud_word_6" class="w2" style="position: absolute; left: 37.9683px; top: 50.4255px;">Amet</span><span id="jqcloud_word_7" class="w1" style="position: absolute; left: 58.9634px; top: 159.35px;">Adipiscing</span><span id="jqcloud_word_8" class="w1" style="position: absolute; left: 170.496px; top: 61.3688px;">Adipiscing</span><span id="jqcloud_word_9" class="w1" style="position: absolute; left: 55.7323px; top: 24.7679px;">Consectetur</span></div>
                    </div>
                </div>                  
            </div>
        </div>
        <div class="pull-right">
            <div class="input-group pull-right">
                <a href="{{ URL::to('admin/blog/create') }}" class="mb-sm btn btn-success">{{trans('backend.blog.create_new_blog_article')}}</a>
            </div>
        </div>
    </div>
</section>
@stop