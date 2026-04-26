<?php
function getMillisecond()
{
    list($t1, $t2) = explode(" ", microtime());

    return (float) sprintf("%.0f", (floatval($t1) + floatval($t2)) * 1000);
}
// 查课接口设置
function getWk($type, $noun, $school, $user, $pass, $name = false)
{
    global $DB;
    global $wk;
    $a = $DB->get_row(
        "select * from qingka_wangke_huoyuan where hid='{$type}' "
    );
    $type = $a["pt"];
    $cookie = $a["cookie"];
    $token = $a["token"];

    if ($type == "29") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //本站学习平台查课接口 放在/Checkorder/ckjk.php 文件
    if ($type == "xy") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //sxlm查课
    else if ($type == "sxlm") {
       $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
       $dx_rl = $a["url"];
       $dx_url = "$dx_rl/api.php?act=get";
       $result = get_url($dx_url, $data);
       $result = json_decode($result, true);
       return $result;
}
      // longlong查课接口
  else if ($type == "longlong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=get";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    return $result;
  }
    // axx查课接口
  else if ($type == "YD") {
    $data = array("token" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun);
    $ixx_url = $a["url"] . "/api/get";
    $result = httpRequest('POST', $ixx_url, $data, [], true);
    $result = json_decode($result, true);
    return $result;
  }
  // hzw查课接口
else if ($type == "hzw") {
  $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun);
  $eq_rl = $a["url"];
  $er_url = "$eq_rl/api.php?act=get";
  $result = get_url($er_url, $data);
  $result = json_decode($result, true);
  return $result;
}
  //TOC查课接口
  if ($type == "courserX") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=get";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    return $result;
}
    //Benz平台查课接口 复制代码放在/Checkorder/ckjk.php 文件
     else if ($type == "Benz"){
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
            $benz_rl = $a["url"];
            $benz_url = "$benz_rl/api.php?act=get";
            $result = get_url($benz_url, $data);
            $result = json_decode($result, true);
            return $result;
    }
//mdx学习平台下单接口放在checkorder/ckjk.php内
    if ($type == "mdx") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    } elseif ($type == "FD") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=get";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //spiderman查课
    elseif ($type == "spi") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=get";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    elseif ($type == "yqsl") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //流年查课接口
    if ($type == "liunian") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=get";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    // 雨同学-智慧职教mooc
  else if ($type == "ytxzhzjmooc") {
    $url = $a["url"];
    $gf_url = "{$url}/Checkorder/zhzjmooc.php?school=$school&name=$user&pwd=$pass";
    $result = file_get_contents($gf_url);
    $result = json_decode($result, true);
    return $result;
  }
  // 雨同学-专业课查课
  else if ($type == "ytxyuzykxxt") {
    $url = $a["url"];
    $gf_url = "{$url}/Checkorder/zykxxt.php?school=$school&name=$user&pwd=$pass";
    $result = file_get_contents($gf_url);
    $result = json_decode($result, true);
    return $result;
  }
  // 雨同学-智慧职教+
  else if ($type == "ytxzhzjj") {
    $url = $a["url"];
    $gf_url = "{$url}/Checkorder/zhzj+.php?school=$school&name=$user&pwd=$pass";
    $result = file_get_contents($gf_url);
    $result = json_decode($result, true);
    return $result;
  }
  // 雨同学-选修课查课
  else if ($type == "ytxyuxxt") {
    $url = $a["url"];
    $gf_url = "{$url}/Checkorder/xxtck.php?school=$school&name=$user&pwd=$pass";
    $result = file_get_contents($gf_url);
    $result = json_decode($result, true);
    return $result;
  }
  // 雨同学-智慧职教资源库
  else if ($type == "ytxzhzjzyk") {
    $url = $a["url"];
    $gf_url = "{$url}/Checkorder/zhzjzyk.php?school=$school&name=$user&pwd=$pass";
    $result = file_get_contents($gf_url);
    $result = json_decode($result, true);
    return $result;
  }
    
    //大雄学习平台查课接口 放在/Checkorder/ckjk.php 文件
    if ($type == "daxiong") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "platform" => $noun,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=get";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    } else {
        print_r("没有了,文件ckjk.php,可能故障：参数缺少，比如平台名错误！！！");
        die();
    }
}


//查询章测
function getZc($user, $pass, $school, $course_id, $page_no)
{
    global $DB;
    global $wk;
    $a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='11'");

    $host = $a["url"];
    $user = urlencode($user);
    $pass = urlencode($pass);
    $gf_url = "$host/xxt/list_exercise?user=$user&password=$pass&school=$school&course_id=$course_id&page_no=$page_no";
    // return $gf_url;
    $result = file_get_contents($gf_url);
    return $result;
    // $result = json_decode($result, true);
    // return $result;
}

?>
