<aside class="aside">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav data-sidebar-anyclick-close="" class="sidebar">
            <!-- START sidebar nav-->
            <ul class="nav">
                <!-- START user info-->
                <li class="has-user-block">
                    <div id="user-block" class="collapse">
                        <div class="item user-block">
                            <!-- User picture-->
                            <div class="user-block-picture">
                                <div class="user-block-status">
                                    <img src="img/user/02.jpg" alt="Avatar" class="img-thumbnail img-circle" height="60"
                                         width="60">
                                    <div class="circle circle-success circle-lg"></div>
                                </div>
                            </div>
                            <!-- Name and Job-->
                            <div class="user-block-info">
                                <span class="user-block-name">Hello, Mike</span>
                                <span class="user-block-role">Designer</span>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END user info-->
                <!-- Iterates over all sidebar items-->
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
                </li>
                <li class="active">
                    <a aria-expanded="true" class="" href="#dashboard" title="Dashboard" data-toggle="collapse">
                        <em class="icon-speedometer"></em>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-heading">
                    <span>USER MANAGEMENT</span>
                </li>

                <li>
                     <a href="#users" data-toggle="collapse" class="" aria-expanded="true">
                        <em class="icon-people"></em> Users
                     </a>
                     <ul id="users" class="nav sidebar-subnav collapse" aria-expanded="true">
                        <li class="sidebar-subnav-header">Users</li>
                        @foreach ($roles as $role => $name)
                        <li>
                           <a href="{{ route('b::user::index', ['role' => $role]) }}">{{ $name }}</a>
                        </li>
                        @endforeach
                     </ul>
                  </li>

                <li>
                     <a href="#acl" data-toggle="collapse" aria-expanded="true">
                        <em class="icon-shield"></em> Access Control
                     </a>
                     <ul id="acl" class="nav sidebar-subnav collapse" aria-expanded="true">
                        <li class="sidebar-subnav-header">Access Control</li>
                        <li>
                           <a href="#">Roles</a>
                        </li>
                        <li>
                           <a href="#">Permissions</a>
                        </li>
                     </ul>
                  </li>

                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">FINANCIAL MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="#pages" title="Pages" data-toggle="collapse">
                        <em class="icon-doc"></em>
                        <spanPAGES">Payments</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="#extras" title="Extras" data-toggle="collapse">
                        <em class="icon-cup"></em>
                        <spanEXTRA">Declarations</span>
                    </a>

                </li>
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">ORGANIZATIONS MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Oganizations</span>
                    </a>
                </li>

                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">LOCATIONS MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Locations</span>
                    </a>
                </li>

                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Courts</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Courts agenda</span>
                    </a>
                </li>

                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">PROGRAMS MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Exercises</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Type of exercises</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Programs</span>
                    </a>
                </li>
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">MEDIA AND FILE MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="{{route('b::media_library')}}" title="Media Library">
                        <em class="icon-graduation"></em>
                        <span>Photos</span>
                    </a>
                </li>

                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">COMMUNICATION MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Mailing</span>
                    </a>
                </li>
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">SETTINGS</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>General settings</span>
                    </a>
                </li>
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">CMS MANAGEMENT</span>
                </li>
                <li class=" ">
                    <a href="{{ URL::to('admin/pages') }}" title="Static Pages">
                        <em class="icon-graduation"></em>
                        <span>Static pages</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="{{ URL::to('admin/blog') }}" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>Blog</span>
                    </a>
                </li>
                <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">Subscriptions</span>
                </li>
                <li class=" ">
                    <a href="documentation.html" title="Documentation">
                        <em class="icon-graduation"></em>
                        <span>All</span>
                    </a>
                </li>
            </ul>
            <!-- END sidebar nav-->
        </nav>
    </div>
    <!-- END Sidebar (left)-->
</aside>