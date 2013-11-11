<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<!--META HTTP-EQUIV="REFRESH" CONTENT="600"-->
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="post-check=0,pre-check=0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="max-age=0">
<meta HTTP-EQUIV="EXPIRES" CONTENT="0">
<script type="text/javascript" src="jquery-1.2.1.js"></script>
<script type="text/javascript" src="datepicker.js"></script>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#datetime1').attachDatepicker({
		rangeSelect: true,
		yearRange: '2013:2050',
		firstDay: 1
	});
	//lwp_post('detail.php', 'Detail=1&Type=User&Where=lwp&Group=Printer&Range='+lwp_cur_range() , 'lwp');
});
</script>
<link rel="stylesheet"  href="style.css" />
<title> PRINTERS USAGE </title>
</head><body bgcolor="#DBDBDB">
<!--div><center><table><tr><td>
<td align="right" width="800px" valign="top"><div align="left">
<form action="get.php" method="post">
	<br><br><br>
	Диапазон дат<input type="text" name="Range" id="datetime1" value="" />
	<input type="button" value="получить" onclick="lwp_post('detail.php', 'Detail=1&Type=User&Where=lwp&Group=Printer' + '&Range=' + encodeURIComponent(document.getElementById('datetime1').value), 'lwp')"/>
	</div></td></tr></table>
	<br><button onclick="lwp_post('detail.php', 'Detail=1&Type=Printer&Where=lwp&Group=User', 'lwp')">Переключить на принтеры</button>
	</div>
	<br><br>
</form>
</td></tr></table></center>
</div-->
<div width="100%" align="center">
<?php include 'calend.php'; ?>
</div>
<div align="center"><table align="center" ><tr><td align="right" width="800px" valign="top"><div align="left" id="lwp">
</div></td></tr></table></div>
</body></html>