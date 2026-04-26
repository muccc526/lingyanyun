<?php  
function xgmm($oid,$xgmm){
	global $DB;
	global $wk;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB->get_row("select hid,yid,user from qingka_wangke_order where oid='{$oid}' ");
	$hid = $b["hid"];
	$yid = $b["yid"];
	$user = $b["user"];
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];

	if ($type == "spi") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid, "xgmm" => $xgmm);
$uu_rl = $a["url"];
$uu_url = "$uu_rl/api.php?act=xgmm";
$result = get_url($uu_url, $data);
$result = json_decode($result, true);
return $result;}
	else {
				$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
		}
}




?>