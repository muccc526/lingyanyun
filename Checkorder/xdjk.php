<?php

function wkname()
{
    $data = [
        "29" => "29",
        "xy" => "小月",
        "mdx" => "莫等闲",
        "daxiong" => "大雄",
        "liunian" => "流年",
        "FD" => "FreeDom",
        "yqsl" => "yqsl",
        "YD" => "爱学习",
        "hzw" => "hzw",
        "sxlm" => "sxlm",
        "courserX" => "TOC",
        "longlong" => "龙龙平台",
        "spi" => "spiderman学习平台",
        "Benz" => "Benz",
        "ytxzhzjj" => "雨同学-智慧职教+",
        "ytxzhzjzyk" => "雨同学-智慧职教资源库",
        "ytxzhzjmooc" => "雨同学-智慧职教mooc",
        "ytxyuzykxxt" => "雨同学-专业课查课",
        "ytxyuxxt" => "雨同学-选修课查课",
    ];
    return $data;
}

function addWk($oid)
{
    global $DB;
    global $wk;
    $d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
    $cid = $d["cid"];
    $school = $d["school"];
    $user = $d["user"];
    $pass = $d["pass"];
    $kcid = $d["kcid"];
    $kcname = $d["kcname"];
    $noun = $d["noun"];
    $miaoshua = $d["miaoshua"];
    $bujiu = 1;
    $b = $DB->get_row("select * from qingka_wangke_class where cid='{$cid}' ");
    $hid = $b["docking"];
    $a = $DB->get_row(
        "select * from qingka_wangke_huoyuan where hid='{$hid}' "
    );
    $type = $a["pt"];
    $cookie = $a["cookie"];
    $token = $a["token"];
    $ip = $a["ip"];
    $region = $d["region"];

    /*****
	 自己可以根据规则增加下单接口    
	 
	//XXXX下单接口
	else if ($type == "XXXX") {
	$data = array("optoken" => $token,"type" => $noun);  请求体参数自己加
	$XXXX_ul = $a["url"];      变量XXXX自己命名    获取顶级域名
	$XXXX_dingdan = "http://$XXXX_ul/api/CourseQuery/api/";    请求接口   XXXX自己命名
	$result = get_url($XXXX_dingdan, $data, $cookie); 
	$result = json_decode($result, true);
	
	if ($result["code"] == "0") {
		$b = array("code" => 1, "msg" => $result["msg"]);
	} else {
		$b = array("code" => -1, "msg" => $result["msg"]);
	}
	return $b;
    }
	
	
	$token  传的token
	$school  传的学校
	$user    传的账号
	$pass    传的密码
	$noun    传的平台里面的接口编号 
	$kcid    传的课程id
     ****/
    if ($type == "29") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
            "shichang" => $shichang,
            "score" => $score,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    // axx下单接口
  else if ($type == "YD") {
    $data = array("token" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
    $ixx_url = $a["url"] . "/api/add";
    $result = httpRequest('POST', $ixx_url, $data, [], true);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
      $b = array("code" => 1, "msg" => "下单成功", "yid" => $result["id"]);
    } else {
      $b = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
  }
  if ($type == "sxlm") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname);
		$eq_rl = $a["url"];
		$eq_url = "$eq_rl/api.php?act=sxadd";
		$result = get_url($eq_url, $data,$cookie);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
			$b = array("code" => 1, "msg" => "下单成功");
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;} 
		//sxlm下单
   	if ($type == "sxlm") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname);
		$eq_rl = $a["url"];
		$eq_url = "$eq_rl/api.php?act=sxadd";
		$result = get_url($eq_url, $data,$cookie);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
			$b = array("code" => 1, "msg" => "下单成功");
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;} 

  // longlong下单接口
  else if ($type == "longlong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "city" => 新疆,"user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=add";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    if ($result["code"] == "0") {
      $b = array("code" => 1, "msg" => "下单成功");
    } else {
      $b = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
  }
  // hzw下单接口
else if ($type == "hzw") {
  $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcid" => $kcid, "kcname" => $kcname);
  $eq_rl = $a["url"];
  $eq_url = "$eq_rl/api.php?act=add";
  $result = get_url($eq_url, $data);
  $result = json_decode($result, true);
  if ($result["code"] == "1") {
    $b = array("code" => 1, "msg" => "下单成功", "yid" => $result["id"]);
  } else {
    $b = array("code" => -1, "msg" => $result["msg"]);
  }
  return $b;
}
  //TOC下单接口
  else if ($type == "courserX") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=add";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
    } else {
        $b = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
}
//Benz平台下单接口 复制代码放在/Checkorder/xdjk.php 文件
    else if ($type == "Benz") 
        {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
        $benz_rl = $a["url"];
        $benz_url = "$benz_rl/api.php?act=add";
        $result = get_url($benz_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
        } else {
        $b = array("code" => - 1, "msg" => $result["msg"]);
        }
         return $b;
        }
//mdx学习平台查课接口 放在/Checkorder/xdjk.php 文件
    if ($type == "mdx") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
        } else {
        $b = array("code" => -1, "msg" => $result["msg"]);
        }
    return $b;
    }    
   else if ($type == "more") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
$more_rl = $a["url"];
$more_url = "$more_rl/api.php?act=add";
$result = get_url($more_url, $data);
$result = json_decode($result, true);
if ($result["code"] == "0") {
$b = array("code" => 1, "msg" => "下单成功");
} else {
$b = array("code" => -1, "msg" => $result["msg"]);
}
return $b;} 
    if ($type == "obyh") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
            "shichang" => $shichang,
            "score" => $score,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    //spiderman下单
    elseif ($type == "spi") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
            "region" => $region,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    //本站学习平台下单接口放在checkorder/xdjk.php内
    if ($type == "xy") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
            "shichang" => $shichang,
            "score" => $score,
        ];
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
// EMO佛系下单接口
  else if ($type == "2xx") {
    $data = array("token" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
    $ixx_url = $a["url"] . "/api/add";
    $result = httpRequest('POST', $ixx_url, $data, [], true);
    $result = json_decode($result, true);
    if ($result["code"] == "1") {
      $b = array("code" => 1, "msg" => "下单成功", "yid" => $result["id"]);
    } else {
      $b = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
  }
    //流年下单接口
    elseif ($type == "liunian") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
//专属
  else if ($type == "HEI") {
      $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
      $dx_rl = $a["url"];
      $dx_url = "$dx_rl/api.php?act=xd";
      $result = get_url($dx_url, $data);
      $result = json_decode($result, true);
      if ($result["code"] == "0") {
          $b = array("code" => 1, "msg" => "下单成功","yid" => $result["id"]);
      } else {
          $b = array("code" => -1, "msg" => $result["msg"],"yid" => $result["id"]);
      }
      return $b;
  }
    elseif ($type == "SY") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    elseif ($type == "FD") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
    //注意是否有$score = $d["score"];和$shichang = $d["shichang"];
    elseif ($type == "yqsl") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
            "score" => $score,
            "shichang" => $shichang,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=addyqsl";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }
if ($type == "maodou") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid, "shichang" => $shichang, "score" => $score);
$ace_rl = $a["url"];
$ace_url = "$ace_rl/api.php?act=add";
$result = get_url($ace_url, $data);
$result = json_decode($result, true);
if ($result["code"] == "0") {
$b = array("code" => 1, "msg" => "下单成功");
} else {
$b = array("code" => -1, "msg" => $result["msg"]);
}
return $b;
}
    //大雄学习平台下单接口 放在/Checkorder/xdjk.php 文件
    elseif ($type == "daxiong") {
        $data = [
            "uid" => $a["user"],
            "key" => $a["pass"],
            "platform" => $noun,
            "school" => $school,
            "user" => $user,
            "pass" => $pass,
            "kcname" => $kcname,
            "kcid" => $kcid,
        ];
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = ["code" => 1, "msg" => "下单成功"];
        } else {
            $b = ["code" => -1, "msg" => $result["msg"]];
        }
        return $b;
    }        
   	
	else {
    print_r("没有了,文件ckjk.php,可能故障：参数缺少，比如平台名错误！！！");die;
	}
}