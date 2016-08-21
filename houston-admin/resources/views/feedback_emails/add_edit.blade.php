@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Feedback Emails <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row">
    <div class="col-md-6">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Feedback Email </div>
            <div class="panel-body">
                <form action="@if (isset($feedbackEmail)){{ URL::to('/admin/feedback-emails/' . $feedbackEmail->id . '/edit') }}@endif" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($feedbackEmail) ? $feedbackEmail->name : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="from-email">From Email</label>
                        <input type="text" class="form-control inputmask" name="from_email" id="from-email" placeholder="From Email" autocomplete="off" value="{{ Input::old('from_email', isset($feedbackEmail) ? $feedbackEmail->from_email : null) }}">
                    </div>
					<div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control inputmask" name="subject" id="subject" placeholder="Subject" autocomplete="off" value="{{ Input::old('subject', isset($feedbackEmail) ? $feedbackEmail->subject : null) }}">
                    </div>
                    <div class="form-group">
                        <label for="from-email">Email Name</label>
                        <input type="text" class="form-control inputmask" name="email_name" id="email-name" placeholder="Email Name" autocomplete="off" value="{{ Input::old('email_name', isset($feedbackEmail) ? $feedbackEmail->email_name : null) }}">
                    </div>
					<div class="form-group">
                        <label for="provider_id">Provider</label>
                        <select class="form-control select2" id="provider-id" name="provider_id">
                            @foreach ($providers as $provider)
                                @if($mode == 'add')
                                    <option value="{{$provider->id}}" {{ Input::old('provider_id') == $provider->id ? 'selected' : '' }}>{{$provider->name}}</option>
                                @else
                                    <option value="{{$provider->id}}" {{ Input::old('provider_id',$feedbackEmail->provider_id) === $provider->id ? 'selected' : '' }}>{{$provider->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group">
                        <label for="language_id">Language</label>
                        <select class="form-control select2" id="language-id" name="language_id">
                            @foreach ($languages as $language)
                                @if($mode == 'add')
                                    <option value="{{$language->id}}" {{ Input::old('language_id') == $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @else
                                    <option value="{{$language->id}}" {{ Input::old('language_id',$feedbackEmail->language_id) === $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body">{!! Input::old('body', isset($feedbackEmail) ? $feedbackEmail->body : null) !!}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-purple">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
  $(function(){
	$('#body').editable({inlineMode: false, height: 300,
		  // Set custom buttons with separator between them.
		buttons: ["bold", "italic", "underline", "sep", "strikeThrough", "subscript", "superscript", "sep", "align", "insertOrderedList", "insertUnorderedList", "sep", "fontFamily", "fontSize", "color", "sep",  "outdent", "indent", "undo", "removeFormat", "redo", "sep", "table", "createLink", "insertImage", "insertVideo",  "insertHorizontalRule",  "uploadFile", "html"]
    })
    $(".froala-wrapper").next("div").hide();
  });
</script>
@stop