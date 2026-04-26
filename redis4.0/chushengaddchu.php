<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
while(true){
    $oid=$redis->lpop('xxdxaddoid');
    $b=$DB->get_row("select * from qingka_wangke_order where oid='$oid' limit 1");
    if ($b) {
        if ($b['dockstatus']=="0"&&$b['status']!="已取消") {
            if($b['user']=="1"){
                $DB->get_row("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");
            }elseif($b['school']==""){
                $DB->get_row("update qingka_wangke_order set `status`='请检查学校名字',`dockstatus`=2 where oid='{$b['oid']}' ");
            }elseif($b['user']==""){
                $DB->get_row("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");
            }elseif($b['dockstatus']!="0"){
                exit($b['oid'].'重复对接');
            }else{
                $result=addWk($b['oid']);
                if($result['code']=='1'){
                    $DB->get_row("update qingka_wangke_order set `status`='进行中',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");
                    echo("成功 uid：{$b['oid']}\r\n返回：{$result['msg']}\r\n");
                }else{
                    $DB->get_row("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
                    echo($result['code']."对接失败 uid：{$b['oid']}\r\n失败原因：{$result['msg']}\r\n");
                }
            }
        }
    }
    sleep(1);
}
?>