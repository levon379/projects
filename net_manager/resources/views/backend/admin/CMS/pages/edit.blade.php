@extends('layouts.backend')

@section('content')
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3>{{trans('backend.static_pages.static_pages')}}
            <small>{{trans('backend.static_pages.create_new_static_page')}}</small>
        </h3>
        <!-- START row-->
        <div class="row">
            <div class="col-lg-9">
                {{ Form::open(array('url' => 'admin/pages/update/'.$static_page->id)) }}
                <!-- START panel-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">{{trans('backend.static_pages.create_page')}}</div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{{trans('backend.static_pages.page_title')}} *</label>
                            <input type="text" name="title" placeholder="Page title..." class="mb-lg form-control input-lg" value="{{ $static_page->title }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{trans('backend.static_pages.page_content')}} *</label>
                            <textarea name="content" id="content" class="form-control" rows="10" cols="80">{{ $static_page->content }}</textarea>                           
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('backend.static_pages.status')}}</label>
                            <div class="col-sm-10">
                                <label class="switch switch-lg">
                                    <input type="checkbox" name="status" @if($static_page->status == 1) checked="checked" @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
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
                </form>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="lead">Article Data</p>
                        <p>Categories</p>
                        <select multiple="" class="chosen-select form-control" style="display: none;">
                            <option>coding</option>
                            <option>less</option>
                            <option>sass</option>
                            <option>angularjs</option>
                            <option>node</option>
                            <option>expressJS</option>
                        </select>
                        <p>Tags</p>
                        <select multiple="" class="chosen-select form-control" style="display: none;">
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
        </div>

    </div>
</section>
@stop
@section('javascriptckedit')
<script type="text/javascript">
    CKEDITOR.replace('content');
    $('.chosen-select').chosen();
     
</script>
@stop
