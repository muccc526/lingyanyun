<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在跳转支付界面...</title>
</head>
<?php
include("../confing/common.php");
require_once("epay/submit.class.php");
$type = $_POST['type'];  //支付方式
$out_trade_no=$_POST['out_trade_no'];//支付单号
$row=$DB->get_row("select * from qingka_wangke_pay where `out_trade_no`='{$out_trade_no}' limit 1 ");
$DB->query("update `qingka_wangke_pay` set `type`='$type' where `out_trade_no`='{$out_trade_no}'");

//构造请求的参数数组
$is_https = false;
if (
    (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || 
    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || 
    (isset($_SERVER['HTTP_CF_VISITOR']) && $_SERVER['HTTP_CF_VISITOR'] == '{"scheme":"https"}') || 
    (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
) {
    $is_https = true;
}
$protocol = $is_https ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
$notify_url = $protocol . $domain . '/epay/notify_url.php';
$return_url = $protocol . $domain . '/epay/return_url.php';
$parameter = array(
    "pid" => trim($alipay_config['partner']),
    "type" => $type,
    "notify_url" => $notify_url,
    "return_url" => $return_url,
    "out_trade_no" => $row['out_trade_no'],
    "name" => $row['name'],
    "money" => $row['money'],
    "sitename" => $domain
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
?>
</body>
</html>