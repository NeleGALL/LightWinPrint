<?php
	//----------GET LAST RECORD
	$get = mysql_query('SELECT `Time` FROM '.db_table.' ORDER BY `Time` LIMIT 1', $dbc);
	while ($row = mysql_fetch_array($get)) {$last = $row['Time'];}
	$dat = lwp_explode_date($last);
	$yearfirst = $dat[0];
	$yearlast = date("Y", time());
	$colspan = ( 12 / ($yearlast - $yearfirst + 1));
	echo '<table align="center" bgcolor="#000000" border="0" bordercolor="#FFFFFF" cellpadding="1" cellspacing="1">';
	echo '<tr class="calendar_off">';
	echo '<td colspan="12" align="center">'.$lwp_lang_calendar.'</td>';
	echo '</tr>';
	echo '<tr class="calendar_off">';
	//YEAR
	for ($i = $yearfirst; $i <= $yearlast; $i++){
		if ($i == $year){
			echo '<td colspan="'.$colspan.'" class="calendar_on">';
			echo '<div align="center">';
			echo $i;
		}else{
			echo '<td colspan="'.$colspan.'">';
			echo '<div align="center">';
			if(lwp_check_year_exists($i, $dbc)){
				echo '<a href="?year='.$year.'&month=1>';
			}
			echo $i;
			if(lwp_check_year_exists($i, $dbc)){
				echo '</a>';
			}
		}
	}
	echo '</div>';
	echo '</td>';
	echo '</tr><tr class="calendar_off">';
	//MONTH
	for ($i = 1; $i <= 12; $i++){
		if (strlen($i) == 1){$i = '0'.$i;}
		if ($i == $month){
			echo '<td class="calendar_on">';
			echo '<div align="center">';
			echo '<a href="?year='.$year.'&month='.$i.'">'.$i.'</a>';
		}else{
			echo '<td>';
			echo '<div align="center">';
			if(lwp_check_month_exists($i, $year, $dbc)){
				echo '<a href="?year='.$year.'&month='.$i.'">';
			}
			echo $i;
			if(lwp_check_month_exists($i, $year, $dbc)){
				echo '</a>';
			}
		}
		echo '</div>';
		echo '</td>';
	}
	echo '</tr>';
	echo '</table>';
?>