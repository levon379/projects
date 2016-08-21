<div class="row">
	<div class="col-sm-8">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" value="@if (isset($voucher)) {{ Input::old('name', $voucher->name) }} @endif">
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="language-id">Language</label>
			<select name="language_id" id="language-id" class="form-control select2">
				<option value="">Choose Language</option>
				@foreach ($languages as $language)
					@if (isset($voucher))
						<option value="{{ $language->id }}" {{ (Input::old("language_id", $voucher->language_id) === $language->id) ? 'selected' : '' }}>{{ $language->name }}</option>
					@else
						<option value="{{ $language->id }}" {{ (Input::old("language_id") === $language->id) ? 'selected' : '' }}>{{ $language->name }}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-8">
		<div class="form-group">
			<label for="website_id">Website</label>
			<select name="website_ids[]" id="website-id" class="form-control select2" multiple>
				@foreach ($websites as $website)
					@if (isset($voucher))
						<option value="{{ $website->id }}" {{ (true == $voucher->websites->contains($website->id)) ? 'selected' : '' }}>{{ $website->name }}</option>
					@else
						<option value="{{ $website->id }}" {{ in_array($website->id, Input::old("website_ids",[]), true) ? "selected" : "" }}>{{ $website->name }}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<label for="provider-id">Provider</label>
			<select name="provider_id" id="provider-id" class="form-control select2">
				<option value="">Choose Provider</option>
				@foreach ($providers as $provider)
					@if (isset($voucher))
						<option value="{{ $provider->id }}" {{ Input::old('provider_id', $voucher->provider_id) === $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
					@else
						<option value="{{ $provider->id }}" {{ Input::old('provider_id') === $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
</div>	
<div class="form-group">
	<label for="greeting">Greeting <a href="#" id="placeHoldersInfo"><i class="glyphicon glyphicon-info-sign"></i> placeholders</a></label>
	<textarea name="greeting" class="form-control" id="greeting">@if (isset($voucher)) {{ Input::old('greeting', $voucher->greeting) }} @endif</textarea>
</div>

		
		
		
@section('script')
<script>
	$(document).ready(function(){
		$("#placeHoldersInfo").click(function(e){
			e.preventDefault();
			swal("List of available placeholders", "provider_name, product_name, name, greeting, created_at, refrence_number, travel_date, no_adult, no_children, total_pax, departure_time, total_paid, payment_method, departpoint_instructions, provider_contact_details, passengers, addon_names");
		});
		$('#greeting').editable({inlineMode: false, height: 300,
			  // Set custom buttons with separator between them.
			buttons: ["bold", "italic", "underline", "sep", "strikeThrough", "subscript", "superscript", "sep", "align", "insertOrderedList", "insertUnorderedList", "sep", "fontFamily", "fontSize", "color", "sep",  "outdent", "indent", "undo", "removeFormat", "redo", "sep", "table", "createLink", "insertImage", "insertVideo",  "insertHorizontalRule",  "uploadFile", "html"]
	    });
	    $(".froala-wrapper").next("div").hide();
	});
</script>
@stop