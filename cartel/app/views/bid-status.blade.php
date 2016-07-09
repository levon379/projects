@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/bid-status" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="{{ URL::asset('css/bid-status.css') }}" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  @if($status == "accept")
    Bid Accepted!
  @else
    Bid Declined.
  @endif
@stop


{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

  {{-- Page Header --}}
  @if($status == "accept")
    <h1>
      Bid Accepted!
    </h1>
  @else
    <h1>
      Bid Declined.
    </h1>
  @endif
  
  {{-- Accept/Decline message --}}
  @if($status == "accept")
    <p class="bg-info">
    You have chosen to <span style="font-weight:bold">accept</span> this bid.
    <br />
    You will receive an e-mail to confirm this transaction. <br />
    Please print the document and forward it immediately to your shipping or
    receiving departments.
    </p>
  @else
    <p class="bg-danger">
      You have chosen to <span style="font-weight:bold">decline</span> this
      bid.<br /> Bidding will now continue on this item. <br />
      The bidder has been emailed to notify them that their bid attempt was
      unsuccessful.
    </p>
  @endif

  
  <a href="my-bids" class="btn btn-primary btn-lg">OK</a>
@stop


{{-- Bottom Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
