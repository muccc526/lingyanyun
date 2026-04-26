<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");

echo "连通redis： " . $redis->ping() . "\r\n";
    $lenth=$redis->LLEN('addoid');
    if($lenth==0){
        $i=0;
        $a=$DB->query("select * from qingka_wangke_order where dockstatus='0' and status!='已取消' order by oid asc");
        foreach($a as $b){
            $redis->lPush("addoid",$b['oid']);
            $i++;
        }
        echo "入队成功！本次入队订单共计：".$i."条\r\n";
    }else {
        echo("入队失败！队列池还有：".$redis->LLEN('addoid')."条订单正在执行\r\n");
    }
?>