<?php
include('confing/common.php'); 
include('ayconfig.php');

switch($act){
    case 'qgmj':
        $zdqgmj=5/30;  //成本/天数   倍数
        $qgmj = trim(strip_tags(daddslashes($_POST['qgmj'])));
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        if ($qgmj < $zdqgmj) {
            jsonReturn(-1, "密价倍数最低只能设置$zdqgmj");
        }
        if (!is_numeric($qgmj)) {
            jsonReturn(-1, "请正确输入价格，必须为数字");
        }
        $a = $DB->get_row("select * from qingka_wangke_user where uid='$uid' ");
        if ($userrow['uid'] == '1') {
            $DB->query("update qingka_wangke_user set qgmj='{$qgmj}' where uid='$uid' ");
            wlog($userrow['uid'], "设置强国密价", "给下级设置强国密价{$qgmj}倍数成功", '0');
            jsonReturn(1, "设置成功");
           
        } else {
            jsonReturn(-1, "无权限");
        }
        break;
    
	
}

?>