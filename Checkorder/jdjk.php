<?php

function processCx($oid)
{
    global $DB;
    $d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
    $b = $DB->get_row("select hid,user,pass from qingka_wangke_order where oid='{$oid}' ");
    $a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$b["hid"]}' ");
    $type = $a["pt"];
    $cookie = $a["cookie"];
    $token = $a["token"];
    $ip = $a["ip"];
    $user = $b["user"];
    $pass = $b["pass"];
    $kcname = $d["kcname"];
    $school = $d["school"];
    $pt = $d["noun"];
    $kcid = $d["kcid"];
    $yid = $d["yid"];

    if ($type == "29") {
        $data = ["username" => $user, "uid" => $a["user"], "key" => $a["pass"]];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=chadan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $remarks = $res["remarks"];
                $remarks = str_ireplace("排队中，等待上号", "请耐心等待，正在排队上号中~", $remarks);
                $remarks = str_ireplace("K家", "独家", $remarks);
                $remarks = str_ireplace("TECH-Ai", "全能版Ai", $remarks);
                $status = str_ireplace("平时分中", "平时分", $status);
                if ($score == "") {
                    $score = "默认";
                }
                if ($shichang == "") {
                    $shichang = "默认";
                }
                if ($status == "队列中") {
                    $process = "0%";
                    $shichang = "默认";
                }
                if ($status == "已完成") {
                    $process = "100%";
                    $shichang = "默认";
                }
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];
                $b[] = [
                    "code" => 1,
                    "msg" => "查询成功",
                    "yid" => $yid,
                    "kcname" => $kcname,
                    "user" => $user,
                    "pass" => $pass,
                    "ksks" => $ksks,
                    "ksjs" => $ksjs,
                    "status_text" => $status,
                    "process" => $process,
                    "remarks" => $remarks,
                ];
            }
        } else {
            $b[] = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    //longlong进度
    if ($type == "longlong")  {
  $b = array(); 
        $data = array("username" => $user,"uid" => $a["user"], "key" => $a["pass"]);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=chadan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $more =$res['order']['score'];
                $order=$res['order'];
                $dlz=$order["status"];
                $more = json_decode($more, true);
                if($hid==4){
                $remarks = $order["result"];
                $remarks .="。当前总分:".$more["score"]." 习惯分:".$more["xiguan"]." 视频:".$more["jindu"]." 作业:".$more["zuoye"]." 见面课:".$more["jianmian"]." 互动:".$more["hudong"]." 考试:".$more["exam"]." 考试时间:".$more["examStartTime"];
                 }
                 else{
                $remarks=$res["remarks"]; }
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];

                $msg = merge_spaces(trim($process));
                $msg1 = merge_spaces(trim($remarks));

                $jindu = explode("%", $msg);
                $jindu1 = explode("%", $msg1);
                if (is_numeric($jindu[0])) {
                    $jindu = $jindu[0] . '%';
                } elseif (is_numeric($jindu1[0])) {
                    $jindu = $jindu1[0] . '%';
                } else {
                    $jindu = explode("/", $msg);
                    if (is_numeric($jindu[0])) {
                        $jindu = number_format($jindu[0] / $jindu[1] * 100, 2);
                        $jindu = $jindu . '%';
                    } else {
                        $jindu = '处理中..';
                    }
                }

                if (strpos($msg, ",当前进度:") != false) {
                    $jindu = explode("当前进度:", $msg);
                    $jindu = $jindu[1];
                }

                if ($jindu == '处理中..') {
                    if ($status == '已完成') $jindu = '100%';
                    if ($status == '待处理') $jindu = '1%';
                }

                if ($jindu == '0%') $jindu = '1%';
                if ($jindu == 'nan%') $jindu = '0%';
                
                if(strpos($process,'/')){//100.00%
                    list($process_0,$process_1) = explode('/',$process);
                    if(is_numeric($process_0) && is_numeric($process_1)){
                        $process = number_format($process_0/$process_1,2,'.','') * 100 . '%';
                        
                    }
                   
                }
                
                
                if ($process == $remarks) $process = '';

                $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "jindu" => $jindu, "status_text" => $status, "process" => $process, "remarks" => $remarks);
            }
        } else {
            $b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
        }
        return $b;}

    // hzw进度接口
else if ($type == "hzw") {
  $data = array("uid" => $a["user"], "key" => $a["pass"], "username" => $user, "id" => $d['yid']);
  $eq_rl = $a["url"];
  $eq_url = "$eq_rl/api.php?act=chadan";
  $result = get_url($eq_url, $data);
  $result = json_decode($result, true);
  $b = [];
  if ($result["code"] == "1") {
    foreach ($result["data"] as $res) {
      $yid = $res["id"];
      $cid = $pt;
      $kcname = $res["kcname"];
      $status = $res["status"];
      $process = $res["process"];
      $remarks = $res["remarks"];
      $kcks = $res["courseStartTime"];
      $kcjs = $res["courseEndTime"];
      $ksks = $res["examStartTime"];
      $ksjs = $res["examEndTime"];
      $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "cid" => $cid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
    }
  } else {
    $b[] = array("code" => -1, "msg" => $result["msg"]);
  }
  return $b;
}
//sxlm进度接口 放在/Checkorder/jdjk.php 文件
  if ($type == "sxlm") {
    $uu_rl = $a["url"];
    $kcname_encoded = urlencode($kcname);
    $user_encoded = urlencode($user);
    $uu_url = "$uu_rl/api/search?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname_encoded."&username=".$user_encoded."&cid=".$d["noun"];
    $result = get_url($uu_url,$data);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
            $yid = $res["id"];
            $kcname = $res["kcname"];
            $status = $res["status"];
            $process = $res["process"];
            $remarks = $res["remarks"];
            $kcks = $res["courseStartTime"];
            $kcjs = $res["courseEndTime"];
            $ksks = $res["examStartTime"];
            $ksjs = $res["examEndTime"];
            $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks,"zhgx" =>  $zhgx);
        }
    } else {
        $b[] = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
}

//mdx学习平台进度接口放在checkorder/jdjk.php内
      if ($type == "mdx") {
        $data = array("username" => $user);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=chadan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $process = $res["process"];
        $remarks = $res["remarks"];
        if ($score == "") {
                    $score = "默认";
                }
                if ($shichang == "") {
                    $shichang = "默认";
                }
                if ($status == "上号中") {
                    $process = "0%";
                    $shichang = "默认";
                }
                if ($status == "已完成") {
                    $process = "100%";
                    $shichang = "默认";
                }
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
        }
        } else {
        $b[] = array("code" => -1, "msg" => $result["msg"]);
        }
        return $b;
    }
  elseif ($type == "FD") {
        $data = ["username" => $user, "uid" => $a["user"], "key" => $a["pass"]];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=chadan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $remarks = $res["remarks"];
                if ($status == "已完成") {
                    $process = "100%";
                    $shichang = "默认";
                }
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];
                $b[] = [
                    "code" => 1,
                    "msg" => "查询成功",
                    "yid" => $yid,
                    "kcname" => $kcname,
                    "user" => $user,
                    "pass" => $pass,
                    "ksks" => $ksks,
                    "ksjs" => $ksjs,
                    "status_text" => $status,
                    "process" => $process,
                    "remarks" => $remarks,
                ];
            }
        } else {
            $b[] = ["code" => -1, "msg" => "查询失败,请联系管理员"];
        }
        return $b;
    }
//流年进度新接口
else if ($type == "liunian") {
$data = array("uid"=>$a["user"],"key"=>$a["pass"],"kcname"=>$kcname,"username"=>$user,"cid"=>$d["noun"],"yid"=>$d["yid"]);
$dx_rl = $a["url"];
$dx_url = "$dx_rl/api/chadan1";
$result = get_url($dx_url,$data);
$result = json_decode($result, true);
if ($result["code"] == "1") {
foreach ($result["data"] as $res) {
$yid = $res["id"];
$kcname = $res["kcname"];
$status = $res["status"];
$process = $res["process"];
$remarks = $res["remarks"];
$kcks = $res["courseStartTime"];
$kcjs = $res["courseEndTime"];
$ksks = $res["examStartTime"];
$ksjs = $res["examEndTime"];
$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
}
} else {
$b[] = array("code" => -1, "msg" => $result["msg"]);
}
return $b;
}
    // axx同步状态接口
  else if ($type == "YD") {
    $data = array("username" => $user, "id"=>$d['yid']);
    $ixx_url = $a["url"] . "/api/refresh";
    $result = httpRequest('POST', $ixx_url, $data, [], true);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
      foreach($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $process = $res["process"];
        $remarks = $res["remarks"];
        $xxtremarks = $res["xxtremarks"];
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks, "xxtremarks" => $xxtremarks);
      }
    } else {
      $b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
    }
    return $b;
  }
  //TOC进度接口
  else if ($type == "courserX") {
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=chadan";
    $data = array("uid" => $a["user"], "key" => $a["pass"],"username" => $user);
    $result = get_url($dx_url,$data);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
    foreach ($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $process = $res["process"];
        $remarks = $res["remarks"];
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
        }
    } else {
    $b[] = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
}
//spiderman进度接口 放在/Checkorder/jdjk.php 文件
  if ($type == "spi") {
    $uu_rl = $a["url"];
    $kcname_encoded = urlencode($kcname);
    $user_encoded = urlencode($user);
    $uu_url = "$uu_rl/api/search?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname_encoded."&username=".$user_encoded."&cid=".$d["noun"];
    $result = get_url($uu_url,$data);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
            $yid = $res["id"];
            $kcname = $res["kcname"];
            $status = $res["status"];
            $process = $res["process"];
            $remarks = $res["remarks"];
            $kcks = $res["courseStartTime"];
            $kcjs = $res["courseEndTime"];
            $ksks = $res["examStartTime"];
            $ksjs = $res["examEndTime"];
            $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks,"zhgx" =>  $zhgx);
        }
    } else {
        $b[] = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
}
//Benz平台进度接口 复制代码放在/Checkorder/jdjk.php 文件
                
    else if ($type == "Benz") {
        $data = array("username" => $user,"uid" => $a["user"],"key" => $a["pass"]);
        $benz_rl = $a["url"];
        $benz_url  = "$benz_rl/api.php?act=chadan";
        $result = get_url($benz_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
            $yid = $res["id"];
            $kcname = $res["kcname"];
            $status = $res["status"];
            $process = $res["process"];
            $remarks = $res["remarks"];
            $kcks = $res["courseStartTime"];
            $kcjs = $res["courseEndTime"];
            $ksks = $res["examStartTime"];
            $ksjs = $res["examEndTime"];
            $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
            }
        } else {
            $b[] = array("code" => -1, "msg" => $result);
        }
        return $b;
    }
    //本站学习平台进度接口放在checkorder/jdjk.php内
    elseif ($type == "xy") {
        $uu_rl = $a["url"];
        $uu_url = "$uu_rl/api/search?uid=" . $a["user"] . "&key=" . $a["pass"] . "&kcname=" . $kcname . "&username=" . $user . "&cid=" . $d["noun"];
        $result = get_url($uu_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $remarks = $res["remarks"];
                if ($status == "已完成") {
                    $process = "100%";
                    $shichang = "默认";
                }
                $status = str_ireplace("已提交，待处理", "待处理", $status);
                $remarks = str_ireplace("总数", "学习资源总数", $remarks);
                $remarks = str_ireplace("未完成", "学习资源未完成", $remarks);
                $remarks = str_ireplace("完成率", "课程完成进度", $remarks);
                $remarks = str_ireplace("有问题重刷再请反馈", "所有任务执行完毕！请自行上号查看，如有问题补单后再找上级反馈。", $remarks);
                $remarks = str_ireplace("正在刷课中,耐心等待完成,请勿上号", "正在全力跑单中，耐心等待完成，请上号查看进度~", $remarks);
                $remarks = str_ireplace("正在刷课中,耐心等待完成", "正在全力跑单中，耐心等待完成，请上号查看进度~", $remarks);
                $remarks = str_ireplace("如果该账号有多门课程 刷完一门才会进行下一门", "同账号下其它科目正在跑单，请耐心等待~", $remarks);
                $status = str_ireplace("上号考试中", "考试中", $status);
                $remarks = str_ireplace("K家", "独家", $remarks);
                $remarks = str_ireplace("万能+Ai", "全能版Ai", $remarks);
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];
                $b[] = ["code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks,];
            }
        } else {
            $b[] = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    elseif ($type == "yqsl") {
        $uu_rl = $a["url"];
        if (!empty($d["yid"])) {
            $uu_url = "$uu_rl/api.php?act=chadan2";
            $data = ["yid" => $d["yid"]];
        } else {
            $uu_url = "$uu_rl/api/search?";
            $data = [
                "username" => $user,
                "kcname" => $kcname,
                "cid" => $d["noun"],
            ];
        }
        $result = get_url($uu_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $remarks = $res["remarks"];
                $status = str_ireplace("上号考试中", "考试中", $status);
                $status = str_ireplace("习惯分完成,等待考试", "待考试", $status);
                $remarks = str_ireplace("万能+Ai", "全能版Ai", $remarks);
                $remarks = str_ireplace("PANDA", "逸总", $remarks);
                $remarks = str_ireplace("TASK", "章节", $remarks);
                $remarks = str_ireplace("已完成 || ", "跑单已完成 || ", $remarks);
                $remarks = str_ireplace("Waiting! You have a course study!", "请耐心等待，正在排队上号中~", $remarks);
                $remarks = str_ireplace("执行完毕！", "跑单已完成", $remarks);
                $remarks = str_ireplace("等待下次重启", "夜晚已暂停", $remarks);
                $remarks = str_ireplace("EXAM", "考试", $remarks);
                $remarks = str_ireplace("K家", "独家", $remarks);
                $status = str_ireplace("休息中", "已暂停", $status);
                $status = str_ireplace("平时分中", "平时分", $status);
                $remarks = str_ireplace("DOVIDEO", "观看视频中~", $remarks);
                $remarks = str_ireplace("私人专线", "人工专线", $remarks);
                $remarks = str_ireplace("呱~", "人工~", $remarks);
                $remarks = str_ireplace("等待呱", "等待开考", $remarks);
                $status = str_ireplace("等待交卷", "待交卷", $status);
                $remarks = str_ireplace("Loading", "填充答案中~", $remarks);
                $remarks = str_ireplace("exam time", "考试", $remarks);
                $remarks = str_ireplace(" time", "时间", $remarks);
                $remarks = str_ireplace("正在摸鱼中", "课间休息120秒", $remarks);
                $remarks = str_ireplace("普通学习进度:100%|", "所有任务执行完毕|", $remarks);
                $remarks = str_ireplace("正在排队 ||", "请耐心等待，正在排队上号中~ ||", $remarks);
                $remarks = str_ireplace("正在排队~", "请耐心等待，正在排队上号中~", $remarks);
                $remarks = str_ireplace("正在打手冲", "正在打飞机", $remarks);
                $status = str_ireplace("等待处理", "待处理", $status);
                if ($status == "队列中") {
                    $process = "0%";
                    $shichang = "默认";
                }
                if ($status == "已完成") {
                    $process = "100%";
                    $shichang = "默认";
                }
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];
                $b[] = [
                    "code" => 1,
                    "msg" => "查询成功",
                    "yid" => $yid,
                    "kcname" => $kcname,
                    "user" => $user,
                    "pass" => $pass,
                    "ksks" => $ksks,
                    "ksjs" => $ksjs,
                    "status_text" => $status,
                    "process" => $process,
                    "remarks" => $remarks,
                ];
            }
        } else {
            $b[] = ["code" => -1, "msg" => "查询失败!!!!"];
        }

        return $b;
    } 
    //大雄学习平台进度新接口 放在/Checkorder/jdjk.php 文件
    elseif ($type == "daxiong") {
        $dx_rl = $a["url"];
        $dx_url =
            "$dx_rl/api/search?uid=" .
            $a["user"] .
            "&key=" .
            $a["pass"] .
            "&kcname=" .
            $kcname .
            "&username=" .
            $user .
            "&cid=" .
            $d["noun"];
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
            foreach ($result["data"] as $res) {
                $yid = $res["id"];
                $kcname = $res["kcname"];
                $status = $res["status"];
                $process = $res["process"];
                $remarks = $res["remarks"];
                $kcks = $res["courseStartTime"];
                $kcjs = $res["courseEndTime"];
                $ksks = $res["examStartTime"];
                $ksjs = $res["examEndTime"];
                $b[] = [
                    "code" => 1,
                    "msg" => "查询成功",
                    "yid" => $yid,
                    "kcname" => $kcname,
                    "user" => $user,
                    "pass" => $pass,
                    "ksks" => $ksks,
                    "ksjs" => $ksjs,
                    "status_text" => $status,
                    "process" => $process,
                    "remarks" => $remarks,
                ];
            }
        } else {
            $b[] = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    } else {
        $b[] = ["code" => -1, "msg" => "查询失败,请联系管理员"];
    }
}