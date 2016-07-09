@extends('layouts.master')

{{-- Meta canonical  --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/" />
@stop

{{-- Css files  --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/chosen.min.css" />
	<link rel="stylesheet" href="css/public.css" />
@stop

{{-- Page Title  --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Home | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Override Nav for guest   --}}
{{-- ----------------------------------------------------- --}}
@section('nav')
  @include('layouts.nav')
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
    
 	{{-- Util::ShowPre($pageData) --}}
    
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <h1>@lang('site_content.index_Header')</h1>
	      {{-- @lang('site_content.index_Header_Text') --}}
    <p><a class="btn btn-primary btn-lg scroll" href="#form-inquiry" role="button">@lang('site_content.index_Header_Button')</a></p>
  </div>

  <div class="row">
    <div class="col-md-12">
    
      <!-- Example row of columns -->
      <div class="col-md-8 col-md-offset-1" id="faq">
      
        <h2>@lang('site_content.index_FAQ_Title')</h2>
      @lang('site_content.index_FAQ_Text')

        
        {{ Form::open(array('url' => '/referrals', 'method'=> 'post')) }}
          {{ Form::select('referral', array
                                      (
                                        'friend' => 'Friend',
                                        'associate' => 'Business associate',
                                        'tv' => 'TV',
                                        'news' => 'News Article',
                                        'other' => 'Other',
                                      ),
                                      null, // preselected option
                                      array
                                      (
                                        'data-placeholder' => "Select a Referrer",
                                        'class' => 'form-control chosen-select',
                                      )
                                          
                          )
          }}
          
          <br />
          {{ Form::submit('Submit', array('class' => 'btn btn-md btn-primary')) }}
        {{ Form::close() }}

        <!-- <p><a class="btn btn-primary" href="#" role="button">Apply Now
        &raquo;</a></p> -->
      </div>

      {{-- <div class="col-md-5"> --}}
        {{-- <div style="padding-left: 6em"> --}}
          {{-- <h2>Our Video</h2> --}}
          {{-- <div> --}}
            {{-- <img src="images/video.jpg" alt="" class="opacity"  --}}
                  {{-- style="width: 100%; display: block; margin: 0 0 2em 0; --}}
                          {{-- border-radius: 0.25em"> --}}
          {{-- </div> --}}
          {{-- <h2>Testimonials</h2> --}}
          {{-- <blockquote> --}}
            {{-- <p> --}}
              {{-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. --}}
              {{-- Repellendus non excepturi doloremque voluptate iste velit --}}
              {{-- voluptates vitae ullam eaque quos. --}}
            {{-- </p> --}}
            {{-- <footer>Some Company, Leamington</footer> --}}
          {{-- </blockquote> --}}
          {{-- <blockquote> --}}
            {{-- <p> --}}
              {{-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. --}}
              {{-- Repellendus non excepturi doloremque voluptate iste velit --}}
              {{-- voluptates vitae ullam eaque quos. --}}
            {{-- </p> --}}
            {{-- <footer>Some Company, Leamington</footer> --}}
          {{-- </blockquote> --}}
        {{-- </div> --}}
      {{-- </div> --}}
    </div><!-- .col-md-12 -->
  </div>

  <br>

  <div class="well">

    <form action="?" id="form-inquiry">
      <h2>Inquiry Form</h2>
      <div class="col-md-6">

        <div class="form-group">
          <label class="control-label" for="company-name">
            Company Name <span class="req">*</span>
          </label>
          <input class="form-control input-lg" type="text" id="company-name"
                  name="company-name" placeholder="Your Company Name">
        </div>

        <div class="form-group">
          <label class="control-label" for="customer-name">
            Your Name <span class="req">*</span>
          </label>
          <input class="form-control" type="text" id="customer-name"
                  name="name" placeholder="Your Name">
        </div>

        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label" for="customer-email">
                Email <span class="req">*</span>
              </label>
              <input class="form-control" type="email" id="customer-email"
                      name="email" placeholder="you@company.com">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label" for="customer-phone">
                  Phone <span class="req">*</span>
                </label>
              <input class="form-control" type="phone" id="customer-phone"
                    name="phone" placeholder="(###) ###-####">
            </div>
          </div>

        </div>

      </div>

      <div class="col-md-6">
        <div style="padding-left: 2em">
          <div class="form-group">
            <label class="control-label" for="comments">Comments</label>
            <textarea name="comments" id="comments" rows="6" cols="80"
                      class="form-control"></textarea>
          </div>

          <div class="form-group">
            <input type="submit" value="Send Email" 
                  class="btn btn-lg btn-primary" id="btn-inquiry"
                  data-loading-text="Sending Email..." />

          </div>

        </div>
      </div>
      <div style="clear: both"></div>
    </form>

  </div><!-- .well -->

@stop {{-- content --}}
  
{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/index.js"></script>
	<script src="js/cta-scroll.js"></script>
@stop
