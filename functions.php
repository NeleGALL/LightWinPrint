<?php
require_once 'config.php';
require_once 'lang/'.lwp_lang.'.php';
function connect_to_db(){
    $dbconnection = mysql_connect(db_host,db_name,db_pass);
    if (!$dbconnection) { die('Ошибка соединения: ' . mysql_error()); }
	mysql_set_charset("UTF8", $dbconnection);
    mysql_select_db(db_db);
	return $dbconnection;
}
function lwp_today_day(){
	$startstr = date('Y-m-d', time())." 00:00:00";
	$stopstr = date('Y-m-d', time())." 23:59:59";
	return array ($startstr, $stopstr);
}
function lwp_day($str, $start){
	if ($start){
		$str = date('Y-m-d', $str)." 00:00:00";
	}else{
		$str = date('Y-m-d', $str)." 23:59:59";
	}
	return $str;	
}
function lwp_explode_date($str){
	$first = explode(" ", $str);
	$left = explode("-", $first[0]);
	$right = explode(":", $first[1]);
	return array($left[0], $left[1], $left[2], $right[0], $right[1]);
}
function lwp_explode_space($str){
	$res = explode(" ", $str);
	$res = str_replace("-", ".", $res);
	return $res[0];
}
function lwp_mysql_to_date($str){
	$base = explode(" ", $str);
	$res = explode("-", $base[0]);
	$txr = $res[2].".".$res[1].".".$res[0]." ".$base[1];
	return $txr;
}
function lwp_ldap_search($user){
	$ldapconn = ldap_connect(lwp_ldap_host);
	if ($ldapconn){
		$ldapbind = ldap_bind($ldapconn, lwp_ldap_user, lwp_ldap_password);
		if($ldapbind){
			$filter = "(".lwp_ldap_type_base.'='.$user.")";
			$sr = ldap_search($ldapconn, lwp_ldap_dn, $filter, array(lwp_ldap_type_base, lwp_ldap_type_fullname)) or die ("Error in search query");
			if ($entr = ldap_get_entries($ldapconn, $sr)){
				return $entr[0][lwp_ldap_type_fullname][0];
			}
		}else{
			$ERR = "Error binding to LDAP server (username, pass, etc.)";
		}
		ldap_unbind($ldap_bind);
	}else{
		$ERR = "Error connecting to LDAP server";
	}
	ldap_close($ldap_conn);
}
function lwp_check_year_exists($year, $dbc){
	$get = mysql_query('SELECT COUNT(*) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-%"', $dbc);
	$row = mysql_fetch_assoc($get);
	if ($row['COUNT(*)'] > 0){return true;}else{return false;};
}
function lwp_check_month_exists($month, $year, $dbc){
	if (strlen($month) == 1){$month = '0'.$month;}
	$get = mysql_query('SELECT COUNT(*) FROM `'.db_table.'` WHERE `Time` LIKE "'.$year.'-'.$month.'-%"', $dbc);
	$row = mysql_fetch_assoc($get);
	if ($row['COUNT(*)'] > 0){return true;}else{return false;};
}
function lwp_ldap_get($user){
	if (lwp_ldap_use){
		$us = lwp_ldap_search($user);
		if ($us <> ""){
			return $us;
		}else{
			return $user;
		}
	}else{
		return $user;
	}
}
?>