<?php
if (isset($_POST["User"]) && isset($_POST["Printer"]) && isset($_POST["Range"])){
	//------------------------------//����������� � ����
	require_once 'config.php';
	require_once 'functions.php';
	$dbc = connect_to_db();
	//------------------------------//���������
	mysql_set_charset('utf8');
	//------------------------------//������ �����
	$user =  $_POST["User"];
	$userstr = "";
	if ($user != "*"){
		$userstr = ' `User` = "'.$user.'" AND';
	}
	//------------------------------//������ �������
	$printer = $_POST["Printer"];
	$printerstr = "";
	if ($printer!="*"){
		$printerstr = ' `Printer` = "'.$printer.'" AND';
	}
	//------------------------------//������ �������� ���
	list($startdate, $stopdate) = explode("-", $_POST["Range"]);
	$startstr = date('Y-m-d', strtotime($startdate))." 00:00:00";
	$stopstr = date('Y-m-d', strtotime($stopdate))." 23:59:59";
	//------------------------------//������ ������, � ����� �������������� �������
	$req = 'SELECT * FROM `'.db_table.'` WHERE'.$userstr.$printerstr.' `Time` > "'.$startstr.'" AND `Time` < "'.$stopstr.'"';
	$get = mysql_query($req, $dbc);
	echo '<table cellspacing="2" cellpadding="10">';
	while ($row = mysql_fetch_array($get)) {
		echo '<tr><td width="150px" bgcolor="#DCFACD">';
        echo $row['User'];
		echo '</td><td width="150px" bgcolor="#FAF7CA">';
        echo $row['Printer'];
		echo '</td><td width="350px" bgcolor="#FAF7CA">';
        echo iconv( 'cp1251', 'utf-8', $row['Document']);
		echo "</td></tr>";
	}
	echo "</table>";
	//------------------------------//�������� ����������. ������� �������� ����.
	mysql_close($dbc);
}
?>