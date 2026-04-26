<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
//yqslyqsl
while(true){
    $oid=$redis->lpop('plbsoid');
    $a=$DB->get_row("select * from qingka_wangke_order where oid='$oid'");
    if($oid!=''){
    
    $result=budanWk($a['oid']);
    
      
    if($result['code']=='1'){
             echo("成功 订单id：{$a['oid']}\r\n返回：{$result['msg']}\r\n");
             $DB->get_row("update qingka_wangke_order set status='补刷中',dockstatus=1 where oid='{$a['oid']}' ");
                 sleep(2);
             $redis->lPush("plztoid",$a['oid']);
    }else{
          $DB->get_row("update qingka_wangke_order set status='补刷失败',dockstatus=1 where oid='{$a['oid']}' ");
          echo("失败 订单id：{$a['oid']}\r\n失败原因：{$result['msg']}\r\n");
        }
    }        
    
    sleep(1);
}
?>