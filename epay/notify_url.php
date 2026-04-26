<?php
@header('Content-Type: text/html; charset=UTF-8');
include("../confing/common.php");
require_once("epay/notify.class.php");
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result) {
	$out_trade_no = $_GET['out_trade_no'];//商户单号
	$trade_no = $_GET['trade_no'];//支付宝交易号
	$trade_status = $_GET['trade_status'];//交易状态
	$name=$_GET['name'];
    $money=$_GET['money'];//金额
    $pid=$_GET['pid'];
	$type = $_GET['type'];
	
	//$srow=$db->get_row("SELECT * FROM qingka_pay WHERE trade_no='{$out_trade_no}' limit 1 for update");

    if ($_GET['trade_status'] == 'TRADE_SUCCESS' && $srow['status']==0 && $srow['money']==$money) {
		//付款完成后，支付宝系统发送该交易状态通知
		$DB->query("update `qingka_wangke_pay` set `status` ='1',`endtime` ='$date',`trade_no`='{$trade_no}' where `out_trade_no`='{$out_trade_no}'");
        echo "success";	
    }else{
		$DB->query("update `qingka_wangke_pay` set `endtime` ='$date',`trade_no`='{$trade_no}' where `out_trade_no`='{$out_trade_no}'");
	    echo "success";	
	}
}
else {
echo "fail";
}
?>