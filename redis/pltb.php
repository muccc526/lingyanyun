<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
while(true){
    $oid=$redis->lpop('plztoid');
    $today_day=date("Y-m-d H:i:s");
    $a=$DB->get_row("select * from qingka_wangke_order where oid='$oid'");
    if($oid!=''){
        $result=processCx($oid);
        // var_dump($result);
        for($i=0;$i<count($result);$i++){
            if($result[$i]['msg']=="系统繁忙，请稍后再试。"){
                
                echo 
                    "更新订单ID：".$oid."时出现系统繁忙，自动暂停10分钟....\r\n本次出队时间：".$today_day."\r\n------------------------------------------------------\r\n";
                sleep(600);
            }
            if($result[$i]['code']==1 && $result[$i]['kcname']==$a['kcname']){
                $process_new=$result[$i]['process'];
                $status_new=$result[$i]['status_text'];
                $remarks_new=$result[$i]['remarks'];
            }
            $DB->query("update qingka_wangke_order set `name`='{$result[$i]['name']}',`yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `user`='{$result[$i]['user']}'  and `kcname`='{$result[$i]['kcname']}' and `oid`='{$oid}'");
        }
        if($process_new=='' && $remarks_new==''){
            echo "订单id：".$oid."返回状态为空！跳过。\r\n------------------------------------------------------\r\n";
        }else{
            if($process_new==$a['process']){echo "订单id：".$oid."状态无需更新，跳过。\r\n本次出队时间：".$today_day."\r\n------------------------------------------------------\r\n";
            }else{
                echo "订单ID：".$oid."\r\n状态更新：".$a['status']."=>".$status_new."\r\n进度更新：".$a['process']."=>".$process_new."\r\n备注更新：".$a['remarks']."=>".$remarks_new."\r\n本次出队时间：".$today_day."\r\n------------------------------------------------------\r\n";
            }
            
        }
    }
    sleep(3);
}


?>