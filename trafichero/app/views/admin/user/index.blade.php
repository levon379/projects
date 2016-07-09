@extends('layout.default')

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
                <?php //print_r(Session::get('errors'));?>
                @foreach (Session::get('errors')->all() as $error)
                {{ $error }}
                @endforeach
            </p>
            @endif

            <div class="col-md-12">
                {{ Form::open(array('url' => 'register-user', 'method' => 'post')) }}
                <div class="widget-area">
                    <h2 class="widget-title"><strong>Wizard</strong> Form</h2>
                    <div class="wizard-form-h">
                        <div id="wizard" class="swMain">
                            <ul class="anchor">
                                <li><a href="#step-1" class="selected" isdone="1" rel="1">Step<span class="stepDesc">1</span></a></li>
                                <li><a href="#step-2" class="disabled" isdone="0" rel="2">Step<span class="stepDesc">2</span></a></li>
                                <!--<li><a href="#step-3" class="disabled" isdone="0" rel="3">Step<span class="stepDesc">3</span></a></li>-->
                            </ul>
                            <div class="stepContainer" style="height: 171px;"><div id="step-1" class="content" style="display: block;">	
                                    <h2 class="StepTitle">Account Information</h2>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Your Name</label><input class="input-style" type="text" name="first_name" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Last Name</label><input class="input-style" type="text" name="last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Your Email</label><input type="text" name="email" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">User Password</label><input type="password" name="password" placeholder="Your password" autocomplete="off" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QsPDhss3LcOZQAAAU5JREFUOMvdkzFLA0EQhd/bO7iIYmklaCUopLAQA6KNaawt9BeIgnUwLHPJRchfEBR7CyGWgiDY2SlIQBT/gDaCoGDudiy8SLwkBiwz1c7y+GZ25i0wnFEqlSZFZKGdi8iiiOR7aU32QkR2c7ncPcljAARAkgckb8IwrGf1fg/oJ8lRAHkR2VDVmOQ8AKjqY1bMHgCGYXhFchnAg6omJGcBXEZRtNoXYK2dMsaMt1qtD9/3p40x5yS9tHICYF1Vn0mOxXH8Uq/Xb389wff9PQDbQRB0t/QNOiPZ1h4B2MoO0fxnYz8dOOcOVbWhqq8kJzzPa3RAXZIkawCenHMjJN/+GiIqlcoFgKKq3pEMAMwAuCa5VK1W3SAfbAIopum+cy5KzwXn3M5AI6XVYlVt1mq1U8/zTlS1CeC9j2+6o1wuz1lrVzpWXLDWTg3pz/0CQnd2Jos49xUAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                                        </div>
                                    </div>

                                </div>
                                <div id="step-2" class="content" style="display: none;">
                                    <h2 class="StepTitle">Step 2 Content</h2>	
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Company Name</label><input type="text" placeholder="Company Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Your Post</label><input type="text" placeholder="Your Post">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Company Email</label><input type="text" placeholder="Company Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Website</label><input type="text" placeholder="Http://">
                                        </div>
                                    </div>	
                                    <div class="col-md-12">
                                        <div class="inline-form">
                                            <label class="c-label">Company Address</label><textarea placeholder="Company Address" rows="5"></textarea>
                                        </div>
                                    </div>																		
                                </div>

                            </div>	
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                <div class="col-md-12">

                    <div class="streaming-table">
                        <div class="progress progress-striped active w-tooltip">
                            <div id="record_count" class="progress-bar progress-bar-success pink large-progress" style="width:5%">5%</div>
                        </div>
                        <span id="found" class="label label-info" style="display: none;"></span>
                        <input name="search" type="text" id="st_search" class="st_search" placeholder="Search Here">
                        <select size="1" name="per_page" class="st_per_page "><option value="10">10</option>
                            <option value="25">25</option><option value="50">50</option></select>
                        <table id="stream_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User FullName</th>
                                    <th>UserName</th>
                                    <th>Site</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $y => $user)
                                <tr id="row_{{{$user->id}}}">
                                    <td>{{{$user->id}}}</td>
                                    <td>{{{$user->first_name}}} {{{$user->last_name}}}</td>
                                    <td>{{{$user->email}}}</td>
                                    <td>
                                        {{--<div class="progress">--}}
                                        {{--<div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="red progress-bar">--}}
                                        {{--<span>60%</span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        <a href="{{{$user->main_url}}}">{{{$user->main_url}}}</a>
                                    </td>
                                    <td>{{date("Y m d H:s:i",strtotime($user->date_registered))}}</td>
                                    <td>
                                        <a href="javascript:;" onclick="fill_userId('{{{$user->id}}}');" class="btn btn-sm btn-info " data-toggle='modal' data-target ='#myModal'><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo route('admin_delete_user', ['id' => $user->id]); ?>" onclick="return confirm('Are You sure You want to delete this user?')" class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></a>
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

                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content" style="top: 57px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Remind password</h4>
                            </div>
                            <div class="modal-body">
                                {{ Form::open(array('route'=> 'password-reminder', 'method' => 'post')) }}
                                <input type="hidden" id="user_id" name="user_id">
                                <div class="input-group">
                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">New Password</label><input type="password" name="password" placeholder="New password" autocomplete="off" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QsPDhss3LcOZQAAAU5JREFUOMvdkzFLA0EQhd/bO7iIYmklaCUopLAQA6KNaawt9BeIgnUwLHPJRchfEBR7CyGWgiDY2SlIQBT/gDaCoGDudiy8SLwkBiwz1c7y+GZ25i0wnFEqlSZFZKGdi8iiiOR7aU32QkR2c7ncPcljAARAkgckb8IwrGf1fg/oJ8lRAHkR2VDVmOQ8AKjqY1bMHgCGYXhFchnAg6omJGcBXEZRtNoXYK2dMsaMt1qtD9/3p40x5yS9tHICYF1Vn0mOxXH8Uq/Xb389wff9PQDbQRB0t/QNOiPZ1h4B2MoO0fxnYz8dOOcOVbWhqq8kJzzPa3RAXZIkawCenHMjJN/+GiIqlcoFgKKq3pEMAMwAuCa5VK1W3SAfbAIopum+cy5KzwXn3M5AI6XVYlVt1mq1U8/zTlS1CeC9j2+6o1wuz1lrVzpWXLDWTg3pz/0CQnd2Jos49xUAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="inline-form">
                                            <label class="c-label">Confirm Password</label><input type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="off" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QsPDhss3LcOZQAAAU5JREFUOMvdkzFLA0EQhd/bO7iIYmklaCUopLAQA6KNaawt9BeIgnUwLHPJRchfEBR7CyGWgiDY2SlIQBT/gDaCoGDudiy8SLwkBiwz1c7y+GZ25i0wnFEqlSZFZKGdi8iiiOR7aU32QkR2c7ncPcljAARAkgckb8IwrGf1fg/oJ8lRAHkR2VDVmOQ8AKjqY1bMHgCGYXhFchnAg6omJGcBXEZRtNoXYK2dMsaMt1qtD9/3p40x5yS9tHICYF1Vn0mOxXH8Uq/Xb389wff9PQDbQRB0t/QNOiPZ1h4B2MoO0fxnYz8dOOcOVbWhqq8kJzzPa3RAXZIkawCenHMjJN/+GiIqlcoFgKKq3pEMAMwAuCa5VK1W3SAfbAIopum+cy5KzwXn3M5AI6XVYlVt1mq1U8/zTlS1CeC9j2+6o1wuz1lrVzpWXLDWTg3pz/0CQnd2Jos49xUAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                                        </div>
                                    </div>

                                    <span class="input-group-btn">
                                        {{ Form::submit('Send Reminder', array('class'=>'btn btn-warning'))}}
                                    </span>
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


            </div>
        </div>
        @stop
        @section('scripts')
        {{HTML::script('js/jquery.smartWizard.js')}}
        <script type="text/javascript">
                    $(document).ready(function(){
            // Smart Wizard 	
            $('#wizard').smartWizard();
                    function onFinishCallback(){

                    $('#wizard').smartWizard('showMessage', 'Finish Clicked');
                            alert('Finish Clicked');
                    }
            });
                    function fill_userId(user_id)
                    {
                    $('#user_id').val(user_id);
                    }
        </script>
        @stop
