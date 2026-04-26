<?php
function budanWk($oid)
{
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

    if ($type == "29") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
//mdx学习平台补刷接口放在checkorder/bsjk.php内
    if ($type == "mdx") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
//spiderman补刷
    if ($type == "spi") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=budan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
      // longlong补刷
  else if ($type == "longlong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
    $txt_rl = $a["url"];
    $txt_url = "$txt_rl/api.php?act=budan";
    $result = get_url($txt_url, $data);
    $result = json_decode($result, true);
    return $result;
  }
    // hzw补刷接口
else if ($type == "hzw") {
  $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
  $eq_rl = $a["url"];
  $eq_url = "$eq_rl/api.php?act=budan";
  $result = get_url($eq_url, $data);
  $result = json_decode($result, true);
  return $result;
}
//本站学习平台补刷接口放在checkorder/bsjk.php内
    if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    // axx补刷
  else if ($type == "YD") {
    $data = array("id" => $d['yid'], "username" => $d['user']);
    $ixx_url = $a["url"] . "/api/reset";
    $result = httpRequest('POST', $ixx_url, $data, [], true);
    $result = json_decode($result, true);
    return $result;
  }
  //TOC补刷接口
  if ($type == "courserX") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=budan";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    return $result;
}
//benz补刷
elseif ($type == "Benz") 
    {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
    $benz_rl = $a["url"];
    $benz_url = "$benz_rl/api.php?act=budan";
    $result = get_url($benz_url, $data);
    $result = json_decode($result, true);
     return $result;
    }
    //流年补刷接口
    if ($type == "liunian") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=budan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    } 
    elseif ($type == "FD") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=budan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    } else if ($type == "yqsl") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=budan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //大雄学习平台补刷 放在/Checkorder/bsjk.php 文件
    if ($type == "daxiong") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=budan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    } else {
        $b = array("code" => -1, "msg" => "接口异常，请联系管理员");
    }
}
