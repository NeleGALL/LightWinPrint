<?php
	list ($startstr, $stopstr) = lwp_today_day();
	//------------------------------//Подключение к базе
	require_once 'config.php';
	require_once 'functions.php';
	$dbc = connect_to_db();
	//------------------------------//
	$req = 'SELECT `User`, SUM(`Pages`) FROM `'.db_talbe.'` WHERE `Time` > "'.$startstr.'" AND `Time` < "'.$stopstr.'" GROUP BY `User` ORDER BY SUM(`Pages`) DESC';
	$get = mysql_query($req, $dbc);
	echo "<table>";	
	while ($row = mysql_fetch_array($get)) {
		echo '<tr><td bgcolor="#DCFACD" width="150px">';
		echo $row['User'];
		echo '</td><td bgcolor="#FAF7CA" width="50px">';
		echo iconv( 'cp1251', 'utf-8', $row['SUM(`Pages`)']);
		echo "</td></tr>";
	}
	echo "</table>";
?>