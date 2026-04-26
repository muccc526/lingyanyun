<?php
include('confing/common.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
if($act=='cookie'){
    qcookie();
}elseif($act=='add'){//执行对接     
	$a=$DB->query("select * from qingka_wangke_order where dockstatus='0' and status!='已取消' ");
	while($b=$DB->fetch($a)){
		if($b['user']=="1"){
			 $DB->query("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['school']==""){
			 $DB->query("update qingka_wangke_order set `status`='请检查学校名字',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['user']==""){
			 $DB->query("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}else{
	 	     $result=addWk($b['oid']);
	    }
		$d=$DB->get_row("select * from qingka_wangke_class where cid='{$b['cid']}' ");   	 	           
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='{$d['docking']}',`status`='进行中',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");//对接成功
        }else{
        	$DB->query("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
        }
	}
		
}elseif($act=='add2'){//执行对接2号
	$b=$DB->get_row("select * from qingka_wangke_order where dockstatus='2' and status!='已取消' limit 1 ");
	$result=addWk($b['oid']);
	    $d=$DB->get_row("select * from qingka_wangke_class where cid='{$b['cid']}' ");   	 
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='{$d['docking']}',`status`='进行中',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");//对接成功
        }else{
        	echo 'no';
        	$DB->query("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
        }
	
}elseif($act=='ziying'){//自营订单处理
	$b=$DB->get_row("select * from qingka_wangke_order where dockstatus='99' and status='待处理' limit 1 ");
	$result=addWk($oid);  	 
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='0',`status`='进行中' where oid='{$b['oid']}' ");//对接成功
        }else{
        	echo 'no';
        }
	
}elseif($act=='update'){//同步进行中	
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='进行中'  order by oid desc");//所有非已完成订单
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update2'){//同步补刷中		
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='补刷中' order by oid desc");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update3'){//获取源ID		
	$a=$DB->query("select * from qingka_wangke_order where oid>'30000' and dockstatus='1' and yid='' order by oid desc ");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update4'){//同步进行中		
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='进行中' ");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update5'){//同步待处理	
	$a=$DB->query("select * from qingka_wangke_order where dockstatus='1' and status='待处理' order by oid desc");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}


?>

