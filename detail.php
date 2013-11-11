<?php
if (isset($_POST["Detail"])){
	//------------------------------//Подключение к базе
	require_once 'config.php';
	require_once 'functions.php';
	$dbc = connect_to_db();
	//------------------------------//
	list ($startstr, $stopstr) = lwp_today_day();
	if (isset($_POST["Range"])) { list ($startstr, $stopstr) = lwp_expode($_POST["Range"]); };
	//------------------------------//	
	if (isset($_POST["Type"]) && isset($_POST["Where"]) && isset($_POST["Group"]) && $_POST["Detail"] == "1") {		
		$get = mysql_query('SELECT `'.$_POST["Type"].'`, SUM(`Pages`) FROM `'.db_table.'` WHERE `Time` > "'.$startstr.'" AND `Time` < "'.$stopstr.'" GROUP BY `'.$_POST["Type"].'` ORDER BY SUM(`Pages`) DESC', $dbc);
		echo "<table>";
		echo "From <b>".lwp_explode_space($startstr)."</b> to <b>".lwp_explode_space($stopstr)."</b>";
		while ($row = mysql_fetch_array($get)) {
			$shown = $row[$_POST["Type"]];
			if (lwp_ldap_use){
				$us=lwp_ldap_search($row[$_POST["Type"]]);
				if ($us <> ""){
					$shown = $us;
				}
			}
			echo '<tr><td bgcolor="#DCFACD" width="150px">';
			echo '<a href="#" onclick="lwp_post(\'detail.php\', \'Detail=2&Type='.$_POST["Type"].'&Where='.$_POST["Where"].'&Who='.$row[$_POST["Type"]].'&Group='.$_POST["Group"].'&Range='.lwp_mysql_to_date($startstr).' - '.lwp_mysql_to_date($stopstr).'\', \''.$_POST["Where"].'\')">';
			echo $shown;
			echo '</a>';
			echo '</td><td bgcolor="#FAF7CA" width="50px">';
			echo $row['SUM(`Pages`)'];
			echo "</td></tr>";
		}
		echo "</table>";
	}
	if (isset($_POST["Type"]) && isset($_POST["Where"]) && isset($_POST["Group"]) && isset($_POST["Who"]) && $_POST["Detail"] == "2" && isset($_POST["Range"])) {
		$get = mysql_query('SELECT `'.$_POST["Type"].'`, `'.$_POST["Group"].'`, SUM(`Pages`) FROM `'.db_table.'` WHERE `Time` > "'.$startstr.'" AND `Time` < "'.$stopstr.'" AND `'.$_POST["Type"].'` = "'.($_POST["Who"]).'" GROUP BY `'.$_POST["Group"].'` ORDER BY SUM(`Pages`) DESC', $dbc);
		echo "<table>";
		echo "From <b>".lwp_explode_space($startstr)."</b> to <b>".lwp_explode_space($stopstr)."</b>";
		while ($row = mysql_fetch_array($get)) {
			$shown = $row[$_POST["Type"]];
			if (lwp_ldap_use){
				$us=lwp_ldap_search($row[$_POST["Type"]]);
				if ($us <> ""){
					$shown = $us;
				}
			}
			echo '<tr><td bgcolor="#DCFACD" width="250px">';
			echo '<a href="#" onclick="lwp_post(\'detail.php\', \'Detail=3&Type='.$_POST["Type"].'&Where='.$_POST["Where"].'&Who='.$row[$_POST["Type"]].'&Group='.$_POST["Group"].'&Sum='.$row[$_POST["Group"]].'&Range='.lwp_mysql_to_date($startstr).' - '.lwp_mysql_to_date($stopstr).'\', \''.$_POST["Where"].'\')">';
			echo $shown;
			echo ' on ';
			echo $row[$_POST["Group"]];			
			echo '</a>';
			echo '</td><td bgcolor="#FAF7CA" width="50px">';
			echo $row['SUM(`Pages`)'];
			echo "</td></tr>";
		}
		echo "</table>";
	}
	//`'.$_POST["Type"].'`, `Document`, `'.$_POST["Group"].'`, `Pages`
	if (isset($_POST["Type"]) && isset($_POST["Where"]) && isset($_POST["Group"]) && isset($_POST["Who"]) && $_POST["Detail"] == "3" && isset($_POST["Range"])) {
		echo "From <b>".lwp_explode_space($startstr)."</b> to <b>".lwp_explode_space($stopstr)."</b>";
		$get = mysql_query('SELECT * FROM `'.db_table.'` WHERE `Time` > "'.$startstr.'" AND `Time` < "'.$stopstr.'" AND `'.$_POST["Type"].'` = "'.($_POST["Who"]).'" AND `'.$_POST["Group"].'` = "'.$_POST["Sum"].'" ORDER BY `Time` DESC', $dbc);
		echo "<table>";
		$shown = $_POST["Who"];
		if (lwp_ldap_use){
			$us=lwp_ldap_search($_POST["Who"]);
			if ($us <> ""){
				$shown = $us;
			}
		}
		echo '<tr><td>'.$shown.' on '.$_POST["Sum"].'</td></tr>';
		while ($row = mysql_fetch_array($get)) {
			echo '<tr><td bgcolor="#DCFACD" width="100px">';
			echo $row["Time"];
			echo '</td>';
			echo '<td bgcolor="#FAF7CA" width="400px">';
			echo $row["Document"];
			echo '</td>';
			echo '<td bgcolor="#FAF7CA" width="20px">';
			echo $row["Pages"];
			echo "</td><td width=auto></td></tr>";
		}
		echo "</table>";
	}
	mysql_close($dbc);
}
?>