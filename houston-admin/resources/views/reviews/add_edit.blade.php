@extends('layouts.master')

@section('content')
<div class="page-header"><h1>Review <small>{{ ucwords($mode) }}</small></h1></div>
<div class="row">
    <div class="col-md-6">
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if($errors->any())
		<div class="form-group">
        <div class="validation-summary-errors alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucwords($mode) }} Review</div>
            <div class="panel-body">
                <form action="@if (isset($review)){{ URL::to('/admin/reviews/' . $review->id . '/edit') }}@endif" role="form" method="POST" id="review-form">
					<div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" autocomplete="off" value="{{ Input::old('title', isset($review) ? $review->title : null) }}">
                    </div>
					<div class="form-group">
                        <label for="language">Language</label>
                        <select class="form-control select2" id="language" name="language_id">
                            @foreach ($languages as $language)
                                @if($mode == 'add')
                                    <option value="{{$language->id}}" {{ Input::old('language_id') == $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @else
                                    <option value="{{$language->id}}" {{ Input::old('language_id',$review->language_id) === $language->id ? 'selected' : '' }}>{{$language->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group">
                        <label for="review-source">Review Source</label>
                        <select class="form-control select2" id="review-source" name="review_source_id">
                            @foreach ($reviewSources as $reviewSource)
                                @if($mode == 'add')
                                    <option value="{{$reviewSource->id}}" {{ Input::old('review_source_id') == $reviewSource->id ? 'selected' : '' }}>{{$reviewSource->name}}</option>
                                @else
                                    <option value="{{$reviewSource->id}}" {{ Input::old('review_source_id',$review->review_source_id) === $reviewSource->id ? 'selected' : '' }}>{{$reviewSource->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group" style="display:none">
                        <label for="booking">Booking</label>
                        <select class="form-control select2" id="booking" name="booking_id">
							<option value="" selected></option>
                            @foreach ($bookings as $booking)
                                @if($mode == 'add')
                                    <option value="{{$booking->id}}" prod-id="{{$booking->product_option->product->id}}" {{ Input::old('booking_id') == $booking->id ? 'selected' : '' }}>Booking ID {{$booking->id}} - {{$booking->product_option->product->name}}</option>
                                @else
                                    <option value="{{$booking->id}}" prod-id="{{$booking->product_option->product->id}}" {{ Input::old('booking_id',$review->booking_id) === $booking->id ? 'selected' : '' }}>Booking ID {{$booking->id}} - {{$booking->product_option->product->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
					<div class="form-group">
                        <label for="product">Product</label>
                        <select class="form-control select2" id="product" name="product_id">
                            @foreach ($products as $product)
                                @if($mode == 'add')
                                    <option value="{{$product->id}}" {{ Input::old('product_id') == $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                @else
                                    <option value="{{$product->id}}" {{ Input::old('product_id',$review->product_id) === $product->id ? 'selected' : '' }}>{{$product->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ Input::old('name', isset($review) ? $review->name : null) }}">
                    </div>
					<div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ Input::old('email', isset($review) ? $review->email : null) }}">
                    </div>
					<div class="form-group">
                        <label for="rating">Rating</label>
                        <div class='starrr rating' data-connected-input='rating'></div>
						<input type="hidden" id="rating" name="rating" value="{{ Input::old('rating', isset($review) ? $review->rating : null) }}">
                    </div>
					
					<div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment" id="comment">{!! Input::old('comment', isset($review) ? $review->comment : null) !!}</textarea>
                    </div>
					<div class="form-group">
                        <label class="cr-styled">
							<input type="hidden" class="disabled-flag-value" name="flag_show_value" value="{{ $shown ? '1' : '0' }}">
                            @if ($mode == 'add')
                                <input type="checkbox" class="disabled-flag" name="flag_show" {{ $shown ? 'checked' : ''}}>
							@else
                                <input type="checkbox" class="disabled-flag" name="flag_show" {{ $shown ? 'checked' : ''}}>
                            @endif
                            <i class="fa"></i>
                        </label>
                        Shown on Website
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
    $(document).ready(function(){

        $("#booking, #product").select2({'allowClear':true});
		
		$("form").on("change",".disabled-flag",function(){
			var isChecked  = $(this).is(':checked');
			var checkValue = $(this).closest(".cr-styled").find(".disabled-flag-value");
			var value = isChecked ? 1 : 0;
			checkValue.val(value);
			console.log(checkValue.val());
		});
    });
</script>
@stop