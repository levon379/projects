@extends('layout.user')
@section('content')
<div class="content-sec">
    <div class="breadcrumbs">
        <ul>
            <li><a href="dashboard" title=""><i class="fa fa-home"></i></a>/</li>
                    <?php
                    if (isset($site_name) && !empty($site_name)) {
                        echo '<li><a title="">' . $site_name . '</a>/</li>';
                    }
                    ?>
            <li><a title="">Visitors</a></li>
        </ul>
    </div><!-- breadcrumbs -->
@stop