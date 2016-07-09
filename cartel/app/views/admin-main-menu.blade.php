@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin_menu" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
  Admin Main Menu | Cartel Marketing Inc. | Leamington, Ontario
@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')

            
<h1>Admin - Main Menu</h1>

	<div class="row">
		<div class="col-md-6">
			Transaction Search:
			<FORM ACTION="/admin_menu" METHOD="get">
				<INPUT TYPE="text" NAME="trans_id" VALUE="">
				<INPUT class="btn btn-primary" TYPE="submit" VALUE="Search &raquo;">
			</FORM>
			<BR>
		</div>
		<div class="col-md-6">
			Some other search:
			<FORM ACTION="/admin_menu" METHOD="get">
				<INPUT TYPE="text" NAME="trans_id" VALUE="">
				<INPUT class="btn btn-primary" TYPE="submit" VALUE="Search &raquo;">
			</FORM>
			<BR>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<B>Daily Operations</B>
			<UL>
			<LI> <a HREF="admin-reports-recent-bids">Recent Bids</a> <i class="fa fa-hand-o-left" style="color: orange;"> new</i>
			<LI> <a HREF="admin-user/list">Online Users</a>
			<LI> <i HREF="">Manual Transactions</i>
			<LI> <i HREF="">zzz</i>
			<LI> <i HREF="">zzz</i>
			<LI> <i HREF="">zzz</i>
			</UL>
		</div>
		<div class="col-md-4">
			<B>Reports</B>
			<UL>
			<LI> <a HREF="admin-reports-completed-transactions">Completed Transactions</a> <i class="fa fa-hand-o-left" style="color: orange;"> dev</i>
			<LI> <a HREF="admin-reports-customer-history">Customer History</a> <i class="fa fa-hand-o-left" style="color: orange;"> dev</i>
			<LI> <a HREF="admin-reports/top-companies/30">Top Companies</a>
			<LI> <i HREF="">zzz</i>
			</UL>
		</div>
		<div class="col-md-4">
			<B>Company</B>
			<UL>
			<LI> <A HREF="admin-company">Companies & Users</A> <i class="fa fa-hand-o-left" style="color: orange;"> new</i>
			<LI> <i HREF="">Company Types</i>
			<LI> <A HREF="admin-permission">Permissions Setup</A> <i class="fa fa-hand-o-left" style="color: orange;"> new</i>
			</UL>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<B>Product Details</B>
			<UL>
			<LI> <A HREF="admin-category">Categories</A>
			<LI> <A HREF="admin-colour">Colours</A>
			{{-- <LI> <A HREF="admin-country">Countries & Provinces</A> --}}
			<LI> <A HREF="admin-maturity">Maturity</A>
			<LI> <A HREF="admin-origin">Origins</A>
			<LI> <A HREF="admin-package">Packages</A>
			<LI> <A HREF="admin-quality">Quality</A>
			<LI> <A HREF="admin-weight-type">Weight Types</A>
			<LI> <A HREF="admin-product-image">Product Images</A>
			</UL>
		</div>
		<div class="col-md-4">
			<B>Some Other heading</B>
			<UL>
			<LI> <i HREF="">Messaging System</i>
			<LI> <i HREF="">zzz</i>
			<LI> <i HREF="">zzz</i>

			</UL>
		</div>
		<div class="col-md-4">
			<B>Site Related</B>
			<UL>
			<LI> <i HREF="">General Config</i>
			<LI> <A HREF="admin-content/site/{{{ $pageData['language_id'] }}}">Site Content</A> <i class="fa fa-ban" style="color: orange;"> don't use</i>
			<LI> <A HREF="admin-content/help/{{{ $pageData['language_id'] }}}">Help Content</A>
			<LI> <A HREF="view-the-board/edit">Board Settings</A>
			<LI> <i HREF="">Brokerage Fees</i>
			<LI> <i HREF="">zzz</i>
			<LI> <i HREF="">zzz</i>
			<LI> <i HREF="">zzz</i>
			</UL>
		</div>
	</div>





@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
