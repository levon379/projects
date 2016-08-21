							<div id="booking-form-errors">
						        
						    </div>
				
							<div class="col date">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<div class="title">
									<span class="number">1</span>
									<span class="text">Pick a date</span>
								</div>
								<div class="form-group">
									<div class="input-group date" id="booking-date">
										<input id="travel-date-field" name="travel_date" type="text" class="form-control" value="{{ \Input::old('travel_date', $calendarStartDate) === null ?  Carbon::today()->addDays(2)->format('d/m/Y') : \Input::old('travel_date', $calendarStartDate->format("d/m/Y"))}}" placeholder="{{ Carbon::today()->addDays(2)->format('d/m/Y') }}">
										<span class="input-group-addon">
											<span class="icon-calender"></span>
										</span>
									</div>
								</div>
							</div>
							
							<div class="col option">
								<div class="title">
									<span class="number">2</span>
									<span class="text">Choose options</span>
								</div>
								<div class="form-group">
									<label for="language-id-field">Language:</label>
									 <select id="language-id-field" name="language_id" class="form-control">
									 	<option value="0"></option>
										
									</select> 
								</div>
								<div class="form-group">
									<label for="product-option-id">Option:</label>
									 <select id="product-option-id" name="product_option_id" class="form-control">
										<option></option>
									</select> 
								</div>
							</div>

							<div class="col traveler">
								<div class="title">
									<span class="number">3</span>
									<span class="text">Select travelers</span>
								</div>
								<div class="form-group">
									<label for="adult">Adults: <span class="text-muted" id="adult_rate"></span></label>
									 <select id="no-adult" name="no_adult" class="form-control">
									 	<option value="0" disabled selected></option>
										@for( $i=2; $i <=8; $i++ )
										<option value="{{$i}}">{{$i}}</option>
										@endfor
									</select> 
								</div>
								<div id="no-children-container" class="form-group">
									<label for="children">Children: <span class="text-muted" id="child_rate">Age 1-15</span></label>
									 <select id="no-children" name="no_children" class="form-control"  >
									 	<option value="0" disabled selected></option>
										@for( $i=0; $i <=8; $i++ )
										<option value="{{$i}}">{{$i}}</option>
										@endfor
									</select> 
								</div>
							</div>

							<div class="col cart">
								<span class="price-holder">
									Total: <span id="tour-price" class="price">0.00 €</span>
								</span>
								<button type="submit" class="btn btn-info">Add to cart<span class="icon-arrow"></span></button>
							</div>