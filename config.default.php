<?php
//MAIN CONFIG
define('lwp_lang','english');
//DB CONFIG
define('db_host','127.0.0.1:3306');
define('db_name','user');
define('db_pass','password');
define('db_db','logs');
define('db_table','print');
//LDAP CONFIG
define('lwp_ldap_use','1');
define('lwp_ldap_host','127.0.0.1');
define('lwp_ldap_user','admin');
define('lwp_ldap_password','pass');
define('lwp_ldap_dn','OU=users,DC=domain,DC=local');
define('lwp_ldap_type_base','sAMAccountName');
define('lwp_ldap_type_fullname','sn');
?>