
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
        <h3>Users</h3>
<div class="content-wrapper">

    <!-- START panel-->
    <div class="panel panel-default">
        <div class="panel-heading">Demo Table #1</div>
        <!-- START table-responsive-->
        <div class="table-responsive">
            <table id="table-ext-1" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>UID</th>
                    <th>Picture</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Profile</th>
                    <th>Last Login</th>
                    <th data-check-all="">
                        <div title="" data-original-title="" data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <div class="media">
                            <img src="img/user/01.jpg" alt="Image" class="img-responsive img-circle">
                        </div>
                    </td>
                    <td>@twitter</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>mail@example.com</td>
                    <td class="text-center">
                        <div data-label="25%" class="radial-bar radial-bar-25 radial-bar-xs"></div>
                    </td>
                    <td>1 week</td>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <div class="media">
                            <img src="img/user/02.jpg" alt="Image" class="img-responsive img-circle">
                        </div>
                    </td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>mail@example.com</td>
                    <td class="text-center">
                        <div data-label="50%" class="radial-bar radial-bar-50 radial-bar-xs"></div>
                    </td>
                    <td>25 minutes</td>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <div class="media">
                            <img src="img/user/03.jpg" alt="Image" class="img-responsive img-circle">
                        </div>
                    </td>
                    <td>@fat</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>mail@example.com</td>
                    <td class="text-center">
                        <div data-label="80%" class="radial-bar radial-bar-80 radial-bar-xs"></div>
                    </td>
                    <td>10 hours</td>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- END table-responsive-->
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-2">
                    <div class="input-group">
                        <input placeholder="Search" class="input-sm form-control" type="text">
                        <span class="input-group-btn">
                              <button type="button" class="btn btn-sm btn-default">Search</button>
                           </span>
                    </div>
                </div>
                <div class="col-lg-8"></div>
                <div class="col-lg-2">
                    <div class="input-group pull-right">
                        <select class="input-sm form-control">
                            <option value="0">Bulk action</option>
                            <option value="1">Delete</option>
                            <option value="2">Clone</option>
                            <option value="3">Export</option>
                        </select>
                        <span class="input-group-btn">
                              <button class="btn btn-sm btn-default">Apply</button>
                           </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END panel-->
    <!-- START panel-->
    <div class="panel panel-default">
        <div class="panel-heading">Demo Table #2</div>
        <!-- START table-responsive-->
        <div class="table-responsive">
            <table id="table-ext-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th data-check-all="">
                        <div title="" data-original-title="" data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </th>
                    <th>Description</th>
                    <th>Active</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="media">
                            <a href="#" class="pull-left">
                                <img src="img/user/01.jpg" alt="" class="media-object img-responsive img-circle">
                            </a>
                            <div class="media-body">
                                <div class="pull-right badge baed-info">admin</div>
                                <h4 class="media-heading">Holly Wallace</h4>
                                <p>Username: holly123</p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac
                                nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <label class="switch">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="media">
                            <a href="#" class="pull-left">
                                <img src="img/user/03.jpg" alt="" class="media-object img-responsive img-circle">
                            </a>
                            <div class="media-body">
                                <div class="pull-right badge baed-info">writer</div>
                                <h4 class="media-heading">Alexis Foster</h4>
                                <p>Username: ali89</p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi
                                vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <label class="switch">
                            <input checked="" type="checkbox">
                            <span></span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="media">
                            <a href="#" class="pull-left">
                                <img src="img/user/05.jpg" alt="" class="media-object img-responsive img-circle">
                            </a>
                            <div class="media-body">
                                <div class="pull-right badge baed-info">editor</div>
                                <h4 class="media-heading">Mario Miles</h4>
                                <p>Username: mariomiles</p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                                ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <label class="switch">
                            <input checked="" type="checkbox">
                            <span></span>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- END table-responsive-->
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-2">
                    <div class="input-group pull-right">
                        <select class="input-sm form-control">
                            <option value="0">Bulk action</option>
                            <option value="1">Delete</option>
                            <option value="2">Clone</option>
                            <option value="3">Export</option>
                        </select>
                        <span class="input-group-btn">
                              <button class="btn btn-sm btn-default">Apply</button>
                           </span>
                    </div>
                </div>
                <div class="col-lg-8"></div>
                <div class="col-lg-2 text-right">
                    <ul class="pagination pagination-sm">
                        <li class="active"><a href="#">1</a>
                        </li>
                        <li><a href="#">2</a>
                        </li>
                        <li><a href="#">3</a>
                        </li>
                        <li><a href="#">»</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END panel-->
    <!-- START row-->
    <div class="row">
        <div class="col-lg-6">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">Demo Table #3
                    <!-- START table-responsive-->
                    <div class="table-responsive">
                        <table id="table-ext-3" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Task name</th>
                                <th>Progress</th>
                                <th>Deadline</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Nunc luctus, quam non condimentum ornare</td>
                                <td>
                                    <div class="progress progress-striped progress-xs">
                                        <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-success progress-80">
                                            <span class="sr-only">80% Complete</span>
                                        </div>
                                    </div>
                                </td>
                                <td>05/05/2014</td>
                            </tr>
                            <tr>
                                <td>Integer in convallis felis.</td>
                                <td>
                                    <div class="progress progress-striped progress-xs">
                                        <div role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-danger progress-20">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </td>
                                <td>15/05/2014</td>
                            </tr>
                            <tr>
                                <td>Nullam sit amet magna vestibulum libero dapibus iaculis.</td>
                                <td>
                                    <div class="progress progress-striped progress-xs">
                                        <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-info progress-50">
                                            <span class="sr-only">50% Complete</span>
                                        </div>
                                    </div>
                                </td>
                                <td>05/10/2014</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END table-responsive-->
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-lg-6">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">Demo Table #4</div>
                <!-- START table-responsive-->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Activity</th>
                            <th>Completion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Bootstrap 5.x</td>
                            <td>
                                <div data-sparkline="" data-bar-color="#5d9cec" data-height="20" data-bar-width="5" data-bar-spacing="2" data-values="1,4,4,7,5,9,10" data-resize="true"><canvas height="20" width="47" style="display: inline-block; width: 47px; height: 20px; vertical-align: top;"></canvas></div>
                            </td>
                            <td>
                                <div class="label label-danger">Canceled</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Web Engine</td>
                            <td>
                                <div data-sparkline="" data-bar-color="#7266ba" data-height="20" data-bar-width="5" data-bar-spacing="2" data-values="1,4,4,10,5,9,2" data-resize="true"><canvas height="20" width="47" style="display: inline-block; width: 47px; height: 20px; vertical-align: top;"></canvas></div>
                            </td>
                            <td>
                                <div class="label label-success">Complete</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nullam sit amet</td>
                            <td>
                                <div data-sparkline="" data-bar-color="#23b7e5" data-height="20" data-bar-width="5" data-bar-spacing="2" data-values="1,4,4,7,5,9,4" data-resize="true"><canvas height="20" width="47" style="display: inline-block; width: 47px; height: 20px; vertical-align: top;"></canvas></div>
                            </td>
                            <td>
                                <div class="label label-warning">Delayed</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- END table-responsive-->
            </div>
            <!-- END panel-->
        </div>
    </div>
    <!-- END row-->
</div>
        </section>
    @endsection
@section('javascripts')
    @append