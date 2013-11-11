<?php
	require_once 'config.php';
	require_once 'functions.php';
	
	$dbc = connect_to_db();
	//-----------------GET TIME
	if (isset($_GET["date"])) {
		$now = mktime($_GET["date"]);
	}else{
		$now = lwp_day(time(), true);
	}
	//----------GET LAST RECORD
	$get = mysql_query('SELECT `Time` FROM '.db_table.' ORDER BY `Time` LIMIT 1', $dbc);
	while ($row = mysql_fetch_array($get)) {
		$last = $row['Time'];
	}
	$need = lwp_explode_date($now);
	$needyear = $need[0];
	$needmonth = $need[1];
	$dat = lwp_explode_date($last);
	$yearfirst = $dat[0];
	$yearlast = date("Y", time());
	$colspan = ( 12 / ($yearlast - $yearfirst + 1));
	echo '<table align="center" bgcolor="#000000" border="0" bordercolor="#FFFFFF" cellpadding="1" cellspacing="1">';
	echo '<tr bgcolor="beige">';
	echo '<td colspan="12" align="center">'.$lwp_lang_calendar.'</td>';
	echo '</tr>';
	echo '<tr bgcolor="beige">';
	//YEAR
	for ($i = $yearfirst; $i <= $yearlast; $i++){
		if ($i == $needyear){
			echo '<td colspan="'.$colspan.'" bgcolor="#FFD700">';
			echo '<div align="center">';
			echo $i;
		}else{
			echo '<td colspan="'.$colspan.'">';
			echo '<div align="center">';
			if(lwp_check_year_exists($i, $dbc)){
				echo '<a href="">';
			}
			echo $i;
			if(lwp_check_year_exists($i, $dbc)){
				echo '</a>';
			}
		}
	}
	echo '</div>';
	echo '</td>';
	echo '</tr><tr bgcolor="beige">';
	//MONTH
	for ($i = 1; $i <= 12; $i++){
		if (strlen($i) == 1){$i = '0'.$i;}
		if ($i == $needmonth){
			echo '<td bgcolor="#FFD700">';
			echo '<div align="center">';
			echo $i;
		}else{
			echo '<td>';
			echo '<div align="center">';
			if(lwp_check_month_exists($i, $needyear, $dbc)){
				echo '<a href="">';
			}
			echo $i;
			if(lwp_check_month_exists($i, $needyear, $dbc)){
				echo '</a>';
			}
		}
		echo '</div>';
		echo '</td>';
	}
	echo '</tr>';
	echo '</table>';
?>