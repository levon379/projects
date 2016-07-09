<script type="text/javascript">
$(document).ready(function() {
try {
$(document).bind("contextmenu", function(e) {
e.preventDefault();
$("#custom-menu").css({ top: e.pageY + "px", left: e.pageX + "px" }).show(100);
});
$(document).mouseup(function(e) {
var container = $("#custom-menu");
if (container.has(e.target).length == 0) {
container.hide();
}
});
}
catch (err) {
alert(err);
}
});
</script>
<style type="text/css">
#custom-menu
{
	z-index: 1000;
	position: absolute;
	border: solid 2px black;
	background-color: white;
	padding: 5px 0;
	display: none;
}
#custom-menu ol
{
	padding: 0;
	margin: 0;
	list-style-type: none;
	min-width: 130px;
	width: auto;
	max-width: 200px;
	font-family:Verdana;
	font-size:12px;
}
#custom-menu ol li
{
	margin: 0;
	display: block;
	list-style: none;
	padding: 5px 5px;
}
#custom-menu ol li:hover
{
	background-color: #efefef;
}

#custom-menu ol li:active
{
	color: White;
	background-color: #000;
}

#custom-menu ol .list-devider
{
	padding: 0px;
	margin: 0px;
}

#custom-menu ol .list-devider hr
{
	margin: 2px 0px;
}

#custom-menu ol li a
{
	color: Black;
	text-decoration: none;
	display: block;
	padding: 0px 5px;
}
#custom-menu ol li a:active
{
	color: White;
}
</style>
<div id="custom-menu">
<ol>
<li><a href="#">Reply</a> </li>
<li><a href="#">Reply All</a> </li>
<li class="list-devider">
<hr />
</li>
<li><a href="#">Mark as unread</a> </li>
<li><a href="#">Delete</a> </li>
<li><a href="#">Archive</a> </li>
<li class="list-devider">
<hr />
</li>
<li><a href="#">Junk</a> </li>
<li><a href="#">View</a> </li>
</ol>
</div>