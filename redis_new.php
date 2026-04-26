<?php
include('config/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");

$time=15;   # 每轮订单同步间隔时间，单位：分钟！
$sleep=2;  # 每条订单同步间隔时间，单位：秒！
$night=["01:00","23:50"];   # 同步订单时间段，防止浪费代理IP
while(true){
    $day=date("Y-m-d H:i:s",strtotime("-".$time." minute"));
    $now=date("Y-m-d H:i:s");
    
    # 如果不希望夜间不同步订单，请将以下部分注释
    if(!judgetime($night)){
        echo "任务不在执行时间段内，跳过 ".$now."\r\n";sleep(1800);continue;
    }
    # 如果不希望夜间不同步订单，请将以上部分注释
    
    $lenth=$redis->LLEN('list');
    if($lenth==0){
        echo("队列池无待执行订单。休息{$time}分钟后开始下轮循环...\r\n\r\n");
        sleep($time*60);
        $order=$DB->query("select * from qingka_wangke_order where status='进行中' and dockstatus=1");
        foreach($order as $b){$redis->lPush("list",$b['oid']);$i++;}
        echo("获取订单数量：".$redis->LLEN('list')."条！开始执行任务...\r\n\r\n");
    }
    
    $oid=$redis->lpop('list');
    $order=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}'");
    $result=processCx($oid);
    if($result['code']==1){
        $DB->query("update qingka_wangke_order set `name`='{$result['name']}',`yid`='{$result['yid']}',`status`='{$result['status']}',`courseStartTime`='{$result['kcks']}',`courseEndTime`='{$result['kcjs']}',`examStartTime`='{$result['ksks']}',`examEndTime`='{$result['ksjs']}',`process`='{$result['process']}', `progress`='{$result['progress']}',`endchecktime`='$now' where `oid`='{$oid}'");
echo 
"订单ID：".$oid."
状态更新：".$order['status']."=>".$result['status']."
进度更新：".$order['process']."=>".$result['process']."
进度条更新：".$order['progress']."=>".$result['progress']."
本次出队时间：".$now."
还剩：".$redis->LLEN('list')."条！
------------------------------------------------------\r\n";
    }else{
echo 
"订单ID：".$oid."更新失败！
原因：".$result['msg']."
本次出队时间：".$now."
------------------------------------------------------\r\n";
    }
    sleep($sleep);
}
?>