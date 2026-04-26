<?php
error_reporting(0);
define('IN_CRONLITE', true);
define('ROOT', dirname(__FILE__).'/');//返回当前文件路径的 路径部分,就是取当前目录
define('XX_ROOT', dirname(ROOT).'/');
define('SYS_KEY', "xiaoyue");
date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");
$jtdate=date("Y-m-d");
$ztdate=date("Y-m-d",strtotime("-1 day"));
session_start();
if(is_file(ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(ROOT.'360safe/360webscan.php');
}
require ROOT.'config.php';
$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
if(!isset($port))$port='3306';
//连接数据库
include_once(ROOT."config.php");
$DB=new DB($host,$user,$pwd,$dbname,$port);
include ROOT."epay/epay.config.php"; 
$sql1=$DB->query("SELECT * FROM `qingka_wangke_config`");
while($row=$DB->fetch($sql1)){
	$conf[$row['v']]=$row['k'];
}
$password_hash='!@#%!s?';
include ROOT."../Checkorder/configuration.php";     
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']        = $conf['epay_api'];
$alipay_config['partner']		= $conf['epay_pid'];
$alipay_config['key']			= $conf['epay_key'];
if(!defined('IN_CRONLITE'))exit();
$my=isset($_GET['my'])?$_GET['my']:null;
$clientip=real_ip();
$root = $_SERVER['DOCUMENT_ROOT']?$_SERVER['DOCUMENT_ROOT']:dirname(dirname(__FILE__)).'/';
if (!isset($port)){
    $port = '3306';
}

if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$user=daddslashes($DB->escape($user));
	$udata = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE user='$user' limit 1");
	$session=md5($udata['user'].$udata['pass'].$password_hash);
	if($session==$sid) {
		$DB->query("UPDATE qingka_wangke_user SET endtime='$date',ip='$clientip' WHERE user = '$user' ");
		$islogin=1;
		$userrow = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE user='$user' limit 1");
		if($udata['active']==0){
			@header('Content-Type: text/html; charset=UTF-8');
			exit('<!DOCTYPE html><html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>'.$conf['sitename'].'</title><style>html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}</style><body id="error-page"><h3>系统提示</h3>您的账号已被封禁！</body></html>');
		}
	}
}

?>