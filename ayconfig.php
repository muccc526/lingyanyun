<?php

//decode by http://www.yunlu99.com/
include "ayauthcode.php";
error_reporting(0);
//$api_url = "http://ayapi27.a44.top/check66544666.php";
$timeout = array("http" => array("timeout" => 1));
$ctx = stream_context_create($timeout);
$text = file_get_contents($api_url, 0, $ctx);
if ($text == false) {
    $http_code = -1;
} else {
    $http_code = getHeaders($api_url . "?url=" . $_SERVER["HTTP_HOST"] . "&authcode=" . $authcode, true);
}
if ($http_code != "200") {
} else {
    $query = get($api_url . "?url=" . $_SERVER["HTTP_HOST"] . "&authcode=" . $authcode);
}
$query = json_decode($query, true);
if ($query) {
    if ($query["code"] == 1) {
        $_SESSION["authcode"] = $authcode;
    } else {
        exit(json_encode(["code" => -1, "msg" => $query["msg"]]));
    }
}
$act = isset($_GET["act"]) ? daddslashes($_GET["act"]) : null;
@header("Content-Type: application/json; charset=UTF-8");
if (!checkRefererHost()) {
    exit("{\"code\":403}");
}
switch ($act) {
    case "login":
        $user = trim(strip_tags(daddslashes($_POST["user"])));
        $pass = trim(strip_tags(daddslashes($_POST["pass"])));
        $pass2 = trim(strip_tags(daddslashes($_POST["pass2"])));
        if ($user == "" || $pass == "") {
            jsonReturn(-1, "账号密码不能为空");
        }

        $row = $DB->get_row("SELECT uid,user,pass FROM qingka_wangke_user WHERE user='" . $user . "' limit 1");
        $user_info = $DB->get_row("SELECT tuisongtoken, dltzkg, dlsbtzkg FROM qingka_wangke_user WHERE user='" . $user . "' limit 1");
        $simplePushToken = $user_info['tuisongtoken'] ?? '';

        function send_failure_notification($user, $token, $reason) {
            if ($token) {
                $message = "
            <div style='
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 16px;
                background-color: #f9f9f9;
                font-family: Arial, sans-serif;
                max-width: 400px;
                margin: 0 auto;
            '>
                <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🔒 登录失败通知 🔒</h2>
                <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                <div style='margin-bottom: 12px;'>
                    <strong>账号:</strong>
                    <span style='color: #555;'>$user</span>
                </div>
                <div style='margin-bottom: 12px;'>
                    <strong>时间:</strong>
                    <span style='color: #555;'>" . date("Y-m-d H:i:s") . "</span>
                </div>
                <div style='margin-bottom: 12px;'>
                    <strong>原因:</strong>
                    <span style='color: #555;'>$reason</span>
                </div>
                <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                <p style='color: #777; text-align: center;'>
                    请检查您的账号和密码是否正确！
                </p>
            </div>
            ";
                $data = [
                    'content' => $message,
                    'summary' => '后台登陆失败！', // 消息摘要
                    'contentType' => 2,
                    'spt' => $token
                ];
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-Type: application/json\r\n",
                        'content' => json_encode($data)
                    ]
                ];
                $context = stream_context_create($options);
                @file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);
            }
        }

        // 用户不存在
        if ($row["user"] == "") {
            exit("{\"code\":-1,\"msg\":\"此用户不存在\"}");
        } else {
            // 密码验证
            if ($pass != $row["pass"]) {
                // 触发失败通知
                if ($user_info["dlsbtzkg"] == "on") {
                    send_failure_notification($user, $simplePushToken, "密码错误");
                }
                exit("{\"code\":-1,\"msg\":\"用户名密码不正确\"}");
            }

            // 管理员二次验证
            if ($row["uid"] == 1) {
                if ($pass2 == "") {
                    exit("{\"code\":5,\"msg\":\"二次验证未填写\"}");
                } elseif ($pass2 != $verification) {
                    // 二次验证失败后再推送通知
                    if ($user_info["dlsbtzkg"] == "on") {
                        send_failure_notification($user, $simplePushToken, "二次验证码错误");
                    }
                    exit("{\"code\":-1,\"msg\":\"验证失败\"}");
                }
            }

            // 密码和二次验证都通过后，进行登录成功处理
            $session = md5($user . $pass . $password_hash);
            $token = authcode($user . "\t" . $session, "ENCODE", SYS_KEY);
            setcookie("admin_token", $token, time() + 216000);
            wlog($row["uid"], "登录", "登录成功" . $conf["sitename"], "0");

            if ($user_info["dltzkg"] == "on" && $simplePushToken) {
                $message = "
                <div style='
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    padding: 16px;
                    background-color: #f9f9f9;
                    font-family: Arial, sans-serif;
                    max-width: 400px;
                    margin: 0 auto;
                '>
                    <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🎉 登录成功通知 🎉</h2>
                    <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                    <div style='margin-bottom: 12px;'>
                        <strong>账号:</strong>
                        <span style='color: #555;'>$user</span>
                    </div>
                    <div style='margin-bottom: 12px;'>
                        <strong>时间:</strong>
                        <span style='color: #555;'>" . date("Y-m-d H:i:s") . "</span>
                    </div>
                    <div style='margin-bottom: 12px;'>
                        <strong>登陆IP:</strong>
                        <span style='color: #555;'>" . real_ip() . "</span>
                    </div>
                    <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                    <p style='color: #777; text-align: center;'>
                        请确认是否为本人操作。
                    </p>
                </div>
                ";
                $data = [
                    'content' => $message,
                    'summary' => '后台登录成功！', // 消息摘要
                    'contentType' => 2,
                    'spt' => $simplePushToken,
                ];
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-Type: application/json\r\n",
                        'content' => json_encode($data)
                    ]
                ];
                $context = stream_context_create($options);
                $response = file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);
            }
            exit("{\"code\":1,\"msg\":\"登录成功\"}");
        }
        break;
    case "logout":
        setcookie("admin_token", "", time() - 216000);
        @header("Content-Type: text/html; charset=UTF-8");
        exit("<script language='javascript'>window.location.href='index';</script>");
        break;
    case "register":
        if ($conf["user_yqzc"] == "0") {
            jsonReturn(-1, "邀请码注册已关闭，具体开放时间等通知");
        }
        $name = trim(strip_tags(daddslashes($_POST["name"])));
        $user = trim(strip_tags(daddslashes($_POST["user"])));
        $pass = trim(strip_tags(daddslashes($_POST["pass"])));
        $yqm = trim(strip_tags(daddslashes($_POST["yqm"])));
        $vercode = trim(strip_tags(daddslashes($_POST["vercode"])));

        // 检查基本信息是否为空
        if ($user == "" || $pass == "" || $name == "" || $yqm == "") {
            exit("{\"code\":-1,\"msg\":\"除验证码外所有项目不能为空\"}");
        }

        if (!preg_match("/[1-9]([0-9]{4,10})/", $user)) {
            exit("{\"code\":-1,\"msg\":\"账号必须为QQ号\"}");
        }
        if (!is_numeric($user)) {
            exit("{\"code\":-1,\"msg\":\"请正确输入账号\"}");
        }
        if ($DB->get_row("select uid from qingka_wangke_user where user='" . $user . "' ")) {
            exit("{\"code\":-1,\"msg\":\"该账号已存在\"}");
        }

        if ($DB->get_row("select uid from qingka_wangke_user where name='" . $name . "' ")) {
            exit("{\"code\":-1,\"msg\":\"该昵称已存在\"}");
        }

        // 只有当验证码开关开启时才验证验证码
        if ($conf['login_captcha_switch'] == 1) {
            if ($vercode == "") {
                exit("{\"code\":-1,\"msg\":\"验证码不能为空\"}");
            }
            $vercodeData = $DB->get_row("SELECT `time` FROM `qingka_wangke_code` WHERE `vercode` = '$vercode' ");
            if (!$vercodeData) {
                exit("{\"code\":-1,\"msg\":\"验证码错误\"}");
            }
            $vercodeTime = new DateTime($vercodeData['time']);
            $now = new DateTime();
            $interval = $now->diff($vercodeTime);
            if ($interval->i > 5) {
                exit("{\"code\":-1,\"msg\":\"验证码已过期\"}");
            }
        }

        if (strlen($pass) < 6) {
            exit("{\"code\":-1,\"msg\":\"密码最少为6位数\"}");
        }
        $a = $DB->get_row("select uid,yqm,yqprice from qingka_wangke_user where yqm='" . $yqm . "' ");
        if (!$a) {
            exit("{\"code\":-1,\"msg\":\"邀请码不存在\"}");
        }
        if ($a["yqprice"] == "") {
            exit("{\"code\":-1,\"msg\":\"当前邀请码未设置邀请费率\"}");
        }
        $clientip = real_ip();
        $ip = $DB->count("select ip from qingka_wangke_log where type='邀请码注册商户' and addtime>'" . $jtdate . "' and ip='" . $clientip . "' ");
        if ($DB->query("insert into qingka_wangke_user (uuid,name,user,pass,addprice,addtime) values ('" . $a["uid"] . "','" . $name . "','" . $user . "','" . $pass . "','" . $a["yqprice"] . "','" . $date . "')")) {
            wlog($a["uid"], "邀请码注册商户", "成功邀请昵称为[" . $name . "],账号为[" . $user . "]的靓仔注册成功！还望再接再厉！", "0");


            $inviter_info = $DB->get_row("SELECT uid,name, dlzctzkg, tuisongtoken FROM qingka_wangke_user WHERE uid='" . $a["uid"] . "'");
            $inviteraname = $inviter_info["name"];
            if ($inviter_info && $inviter_info["dlzctzkg"] == "on") {
                if ($inviter_info["tuisongtoken"]) {
                    $message = "
                    <div style='
                        border: 1px solid #e0e0e0;
                        border-radius: 8px;
                        padding: 16px;
                        background-color: #f9f9f9;
                        font-family: Arial, sans-serif;
                        max-width: 400px;
                        margin: 0 auto;
                    '>
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🎉 邀请成功通知 🎉</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>邀请用户:</strong>
                            <span style='color: #555;'> $inviteraname</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>被邀用户:</strong>
                            <span style='color: #555;'> $name</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>被邀账号:</strong>
                            <span style='color: #555;'> $user</span>
                        </div>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>注册时间:</strong>
                            <span style='color: #555;'>" . date("Y-m-d H:i:s") . "</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>注册IP地址:</strong>
                            <span style='color: #555;'> " . real_ip() . "</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢使用本平台！
                        </p>
                    </div>
                    ";
                    // 构造请求数据
                    $data = [
                        'content' => $message,
                        'summary' => '邀请成功通知！', // 消息摘要
                        'contentType' => 2, // HTML 格式
                        'spt' => $inviter_info["tuisongtoken"],
                    ];

                    // 发送 POST 请求
                    $options = [
                        'http' => [
                            'method' => 'POST',
                            'header' => "Content-Type: application/json\r\n",
                            'content' => json_encode($data)
                        ]
                    ];
                    $context = stream_context_create($options);
                    @file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);
                }
            }

            exit("{\"code\":1,\"msg\":\"注册成功！\"}");
        } else {
            exit("{\"code\":-1,\"msg\":\"未知异常\"}");
        }
        break;
    case "get1":
        $cid = trim(strip_tags(daddslashes($_POST["cid"])));
        $userinfo = daddslashes($_POST["userinfo"]);
        $hash = daddslashes($_POST["hash"]);
        $rs = $DB->get_row("select * from qingka_wangke_class where cid='" . $cid . "' limit 1 ");
        $kms = str_replace(array("\r\n", "\r", "\n"), " ", $userinfo);
        $info = $kms;
        $key = "AES_Encryptwords";
        $iv = "0123456789abcdef";
        $hash = openssl_decrypt($hash, "aes-128-cbc", $key, 0, $iv);
        if (empty($_SESSION["addsalt"]) || $hash != $_SESSION["addsalt"]) {
            exit("{\"code\":-1,\"msg\":\"验证失败，请刷新页面重试\"}");
        }
        $str = merge_spaces(trim($info));
        $userinfo2 = explode(" ", $str);
        if (count($userinfo2) > 2) {
            $result = getWk($rs["queryplat"], $rs["getnoun"], trim($userinfo2[0]), trim($userinfo2[1]), trim($userinfo2[2]), $rs["name"]);
        } else {
            $result = getWk($rs["queryplat"], $rs["getnoun"], "自动识别", trim($userinfo2[0]), trim($userinfo2[1]), $rs["name"]);
        }
        $userinfo3 = trim($userinfo2[0] . " " . $userinfo2[1] . " " . $userinfo2[2]);
        $result["userinfo"] = $userinfo3;
        wlog($userrow["uid"], "查课", $rs["name"] . "-查课信息：" . $userinfo3, 0);
        exit(json_encode($result));
        break;
	case "add_pl":
		$cid = trim(strip_tags(daddslashes($_POST["cid"])));
		$data = daddslashes($_POST["userinfo"]);
		$num = daddslashes($_POST["num"]);
		$rs = $DB->get_row("select * from qingka_wangke_class where cid='" . $cid . "' limit 1 ");
		if ($rs["yunsuan"] == "*") {
			$danjia = round($rs["price"] * $userrow["addprice"], 2);
		} elseif ($rs["yunsuan"] == "+") {
			$danjia = round($rs["price"] + $userrow["addprice"], 2);
		} else {
			$danjia = round($rs["price"] * $userrow["addprice"], 2);
		}
		if ($danjia == 0 || $userrow["addprice"] < 0.1) {
			exit("{\"code\":-1,\"msg\":\"未知错误\"}");
		}
		for ($i = 0; $i < $num; $i++) {
			$userinfo_a = trim($data[$i]);
			$userinfo_k = preg_replace("/\\s(?=\\s)/", "\\1", $userinfo_a);
			$userinfo = explode(" ", $userinfo_k);
			if (preg_match("/[\x7f-\xff]/", $userinfo[0])) {
			} else {
				if (!empty($userinfo[0])) {
					Array_unshift($userinfo, "自动识别");
				}
			}
			if (preg_match("/[\x7f-\xff]/", $userinfo[2])) {
				exit("{\"code\":-1,\"msg\": \"格式错误，请修改后重新提交！！！\"}");
			}
			if (empty($userinfo[3]) || $userinfo[3] == NULL || $userinfo[3] == " ") {
				exit("{\"code\":-1,\"msg\": \"格式错误，请修改后重新提交！！！\"}");
			}
			for ($j = 3; $j < count($userinfo); $j++) {
				$new_info[] = [$userinfo[0], $userinfo[1], $userinfo[2], $userinfo[$j]];
			}
		}
		$money = count($new_info) * $danjia;
		if ($userrow["money"] < $money) {
			exit("{\"code\":-1,\"msg\": \"余额不足！\"}");
		}
		for ($i = 0; $i < count($new_info); $i++) {
			$school = $new_info[$i][0];
			$user = $new_info[$i][1];
			$pass = $new_info[$i][2];
			$kcname = $new_info[$i][3];
			if ($DB->get_row("select * from qingka_wangke_order where ptname='" . $rs["name"] . "' and school='" . $school . "' and user='" . $user . "' and pass='" . $pass . "' and kcid='" . $kcid . "' and kcname='" . $kcname . "' ")) {
				$dockstatus = "3";
			} else {
				if ($rs["docking"] == 0) {
					$dockstatus = "99";
				} else {
					$dockstatus = "0";
				}
			}
			$is = $DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,name,user,pass,kcid,kcname,courseEndTime,fees,noun,miaoshua,addtime,ip,dockstatus) values ('" . $userrow["uid"] . "','" . $rs["cid"] . "','" . $rs["docking"] . "','" . $rs["name"] . "','" . $school . "','" . $userName . "','" . $user . "','" . $pass . "','" . $kcid . "','" . $kcname . "','" . $kcjs . "','" . $danjia . "','" . $rs["noun"] . "','" . $miaoshua . "','" . $date . "','" . $clientip . "','" . $dockstatus . "') ");
			if ($is) {
				$DB->query("update qingka_wangke_user set money=money-'" . $danjia . "' where uid='" . $userrow["uid"] . "' limit 1 ");
				wlog($userrow["uid"], "批量提交", " " . $rs["name"] . " " . $school . " " . $user . " " . $pass . " " . $kcname . " ", -1 * $danjia);
			}
		}
		exit("{\"code\":1,\"msg\":\"成功提交 " . count($new_info) . " 门课程,扣费" . $money . "元！！！\"}");
		break;
	case "connect":
		$res = $Oauth->login("qq");
		if (isset($res["code"]) && $res["code"] == 0) {
			$result = ["code" => 0, "url" => $res["url"]];
		} else {
			if (isset($res["code"])) {
				$result = ["code" => -1, "msg" => $res["msg"]];
			} else {
				$result = ["code" => -1, "msg" => "快捷登录接口请求失败"];
			}
		}
		exit(json_encode($result));
		break;
	case "loglist1":
		$page = trim(strip_tags(daddslashes(trim($_POST["page"]))));
		$type = "批量提交";
		$types = trim(strip_tags(daddslashes(trim($_POST["types"]))));
		$qq = trim(strip_tags(daddslashes(trim($_POST["qq"]))));
		$pagesize = 20;
		$pageu = ($page - 1) * $pagesize;
		if ($userrow["uid"] != "1") {
			$sql1 = "where uid='" . $userrow["uid"] . "'";
		} else {
			$sql1 = "where 1=1";
		}
		if ($type != "") {
			$sql2 = " and type='" . $type . "'";
		}
		if ($types != "") {
			if ($type == "1") {
				$sql3 = " and text like '%" . $qq . "%' ";
			} elseif ($type == "2") {
				$sql3 = " and money like '%" . $qq . "%' ";
			} elseif ($type == "3") {
				$sql3 = " and addtime=" . $qq;
			}
		}
		$sql = $sql1 . $sql2 . $sql3;
		$a = $DB->query("select * from qingka_wangke_log " . $sql . " order by id desc limit  " . $pageu . "," . $pagesize . " ");
		$count1 = $DB->count("select count(*) from qingka_wangke_log " . $sql . " ");
		while ($row = $DB->fetch($a)) {
			$data[] = $row;
		}
		$last_page = ceil($count1 / $pagesize);
		$data = array("code" => 1, "data" => $data, "current_page" => (int) $page, "last_page" => $last_page);
		exit(json_encode($data));
		break;
}
if ($islogin != 1) {
	exit("{\"code\":-10,\"msg\":\"请先登录\"}");
}
function get($rDrFhWJ)
{
	$CphLtfJ = curl_init();
	curl_setopt($CphLtfJ, CURLOPT_URL, $rDrFhWJ);
	curl_setopt($CphLtfJ, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($CphLtfJ, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($CphLtfJ, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($CphLtfJ, CURLOPT_TIMEOUT, 10);
	curl_setopt($CphLtfJ, CURLOPT_USERAGENT, isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36");
	$STlQtWv = curl_exec($CphLtfJ);
	curl_close($CphLtfJ);
	return $STlQtWv;
}
function getHeaders($OElAKav, $ZllWBJJ = FALSE)
{
	$jQLPGGJ = get_headers($OElAKav, 1);
	if (!$ZllWBJJ) {
		return $jQLPGGJ;
	}
	$xzMQqZJ = curl_init();
	curl_setopt($xzMQqZJ, CURLOPT_URL, $OElAKav);
	curl_setopt($xzMQqZJ, CURLOPT_HEADER, 1);
	curl_setopt($xzMQqZJ, CURLOPT_NOBODY, 1);
	curl_setopt($xzMQqZJ, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($xzMQqZJ, CURLOPT_TIMEOUT, 30);
	curl_exec($xzMQqZJ);
	$seXQMEv = curl_getinfo($xzMQqZJ, CURLINFO_HTTP_CODE);
	curl_close($xzMQqZJ);
	return $seXQMEv;
}