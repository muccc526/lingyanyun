<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
echo "链接redis正常！连通redis： " . $redis->ping() . "\r\n";
$lenth=$redis->LLEN('oids');
if($lenth==0){
    $i=0;
    $a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status!='已完成' and status!='异常'  and status!='已考试' and status!='已退款' and status!='已取消' order by oid asc");
foreach($a as $b){    
   $redis->lPush("oids",$b['oid']);
   $i++;
    }
    echo "本次入队订单共计：".$i."条！\r\n";
}else{
    echo("入队失败！队列池还有：".$redis->LLEN('oids')."条订单正在执行\r\n");
}
?>