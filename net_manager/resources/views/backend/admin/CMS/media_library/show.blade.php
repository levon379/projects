@extends('layouts.backend')

@section('content')
    <section>
    <div class="page-header" style="height: 100px; display: block;">
        <h1 class="title">
            Media library <span class="margin-l-10 label label-warning"></span>
        </h1>
        <div class="text-right">
            {{--<a class="btn btn-lg btn-rounded btn-success" data-toggle="collapse" href="#create" aria-expanded="false" aria-controls="create">--}}
            {{--<i class="fa fa-plus-circle"></i> create--}}
            {{--</a>--}}
        </div>
    </div>
    <iframe src="/kcfinder/browse.php?type=files&dir=files/public" width="100%" height="1200px" frameborder="0"></iframe>
@endsection
</section>