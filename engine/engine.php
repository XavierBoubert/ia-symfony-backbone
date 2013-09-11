<?php

if(!defined('IN_IA')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

require_once dirname(__FILE__).'/config.php';

function db_connect() {
	global $dbInstance;

	$dbInstance = mysql_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password']);
	mysql_select_db($GLOBALS['db_name'], $dbInstance);
}

function db() {
	global $dbInstance;
	return $dbInstance;
}

function db_query($sql) {
	return mysql_query($sql, db());
}

function db_close() {
	mysql_close(db());
}

