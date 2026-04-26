<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");

echo "连通redis： " . $redis->ping() . "\r\n";
    $lenth=$redis->LLEN('xxdxaddoid');
    if($lenth==0){
        $i=0;
        $a=$DB->query("select * from qingka_wangke_order where dockstatus='0' and status!='已取消'");
        foreach($a as $b){
            $redis->lPush("xxdxaddoid",$b['oid']);
            $i++;
        }
        echo "入队成功！本次入队订单共计：".$i."条\r\n";
    }else {
        echo("入队失败！队列池还有：".$redis->LLEN('xxdxaddoid')."条订单正在执行\r\n");
    }
?>