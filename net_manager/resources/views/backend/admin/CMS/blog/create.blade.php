@extends('layouts.backend')

@section('content')
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3>{{trans('backend.blog.blog')}}
            <small>{{trans('backend.blog.create_new_blog_post')}}</small>
        </h3>
        <!-- START row-->
        <div class="row">
            {{ Form::open(array('url' => 'admin/blog/store','method'=>'POST', 'files'=>true)) }}
            <div class="col-lg-9">

                <!-- START panel-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">{{trans('backend.blog.create_blog')}}</div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{{trans('backend.blog.title')}} *</label>
                            <input type="text" name="title" placeholder="Page title..." class="mb-lg form-control input-lg">
                        </div>
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label">{{trans('backend.blog.content')}} *</label>
                                <textarea name="content" id="content" class="form-control" rows="10" cols="80"></textarea>                           
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">File input</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);"><div class="bootstrap-filestyle input-group"><input type="text" class="form-control " placeholder="" disabled=""> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="filestyle-0" class="btn btn-default "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Choose file</span></label></span></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('backend.blog.status')}}</label>
                                <div class="col-sm-10">
                                    <label class="switch switch-lg">
                                        <input type="checkbox" name="status">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('backend.blog.author')}}</label>
                                <div class="col-sm-10">
                                    <select name="author" class="chosen-select form-control" style="display: none;">
                                        <option>Test1</option>
                                        <option>Test2</option>
                                        <option>Test3</option>
                                        <option>Test4</option>
                                        <option>Test5</option>
                                        <option>Test6</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="required">* {{trans('backend.static_pages.required_fields')}}</div>
                    </div>
                    <div class="panel-footer">
                        <div class="clearfix">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">{{trans('backend.static_pages.create')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END panel-->
            </div>
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="lead">Article Data</p>
                        <p>Categories</p>
                        <select name="category" class="chosen-select form-control" style="display: none;">
                            <option>coding</option>
                            <option>less</option>
                            <option>sass</option>
                            <option>angularjs</option>
                            <option>node</option>
                            <option>expressJS</option>
                        </select>
                        <p>Tags</p>
                        <select  name="tags" class="chosen-select form-control" style="display: none;">
                            <option>JAVASCRIPT</option>
                            <option>WEB</option>
                            <option>BOOTSTRAP</option>
                            <option>SERVER</option>
                            <option>HTML5</option>
                            <option>CSS</option>
                        </select>
                        <p class="lead">SEO Metadata</p>
                        <div class="form-group">
                            <p>Title</p>
                            <input type="text" placeholder="Brief description.." class="form-control">
                        </div>
                        <div class="form-group">
                            <p>Description</p>
                            <textarea rows="5" placeholder="Max 255 characters..." class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <p>Keywords</p>
                            <textarea rows="5" placeholder="Max 1000 characters..." class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</section>
@stop
@section('javascriptckedit')
<script type="text/javascript">
    CKEDITOR.replace('content', {
        customConfig: '/ckeditor/config.js'
    });
    // CKEDITOR.replace('content');
    $('.chosen-select').chosen();

</script>
@stop
