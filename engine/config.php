<?php

if(!defined('IN_IA')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

$GLOBALS['db_host'] = '<add your host here>';
$GLOBALS['db_user'] = '<add your user here>';
$GLOBALS['db_name'] = '<add your database name here>';
$GLOBALS['db_password'] = '<add your user password here>';