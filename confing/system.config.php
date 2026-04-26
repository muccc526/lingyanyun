<?php
define('ROOT', __DIR__ . '/'); // 当前目录
require_once(ROOT . 'common.php');


// 邮件配置项开始
// 邮件地址（网站域名）
$emailUrl = $conf['email_url'];
// 邮件服务地址 默认：smtp.qq.com
$emailService = $conf['email_service'];
// 邮件服务端口 默认：465
$emailPort = $conf['email_port'];
// 发邮件邮箱
$emailUser = $conf['email_user'];
// 发邮件邮箱密码
$emailPass = $conf['email_pass'];
// 管理员收件邮箱
$adminEmail = $conf['email_user'];

$siteName= $conf['sitename'];
