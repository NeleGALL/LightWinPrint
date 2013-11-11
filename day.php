<?php
	$day = $_GET['day'];
	if($_GET['day'] == "%"){$lang_day = $lwp_lang_whole;}else{$lang_day = $day;}
	if ($_GET['mode'] == "p"){
		echo '<div><table><tr><td align="center" width="150px" class="T_Header_Date">'.$lang_day.' '.$lwp_lang_month[$month].' '.$year.'</td></tr></table></div>';
		echo '<table align="center" cellpadding="1" cellspacing="2">';
		echo '<tr class="T_Header">';
		echo '<th align="left" width="200px"><font color="darkblue" size="-1">'.$lwp_lang_printer.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_users.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_jobs.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_pages.'</font></th>';
		echo '</tr>';
		$get = mysql_query('SELECT SUM(`Pages`), COUNT(DISTINCT `User`), COUNT(*), `Printer`, `RealPrinter` FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$day.'%" GROUP BY `Printer` ORDER BY `RealPrinter`', $dbc);
		$sump = 0;
		$sumj = 0;
		while ($row = mysql_fetch_array($get)) {
			echo '<tr class="main"><td align="left"><a href="?year='.$year.'&month='.$month.'&day='.$day.'&mode=p&item='.$row['Printer'].'&rl='.$row['RealPrinter'].'">';
			echo iconv("utf-8", "windows-1251", $row['RealPrinter']);
			echo '</a></td><td align="center">';
			echo $row['COUNT(DISTINCT `User`)'];
			echo '</td><td align="center">';
			echo $row['COUNT(*)'];	
			echo '</td><td align="center">';
			echo $row['SUM(`Pages`)'];
			$sump = $sump + $row['SUM(`Pages`)'];
			$sumj = $sumj + $row['COUNT(*)'];
			echo '</td></a></tr>';
		}
		echo '<tr><td></td><td></td><td class="T_Summ" align="center">';
		echo $sumj;
		echo '</td><td class="T_Summ" align="center">';
		echo $sump;
		echo '</td></tr>';
		echo '</table>';
	}elseif ($_GET['mode'] == "u"){
		echo '<div><table><tr><td align="center" width="150px" class="T_Header_Date">'.$lang_day.' '.$lwp_lang_month[$month].' '.$year.'</td></tr></table></div>';
		echo '<table align="center" cellpadding="1" cellspacing="2">';
		echo '<tr class="T_Header">';
		echo '<th align="center" width="200px"><font color="darkblue" size="-1">'.$lwp_lang_user.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_printers.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_jobs.'</font></th>';
		echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_pages.'</font></th>';
		echo '</tr>';
		$get = mysql_query('SELECT COUNT(*), SUM(`Pages`), `User`, COUNT(DISTINCT `Printer`) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$day.'%" GROUP BY `User`', $dbc);
		$sump = 0;
		$sumj = 0;
		while ($row = mysql_fetch_array($get)) {
			$user = lwp_ldap_get($row['User']);
			echo '<tr class="main"><td align="left"><a href="?year='.$year.'&month='.$month.'&day='.$day.'&mode=u&item='.$row['User'].'">';
			echo $user;
			echo '</a></td><td align="center">';
			echo $row['COUNT(DISTINCT `Printer`)'];
			echo '</td><td align="center">';
			echo $row['COUNT(*)'];
			echo '</td><td align="center">';
			echo $row['SUM(`Pages`)'];
			$sump = $sump + $row['SUM(`Pages`)'];
			$sumj = $sumj + $row['COUNT(*)'];
			echo '</td></a></tr>';
		}
		echo '<tr><td></td><td></td><td class="T_Summ" align="center">';
		echo $sumj;
		echo '</td><td class="T_Summ" align="center">';
		echo $sump;
		echo '</td></tr>';
		echo '</table>';
	}
?>