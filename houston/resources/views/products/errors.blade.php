	@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('success') !!}
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('error') !!}
    </div>
    @endif
    @if($errors->any())
    <div class="validation-summary-errors alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
        </ul>
    </div>
    @endif