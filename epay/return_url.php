<?php
@header('Content-Type: text/html; charset=UTF-8');
include("../confing/common.php");
require_once("epay/notify.class.php");
//得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
$gift_limit = 1; // 是否开启赠送规则，1 表示开启，0 表示关闭
//查询充值金额
if($verify_result) {
    $out_trade_no = $_GET['out_trade_no'];//商户订单号
    $trade_no = $_GET['trade_no'];//支付宝交易号
    $trade_status = $_GET['trade_status'];//交易状态
    $type = $_GET['type'];
    $money=$_GET['money'];//金额;
    $money3 = 0;

    if ($gift_limit == 1) {
        if ($money < 50) {             //此处$money < 50表示实际支付金额小于50，此处50也可以改成其他金额，如20，则表示低于20没有赠送
            $money3 = 0;               //充值金额<50，没有赠送，赠送金额为0
        }
        if ($money >= 50) {            //此处$money >= 50表示充值金额大于50，此处50也可以改成其他金额
            $money3 = $money * 0.05;   //充值金额>=50，<100，赠送实际支付金额*0.02，此处0.02可以改成其他比率
        }
        if ($money >= 100) {           //此处$money >= 100表示充值金额大于100，此处100也可以改成其他金额
            $money3 = $money * 0.10;   //充值金额>=100，<300，赠送实际支付金额*0.05，此处0.05可以改成其他比率
        }
        if ($money >= 500) {           //此处$money >= 300表示充值金额大于300，此处300也可以改成其他金额
            $money3 = $money * 0.15;   //充值金额>=300，<500，赠送实际支付金额*0.08，此处0.08可以改成其他比率
        }
    //如果觉得赠送比例不够或者有多，可以自行添加或者删除。添加示例：添加一段充值金额在1000到3000内的赠送规则直接在上一行回车加入下方去掉注释的代码即可
        // if ($money >= 3000) {
        //     $money3 = $money * 0.50;
        // }
    }

    $srow = $DB->get_row("SELECT * FROM qingka_wangke_pay WHERE out_trade_no='{$out_trade_no}' limit 1 for update");
    $userrow = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE uid='{$srow['uid']}'");

    $money1 = $userrow['money'];
    $money2 = $money1 + $money + $money3;

    if ($money3 != 0) {
        $cg = "用户[{$userrow['user']}]成功充值".$money."积分；本次赠送".$money3."积分! ";
    } else {
        $cg = "用户[{$userrow['user']}]成功充值".$money."积分! ";
    }

    if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
        if ($srow['status'] == 0 && $srow['money'] == $money) {
            $DB->query("update `qingka_wangke_pay` set `status` ='1',`endtime` ='$date',`trade_no`='{$trade_no}' where `out_trade_no`='{$out_trade_no}'");
            $DB->query("update `qingka_wangke_user` set `money`='{$money2}',`zcz`=zcz+'$money2' where uid='{$userrow['uid']}'");
            wlog($userrow['uid'], "在线充值", "用户[{$userrow['user']}]在线充值了{$money}积分", $money);
            if ($money3 != 0) {
                wlog($userrow['uid'], "充值达标赠送", "用户[{$userrow['user']}]充值金额达标赠送{$money3}积分", $money3);
            }
            exit("<script language='javascript'>alert('$cg');window.location.href='../index/charge';</script>");
        } else {
            $DB->query("update `qingka_wangke_pay` set `status` ='1',`endtime` ='$date',`trade_no`='{$trade_no}' where `out_trade_no`='{$out_trade_no}'");
            wlog($userrow['uid'], "在线充值", "重复刷新--用户[{$userrow['user']}]在线充值了{$money}积分", $money);
            exit("<script language='javascript'>alert('已充值，请勿重复刷新');window.location.href='../index/pay';</script>");
        }
    } else {
        echo "trade_status=".$_GET['trade_status'];
    }
} else {
    exit("<script language='javascript'>alert('充值失败!');window.location.href='../index/index';</script>");
}

?>    