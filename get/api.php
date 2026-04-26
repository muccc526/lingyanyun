<?php
include('../confing/function.php'); 
$ckxz=$DB->get_row("select settings,api_ck,api_xd,api_proportion from qingka_wangke_config");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');
if($conf['settings']!=1){
    exit('{"code":-1,"msg":"API功能已关闭，请联系管理员！"}');
}else{
    switch($act){
  case 'uporder': //进度刷新
        $oid = trim(strip_tags(daddslashes($_POST['oid'])));
        $row = $DB -> get_row("select * from qingka_wangke_order where oid='$oid'");
        if ($row['dockstatus'] == '99') {
            $result = pre_zy($oid);
            exit(json_encode($result));
        }
        $result = processCx($oid);
        for ($i = 0; $i < count($result); $i++) {
            $DB -> query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `user`='{$result[$i]['user']}' and `kcname`='{$result[$i]['kcname']}' and `oid`='{$oid}'");
        }
        $upmsg = "同步成功";
        jsonReturn(1, $upmsg);
        break;    

  case 'chadan':
    $username=trim(strip_tags(daddslashes($_REQUEST['account'])));
    
    $id=trim(strip_tags(daddslashes($_REQUEST['oid'])));
    if($username==""){
        if($id == ""){
            $data=array('code'=>-1,'msg'=>"账号不能为空");
            exit(json_encode($data)); 
        }else if($id == ""){
            $data=array('code'=>-1,'msg'=>"订单ID不能为空");
            exit(json_encode($data)); 
        }
    }
    
    // 计算3个月前的日期
    $threeMonthsAgo = date('Y-m-d H:i:s', strtotime('-3 months'));
    
    if($username != ""){
        // 使用子查询筛选每个课程的最新订单
        $a=$DB->query("
            SELECT o.* 
            FROM qingka_wangke_order o
            JOIN (
                SELECT kcname, MAX(addtime) as max_addtime
                FROM qingka_wangke_order
                WHERE user='$username' AND addtime >= '$threeMonthsAgo'
                GROUP BY kcname
            ) latest ON o.kcname = latest.kcname AND o.addtime = latest.max_addtime
            WHERE o.user='$username' AND o.addtime >= '$threeMonthsAgo'
            ORDER BY o.oid ASC
        ");
    }else if($id != ""){
        $a=$DB->query("select * from qingka_wangke_order where oid='$id'");
    }
    if($a){
        while($row=$DB->fetch($a)){
            $data[]=array(
                'id'=>$row['oid'],
                'ptname'=>$row['ptname'],
                'school'=>$row['school'],
                'name'=>$row['name'],
                'user'=>$row['user'],
                'kcname'=>$row['kcname'],
                'addtime'=>$row['addtime'],
                'courseStartTime'=>$row['courseStartTime'],
                'courseEndTime'=>$row['courseEndTime'],
                'examStartTime'=>$row['examStartTime'],
                'examEndTime'=>$row['examEndTime'],
                'status'=>$row['status'],
                'process'=>$row['process'],
                'remarks'=>$row['remarks'],
                'pushUid'=>$row['pushUid'],
                'pushStatus'=>$row['pushStatus'],
            );
        }
        if(empty($data)){
            $data=array('code'=>-1,'msg'=>"未查到该账号近3个月的下单信息");
            exit(json_encode($data)); 
        }
        $data=array('code'=>1,'data'=>$data);
        exit(json_encode($data)); 
    }else{
        $data=array('code'=>-1,'msg'=>"未查到该账号的下单信息");
        exit(json_encode($data)); 
    } 
break;
     case 'budan':
        $oid=daddslashes($_POST['id']);
		$b=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
		if($b['bsnum']>5){
			exit('{"code":-1,"msg":"该订单补刷已超过5次不支持再次补刷！"}');
		}
        	  $c=budanWk($oid);
        	  if($c['code']==1){
        	      if($b['status']=="已退款"){
                        jsonReturn(-1,"订单已退款无法补刷！");
                    }else{
                        $DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
        	  	        jsonReturn(1,$c['msg']);
                    }
        	  }else{
        	  	jsonReturn(-1,$c['msg']);
        	  }
  break;


}
}


?>