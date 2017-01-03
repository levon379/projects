<div id="nav_part">
    <form action="search-results.html" method="GET" class="search-form">
        <div class="search-pane">
            <input type="text" name="search" placeholder="Search here...">
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
    <ul class="nav nav-list">
        <li id="dashboard"><a href="{$url}admin/dashboard/dashboard/read"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
        <li id="report"><a href="{$url}admin/dashboard/report/read"><i class="fa fa-list-ol"></i> <span>Report</span></a></li>
        <li id="assets"><a href="{$url}admin/dashboard/assets/read"><i class="fa fa-font"></i> <span>Assets</span></a></li>
        <li id="rooms"><a href="{$url}admin/dashboard/rooms/read"><i class="fa fa-list"></i> <span>Forum rooms</span></a></li>
        <li id="rooms"><a href="{$url}admin/dashboard/timezone/read"><i class="fa fa-clock-o"></i><span>Time Zones</span></a></li>
        <li id="rooms"><a href="{$url}admin/dashboard/trade/read"><i class="fa fa-clock-o"></i><span>Update Trade</span></a></li>
    </ul>
</div>    
<div id="content_part">