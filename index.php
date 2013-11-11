<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META HTTP-EQUIV="REFRESH" CONTENT="120">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="post-check=0,pre-check=0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="max-age=0">
<meta HTTP-EQUIV="EXPIRES" CONTENT="0">
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.spoiler-text').hide()
		jQuery('.spoiler').click(function(){
			jQuery(this).toggleClass("folded").toggleClass("unfolded").next().slideToggle()
		})
	})
</script>
<link rel="stylesheet"  href="style.css" />
<title> PRINTERS USAGE </title>
</head><body class="bg">
<div width="100%" align="center">
<?php
require_once 'functions.php';
require_once 'config.php';
$dbc = connect_to_db();
if (isset($_GET["year"])) {$year = ($_GET["year"]);}else{$year = date("Y", time());}
if (isset($_GET["month"])) {$month = ($_GET["month"]);}else{$month = date("m", time());}
include 'calend.php'; 
include 'tables.php';
?>
</div>
<div align="center"><table align="center" ><tr><td align="right" width="800px" valign="top"><div align="left" id="lwp">
</div></td></tr></table></div>
</body></html>