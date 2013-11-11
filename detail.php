<?php
	$day = $_GET['day'];
	if($_GET['day'] == "%"){$lang_day = $lwp_lang_whole;}else{$lang_day = $day;}
	echo '<div><table><tr><td align="center" width="150px" class="T_Header_Date">'.$lang_day.' '.$lwp_lang_month[$month].' '.$year.'</td></tr></table></div>';
	echo '<div><table><tr><td align="center" width="150px" class="T_Header_Date">';
	if ($_GET['mode'] == "p"){echo $lwp_lang_printer.'<br>'.iconv("utf-8", "windows-1251", $_GET['rl']);}else//****CHNG
	{echo $lwp_lang_user.'<br>'.$user = lwp_ldap_get($_GET['item']);}//****CHNG
	echo '</td></tr></table></div>';
	echo '<br>';
	//Суммарная таблица
	echo '<table align="center" cellpadding="1" cellspacing="2">';
	echo '<tr class="T_Header">';
	echo '<th align="center" width="150px"><font color="darkblue" size="-1">';
	if ($_GET['mode'] == "p"){echo $lwp_lang_user;}//****CHNG
	if ($_GET['mode'] == "u"){echo $lwp_lang_printer;}//****CHNG
	echo '</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_jobs.'</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_pages.'</font></th>';
	echo '</tr>';
	$q = 'SELECT SUM(`Pages`), COUNT(*), `User`, `RealPrinter` FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$day.'%" ';
	if ($_GET['mode'] == "p"){$q = $q.'AND `Printer` = "'.$_GET['item'].'" GROUP BY `User` ORDER BY `RealPrinter`';}//****CHNG
	if ($_GET['mode'] == "u"){$q = $q.'AND `User` = "'.$_GET['item'].'" GROUP BY `RealPrinter`';}//****CHNG
	$get = mysql_query($q, $dbc);
	$sump = 0;
	$sumj = 0;
	while ($row = mysql_fetch_array($get)) {
		$user = lwp_ldap_get($row['User']);
		echo '<tr class="main"><td>';
		if ($_GET['mode'] == "p"){echo $user;}//****CHNG
		if ($_GET['mode'] == "u"){echo iconv("utf-8", "windows-1251", $row['RealPrinter']);}//****CHNG
		echo '</td><td align="center">';
		echo $row['COUNT(*)'];
		echo '</td><td align="center">';
		echo $row['SUM(`Pages`)'];
		echo '</td></tr>';
		$sump = $sump + $row['SUM(`Pages`)'];
		$sumj = $sumj + $row['COUNT(*)'];
	}
	echo '<tr><td></td><td class="T_Summ" align="center">';
	echo $sumj;
	echo '</td><td class="T_Summ" align="center">';
	echo $sump;		
	echo '</td></tr>';
	echo '</table><br>';
	//Детализация
	$q = 'SELECT `Time`, `Pages`, `User`, `Document`, `RealPrinter` FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$day.'%" ';
	if ($_GET['mode'] == "p"){$q = $q.'AND `Printer` = "'.$_GET['item'].'" ORDER BY `Time` DESC';}//****CHNG
	if ($_GET['mode'] == "u"){$q = $q.'AND `User` = "'.$_GET['item'].'" ORDER BY `Time` DESC';}//****CHNG
	$get = mysql_query($q, $dbc);
	echo '<div class="spoiler-wrapper"><div class="spoiler folded"><a href="#" class="lwp_dyn_a">'.$lwp_land_detail.'</a></div><div class="spoiler-text">';
	echo '<table align="center" cellpadding="1" cellspacing="2">';
	echo '<tr class="T_Header">';
	echo '<th align="center" width="150px"><font color="darkblue" size="-1">'.$lwp_lang_time.'</font></th>';
	echo '<th align="center" width="150px"><font color="darkblue" size="-1">';
	if ($_GET['mode'] == "p"){echo $lwp_lang_user;}//****CHNG
	if ($_GET['mode'] == "u"){echo $lwp_lang_printer;}//****CHNG
	echo '</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_pages.'</font></th>';
	echo '<th align="center" width="250px"><font color="darkblue" size="-1">'.$lwp_lang_doc.'</font></th>';
	echo '</tr>';
	while ($row = mysql_fetch_array($get)) {
		$user = lwp_ldap_get($row['User']);
		echo '<tr class="main"><td align="center">';
		echo $row['Time'];
		echo '</td><td align="left">';
		if ($_GET['mode'] == "p"){echo $user;}//****CHNG
		if ($_GET['mode'] == "u"){echo iconv("utf-8", "windows-1251", $row['RealPrinter']);}//****CHNG
		echo '</td><td align="center">';
		echo $row['Pages'];	
		echo '</td><td align="center">';
		echo iconv("utf-8", "windows-1251", $row['Document']);
		$sump = $sump + $rowi['Pages'];
		$sumj = $sumj + $rowi['COUNT(*)'];
		echo '</td></a></tr>';
	}
	echo '</table></div></div>';
?>