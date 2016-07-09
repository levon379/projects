@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/signup" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/bid-details.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Signup | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
            
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2">
      <div class="page-header">
        <h2>Sign up</h2>
      </div>

      <!-- Change the "action" attribute to your back-end URL -->
      <form id="registrationForm" method="post" class="form-horizontal" action="?">
        <div class="form-group">
          <label class="col-lg-3 control-label">Username</label>
          <div class="col-lg-5">
            <input type="text" class="form-control" name="username" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 control-label">Email address</label>
          <div class="col-lg-5">
            <input type="text" class="form-control" name="email" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 control-label">Password</label>
          <div class="col-lg-5">
            <input type="password" class="form-control" name="password" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 control-label">Gender</label>
          <div class="col-lg-5">
            <div class="radio">
              <label>
                <input type="radio" name="gender" value="male" /> Male
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="gender" value="female" /> Female
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="gender" value="other" /> Other
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 control-label">Date of birth</label>
          <div class="col-lg-5">
            <input type="text" class="form-control" name="birthday"
            placeholder="YYYY/MM/DD" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-9 col-lg-offset-3">
            <!-- Do NOT use name="submit" or id="submit" for the Submit button -->
            <button type="submit" class="btn btn-default">Sign up</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@stop {{-- content --}}

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
	<script src="js/test.js"></script>
@stop
