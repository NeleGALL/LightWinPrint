<?php
	echo '<div><table><tr><td align="center" width="150px" class="T_Header_Date">'.$lwp_lang_month[$month].' '.$year.'</td></tr></table></div>';
	echo '<table align="center" cellpadding="1" cellspacing="2">';
	echo '<tr class="T_Header">';
	echo '<th align="center" width="100px"><font color="darkblue" size="-1">'.$lwp_lang_day.'</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_users.'</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_printers.'</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_jobs.'</font></th>';
	echo '<th align="center" width="50px"><font color="darkblue" size="-1">'.$lwp_lang_pages.'</font></th>';
	echo '</tr>';
	$sump = 0;
	$sumj = 0;
	for ($i = 31; $i > 0 ; $i--){
		if (strlen($i) == 1){$i = '0'.$i;}
		$get = mysql_query('SELECT COUNT(*), SUM(`Pages`), COUNT(DISTINCT `User`), COUNT(DISTINCT `Printer`) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$i.'%"', $dbc);
		$row = mysql_fetch_assoc($get);
		if (($row['COUNT(*)']) > 0){
			if (date('N', strtotime($i.'-'.$month.'-'.$year)) == 6){
				echo '<tr class="T_Saturday"><td align="center">';
			}elseif(date('N', strtotime($i.'-'.$month.'-'.$year)) == 7){
				echo '<tr class="T_Sunday"><td align="center">';
			}else{
				echo '<tr class="main"><td align="center">';
			}
			echo $i.' '.$lwp_lang_month[$month].' '.$year;
			echo '</td><td align="center"><a href="?year='.$year.'&month='.$month.'&day='.$i.'&mode=u">';
			echo $row['COUNT(DISTINCT `User`)'];
			echo '</a></td><td align="center"><a href="?year='.$year.'&month='.$month.'&day='.$i.'&mode=p">';
			echo $row['COUNT(DISTINCT `Printer`)'];
			echo '</a></td><td align="center">';
			echo $row['COUNT(*)'];
			echo '</td><td align="center">';
			echo $row['SUM(`Pages`)'];
			$sumj = $sumj + $row['COUNT(*)'];
			$sump = $sump + $row['SUM(`Pages`)'];
			echo '</td></tr>';
		}
		if (date('N', strtotime($i.'-'.$month.'-'.$year)) == 1){
			$weekj = 0;
			$weekp = 0;
			for ($j = 0; $j <= 6; $j++){
				$f = $i + $j;
				if (strlen($f) == 1){$f = '0'.$f;}
				$getj = mysql_query('SELECT COUNT(*), SUM(`Pages`) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-'.$f.'%"', $dbc);
				$rowj = mysql_fetch_assoc($getj);
				if (($rowj['COUNT(*)']) > 0){
					$weekj = $weekj + $rowj['COUNT(*)'];
					$weekp = $weekp + $rowj['SUM(`Pages`)'];
				}
			}
			if ($weekj > 0){
				echo '<tr><td></td><td></td><td></td><td class="T_Summ_Week" align="center">';
				echo $weekj;
				echo '</td><td class="T_Summ_Week" align="center">';
				echo $weekp;
				echo '</td></tr>';
				echo '<tr><td colspan="5"><hr></td></tr>';
			}
		}
	}
	echo '<tr><td></td>';
	$get = mysql_query('SELECT COUNT(*), SUM(`Pages`), COUNT(DISTINCT `User`), COUNT(DISTINCT `Printer`) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-%"', $dbc);
	$row = mysql_fetch_assoc($get);
	if (($row['COUNT(*)']) > 0){
		echo '<td class="T_Summ" align="center"><a href="?year='.$year.'&month='.$month.'&day=%&mode=u">';
		echo $row['COUNT(DISTINCT `User`)'];
		echo '</a></td><td class="T_Summ" align="center"><a href="?year='.$year.'&month='.$month.'&day=%&mode=p">';
		echo $row['COUNT(DISTINCT `Printer`)'];
		echo '</a>';
	}else{
		echo '</td><td></td><td>';
	}
	echo '</td><td class="T_Summ" align="center">';
	echo $sumj;
	echo '</td><td class="T_Summ" align="center">';
	echo $sump;
	echo '</td></tr>';
	echo '</table>';
?>