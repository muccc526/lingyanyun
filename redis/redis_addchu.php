<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
while(true){
    $oid=$redis->lpop('addoid');
    $today_day=date("Y-m-d H:i:s");
    $b=$DB->get_row("select * from qingka_wangke_order where oid='$oid' limit 1");
    if ($b) {
        if ($b['dockstatus']=="0"&&$b['status']!="已取消") {
            if($b['user']=="1"){
			 $DB->get_row("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['school']==""){
			 $DB->get_row("update qingka_wangke_order set `status`='请检查学校名字',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['user']==""){
			 $DB->get_row("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}else{
	 	     $result=addWk($b['oid']);
	    }
	    $d=$DB->get_row("select * from qingka_wangke_class where cid='{$b['cid']}' ");   	 	           
	  	if($result['code']=='1'){
       	    echo("成功 uid：{$b['oid']}\r\n返回：{$result['msg']}\r\n本次出队时间：".$today_day."\r\n------------------------------------------------------\r\n");
       	    $DB->get_row("update qingka_wangke_order set `hid`='{$d['docking']}',`status`='已提交',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");//对接成功
        }else{
        	$DB->get_row("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
        	echo("对接失败 uid：{$b['oid']}\r\n失败原因：{$result['msg']}\r\n本次出队时间：".$today_day."\r\n------------------------------------------------------\r\n");
        }
        }
    }
    sleep(5);
}


?>