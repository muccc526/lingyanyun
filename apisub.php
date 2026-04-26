<?php
include "confing/common.php";
include "ayconfig.php";
require_once "custom_goods/functions.php";

switch ($act) {
    case "custom_goods_config_get":
        custom_goods_require_admin();
        custom_goods_json(1, "查询成功", array("data" => custom_goods_get_config()));
        break;
    case "custom_goods_config_save":
        custom_goods_require_admin();
        if (!custom_goods_table_exists("qingka_custom_goods_config")) {
            custom_goods_json(-1, "请先导入 custom_goods/install.sql");
        }
        $row = custom_goods_escape($_POST["config"]);
        $baseurl = custom_goods_normalize_baseurl($row["baseurl"]);
        $uid = $row["uid"];
        $api_key = $row["api_key"];
        if ($baseurl == "" || $uid == "" || $api_key == "") {
            custom_goods_json(-1, "配置不能为空");
        }
        $old = $DB->get_row("select * from qingka_custom_goods_config order by id asc limit 1");
        if ($old) {
            $DB->query("update qingka_custom_goods_config set baseurl='{$baseurl}',uid='{$uid}',api_key='{$api_key}',status='1',updatetime='{$date}' where id='{$old["id"]}'");
        } else {
            $DB->query("insert into qingka_custom_goods_config (baseurl,uid,api_key,status,addtime,updatetime) values ('{$baseurl}','{$uid}','{$api_key}','1','{$date}','{$date}')");
        }
        custom_goods_json(1, "保存成功");
        break;
    case "custom_goods_test":
        custom_goods_require_admin();
        $result = custom_goods_upstream_request("getclass");
        if (isset($result["code"]) && $result["code"] == 1) {
            custom_goods_json(1, "连接成功");
        }
        custom_goods_json(-1, isset($result["msg"]) ? $result["msg"] : "连接失败");
        break;
    case "custom_goods_sync":
        custom_goods_require_admin();
        $result = custom_goods_sync_from_upstream();
        custom_goods_json($result["code"], $result["msg"]);
        break;
    case "custom_goods_admin_list":
        custom_goods_require_admin();
        if (!custom_goods_table_exists("qingka_custom_goods")) {
            custom_goods_json(-1, "请先导入 custom_goods/install.sql");
        }
        $keyword = trim(strip_tags(daddslashes($_POST["keyword"])));
        $where = "where 1=1";
        if ($keyword != "") {
            $where .= " and name like '%{$keyword}%'";
        }
        $data = array();
        $a = $DB->query("select * from qingka_custom_goods {$where} order by sort asc,id desc");
        while ($row = $DB->fetch($a)) {
            $data[] = $row;
        }
        custom_goods_json(1, "查询成功", array("data" => $data));
        break;
    case "custom_goods_save":
        custom_goods_require_admin();
        if (!custom_goods_table_exists("qingka_custom_goods")) {
            custom_goods_json(-1, "请先导入 custom_goods/install.sql");
        }
        $item = custom_goods_escape($_POST["item"]);
        $id = intval($item["id"]);
        if ($id <= 0) {
            custom_goods_json(-1, "商品ID错误");
        }
        $price = floatval($item["price"]);
        $sort = intval($item["sort"]);
        $status = intval($item["status"]) == 1 ? 1 : 0;
        $yunsuan = $item["yunsuan"] == "+" ? "+" : "*";
        $name = $item["name"];
        $content = isset($item["content"]) ? $item["content"] : "";
        $DB->query("update qingka_custom_goods set name='{$name}',content='{$content}',price='{$price}',yunsuan='{$yunsuan}',sort='{$sort}',status='{$status}',updatetime='{$date}' where id='{$id}'");
        custom_goods_json(1, "保存成功");
        break;
    case "custom_goods_delete":
        custom_goods_require_admin();
        if (!custom_goods_table_exists("qingka_custom_goods")) {
            custom_goods_json(-1, "请先导入 custom_goods/install.sql");
        }
        $id = intval($_POST["id"]);
        $DB->query("delete from qingka_custom_goods where id='{$id}'");
        custom_goods_json(1, "删除成功");
        break;
    case "custom_goods_public_list":
        custom_goods_require_login();
        custom_goods_json(1, "查询成功", array("data" => custom_goods_get_public_list($userrow)));
        break;
    case "custom_goods_order_add":
        custom_goods_require_login();
        if ($userrow["active"] == 0) {
            custom_goods_json(-1, "账号已被封禁");
        }
        $platform = trim(strip_tags(daddslashes($_POST["platform"])));
        $quantity = isset($_POST["quantity"]) ? floatval($_POST["quantity"]) : 1;
        $input_data = array();
        if (isset($_POST["input_data"])) {
            $input_data = json_decode($_POST["input_data"], true);
        }
        if (!is_array($input_data)) {
            $input_data = array();
        }
        $result = custom_goods_submit_order($userrow, $platform, $input_data, $quantity);
        if ($result["code"] == 1) {
            custom_goods_json(1, "提交成功", array("id" => $result["id"]));
        }
        custom_goods_json(-1, $result["msg"]);
        break;
    case "custom_goods_order_list":
        custom_goods_require_login();
        if (!custom_goods_table_exists("qingka_custom_goods_order")) {
            custom_goods_json(-1, "请先导入 custom_goods/install.sql");
        }
        $where = $userrow["uid"] == 1 ? "where 1=1" : "where o.uid='{$userrow["uid"]}'";
        $data = array();
        $a = $DB->query("select o.*,g.name as goods_name from qingka_custom_goods_order o left join qingka_custom_goods g on g.id=o.goods_id {$where} order by o.id desc limit 100");
        while ($row = $DB->fetch($a)) {
            $data[] = $row;
        }
        custom_goods_json(1, "查询成功", array("data" => $data));
        break;
    case "custom_goods_order_query":
        custom_goods_require_login();
        $oid = trim(strip_tags(daddslashes($_POST["oid"])));
        $result = custom_goods_query_order($userrow["uid"], $oid);
        if ($result["code"] != 1) {
            custom_goods_json(-1, $result["msg"]);
        }
        custom_goods_json(1, "查询成功", array("data" => $result["data"]));
        break;
    case "yqprice_1":
        $yqprice = filter_input(INPUT_POST, "yqprice", FILTER_VALIDATE_FLOAT);
        if ($yqprice === false || $yqprice < 0) {
            jsonReturn(-1, "请正确输入费率，必须为数字且大于0");
        }
        if ($yqprice < $userrow["addprice"]) {
            jsonReturn(-1, "下级默认费率不能比你低哦");
        }
        if ($yqprice < 0.2) {
            jsonReturn(-1, "邀请费率不能低于0.2");
        }
        $stmt = $DB->prepare(
            "UPDATE qingka_wangke_user SET yqprice = :yqprice WHERE uid = :uid"
        );
        $stmt->bindParam(":yqprice", $yqprice);
        $stmt->bindParam(":uid", $userrow["uid"]);
        if ($stmt->execute()) {
            jsonReturn(1, "设置成功");
        } else {
            jsonReturn(-1, "更新失败，请稍后再试");
        }
        if ($userrow["yqm"] == "") {
        }

        break;
    case "fl2":
        $raw_data = $_POST["data"];
        $raw_active = $_POST["active"];
        if (
            !is_array($raw_data) ||
            !isset($raw_data["id"], $raw_data["sort"], $raw_data["name"])
        ) {
            jsonReturn(-1, "缺少必要的数据");
        }
        $id = trim($raw_data["id"]);
        $sort = trim($raw_data["sort"]);
        $name = trim($raw_data["name"]);
        $active = filter_var($raw_active, FILTER_VALIDATE_INT);

        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "权限不足");
        }

        $stmt = $DB->prepare(
            "UPDATE `qingka_wangke_class` SET `fenlei` = :name WHERE `name` LIKE :sort_pattern"
        );
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sort_pattern", "%$sort%");

        if ($active === 1 && $stmt->execute()) {
            jsonReturn(1, "修改成功");
        } else {
            jsonReturn(-1, "操作无效或未知");
        }

        break;
    case "xxt_list_exercise":
        $user = trim(strip_tags(daddslashes($_GET["user"])));
        $password = trim(strip_tags(daddslashes($_GET["password"])));
        $school = trim(strip_tags(daddslashes($_GET["school"])));
        $course_id = trim(strip_tags(daddslashes($_GET["course_id"])));
        $page_no = trim(strip_tags(daddslashes($_GET["page_no"])));
        $result = getZc($user, $password, $school, $course_id, $page_no);
        exit($result);
        break;
    case 'dltzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dltzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "登陆通知已开启");
    break;
case 'dltzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dltzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "登陆通知已关闭");
    break;
case 'wctzkgkzOpen':
    $uid = $userrow['uid'];
       $DB->query("UPDATE qingka_wangke_user SET wctzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "订单完成通知已开启");
    break;
case 'wctzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET wctzkg = 'off' WHERE uid = '$uid'");
     jsonReturn(1, "订单完成通知已关闭");
    break;
case 'yctzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET yctzkg = 'off' WHERE uid = '$uid'");
     jsonReturn(1, "订单异常通知已关闭");
    break;
case 'yctzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET yctzkg = 'on' WHERE uid = '$uid'");
     jsonReturn(1, "订单异常通知已开启");
    break;
    case 'yetzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET yetzkg = 'on' WHERE uid = '$uid'");
    jsonReturn(1, "余额预警通知已开启");
    break;
case 'yetzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET yetzkg = 'off' WHERE uid = '$uid'");
    jsonReturn(1, "余额预警通知已关闭");
    break;
case 'sjtzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET sjtzkg = 'off' WHERE uid = '$uid'");
     jsonReturn(1, "数据通知已关闭");
    break;
case 'sjtzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET sjtzkg = 'on' WHERE uid = '$uid'");
     jsonReturn(1, "数据通知已开启");
    break;
case 'dlzctzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dlzctzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "邀请注册通知已开启");
    break;
case 'dlzctzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dlzctzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "邀请注册通知已关闭");
    break;
case 'tktzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET tktzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "退款通知已开启");
    break;
case 'tktzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET tktzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "退款通知已关闭");
    break;
case 'czcgtzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET czcgtzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "充值成功通知已开启");
    break;
case 'czcgtzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET czcgtzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "充值成功通知已关闭");
    break;
case 'dlsbtzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dlsbtzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "登录失败通知已开启");
    break;
case 'dlsbtzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET dlsbtzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "登录失败通知已关闭");
    break;
case 'xgmmtzkgkzOpen':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET xgmmtzkg = 'on' WHERE uid = '$uid'");
        jsonReturn(1, "修改密码通知已开启");
    break;
case 'xgmmtzkgkzClose':
    $uid = $userrow['uid'];
    $DB->query("UPDATE qingka_wangke_user SET xgmmtzkg = 'off' WHERE uid = '$uid'");
        jsonReturn(1, "修改密码通知已关闭");
    break;
    case "wlogin_1":
        $uid = $_POST["uid"] ?? null;
        if ($uid === null) {
            jsonReturn(-1, "UID未提供");
        }

        $stmt = $DB->prepare(
            "SELECT * FROM qingka_wangke_user WHERE uid = :uid LIMIT 1"
        );
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || $row["uid"] !== 1) {
            jsonReturn(-1, "登录失败：用户不存在或不是管理员");
        }

        $pass = $_POST["pass"] ?? null;
        if ($pass === null || !password_verify($pass, $row["password_hash"])) {
            jsonReturn(-1, "登录失败：密码错误");
        }

        $session = password_hash($uid . $pass, PASSWORD_DEFAULT);
        $token = authcode("{$uid}\t{$session}", "ENCODE", SYS_KEY);

        setcookie("admin_token", $token, time() + 3000, "/", null, true, true);

        jsonReturn(1, "登录成功");

        break;
    case "userinfo_1":
        if ($islogin != 1) {
            exit('{"code":-10,"msg":"请先登录"}');
        }
        $a = $DB->get_row(
            "select uid,user,notice from qingka_wangke_user where uid='{$userrow["uuid"]}' "
        );
        $dd = $DB->count(
            "select count(oid) from qingka_wangke_order where uid='{$userrow["uid"]}' "
        );
        //$zcz=$DB->count("select sum(money) as money from qingka_wangke_log where type='上级充值' and uid='{$userrow['uid']}' ");

        //安全验证1
        if ($userrow["addprice"] < 0.1) {
            $DB->query(
                "update qingka_wangke_user set addprice='1' where uid='{$userrow["uid"]}' "
            );
            jsonReturn(
                -9,
                "大佬，我得罪不起您啊，有什么做的不好的地方尽管提出来，我小本生意，经不起折腾，还望多多包涵"
            );
        }
        //安全验证2
        if ($userrow["uid"] != 1) {
            if ((int) $userrow["money"] - (int) "0.1" > (int) $userrow["zcz"]) {
                $DB->query(
                    "update qingka_wangke_user set money='$zcz',active='0' where uid='{$userrow["uid"]}' "
                );
                jsonReturn(-9, "账号异常，请联系你老大");
            }
        }

        //代理数据统计
        $dlzs = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' "
        );
        $dldl = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' and endtime>'$jtdate' "
        );
        $dlzc = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' and addtime>'$jtdate' "
        );
        $jrjd = $DB->count(
            "select count(uid) from qingka_wangke_order where uid='{$userrow["uid"]}' and addtime>'$jtdate' "
        );

        $dailitongji = [
            "dlzc" => $dlzc,
            "dldl" => $dldl,
            "dlxd" => $dlxd,
            "dlzs" => $dlzs,
            "jrjd" => $jrjd,
        ];

        $data = [
            "code" => 1,
            "msg" => "查询成功",
            "uid" => $userrow["uid"],
            "user" => $userrow["user"],
            "qq_openid" => $userrow["qq_openid"],
            "nickname" => $userrow["nickname"],
            "faceimg" => $userrow["faceimg"],
            "money" => round($userrow["money"], 2),
            "addprice" => $userrow["addprice"],
            "key" => $userrow["key"],
            "sjuser" => $a["user"],
            "dd" => $dd,
            "zcz" => $userrow["zcz"],
            "yqm" => $userrow["yqm"],
            "yqprice" => $userrow["yqprice"],
            "notice" => $conf["notice"],
            "sjnotice" => $a["notice"],
            "dailitongji" => $dailitongji,
        ];
        exit(json_encode($data));
        break;
}
$php_Self = substr(
    $_SERVER["PHP_SELF"],
    strripos($_SERVER["PHP_SELF"], "/") + 1
);
if ($php_Self != "apisub.php") {
    $msg = "%E6%96%87%E4%BB%B6%E9%94%99%E8%AF%AF";
    $msg = urldecode($msg);
    exit(json_encode(["code" => -1, "msg" => $msg]));
}
switch ($act) {
    case "status_order":
        $a = trim(strip_tags(daddslashes($_GET["a"])));
        $sex = daddslashes($_POST["sex"]);
        $type = trim(strip_tags(daddslashes($_POST["type"])));
        if ($a == " " or empty($sex)) {
            jsonReturn(-1, "请先选择订单");
        }
        if ($userrow["uid"] == 0) {
            jsonReturn(-1, "老铁，求您别干我");
        }

        if ($type == 1) {
            $sql = "`status`='$a'";
        } elseif ($type == 2) {
            $sql = "`dockstatus`='$a'";
        }

        if ($userrow["uid"] == 1) {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $b = $DB->query(
                    "update qingka_wangke_order set {$sql} where oid='{$oid}' "
                );
            }
            if ($b) {
                jsonReturn(1, "修改成功");
            } else {
                jsonReturn(-1, "未知异常");
            }
        } else {
            exit('{"code":-1,"msg":"无权限"}');
        }
        break;
    case 'passwd':
    $oldpass = trim(strip_tags(daddslashes($_POST['oldpass'])));
    $newpass = trim(strip_tags(daddslashes($_POST['newpass'])));  

    if ($oldpass != $userrow['pass']) {
        exit('{"code":-1,"msg":"原密码错误"}');
    }
    if ($newpass == '') {
        exit('{"code":-1,"msg":"新密码不能为空"}');
    }

    // 获取 xgmmtzkg 和 tuisongtoken
    $uid = $userrow['uid'];
    $userQuery = "SELECT xgmmtzkg, tuisongtoken FROM `qingka_wangke_user` WHERE `uid`='{$uid}'";
    $userResult = $DB->query($userQuery);
    $userInfo = $userResult->fetch_assoc();

    $xgmmtzkg = $userInfo['xgmmtzkg'];
    $tuisongtoken = $userInfo['tuisongtoken'];

    $sql = "UPDATE `qingka_wangke_user` SET `pass` ='{$newpass}' WHERE `uid`='{$uid}'";
    if ($DB->query($sql)) {
        // 如果 xgmmtzkg 为 on，则发送通知
        if ($xgmmtzkg === 'on') {
            $user = $userrow['user']; // 假设用户信息中有用户名
            $current_time = date('Y-m-d H:i:s');
    $message = <<<EOD
                    <div style='
                        border: 1px solid #e0e0e0;
                        border-radius: 8px;
                        padding: 16px;
                        background-color: #f9f9f9;
                        font-family: Arial, sans-serif;
                        max-width: 400px;
                        margin: 0 auto;
                    '>
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>❤️ 密码修改通知 ❤️ </h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>账号:</strong>
                            <span style='color: #555;'>$user</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                        <strong>时间:</strong>
                            <span style='color: #555;'>$current_time</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                        <strong>内容:</strong>
                            <span style='color: #555;'>您的密码已成功修改！</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            请确保是否为本人操作！
                        </p>
                    </div>
EOD;
            $data = [
                'content' => $message,
                'summary' => '密码修改通知',
                'contentType' => 2,
                'spt' => $tuisongtoken, // 使用获取的 tuisongtoken
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

        exit('{"code":1,"msg":"修改成功,请牢记密码"}');
    } else {
        exit('{"code":-1,"msg":"修改失败"}');
    }
    break;
     case 'kehutuisong':
        $oid=trim(strip_tags(daddslashes($_POST['oid'])));
        $tuisongtoken=trim(strip_tags(daddslashes($_POST['token'])));
        $row = $DB->get_row("SELECT * FROM `qingka_wangke_order` WHERE `oid` = '$oid' ");
        if ($userrow['uid'] != $row['uid']) {
        jsonReturn(-1, "该订单不是你的，无法添加！");
        } else {
       
                $DB->query("UPDATE `qingka_wangke_order` SET `tuisongtoken` = '$tuisongtoken'  WHERE `oid` = '$oid'");
                wlog($row['uid'], "填写推送", "{$row['uid']} 填写了订单{$row['oid']}的客户推送地址", 0); // 添加日志记录
                jsonReturn(1, "推送token填写成功，静待推送");
            }
break;
    case "webset":
    parse_str(daddslashes($_POST["data"]), $row);
    if ($userrow["uid"] != 1) {
        exit('{"code":-1,"msg":"权限不足"}');
    } else {
        foreach ($row as $config_key => $config_value) {
            // 特殊字段加密处理
            if (in_array($config_key, ["dklcookie", "nanatoken", "akcookie", "vpercookie"])) {
                $config_value = authcode($config_value, "ENCODE", "qingka");
            }
            // 更新指定配置项（v=配置名，k=值）
            $DB->query("UPDATE `qingka_wangke_config` SET k='{$config_value}' WHERE v='{$config_key}'");
        }
        exit('{"code":1,"msg":"修改成功"}');
    }
    break;
    case 'neworderlist':
	    $cx=daddslashes($_POST['cx']);
	    $page=trim(strip_tags(daddslashes($_POST['page'])));
		// 接收新的查询参数
$mh = trim(strip_tags(daddslashes($_POST['cx']['mh'])));
$search = trim(strip_tags(daddslashes($_POST['cx']['search'])));
$school = trim(strip_tags(daddslashes($_POST['cx']['school'])));
	 // 使用新的limit参数
    $pagesize = isset($cx['limit']) && is_numeric($cx['limit']) ? intval($cx['limit']) : 20;
    $pageu = ($page - 1) * $pagesize; //当前界面
	    $qq=trim(strip_tags($cx['qq']));
	    $status_text=trim(strip_tags($cx['status_text']));
	    $dock=trim(strip_tags($cx['dock']));
	    $cid=trim(strip_tags($cx['cid']));
	    $oid=trim(strip_tags($cx['oid']));
	    $uid=trim(strip_tags($cx['uid']));
	    $kcname=trim(strip_tags($cx['kcname']));
	    if($userrow['uid']!='1'){
          	$sql1="where uid='{$userrow['uid']}'"; 
		}else{
			$sql1="where 1=1"; 
		}

	if($cid!=''){
    $sql2 .= " and cid='{$cid}'"; // 追加条件，而不是覆盖
}
if($qq!=''){
    $sql2 .= " and user='{$qq}'"; // 追加条件，而不是覆盖
}
if($oid!=''){
    $sql21 .= " and oid='{$oid}'"; // 追加条件，而不是覆盖
}
if($uid!=''){
    $sql21 .= " and uid='{$uid}'"; // 追加条件，而不是覆盖
}
if($status_text!=''){
    $sql3 .= " and status='{$status_text}'"; // 追加条件，而不是覆盖
}
if($kcname!=''){
    $sql3 .= " and kcname LIKE '%{$kcname}%'"; // 追加条件，而不是覆盖
}
if($dock!=''){
    $sql4 .= " and dockstatus='{$dock}'"; // 追加条件，而不是覆盖
}
    // 模糊查询处理
    if ($mh != '' && $search != '') {
        $sql5 .= " and {$search} LIKE '%{$mh}%'";
    } else if ($mh != '') {
        // 如果没有提供search参数，则对所有字段进行模糊查询
        $sql5 .= " and (uid LIKE '%{$mh}%' or oid LIKE '%{$mh}%' or user LIKE '%{$mh}%' or kcname LIKE '%{$mh}%' or school LIKE '%{$mh}%' or process LIKE '%{$mh}%' or remarks LIKE '%{$mh}%' or pass LIKE '%{$mh}%')";
    }
        // 组合所有的SQL查询条件
    $sql = $sql1 . $sql2 . $sql21 . $sql3 . $sql4 . $sql5;
	 // 指定查询的字段
    $fields = "addtime, cid, courseEndTime, courseStartTime, dockstatus, examEndTime, examStartTime, fees, kcname, oid, pass, ptname, school, status, uid, user,process,remarks";

    // 获取数据
    $a = $DB->query("SELECT {$fields} FROM qingka_wangke_order {$sql} ORDER BY oid DESC LIMIT $pageu, $pagesize");
	    $count1=$DB->count("select count(*) from qingka_wangke_order {$sql} ");	
	    while($row=$DB->fetch($a)){
	       if($row['name']=='' || $row['name']=='undefined'){
	       	  $row['name']='null';
	       }
	   	   $data[]=$row;
	    }
	    $last_page=ceil($count1/$pagesize);//取最大页数
	    $data=array('code'=>1,'data'=>$data,"current_page"=>(int)$page,"last_page"=>$last_page,"uid"=>(int)$userrow['uid']);
	    exit(json_encode($data));
	break;
    case "szyqm":
        //jsonReturn(-1,"邀请码暂停设置");
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        $yqm = trim(strip_tags(daddslashes($_POST["yqm"])));
        if (strlen($yqm) < 4) {
            jsonReturn(-1, "邀请码最少4位，且必须为数字");
        }
        if (!is_numeric($yqm)) {
            jsonReturn(-1, "请正确输入邀请码，必须为数字");
        }
        if (
            $DB->get_row("select * from qingka_wangke_user where yqm='$yqm' ")
        ) {
            jsonReturn(-1, "该邀请码已被使用，请换一个");
        }
        $a = $DB->get_row("select * from qingka_wangke_user where uid='$uid' ");
        if ($userrow["uid"] == "1") {
            $DB->query(
                "update qingka_wangke_user set yqm='{$yqm}' where uid='$uid' "
            );
            wlog(
                $userrow["uid"],
                "设置邀请码",
                "给下级设置邀请码{$yqm}成功",
                "0"
            );
            jsonReturn(1, "设置成功");
            //}elseif($userrow['uid']==$a['uuid'] && $userrow['addprice']=='1'){
        } elseif ($userrow["uid"] == $a["uuid"]) {
            $DB->query(
                "update qingka_wangke_user set yqm='{$yqm}' where uid='$uid' "
            );
            wlog(
                $userrow["uid"],
                "设置邀请码",
                "给下级设置邀请码{$yqm}成功",
                "0"
            );
            jsonReturn(1, "设置成功");
        } else {
            jsonReturn(-1, "无权限");
        }

        break;
    case "yqprice":
        $yqprice = trim(strip_tags(daddslashes($_POST["yqprice"])));
        if (!is_numeric($yqprice)) {
            jsonReturn(-1, "请正确输入费率，必须为数字");
        }
        if ($yqprice < $userrow["addprice"]) {
            jsonReturn(-1, "下级默认费率不能比你低哦");
        }
        if ($yqprice < 0.2) {
            jsonReturn(-1, "邀请费率最低设置为0.20");
        }

        if ($userrow["yqm"] == "") {
            $yqm = random(5, 5);
            if (
                $DB->get_row(
                    "select uid from qingka_wangke_user where yqm='$yqm' "
                )
            ) {
                $yqm = random(6, 5);
            }
            $sql = "yqm='{$yqm}',yqprice='$yqprice'";
        } else {
            $sql = "yqprice='$yqprice'";
        }
        $DB->query(
            "update qingka_wangke_user set {$sql} where uid='{$userrow["uid"]}' "
        );
        jsonReturn(1, "设置成功");
        break;
    case "wlogin":
        jsonReturn(1, "不写也罢");
        if ($userrow["uid"] == 1) {
            $uid = daddslashes($_POST["uid"]);
            $row = $DB->get_row(
                "SELECT * FROM qingka_wangke_user WHERE uid='$uid' limit 1"
            );
            $session = md5($user . $pass . $password_hash);
            $token = authcode("{$user}\t{$session}", "ENCODE", SYS_KEY);
            setcookie("admin_token", $token, time() + 3000);
            exit('{"code":1,"msg":"登录成功"}');
        } else {
            jsonReturn(-1, "你在干啥？");
        }
        break;
    case "userinfo":
        if ($islogin != 1) {
            exit('{"code":-10,"msg":"请先登录"}');
        }
        $a = $DB->get_row(
            "select uid,user,notice from qingka_wangke_user where uid='{$userrow["uuid"]}' "
        );
        $dd = $DB->count(
            "select count(oid) from qingka_wangke_order where uid='{$userrow["uid"]}' "
        );
        //$zcz=$DB->count("select sum(money) as money from qingka_wangke_log where type='上级充值' and uid='{$userrow['uid']}' ");

        //安全验证1
        if ($userrow["addprice"] < 0.1) {
            $DB->query(
                "update qingka_wangke_user set addprice='1' where uid='{$userrow["uid"]}' "
            );
            jsonReturn(
                -9,
                "大佬，我得罪不起您啊，有什么做的不好的地方尽管提出来，我小本生意，经不起折腾，还望多多包涵"
            );
        }
        //安全验证2
        if ($userrow["uid"] != 1) {
            if ((int) $userrow["money"] - (int) "0.1" > (int) $userrow["zcz"]) {
                $DB->query(
                    "update qingka_wangke_user set money='$zcz',active='0' where uid='{$userrow["uid"]}' "
                );
                jsonReturn(-9, "账号异常，请联系你老大");
            }
        }

        //代理数据统计
        $dlzs = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' "
        );
        $dldl = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' and endtime>'$jtdate' "
        );
        $dlzc = $DB->count(
            "select count(uid) from qingka_wangke_user where uuid='{$userrow["uid"]}' and addtime>'$jtdate' "
        );
        $jrjd = $DB->count(
            "select count(uid) from qingka_wangke_order where uid='{$userrow["uid"]}' and addtime>'$jtdate' "
        );

        //       while($dllist2=$DB->fetch($DB->query("select uid from qingka_wangke_user where uuid='{$userrow['uid']}'"))){
        //       	  $dlxd+=$DB->count("select count(oid) from qingka_wangke_order where uid='{$ddlist2['uid']}' and addtime>'$jtdate' ");
        //       }

        //$dlxd="emmmmmm";
        $dailitongji = [
            "dlzc" => $dlzc,
            "dldl" => $dldl,
            "dlxd" => $dlxd,
            "dlzs" => $dlzs,
            "jrjd" => $jrjd,
        ];

        $data = [
            "code" => 1,
            "msg" => "查询成功",
            "uid" => $userrow["uid"],
            "user" => $userrow["user"],
            "qq_openid" => $userrow["qq_openid"],
            "nickname" => $userrow["nickname"],
            "faceimg" => $userrow["faceimg"],
            "money" => round($userrow["money"], 2),
            "addprice" => $userrow["addprice"],
            "key" => $userrow["key"],
            "sjuser" => $a["user"],
            "dd" => $dd,
            "zcz" => $userrow["zcz"],
            "yqm" => $userrow["yqm"],
            "yqprice" => $userrow["yqprice"],
            "notice" => $conf["notice"],
            "sjnotice" => $a["notice"],
            "dailitongji" => $dailitongji,
            'yctzkg' => $userrow['yctzkg'],
            'wctzkg' => $userrow['wctzkg'], 
            'dltzkg' => $userrow['dltzkg'], 
            'sjtzkg' => $userrow['sjtzkg'],
            'dlzctzkg' => $userrow['dlzctzkg'],
            'tktzkg' => $userrow['tktzkg'], 
            'dlsbtzkg' => $userrow['dlsbtzkg'], 
            'czcgtzkg' => $userrow['czcgtzkg'], 
            'xgmmtzkg' => $userrow['xgmmtzkg'], 
            
        ];
        exit(json_encode($data));
        break;
    case "ktapi":
        $type = trim(strip_tags(daddslashes($_GET["type"])));
        $uid = trim(strip_tags(daddslashes($_GET["uid"])));
        $key = random(16);
        if ($type == 1) {
            //自我开通
            if ($userrow["money"] < 300) {
                if ($userrow["money"] >= 10) {
                    $DB->query(
                        "update qingka_wangke_user set `key`='$key',`money`=`money`-10 where uid='{$userrow["uid"]}' "
                    );
                    wlog(
                        $userrow["uid"],
                        "开通接口",
                        "开通接口成功!扣费10元",
                        "-10"
                    );
                    exit(
                        '{"code":1,"msg":"花费10元开通接口成功","key":"' .
                            $key .
                            '"}'
                    );
                } else {
                    exit('{"code":-1,"msg":"余额不足"}');
                }
            } else {
                $DB->query(
                    "update qingka_wangke_user set `key`='$key' where uid='{$userrow["uid"]}' "
                );
                wlog($userrow["uid"], "开通接口", "免费开通接口成功!", "0");
                exit('{"code":1,"msg":"免费开通成功","key":"' . $key . '"}');
            }
        } elseif ($type == 2) {
            if ($userrow["money"] < 5) {
                wlog(
                    $userrow["uid"],
                    "开通接口",
                    "尝试给下级UID{$uid}开通接口失败! 原因：余额不足",
                    "0"
                );
                jsonReturn(-2, "余额不足以开通");
            } else {
                if ($uid == "") {
                    jsonReturn(-2, "uid不能为空");
                }
                $DB->query(
                    "update qingka_wangke_user set `key`='$key' where uid='{$uid}' "
                );
                $DB->query(
                    "update qingka_wangke_user set `money`=`money`-5 where uid='{$userrow["uid"]}' "
                );
                wlog(
                    $userrow["uid"],
                    "开通接口",
                    "给下级代理UID{$uid}开通接口成功!扣费5元",
                    "-5"
                );
                wlog($uid, "开通接口", "你上级给你开通API接口成功!", "0");
                exit('{"code":1,"msg":"花费5元开通成功"}');
            }
        } elseif ($type == 3) {
            if ($userrow["key"] == "0") {
                exit('{"code":-1,"msg":"请先开通key""}');
            } elseif ($userrow["key"] != "") {
                $DB->query(
                    "update qingka_wangke_user set `key`='$key' where uid='{$userrow["uid"]}' "
                );
                wlog($userrow["uid"], "开通接口", "更换接口{$key}成功", "0");
                exit('{"code":1,"msg":"更换成功","key":"' . $key . '"}');
            }
        } elseif ($type == 4) {
            if ($userrow["key"] == "0") {
                exit('{"code":-1,"msg":"请先开通key""}');
            } elseif ($userrow["key"] != "") {
                $DB->query(
                    "update qingka_wangke_user set `key`='0' where uid='{$userrow["uid"]}' "
                );
                wlog($userrow["uid"], "关闭接口", "关闭接口{$key}成功", "0");
                exit('{"code":1,"msg":"关闭成功","key":"' . $key . '"}');
            }
        }
        jsonReturn(-2, "未知异常");
        break;

    case "yjdj":
        if ($userrow["uid"] == 1) {
            $hid = trim(strip_tags(daddslashes($_GET["hid"])));
            $pricee = trim(strip_tags(daddslashes($_GET["pricee"])));
            $category = trim(strip_tags(daddslashes($_GET["category"])));
            $a = $DB->get_row(
                "select * from qingka_wangke_huoyuan where hid='{$hid}' "
            );
            $data = ["uid" => $a["user"], "key" => $a["pass"]];
            $er_url = "{$a["url"]}/api.php?act=getclass";
            $result = get_url($er_url, $data);
            $result1 = json_decode($result, true);
            $DB->query(
                "insert into qingka_wangke_fenlei (sort,name,status,time) values ('0','{$a["name"]}','1',NOW())"
            );
            $b = $DB->get_row(
                "select * from qingka_wangke_fenlei where name='{$a["name"]}' ORDER BY id DESC LIMIT 0,1"
            );
            $data = $result1["data"];
            $numItems = count($data);
            $i = 0;
            foreach ($data as $k => $value) {
                if ($value["fenlei"] == $category) {
                    // 对比用户输入的分类ID
                    $price = $value["price"] * $pricee; // 1.05 就是增加5% 看不懂问数学老师
                    $sort = $i + 1; // 排序字段，可以根据需要进行调整
                    $DB->query(
                        "insert into qingka_wangke_class (name, getnoun, noun, fenlei, queryplat, docking, price, sort, content) values ('{$value["name"]}', '{$value["cid"]}', '{$value["cid"]}', '{$b["id"]}', '$hid', '$hid', '{$price}', '{$sort}', '{$value["content"]}')"
                    );
                    $i++;
                }
            }
            jsonReturn(
                1,
                "已上架{$a["name"]}的全部分类的项目，共计{$i}个，并自动新建分类到【{$b["name"]}】中，价格、排序和内容已更新"
            );
        }
        break;
    case "yjsj":
        $b = $DB->query("select * from qingka_wangke_class where 1=1 ");
        $count1 = $DB->count(
            "select count(*) from qingka_wangke_class where 1=1"
        );
        while ($res = $DB->fetch($b)) {
            $DB->query(
                "update qingka_wangke_class set status='1' where cid={$res["cid"]} "
            );
        }
        jsonReturn(1, "已上架{$count1}个项目");
        break;
    case "yjxj":
        $b = $DB->query("select * from qingka_wangke_class where 1=1 ");
        $count1 = $DB->count(
            "select count(*) from qingka_wangke_class where 1=1"
        );
        while ($res = $DB->fetch($b)) {
            $DB->query(
                "update qingka_wangke_class set status='0' where cid={$res["cid"]} "
            );
        }
        jsonReturn(1, "已下架{$count1}个项目");
        break;
    case "get":
        $cid = trim(strip_tags(daddslashes($_POST["cid"])));
        $userinfo = daddslashes($_POST["userinfo"]);
        $hash = daddslashes($_POST["hash"]);
        $rs = $DB->get_row(
            "select * from qingka_wangke_class where cid='$cid' limit 1 "
        );
        $kms = str_replace(["\r\n", "\r", "\n"], "[br]", $userinfo);
        $info = explode("[br]", $kms);

        $key = "AES_Encryptwords";
        $iv = "0123456789abcdef";
        $hash = openssl_decrypt($hash, "aes-128-cbc", $key, 0, $iv);
        if (empty($_SESSION["addsalt"]) || $hash != $_SESSION["addsalt"]) {
            exit('{"code":-1,"msg":"验证失败，请刷新页面重试"}');
        }

        for ($i = 0; $i < count($info); $i++) {
            $str = merge_spaces(trim($info[$i]));
            $userinfo2 = explode(" ", $str); //分割
            if (count($userinfo2) > 2) {
                $result = getWk(
                    $rs["queryplat"],
                    $rs["getnoun"],
                    trim($userinfo2[0]),
                    trim($userinfo2[1]),
                    trim($userinfo2[2]),
                    $rs["name"]
                );
            } else {
                $result = getWk(
                    $rs["queryplat"],
                    $rs["getnoun"],
                    "自动识别",
                    trim($userinfo2[0]),
                    trim($userinfo2[1]),
                    $rs["name"]
                );
            }
            $userinfo3 = trim(
                $userinfo2[0] . " " . $userinfo2[1] . " " . $userinfo2[2]
            );
            $result["userinfo"] = $userinfo3;
            wlog(
                $userrow["uid"],
                "查课",
                "{$rs["name"]}-查课信息：{$userinfo3}",
                0
            );
        }
        exit(json_encode($result));
        break;

case 'pay':
    $zdpay=$conf['zdpay'];
    $money=trim(strip_tags(daddslashes($_POST['money'])));
    $name="零食购买-".$money."";
    if(!preg_match('/^[0-9.]+$/', $money))exit('{"code":-1,"msg":"订单金额不合法"}');
    if($money<$zdpay){
        jsonReturn(-1,"在线充值最低{$zdpay}元");
    }
    $out_trade_no=date("YmdHis").rand(111,999);//生成本地订单号
    $wz=$_SERVER['HTTP_HOST'];
    $sql="insert into `qingka_wangke_pay` (`out_trade_no`,`uid`,`num`,`name`,`money`,`ip`,`addtime`,`domain`,`status`) values ('".$out_trade_no."','".$userrow['uid']."','".$money."','".$name."','".$money."','".$clientip."','".$date."','".$wz."','0')";
    if($DB->query($sql)){
        exit('{"code":1,"msg":"生成订单成功！","out_trade_no":"'.$out_trade_no.'","need":"'.$money.'"}');
    }else{
        exit('{"code":-1,"msg":"生成订单失败！'.$DB->error().'"}');
    }

        break;

    case "getclass_pl":
        $a = $DB->query(
            "select * from qingka_wangke_class where status=1 order by sort desc"
        );
        while ($row = $DB->fetch($a)) {
            if ($row["yunsuan"] == "*") {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            } elseif ($row["yunsuan"] == "+") {
                $price = round($row["price"] + $userrow["addprice"], 2);
                $price1 = $price;
            } else {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            }
            //密价
            $mijia = $DB->get_row(
                "select * from qingka_wangke_mijia where uid='{$userrow["uid"]}' and cid='{$row["cid"]}' "
            );
            if ($mijia) {
                if ($mijia["mode"] == 0) {
                    $price = round($price - $mijia["price"], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 1) {
                    $price = round(
                        ($row["price"] - $mijia["price"]) *
                            $userrow["addprice"],
                        2
                    );
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 2) {
                    $price = $mijia["price"];
                    if ($price <= 0) {
                        $price = 0;
                    }
                }
                $row["name"] = "【密价】{$row["name"]}";
            }
            if ($price >= $price1) {
                //密价价格大于原价，恢复原价
                $price = $price1;
            }
            $data[] = [
                "sort" => $row["sort"],
                "cid" => $row["cid"],
                "name" => $row["name"],
                "noun" => $row["noun"],
                "price" => $price,
                "fenlei" => $row["fenlei"],
                "content" => $row["content"],
                "status" => $row["status"],
                "miaoshua" => $miaoshua,
            ];
        }
        foreach ($data as $key => $row) {
            $sort[$key] = $row["sort"];
            $cid[$key] = $row["cid"];
            $name[$key] = $row["name"];
            $noun[$key] = $row["noun"];
            $price[$key] = $row["price"];
            $info[$key] = $row["info"];
            $content[$key] = $row["content"];
            $status[$key] = $row["status"];
            $miaoshua[$key] = $row["miaoshua"];
        }
        array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
        $data = ["code" => 1, "data" => $data];
        exit(json_encode($data));
        break;
    case 'add':
        if ($userrow['active'] == 0) {  
        jsonReturn(-1, "账号已被封禁!");  
    }  
	    $cid=trim(strip_tags(daddslashes($_POST['cid'])));
	    $data=daddslashes($_POST['data']);
	    $shichang=trim(strip_tags(daddslashes($_POST['shichang'])));
	    $score=trim(strip_tags(daddslashes($_POST['score'])));
	    $clientip=real_ip();
	    $rs=$DB->get_row("select * from qingka_wangke_class where cid='$cid' limit 1 ");
	    if($cid==''||$data==''){exit('{"code":-1,"msg":"请选择课程"}');}	    
	        if($rs['yunsuan']=="*"){
	    		$danjia=round($rs['price']*$userrow['addprice'],2);
	    	}elseif($rs['yunsuan']=="+"){
	    		$danjia=round($rs['price']+$userrow['addprice'],2);
	    	}else{
	    		$danjia=round($rs['price']*$userrow['addprice'],2);
	    	}
			//密价
				    	$mijia=$DB->get_row("select * from qingka_wangke_mijia where uid='{$userrow['uid']}' and cid='$cid' ");
				        if($mijia){
				            if ($mijia['mode']==0) {
				                $danjia=round($danjia-$mijia['price'],2);
				                if ($danjia<=0) {
				                    $danjia=0;
				                }
				            }elseif ($mijia['mode']==1) {
				                $danjia=round(($rs['price']-$mijia['price'])*$userrow['addprice'],2);
				                if ($danjia<=0) {
				                    $danjia=0;
				                }
				            }elseif ($mijia['mode']==2) {
				                $danjia=$mijia['price'];
				                if ($danjia<=0) {
				                    $danjia=0;
				                }
				            }
				        }	
	    
	        if($danjia==0 || $userrow['addprice']<0.1){
            	exit('{"code":-1,"msg":"大佬，我得罪不起您，我小本生意，有哪里得罪之处，还望多多包涵 !"}');
            } 
            
           $money=count($data)*$danjia;    
	       if($userrow['money']<$money){
	        	exit('{"code":-1,"msg":"余额不足"}');
	       } 
	    foreach($data as $row){
	    	$userinfo=$row['userinfo'];
	    	$userName=$row['userName'];
			$userinfo=explode(" ",$userinfo);//分割账号密码
		        if(count($userinfo)>2){
		          $school=$userinfo[0];
		       	  $user=$userinfo[1];
		       	  $pass=$userinfo[2];
		        }else{
		          $school="自动识别";
		          $user=$userinfo[0];
		       	  $pass=$userinfo[1];
		        }

	    	   $kcid=$row['data']['id'];
	    	   $kcname=$row['data']['name'];
	    	   $kcjs=$row['data']['kcjs'];
	    	   if($DB->get_row("select * from qingka_wangke_order where ptname='{$rs['name']}' and school='$school' and user='$user' and pass='$pass' and kcid='$kcid' and kcname='$kcname' ")){
                    $dockstatus='3';//重复下单
	       	   }elseif($rs['docking']==0 || $rs['docking']==10){
	       	      	$dockstatus='99';
	       	   }else{
	       	        $dockstatus='0';
	       	   }
       	      	$is=$DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,name,user,pass,kcid,kcname,courseEndTime,fees,noun,miaoshua,addtime,ip,dockstatus,score,shichang) values ('{$userrow['uid']}','{$rs['cid']}','{$rs['docking']}','{$rs['name']}','{$school}','$userName','$user','$pass','$kcid','$kcname','{$kcjs}','{$danjia}','{$rs['noun']}','$miaoshua','$date','$clientip','$dockstatus','$score','$shichang') ");//将对应课程写入数据库	               	       	      	
                if($is){
                  $DB->query("update qingka_wangke_user set money=money-'{$danjia}' where uid='{$userrow['uid']}' limit 1 "); 
                  wlog($userrow['uid'],"添加任务","  {$rs['name']} {$user} {$pass} {$kcname} 扣除{$danjia}积分！",-$danjia);
                } 
	    } 
	       if($is){
	         	exit('{"code":1,"msg":"提交成功"}');
	       }else{
	       	    exit('{"code":-1,"msg":"提交失败"}');
	       }
    break;
    case 'bs':
    if ($userrow['active'] == 0) {  
        jsonReturn(-1, "账号已被封禁");  
    }  
    $oid = trim(strip_tags(daddslashes($_GET['oid'])));
    $b = $DB->get_row("select hid,cid,dockstatus,status from qingka_wangke_order where oid='{$oid}' "); 
    
    if ($b['dockstatus'] == '99') {
        $DB->query("update qingka_wangke_order set status='待处理',`process`='',`remarks`='',`bsnum`=bsnum+1 where oid='{$oid}' ");
        jsonReturn(1, "成功加入线程，排队补刷中");       
    }
    if ($b['status'] == "已退款") {
        jsonReturn(1, "已退款订单无法补刷！");
    } else {
        // 增加对处理成功状态的判断和处理
        if ($b['dockstatus'] == '1') {
            $DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
            jsonReturn(1, "补刷操作开始，处理状态保持处理成功");
        } else {
            $b = budanWk($oid);
            if ($b['code'] == 1) {
                $DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
                jsonReturn(1, $b['msg']);
            } else {
                jsonReturn(-1, $b['msg']);
            }
        }
    }  
    break;
    case 'uporder'://进度刷新
    if ($userrow['active'] == 0) {  
        jsonReturn(-1, "账号已被封禁");  
    }  
           $oid=trim(strip_tags(daddslashes($_GET['oid'])));
           $row=$DB->get_row("select * from qingka_wangke_order where oid='$oid'");
           if($row['hid']=='ximeng'){
             	exit('{"code":-2,"msg":"当前订单接口异常，请去查询补单","url":""}');
           }elseif($row['dockstatus']=='99'){
           	    //$result=pre_zy($oid);
           	    //exit(json_encode($result));
           	    jsonReturn(1,'实时进度无需更新');
           }       	     
    	       $result=processCx($oid);
    	       for($i=0;$i<count($result);$i++){
    	        	$DB->query("update qingka_wangke_order set `name`='{$result[$i]['name']}',`yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `user`='{$result[$i]['user']}' and `kcname`='{$result[$i]['kcname']}' and `oid`='{$oid}'");
    	       }
    	       exit('{"code":1,"msg":"同步成功"}');
        break;
case 'ms_order'://列表提交秒刷
       $oid=trim(strip_tags(daddslashes($_GET['oid'])));
       $b = $DB->get_row("select cid,dockstatus from qingka_wangke_order where oid='{$oid}' ");
       if ($b['dockstatus'] == '99') {
			jsonReturn(1, "我的订单");
		} else {
			$b = msWk($oid);
			if ($b['code'] == 1) {
              $DB->query("update qingka_wangke_user set money=money-0.05 where uid='{$userrow['uid']}' limit 1 ");
				wlog($userrow['uid'], "提交秒刷", "订单{$oid}提交秒刷成功扣除0.05", -0.05);
				jsonReturn(1, $b['msg']);
			} else {
				jsonReturn(-1, $b['msg']);
			}
		}
    break;
    case 'qx_order'://取消订单
    if ($userrow['active'] == 0) {  
        jsonReturn(-1, "账号已被封禁 ");  
    }  
       $oid=trim(strip_tags(daddslashes($_GET['oid'])));
       $row=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
       if($row['uid']!=$userrow['uid'] && $userrow['uid']!=1){
       	 jsonReturn(-1,"无权限");
       }else{
       	$DB->query("update qingka_wangke_order set `status`='已取消',`dockstatus`=4 where oid='$oid' ");  
       	jsonReturn(1,"取消成功");
       } 
    break;
	case 'orderlist':
	    if ($userrow['active'] == 0) {  
        jsonReturn(-1, "账号已被封禁");  
    }  
	    $cx=daddslashes($_POST['cx']);
	    $page=trim(strip_tags(daddslashes($_POST['page'])));
		$pagesize=trim(strip_tags($cx['pagesize']));
	    $pageu = ($page - 1) * $pagesize;//当前界面		
	    $qq=trim(strip_tags($cx['qq']));
	    $status_text=trim(strip_tags($cx['status_text']));
	    $dock=trim(strip_tags($cx['dock']));
	    $cid=trim(strip_tags($cx['cid']));
	    $oid=trim(strip_tags($cx['oid']));
	    $uid=trim(strip_tags($cx['uid']));
	    $kcname=trim(strip_tags($cx['kcname']));
	    if($userrow['uid']!='1'){
          	$sql1="where uid='{$userrow['uid']}'"; 
		}else{
			$sql1="where 1=1"; 
		}
		if($kcname!=''){
	    	//$sql2=" and kcname='{$kcname}'";
	    	$sql2=" and kcname like '%".$kcname."%' ";
	    }
		if($cid!=''){
	    	$sql3=" and cid='{$cid}'";
	    }
	    if($qq!=''){
	    	$sql4=" and user='{$qq}'";
	    }
	    if($oid!=''){
	    	$sql5=" and oid='{$oid}'";
	    }
	    if($uid!=''){
	    	$sql6=" and uid='{$uid}'";
	    }
	   	if($status_text!=''){
	    	$sql7=" and status='{$status_text}'";
	    }
	   	if($dock!=''){
	    	$sql8=" and dockstatus='{$dock}'";
	    }
        $sql=$sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7.$sql8;
		$a=$DB->query("select * from qingka_wangke_order {$sql} order by oid desc limit $pageu,$pagesize ");
	    $count1=$DB->count("select count(*) from qingka_wangke_order {$sql} ");	
	    while($row=$DB->fetch($a)){
	       if($row['name']=='' || $row['name']=='undefined'){
	       	  $row['name']='null';
	       }
	   	   $data[]=$row;
	    }
	    $last_page=ceil($count1/$pagesize);//取最大页数
	    $data=array('code'=>1,'data'=>$data,"current_page"=>(int)$page,"last_page"=>$last_page,"uid"=>(int)$userrow['uid']);
	    exit(json_encode($data));
	break;

    case "duijie":
        $oid = trim(strip_tags(daddslashes($_GET["oid"])));
        $b = $DB->get_row(
            "select * from qingka_wangke_order where oid='$oid' limit 1 "
        );
        if ($userrow["uid"] != 1) {
            exit('{"code":-2,"msg":"无权限"}');
        }
        $d = $DB->get_row(
            "select * from qingka_wangke_class where cid='{$b["cid"]}' "
        );
        $result = addWk($oid);
        if ($result["code"] == "1") {
            $DB->query(
                "update qingka_wangke_order set `hid`='{$d["docking"]}',`status`='进行中',`dockstatus`=1,`yid`='{$result["yid"]}' where oid='{$oid}' "
            ); //对接成功
        } else {
            $DB->query(
                "update qingka_wangke_order set `dockstatus`=2 where oid='{$oid}' "
            );
        }
        exit(json_encode($result, true));
        break;
    case "getclass":
        $a = $DB->query(
            "select * from qingka_wangke_class where status=1 order by sort desc"
        );

        while ($row = $DB->fetch($a)) {
            if ($row["docking"] == "nana") {
                $miaoshua = 1;
            } else {
                $miaoshua = 0;
            }

            if ($row["yunsuan"] == "*") {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            } elseif ($row["yunsuan"] == "+") {
                $price = round($row["price"] + $userrow["addprice"], 2);
                $price1 = $price;
            } else {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            }
            //密价
            $mijia = $DB->get_row(
                "select * from qingka_wangke_mijia where uid='{$userrow["uid"]}' and cid='{$row["cid"]}' "
            );
            if ($mijia) {
                if ($mijia["mode"] == 0) {
                    $price = round($price - $mijia["price"], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 1) {
                    $price = round(
                        ($row["price"] - $mijia["price"]) *
                            $userrow["addprice"],
                        2
                    );
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 2) {
                    $price = $mijia["price"];
                    if ($price <= 0) {
                        $price = 0;
                    }
                }
                $row["name"] = "【密价】{$row["name"]}";
            }
            if ($price >= $price1) {
                //密价价格大于原价，恢复原价
                $price = $price1;
            }
            $data[] = [
                "sort" => $row["sort"],
                "cid" => $row["cid"],
                "name" => $row["name"],
                "noun" => $row["noun"],
                "price" => $price,
                "content" => $row["content"],
                "status" => $row["status"],
                "miaoshua" => $miaoshua,
            ];
        }
        foreach ($data as $key => $row) {
            $sort[$key] = $row["sort"];
            $cid[$key] = $row["cid"];
            $name[$key] = $row["name"];
            $noun[$key] = $row["noun"];
            $price[$key] = $row["price"];
            $info[$key] = $row["info"];
            $content[$key] = $row["content"];
            $status[$key] = $row["status"];
            $miaoshua[$key] = $row["miaoshua"];
        }
        array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
        $data = ["code" => 1, "data" => $data];
        exit(json_encode($data));

        break;
    case "getclassfl":
        $fenlei = trim(strip_tags(daddslashes($_POST["id"])));
        if ($fenlei == "") {
            $a = $DB->query(
                "select * from qingka_wangke_class where status=1 order by sort desc"
            );
        } else {
            $a = $DB->query(
                "select * from qingka_wangke_class where status=1 and fenlei='$fenlei' order by sort desc"
            );
        }

        while ($row = $DB->fetch($a)) {
            if ($row["docking"] == "nana") {
                $miaoshua = 1;
            } else {
                $miaoshua = 0;
            }

            if ($row["yunsuan"] == "*") {
                $price = number_format($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            } elseif ($row["yunsuan"] == "+") {
                $price = number_format($row["price"] + $userrow["addprice"], 2);
                $price1 = $price;
            } else {
                $price = number_format($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            }
            //密价
            $mijia = $DB->get_row(
                "select * from qingka_wangke_mijia where uid='{$userrow["uid"]}' and cid='{$row["cid"]}' "
            );
            if ($mijia) {
                if ($mijia["mode"] == 0) {
                    $price = number_format($price - $mijia["price"], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 1) {
                    $price = number_format(
                        ($row["price"] - $mijia["price"]) *
                            $userrow["addprice"],
                        2
                    );
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 2) {
                    $price = $mijia["price"];
                    if ($price <= 0) {
                        $price = 0;
                    }
                }
                $row["name"] = "【密价】{$row["name"]}";
            }
            if ($price >= $price1) {
                //密价价格大于原价，恢复原价
                $price = $price1;
            }

            //全站一个价
            if ($row["suo"] != 0) {
                $price = $row["suo"];
            }
            $data[] = [
                "sort" => $row["sort"],
                "cid" => $row["cid"],
                "name" => $row["name"],
                "noun" => $row["noun"],
                "price" => $price,
                "content" => $row["content"],
                "status" => $row["status"],
                "miaoshua" => $miaoshua,
            ];
        }
        foreach ($data as $key => $row) {
            $sort[$key] = $row["sort"];
            $cid[$key] = $row["cid"];
            $name[$key] = $row["name"];
            $noun[$key] = $row["noun"];
            $price[$key] = $row["price"];
            $info[$key] = $row["info"];
            $content[$key] = $row["content"];
            $status[$key] = $row["status"];
            $miaoshua[$key] = $row["miaoshua"];
        }
        array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
        $data = ["code" => 1, "data" => $data];
        exit(json_encode($data));

    case "classlist":
        $page = trim(strip_tags(daddslashes($_POST["page"])));
        $keyword = trim(strip_tags(daddslashes($_POST["keyword"])));
        $fenlei = trim(strip_tags(daddslashes($_POST["fenlei"])));
        $huoyuan = trim(strip_tags(daddslashes($_POST["huoyuan"])));
        $shangjiastatus = trim(
            strip_tags(daddslashes($_POST["shangjiastatus"]))
        );
        $pagesize = 100;
        $pageu = ($page - 1) * $pagesize; //当前界面

        // 初始化查询条件
        $where = [];

        // 添加关键词条件
        if (!empty($keyword)) {
            $where[] = "name LIKE '%$keyword%'";
        }

        // 添加分类条件
        if (!empty($fenlei)) {
            $where[] = "fenlei = '$fenlei'";
        }

        if (!empty($huoyuan)) {
            $where[] = "docking = '$huoyuan'";
        }
        // 添加状态条件
        if ($shangjiastatus !== "") {
            $where[] = "status = '$shangjiastatus'";
        }

        // 构建最终的查询条件
        $where = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        // 计算总记录数和总页数
        $count1 = $DB->count("SELECT COUNT(*) FROM qingka_wangke_class $where");
        $last_page = ceil($count1 / $pagesize); //取最大页数

        if ($userrow["uid"] == "1") {
            $a = $DB->query(
                "SELECT * FROM qingka_wangke_class $where LIMIT $pageu, $pagesize"
            );
            while ($row = $DB->fetch($a)) {
                $c = $DB->get_row(
                    "SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$row["queryplat"]}'"
                );
                $d = $DB->get_row(
                    "SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$row["docking"]}'"
                );
                $row["cx_name"] = $c["name"];
                $row["add_name"] = $d["name"];
                if ($row["queryplat"] == "0") {
                    $row["cx_name"] = "自营";
                }
                if ($row["docking"] == "0") {
                    $row["add_name"] = "自营";
                }
                // 确保返回的数据包含 newPrice 和 newSort 属性
                $row["newPrice"] = $row["price"];
                $row["newSort"] = $row["sort"];
                $data[] = $row;
            }
            foreach ($data as $key => $rows) {
                $sort[$key] = $rows["sort"];
                $cid[$key] = $rows["cid"];
                $name[$key] = $rows["name"];
                $getnoun[$key] = $rows["getnoun"];
                $noun[$key] = $rows["noun"];
                $price[$key] = $rows["price"];
                $queryplat[$key] = $rows["queryplat"];
                $yunsuan[$key] = $rows["yunsuan"];
                $content[$key] = $rows["content"];
                $addtime[$key] = $rows["addtime"];
                $status[$key] = $rows["status"];
                $cx_names[$key] = $rows["cx_names"];
                $add_name[$key] = $rows["add_name"];
            }
            array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
            $data = [
                "code" => 1,
                "data" => $data,
                "current_page" => (int) $page,
                "last_page" => $last_page,
            ];
            exit(json_encode($data));
        } else {
            exit('{"code":-2,"msg":"你在干啥"}');
        }
        break;

    case "deleteclass":
        $cid = trim(strip_tags(daddslashes($_POST["cid"])));
        if ($userrow["uid"] == 1) {
            $DB->query("DELETE FROM qingka_wangke_class WHERE cid = '$cid'");
            exit('{"code":1,"msg":"操作成功"}');
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;

    case "batchdeleteclass":
        if ($userrow["uid"] == 1) {
            if (isset($_POST["cids"]) && is_array($_POST["cids"])) {
                $cids = array_map("intval", $_POST["cids"]); // 确保 cids 是整数数组
                foreach ($cids as $cid) {
                    $DB->query(
                        "DELETE FROM qingka_wangke_class WHERE cid = '$cid'"
                    );
                }
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                exit('{"code":-1,"msg":"无效的参数"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;

    case "batchupdatestatus":
        $status = trim(strip_tags(daddslashes($_POST["status"])));
        if ($userrow["uid"] == 1) {
            if (isset($_POST["cids"]) && is_array($_POST["cids"])) {
                $cids = array_map("intval", $_POST["cids"]); // 确保 cids 是整数数组
                foreach ($cids as $cid) {
                    $DB->query(
                        "UPDATE qingka_wangke_class SET status = '$status' WHERE cid = '$cid'"
                    );
                }
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                exit('{"code":-1,"msg":"无效的参数"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;
    case "batchupdatepricesort":
        if ($userrow["uid"] == 1) {
            if (isset($_POST["updates"]) && is_array($_POST["updates"])) {
                $updates = $_POST["updates"];
                foreach ($updates as $update) {
                    $cid = intval($update["cid"]);
                    $newPrice = floatval($update["newPrice"]);
                    $newSort = intval($update["newSort"]);
                    $DB->query(
                        "UPDATE qingka_wangke_class SET price = '$newPrice', sort = '$newSort' WHERE cid = '$cid'"
                    );
                }
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                exit('{"code":-1,"msg":"无效的参数"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;

    case "upclass":
        parse_str(daddslashes($_POST["data"]), $row); //将字符串解析成多个变量
        if ($userrow["uid"] == 1) {
            if ($row["action"] == "add") {
                $DB->query(
                    "insert into qingka_wangke_class (sort,name,getnoun,noun,price,queryplat,docking,content,addtime,status,fenlei) values ('{$row["sort"]}','{$row["name"]}','{$row["getnoun"]}','{$row["noun"]}','{$row["price"]}','{$row["queryplat"]}','{$row["docking"]}','{$row["content"]}','{$date}','{$row["status"]}','{$row["fenlei"]}')"
                );
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                $DB->query(
                    "update `qingka_wangke_class` set `sort`='{$row["sort"]}',`name`='{$row["name"]}',`getnoun`='{$row["getnoun"]}',`noun`='{$row["noun"]}',`price`='{$row["price"]}',`queryplat`='{$row["queryplat"]}',`docking`='{$row["docking"]}',`yunsuan`='{$row["yunsuan"]}',`content`='{$row["content"]}',`status`='{$row["status"]}',`fenlei`='{$row["fenlei"]}' where cid='{$row["cid"]}' "
                );
                exit('{"code":1,"msg":"操作成功"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;
    case "batchaddsecretprice":
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "不知道你在干什么");
        }
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        $secretPrices = $_POST["secretPrices"];

        foreach ($secretPrices as $item) {
            $cid = intval($item["cid"]);
            $price = floatval($item["price"]);
            $mode = 2; // 固定为2

            $DB->query(
                "insert into qingka_wangke_mijia (uid, cid, mode, price, addtime) values ('$uid', '$cid', '$mode', '$price', NOW())"
            );
        }
        jsonReturn(1, "添加成功");
        break;
    case "mijialist":
        $page = trim(strip_tags(daddslashes($_POST["page"])));
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        $cid = trim(strip_tags(daddslashes($_POST["cid"])));
        $pagesize = 5000;
        $pageu = ($page - 1) * $pagesize; // 当前界面
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }

        $sql = "";
        if ($uid != "") {
            $sql .= "where uid='$uid'";
        }
        if ($cid != "" && $sql == "") {
            $sql .= "where cid='$cid'";
        } elseif ($cid != "") {
            $sql .= " and cid='$cid'";
        }

        $a = $DB->query(
            "select * from qingka_wangke_mijia {$sql} limit $pageu, $pagesize"
        );
        $count1 = $DB->count("select count(*) from qingka_wangke_mijia {$sql}");
        while ($row = $DB->fetch($a)) {
            $r = $DB->get_row(
                "select * from qingka_wangke_class where cid='{$row["cid"]}'"
            );
            $row["name"] = $r["name"];
            $data[] = $row;
        }
        $last_page = ceil($count1 / $pagesize); // 取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
            "uid" => $userrow["uid"],
        ];
        exit(json_encode($data));
        break;
        break;
    case "mijia":
        $data = daddslashes($_POST["data"]);
        $active = trim(strip_tags(daddslashes(trim($_POST["active"]))));
        $uid = trim(strip_tags(daddslashes(trim($data["uid"]))));
        $mid = trim(strip_tags(daddslashes(trim($data["mid"]))));
        $mode = trim(strip_tags(daddslashes(trim($data["mode"]))));
        $cid = trim(strip_tags(daddslashes(trim($data["cid"]))));
        $price = trim(strip_tags(daddslashes(trim($data["price"]))));
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "不知道你在干什么");
        }
        if ($active == "1") {
            //添加
            $DB->query(
                "insert into qingka_wangke_mijia (uid,cid,mode,price,addtime) values ('$uid','$cid','$mode','$price',NOW())"
            );
            jsonReturn(1, "添加成功");
        } elseif ($active == "2") {
            //修改
            $DB->query(
                "update qingka_wangke_mijia set `price`='$price',`mode`='$mode',`uid`='$uid',`cid`='$cid' where mid='$mid' "
            );
            jsonReturn(1, "修改成功");
        } else {
            jsonReturn(-1, "不知道你在干什么");
        }
        break;
    case "mijia_del":
        $mid = daddslashes($_POST["mid"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_mijia where mid='$mid' ");
        jsonReturn(1, "删除成功");
        break;

    case "mijiaxiugai":
        if ($userrow["uid"] == 1) {
            if (isset($_POST["updates"]) && is_array($_POST["updates"])) {
                $updates = $_POST["updates"];
                foreach ($updates as $update) {
                    $mid = intval($update["mid"]);
                    $newPrice = floatval($update["newPrice"]);
                    $DB->query(
                        "UPDATE qingka_wangke_mijia SET price = '$newPrice' WHERE mid = '$mid'"
                    );
                }
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                exit('{"code":-1,"msg":"无效的参数"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;

    case "batchdelete":
        if ($userrow["uid"] == 1) {
            if (isset($_POST["mids"]) && is_array($_POST["mids"])) {
                $mids = $_POST["mids"];
                foreach ($mids as $mid) {
                    $mid = intval($mid);
                    $DB->query(
                        "DELETE FROM qingka_wangke_mijia WHERE mid = '$mid'"
                    );
                }
                exit('{"code":1,"msg":"操作成功"}');
            } else {
                exit('{"code":-1,"msg":"无效的参数"}');
            }
        } else {
            exit('{"code":-2,"msg":"无权限"}');
        }
        break;
    case "huoyuanlist":
        $page = daddslashes($_POST["page"]);
        $pagesize = 50;
        $pageu = ($page - 1) * $pagesize; //当前界面
        $count1 = $DB->count("select count(*) from qingka_wangke_huoyuan");
        $last_page = ceil($count1 / $pagesize); //取最大页数
        if ($userrow["uid"] == "1") {
            $a = $DB->query(
                "select * from qingka_wangke_huoyuan limit $pageu,$pagesize "
            );
            while ($row = $DB->fetch($a)) {
                $data[] = $row;
            }
            $data = [
                "code" => 1,
                "data" => $data,
                "current_page" => (int) $page,
                "last_page" => $last_page,
            ];
            exit(json_encode($data));
        } else {
            exit('{"code":-2,"msg":"你在干啥"}');
        }
        break;
    case "uphuoyuan":
    parse_str(daddslashes($_POST["data"]), $row);
    if ($userrow["uid"] == 1) {
        if ($row["action"] == "add") {
            $DB->query(
                "insert into qingka_wangke_huoyuan (pt,name,url,user,pass,token,ip,cookie,addtime) values (
                '{$row["pt"]}',
                '{$row["name"]}',
                '{$row["url"]}',
                '{$row["user"]}',
                '{$row["pass"]}',
                '{$row["token"]}',
                '{$row["ip"]}',
                '{$row["cookie"]}',
                NOW())"
            );
            exit('{"code":1,"msg":"操作成功"}');
        } else {
            $update_fields = [
                "`pt`='{$row["pt"]}'",
                "`name`='{$row["name"]}'",
                "`url`='{$row["url"]}'",
                "`user`='{$row["user"]}'",
                "`ip`='{$row["ip"]}'",
                "`cookie`='{$row["cookie"]}'",
                "`endtime`=NOW()"
            ];
            if (!empty($row["pass"])) {
                $update_fields[] = "`pass`='{$row["pass"]}'";
            }
            if (!empty($row["token"])) {
                $update_fields[] = "`token`='{$row["token"]}'";
            }
            $set_clause = implode(", ", $update_fields);
            
            $DB->query(
                "UPDATE `qingka_wangke_huoyuan` 
                SET {$set_clause}
                WHERE hid='{$row["hid"]}'"
            );
            exit('{"code":1,"msg":"操作成功"}');
        }
    } else {
        exit('{"code":-2,"msg":"无权限"}');
    }
    break;
    case "tk":
        $sex = daddslashes($_POST["sex"]);
        if ($userrow["uid"] == 1) {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $order = $DB->get_row(
                    "select * from qingka_wangke_order where oid='{$oid}' "
                );
                $user = $DB->get_row(
                    "select * from qingka_wangke_user where uid='{$order["uid"]}' "
                );
                $DB->query(
                    "update qingka_wangke_user set money=money+'{$order["fees"]}' where uid='{$user["uid"]}'"
                );
                $DB->query(
                    "update qingka_wangke_order set status='已退款',dockstatus='4' where oid='{$oid}'"
                );
                wlog(
                    $user["uid"],
                    "订单退款",
                    "订单ID：{$order["oid"]} 订单信息：{$order["user"]} {$order["pass"]} {$order["kcname"]}被管理员退款",
                    "+{$order["fees"]}"
                );
            }
            exit('{"code":1,"msg":"选择的订单已批量退款！可在日志中查看！"}');
        } else {
            exit('{"code":-1,"msg":"无权限"}');
        }
        break;
        $config_row = $DB->get_row("SELECT khyue FROM qingka_wangke_config LIMIT 1");
$khyue = $config_row['khyue'];
    case 'khcz':
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $money = trim(strip_tags(daddslashes($_POST['money'])));
    $khyue_row = $DB->get_row("SELECT k FROM qingka_wangke_config WHERE v='khyue' LIMIT 1");
    $khyue = (float)$khyue_row['k']; 
    if ($userrow['money'] < $khyue) {
        exit('{"code":-1,"msg":"您的账户余额必须大于'.$khyue.'元才能进行跨户充值"}');
    }
    if (!preg_match('/^[0-9.]+$/', $money)) {
        exit('{"code":-1,"msg":"充值金额不合法"}');
    }
    if ($money < 10 && $userrow['uid']!= 1) {
        exit('{"code":-1,"msg":"最低充值10元"}');
    }

    $row = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE uid='$uid' LIMIT 1");
    if ($userrow['uid'] == $uid) {
        exit('{"code":-1,"msg":"自己不能给自己充值哦"}');
    }

    $kochu = round($money * ($userrow['addprice'] / $row['addprice']), 2);
    if ($userrow['money'] < $kochu) {
        exit('{"code":-1,"msg":"您当前余额不足,无法充值"}');
    }
    if ($kochu == 0) {
        exit('{"code":-1,"msg":"你在干嘛呢？"}');
    }

    $wdkf = round($userrow['money'] - $kochu, 2);
    $xjkf = round($row['money'] + $money, 2);
    if (isset($_GET['get_confirm'])) {
        $confirmMsg = "您即将给UID为{$row['uid']}的用户充值{$money}元，扣除您{$kochu}余额，请问是否继续？";
        exit('{"code":1,"msg":"","confirmMsg":"'. $confirmMsg. '"}');
    }
    $DB->query("UPDATE qingka_wangke_user SET money='$wdkf' WHERE uid='{$userrow['uid']}' ");
    $DB->query("UPDATE qingka_wangke_user SET money='$xjkf', zcz=zcz+'$money' WHERE uid='$uid' ");
    wlog($userrow['uid'], "跨户充值", "成功给账号为[{$row['user']}]的靓仔充值{$money}元,扣除{$kochu}元", -$kochu);
    wlog($row['uid'], "跨户充值", "{$userrow['name']}成功给你充值{$money}元", +$money);
    $msg = "跨户充值成功，成功给{$row['user']}用户充值{$money}元，实际扣费{$kochu}元";
    exit('{"code":1,"msg":"'. $msg. '","confirmMsg":""}');
break;
    case "sc":
        $sex = daddslashes($_POST["sex"]);
        if ($userrow["uid"] == 1) {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $order = $DB->get_row(
                    "select * from qingka_wangke_order where oid='{$oid}' "
                );
                $user = $DB->get_row(
                    "select * from qingka_wangke_user where uid='{$order["uid"]}' "
                );
                $DB->query(
                    "delete from qingka_wangke_order where oid='{$oid}'"
                );
                //wlog($user['uid'], "删除订单信息", "订单ID：{$order['oid']} 订单信息：{$order['user']} {$order['pass']} {$order['kcname']}被管理员删除", "+0");
            }
            exit('{"code":1,"msg":"选择的订单已批量删除！"}');
        } else {
            exit('{"code":-1,"msg":"别乱搞，单子丢了钱你赔吗？"}');
        }
        break;
    case "qgmj":
        $zdqgmj = 5 / 30; //成本/天数   倍数
        $qgmj = trim(strip_tags(daddslashes($_POST["qgmj"])));
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        if ($qgmj < $zdqgmj) {
            jsonReturn(-1, "密价倍数最低只能设置$zdqgmj");
        }
        if (!is_numeric($qgmj)) {
            jsonReturn(-1, "请正确输入价格，必须为数字");
        }
        $a = $DB->get_row("select * from qingka_wangke_user where uid='$uid' ");
        if ($userrow["uid"] == "1") {
            $DB->query(
                "update qingka_wangke_user set qgmj='{$qgmj}' where uid='$uid' "
            );
            wlog(
                $userrow["uid"],
                "设置强国密价",
                "给下级设置强国密价{$qgmj}倍数成功",
                "0"
            );
            jsonReturn(1, "设置成功");
        } else {
            jsonReturn(-1, "无权限");
        }
        break;
    case "kbs":
        $sex = daddslashes($_POST["sex"]);
        if ($userrow["uid"] != "") {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $order = $DB->get_row(
                    "select * from qingka_wangke_order where oid='{$oid}' "
                );
                $user = $DB->get_row(
                    "select * from qingka_wangke_user where uid='{$order["uid"]}' "
                );
                //$DB->query("update qingka_wangke_user set money=money+'{$order['fees']}' where uid='{$user['uid']}'");
                if ($order["hid"] == 11 || $order["hid"] == 12) {
                    $DB->query(
                        "update qingka_wangke_order set dockstatus='0',status='待更新',`process`='',`remarks`='',`bsnum`=bsnum+1 where oid='{$oid}' "
                    );
                } else {
                    $DB->query(
                        "update qingka_wangke_order set status='待处理',`process`='',`remarks`='',`bsnum`=bsnum+1 where oid='{$oid}'"
                    );
                }
                //wlog($user['uid'], "删除订单信息", "订单ID：{$order['oid']} 订单信息：{$order['user']} {$order['pass']} {$order['kcname']}被管理员删除", "+0");
            }
            exit('{"code":1,"msg":"选择的订单已批量重新上号！"}');
        } else {
            exit('{"code":-1,"msg":"无权限"}');
        }
        break;
    case "adduser":
        if ($conf["user_htkh"] == "0") {
            jsonReturn(-1, "暂停开户，具体开放时间等通知");
        }
        parse_str(daddslashes($_POST["data"]), $row); //将字符串解析成多个变量
        $type = daddslashes($_POST["type"]);
        $row["user"] = trim($row["user"]);
        $row["pass"] = trim($row["pass"]);
        if (
            $row["name"] == "" ||
            $row["user"] == "" ||
            $row["pass"] == "" ||
            $row["addprice"] == ""
        ) {
            exit('{"code":-2,"msg":"所有项目不能为空"}');
        }
        if (!preg_match("/[1-9]([0-9]{4,10})/", $row["user"])) {
            exit('{"code":-1,"msg":"账号必须为QQ号"}');
        }
        if (
            $DB->get_row(
                "select * from qingka_wangke_user where user='{$row["user"]}' "
            )
        ) {
            exit('{"code":-1,"msg":"该账号已存在"}');
        }
        if (
            $DB->get_row(
                "select * from qingka_wangke_user where name='{$row["name"]}' "
            )
        ) {
            exit('{"code":-1,"msg":"该昵称已存在"}');
        }

        if ($row["addprice"] < $userrow["addprice"]) {
            exit('{"code":-1,"msg":"费率不能比自己低哦"}');
        }

        $cz = 0;
        $h = $DB->query("select * from qingka_wangke_dengji");
        while ($row1 = $DB->fetch($h)) {
            if ($row["addprice"] == $row1["rate"]) {
                if ($row1["addkf"] == 1) {
                    $cz = $row1["money"];
                }
            }
        }
        $kochu = round($cz * ($userrow["addprice"] / $row["addprice"]), 2); //充值
        $kochu2 = $kochu + $conf["user_ktmoney"];
        if ($type != 1) {
            jsonReturn(
                1,
                "开通扣{$conf["user_ktmoney"]}元开户费，并自动给下级充值{$cz}元，将扣除{$kochu}余额"
            );
        }
        if ($userrow["money"] >= $kochu2) {
            $DB->query(
                "insert into qingka_wangke_user (uuid,user,pass,name,addprice,addtime) values ('{$userrow["uid"]}','{$row["user"]}','{$row["pass"]}','{$row["name"]}','{$row["addprice"]}','$date') "
            );
            $DB->query(
                "update qingka_wangke_user set `money`=`money`-'{$conf["user_ktmoney"]}' where uid='{$userrow["uid"]}' "
            );
            wlog(
                $userrow["uid"],
                "添加商户",
                "添加商户{$row["user"]}成功!扣费{$conf["user_ktmoney"]}元!",
                "-{$conf["user_ktmoney"]}"
            );
            if ($cz != 0) {
                $DB->query(
                    "update qingka_wangke_user set money='$cz',zcz=zcz+'$cz' where user='{$row["user"]}' "
                );
                $DB->query(
                    "update qingka_wangke_user set `money`=`money`-'$kochu' where uid='{$userrow["uid"]}' "
                );
                wlog(
                    $userrow["uid"],
                    "代理充值",
                    "成功给账号为[{$row["user"]}]的靓仔充值{$cz}元,扣除{$kochu}元",
                    -$kochu
                );
                $is = $DB->get_row(
                    "select uid from qingka_wangke_user where user='{$row["user"]}' limit 1"
                );
                wlog(
                    $is["uid"],
                    "上级充值",
                    "你上面的靓仔[{$userrow["name"]}]成功给你充值{$cz}元",
                    +$cz
                );
            }
            exit('{"code":1,"msg":"添加成功"}');
        } else {
            jsonReturn(
                -1,
                "余额不足开户，开户需扣除开户费{$conf["user_ktmoney"]}元，及余额{$kochu}元"
            );
        }

        break;
    case "userlist":
        $type = trim(strip_tags(daddslashes($_POST["type"])));
        $qq = trim(strip_tags(daddslashes($_POST["qq"])));
        $page = trim(daddslashes($_POST["page"]));
        $pagesize = 10;
        $pageu = ($page - 1) * $pagesize; //当前界面

        if ($userrow["uid"] == "1") {
            if ($qq != "" and $type == 1) {
                $sql = "where uid='" . $qq . "'";
            } elseif ($qq != "" and $type == 2) {
                $sql = "where user='" . $qq . "'";
            } elseif ($qq != "" and $type == 3) {
                $sql = "where yqm='" . $qq . "'";
            } elseif ($qq != "" and $type == 4) {
                $sql = "where name='" . $qq . "'";
            } elseif ($qq != "" and $type == 5) {
                $sql = "where addprice='" . $qq . "'";
            } elseif ($qq != "" and $type == 6) {
                $sql = "where money='" . $qq . "'";
            } elseif ($qq != "" and $type == 7) {
                $sql = "where endtime>'" . $qq . "'";
            }
        } else {
            if ($qq != "" and $type == 1) {
                $sql = "where uuid='{$userrow["uid"]}' and uid='" . $qq . "'";
            } elseif ($qq != "" and $type == 2) {
                $sql = "where uuid='{$userrow["uid"]}' and user='" . $qq . "'";
            } elseif ($qq != "" and $type == 3) {
                $sql = "where uuid='{$userrow["uid"]}' and yqm='" . $qq . "'";
            } elseif ($qq != "" and $type == 4) {
                $sql = "where uuid='{$userrow["uid"]}' and name='" . $qq . "'";
            } elseif ($qq != "" and $type == 5) {
                $sql =
                    "where uuid='{$userrow["uid"]}' and addprice='" . $qq . "'";
            } elseif ($qq != "" and $type == 6) {
                $sql = "where uuid='{$userrow["uid"]}' and money='" . $qq . "'";
            } elseif ($qq != "" and $type == 7) {
                $sql =
                    "where endtime>'" . $qq . "' and uuid='{$userrow["uid"]}'";
            } else {
                $sql = "where uuid='{$userrow["uid"]}'";
            }
        }

        $a = $DB->query(
            "select * from qingka_wangke_user {$sql} order by uid desc limit $pageu,$pagesize "
        );
        $count1 = $DB->count("select count(*) from qingka_wangke_user {$sql}");
        while ($row = $DB->fetch($a)) {
            $zcz = 0;
            $row["pass"] = "这还能让你知道？";
            if ($row["key"] != "0") {
                $row["key"] = "1";
            }

            $dd = $DB->count(
                "select count(oid) from qingka_wangke_order where uid='{$row["uid"]}' "
            );
            //$zcz=$DB->count("select sum(money) as money from qingka_wangke_log where type='上级充值' and uid='{$row['uid']}' ");
            $row["dd"] = $dd;
            //$row['zcz']=round($zcz,2);
            $data[] = $row;
        }
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
        ];
        exit(json_encode($data));
        break;
    case "paylist":
        $page = trim(daddslashes($_GET["page"]));
        $limit = trim(daddslashes($_GET["limit"]));
        $pageu = ($page - 1) * $limit; //当前界面
        $a = $DB->query(
            "select * from qingka_wangke_pay order by oid desc limit $pageu,$limit"
        );
        $count = $DB->count("select count(*) from qingka_wangke_pay");
        while ($row = $DB->fetch($a)) {
            if ($row["status"] == 0) {
                $row["status"] = "未支付";
            } elseif ($row["status"] == 1) {
                $row["status"] = "已支付";
            }
            if ($row["type"] == "alipay") {
                $row["type"] = "支付宝";
            } elseif ($row["type"] = "vxpay") {
                $row["type"] = "微信";
            } elseif ($row["type"] = "qqpay") {
                $row["type"] = "QQ";
            }
            if ($row["endtime"] == "") {
                $row["endtime"] = "支付未完成";
            }
            $data[] = [
                "oid" => $row["oid"],
                "out_trade_no" => $row["out_trade_no"],
                "addtime" => $row["addtime"],
                "type" => $row["type"],
                "uid" => $row["uid"],
                "endtime" => $row["endtime"],
                "name" => $row["name"],
                "money" => $row["money"],
                "status" => $row["status"],
                "ip" => $row["ip"],
            ];
        }

        //array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $data = ["code" => 1, "data" => $data, "count" => $count];
        exit(json_encode($data));
        break;
    case "kcidlist":
        $page = trim(daddslashes($_GET["page"]));
        $limit = trim(daddslashes($_GET["limit"]));
        $pageu = ($page - 1) * $limit; //当前界面
        if ($userrow["uid"] == 1) {
            $a = $DB->query(
                "select * from qingka_wangke_order order by oid desc limit $pageu,$limit"
            );
            $count = $DB->count("select count(*) from qingka_wangke_order");
        } else {
            $a = $DB->query(
                "select * from qingka_wangke_order  where uid='{$userrow["uid"]}' order by oid desc limit $pageu,$limit"
            );
            $count = $DB->count(
                "select count(*) from qingka_wangke_order  where uid='{$userrow["uid"]}'"
            );
        }
        while ($row = $DB->fetch($a)) {
            $data[] = [
                "oid" => $row["oid"],
                "ptname" => $row["ptname"],
                "user" => $row["user"],
                "kcname" => $row["kcname"],
                "kcid" => $row["kcid"],
                "addtime" => $row["addtime"],
                "status" => $row["status"],
            ];
        }

        //array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $data = ["code" => 1, "data" => $data, "count" => $count];
        exit(json_encode($data));
        break;

    case "log":
        $page = trim(daddslashes($_GET["page"]));
        $limit = trim(daddslashes($_GET["limit"]));
        $pageu = ($page - 1) * $limit; //当前界面
        if ($userrow["uid"] == 1) {
            $a = $DB->query(
                "select * from qingka_wangke_log order by id desc limit $pageu,$limit"
            );
            $count = $DB->count("select count(*) from qingka_wangke_log");
        } else {
            $a = $DB->query(
                "select * from qingka_wangke_log where uid='{$userrow["uid"]}' order by id desc limit $pageu,$limit"
            );
            $count = $DB->count(
                "select count(*) from qingka_wangke_log where uid='{$userrow["uid"]}'"
            );
        }

        while ($row = $DB->fetch($a)) {
            $data[] = [
                "id" => $row["id"],
                "uid" => $row["uid"],
                "type" => $row["type"],
                "money" => $row["money"],
                "smoney" => $row["smoney"],
                "text" => $row["text"],
                "addtime" => $row["addtime"],
                "ip" => $row["ip"],
            ];
        }

        //array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $data = ["code" => 1, "data" => $data, "count" => $count];
        exit(json_encode($data));
        break;
    case "adddjlist":
        $a = $DB->query(
            "select * from qingka_wangke_dengji where status=1 and rate>='{$userrow["addprice"]}' order by sort desc"
        );
        while ($row = $DB->fetch($a)) {
            $data[] = [
                "sort" => $row["sort"],
                "name" => $row["name"],
                "rate" => $row["rate"],
            ];
        }
        foreach ($data as $key => $row) {
            $sort[$key] = $row["sort"];
            $name[$key] = $row["name"];
            $rate[$key] = $row["rate"];
        }
        array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $data = ["code" => 1, "data" => $data];
        exit(json_encode($data));
        break;
    case "user_notice":
        $notice = trim(strip_tags(daddslashes($_POST["notice"])));
        if (
            $DB->query(
                "update qingka_wangke_user set notice='{$notice}' where uid='{$userrow["uid"]}' "
            )
        ) {
            wlog($userrow["uid"], "设置公告", "设置公告: {$notice}", 0);
            jsonReturn(1, "设置成功");
        } else {
            jsonReturn(-1, "未知异常");
        }
        break;
    case 'userjk':
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $money = trim(strip_tags(daddslashes($_POST['money'])));
    if (!preg_match('/^[0-9.]+$/', $money)) exit('{"code":-1,"msg":"充值金额不合法"}');
    
    // 充值扣费计算：扣除费用=充值金额*(我的总费率/代理费率-等级差*2%)
    if ($money < 1 && $userrow['uid'] != 1) {
        exit('{"code":-1,"msg":"最低充值1积分"}');
    }
    
    $row = $DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
    if ($row['uuid'] != $userrow['uid'] && $userrow['uid'] != 1) {
        exit('{"code":-1,"msg":"该用户不是你的下级,无法充值"}');
    }
    
    if ($userrow['uid'] == $uid) {
        exit('{"code":-1,"msg":"自己不能给自己充值哦"}');
    }
    
    $kochu = round($money * ($userrow['addprice'] / $row['addprice']), 2); // 充值
    
    if ($userrow['money'] < $kochu) {
        exit('{"code":-1,"msg":"您当前余额不足,无法充值"}');
    }
    
    if ($kochu == 0) {
        exit('{"code":-1,"msg":"你在干你妈臭逼呢？"}');
    }
    
    $wdkf = round($userrow['money'] - $kochu, 2);
    $xjkf = round($row['money'] + $money, 2);
    
    $DB->query("update qingka_wangke_user set money='$wdkf' where uid='{$userrow['uid']}' "); // 我的扣费
    $DB->query("update qingka_wangke_user set money='$xjkf', zcz=zcz+'$money' where uid='$uid' "); // 下级增加
    
    wlog($userrow['uid'], "代理充值", "成功给账号为[{$row['user']}]的靓仔充值{$money}积分,扣除{$kochu}积分", -$kochu);
    wlog($row['uid'], "上级充值", "{$userrow['name']}成功给你充值{$money}积分", +$money);
    
 
    $user_info = $DB->get_row("SELECT czcgkg, tuisongtoken FROM qingka_wangke_user WHERE uid = '{$uid}'");
    if ($user_info && $user_info['czcgkg'] == "on") {

        $message = "您已成功充值{$money}积分，当前余额为{$xjkf}积分。";
        
        // 构造请求数据
        $data = [
            'content' => $message,
            'summary' => '充值成功通知', // 消息摘要
            'contentType' => 1, // 文本格式
            'spt' => $user_info['tuisongtoken'], 
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

    exit('{"code":1,"msg":"充值'.$money.'积分成功,实际扣费'.$kochu.'积分"}');
    
break;
    case 'userkc1':
    if ($userrow['uid'] != 1) {
        exit('{"code":-1,"msg":"只有管理员账户才能进行扣除余额操作"}');
    }
    $uid = trim(strip_tags(addslashes($_POST['uid'])));
    $money = trim(strip_tags(addslashes($_POST['money'])));
    if (!preg_match('/^[0-9.]+$/', $money)) {
        exit('{"code":-1,"msg":"金额不合法"}');
    }
    $row = $DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
    if ($userrow['uid'] == $uid) {
        exit('{"code":-1,"msg":"自己不能给自己扣款哦"}');
    }
    if ($money == 0) {
        exit('{"code":-1,"msg":"扣除金额不能为 0"}');
    }
    if ($row['money'] < $money) {
        exit('{"code":-1,"msg":"该代理当前余额不足,无法扣除"}');
    }
    $xjkf = round($row['money'] - $money, 2);
    $DB->query("update qingka_wangke_user set money='$xjkf',zcz=zcz-'$money' where uid='$uid' "); 
    wlog($userrow['uid'], "管理员扣除代理余额", "成功从账号为[{$row['user']}]的代理扣除{$money}元", 0);
    wlog($row['uid'], "被管理员扣除余额", "管理员【{$userrow['name']}】成功从你账户扣除{$money}元，具体原因请提交工单处理！", -$money);

    // 返回成功信息
    exit('{"code":1,"msg":"成功从代理扣除'.$money.'元"}');
    break;
    case "usergj":
        parse_str(daddslashes($_POST["data"]), $row);
        $uid = trim(strip_tags(daddslashes(trim($row["uid"]))));
        $addprice = trim(strip_tags(daddslashes($row["addprice"])));
        $type = trim(strip_tags(daddslashes($_POST["type"])));
        if (!preg_match('/^[0-9.]+$/', $addprice)) {
            exit('{"code":-1,"msg":"费率不合法"}');
        }

        $row = $DB->get_row(
            "select * from qingka_wangke_user where uid='$uid' limit 1"
        );
        if ($row["uuid"] != $userrow["uid"] && $userrow["uid"] != 1) {
            exit('{"code":-1,"msg":"该用户你的不是你的下级,无法修改价格"}');
        }
        if ($userrow["uid"] == $uid) {
            exit('{"code":-1,"msg":"自己不能给自己改价哦"}');
        }
        if ($userrow["addprice"] > $addprice) {
            exit('{"code":-1,"msg":"你下级的费率不能低于你哦"}');
        }

        if ($addprice == $row["addprice"]) {
            jsonReturn(-1, "该商户已经是{$addprice}费率了，你还修改啥");
        }
        if ($addprice > $row["addprice"] && $userrow["uid"] != 1) {
            jsonReturn(-1, "下调费率，请联系管理员");
        }
        if ($addprice < "0.2" && $userrow["uid"] != 1) {
            exit('{"code":-1,"msg":"你在干什么？"}');
        }

        //降价扣费计算：下级余额 /当前费率 *修改费率 ；
        $money = round(($row["money"] / $row["addprice"]) * $addprice, 2); //涨降价余额变动,,自动调费
        $money1 = $money - $row["money"]; //日志显示变动余额

        // 		if($addprice>=0.2 && $addprice<0.3){
        //             $cz=2000;
        // 		}elseif($addprice>=0.3 && $addprice<0.4){
        // 			$cz=1000;
        // 		}elseif($addprice>=0.4 && $addprice<0.5){
        // 			$cz=300;
        // 		}elseif($addprice>=0.5 && $addprice<0.6){
        // 			$cz=100;
        // 		}else{
        // 			$cz=0;
        // 		}
        $cz = 0;
        $h = $DB->query("select * from qingka_wangke_dengji");
        while ($row1 = $DB->fetch($h)) {
            if ($addprice == $row1["rate"]) {
                if ($row1["gjkf"] == 1) {
                    $cz = $row1["money"];
                }
            }
        }
        $kochu = round($cz * ($userrow["addprice"] / $addprice), 2); //充值
        $kochu2 = $kochu + $money + 3;
        if ($type != 1) {
            jsonReturn(
                1,
                "改价手续费3元，并自动给下级[UID:{$uid}]充值{$cz}元，将扣除{$kochu}余额"
            );
        }

        if ($userrow["money"] < $kochu2) {
            jsonReturn(-1, "余额不足,改价需扣3元手续费,及余额{$kochu}元");
        } else {
            $DB->query(
                "update qingka_wangke_user set money=money-3 where uid='{$userrow["uid"]}' "
            );
            $DB->query(
                "update qingka_wangke_user set money='$money',addprice='$addprice' where uid='$uid' "
            ); //调费
            wlog(
                $userrow["uid"],
                "修改费率",
                "修改代理{$row["name"]},费率：{$addprice},扣除手续费3元",
                "-3"
            );
            wlog(
                $uid,
                "修改费率",
                "{$userrow["name"]}修改你的费率为：{$addprice},系统根据比例自动调整价格",
                $money1
            );
            if ($cz != 0) {
                $DB->query(
                    "update qingka_wangke_user set money=money-'{$kochu}' where uid='{$userrow["uid"]}' "
                ); //我的扣费
                $DB->query(
                    "update qingka_wangke_user set money=money+'{$cz}',zcz=zcz+'$cz' where uid='$uid' "
                ); //下级增加
                wlog(
                    $userrow["uid"],
                    "代理充值",
                    "成功给账号为[{$row["user"]}]的靓仔充值{$cz}元,扣除{$kochu}元",
                    -$kochu
                );
                wlog(
                    $uid,
                    "上级充值",
                    "{$userrow["name"]}成功给你充值{$cz}元",
                    +$cz
                );
            }
            exit('{"code":1,"msg":"改价成功"}');
        }
        break;
    case 'user_czmm':
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    if($userrow['uid']!=1){
	       jsonReturn(-1,"只有管理员才能给用户重置密码");
	    }
    if ($userrow['uid'] == $uid) {
        jsonReturn(-1, "自己不能给自己重置哦");
    }
    $row = $DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
    if ($row['uuid'] != $userrow['uid'] && $userrow['uid'] != 1) {
        exit('{"code":-1,"msg":"该用户不是你的下级,无法修改价格"}');
    } else {
        $DB->query("update qingka_wangke_user set pass='1234567' where uid='{$uid}' ");
        wlog($row['uid'], "重置密码", "成功重置UID为{$uid}的密码为1234567", 0);

        // 获取该用户的 tuisongtoken
        $tuisongtoken = $row['tuisongtoken']; // 从$row中获取tuisongtoken
    $message = <<<EOD
                    <div style='
                        border: 1px solid #e0e0e0;
                        border-radius: 8px;
                        padding: 16px;
                        background-color: #f9f9f9;
                        font-family: Arial, sans-serif;
                        max-width: 400px;
                        margin: 0 auto;
                    '>
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'> 🙈 重置密码通知 🙈</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>您的密码已被重置为: </strong>
                            <span style='color: #555;'> 1234567 </span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            请尽快登录并修改密码以确保账户安全！
                        </p>
                    </div>
EOD;

        $data = [
            'content' => $message,
            'summary' => '密码重置通知',
            'contentType' => 2,
            'spt' => $tuisongtoken, // 使用获取的 tuisongtoken
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

        jsonReturn(1, "成功重置密码为1234567");
    }
    break;
    case "user_ban":
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        $active = trim(strip_tags(daddslashes($_POST["active"])));
        if ($userrow["uid"] != 1) {
            jsonReturn(-1, "无权限");
        }
        if ($uid == 1) {
            jsonReturn(-1, "你封禁你自己干鸡毛"); // 返回错误信息
        }
        if ($active == 1) {
            $a = 0;
            $b = "封禁商户";
        } else {
            $a = 1;
            $b = "解封商户";
        }
        $DB->query(
            "update qingka_wangke_user set active='$a' where uid='{$uid}' "
        );
        wlog($userrow["uid"], $b, "{$b}[UID {$uid}]成功", 0);
        jsonReturn(1, "操作成功");

        break;
    case "user_kh":
        $uid = trim(strip_tags(daddslashes($_POST["uid"])));
        $kuahu = trim(strip_tags(daddslashes($_POST["kuahu"])));
        if ($userrow["uid"] != 1) {
            jsonReturn(-1, "无权限");
        }
        if ($kuahu == 1) {
            $a = 0;
            $b = "关闭跨户";
        } else {
            $a = 1;
            $b = "开启跨户";
        }
        $DB->query(
            "update qingka_wangke_user set kuahu='$a' where uid='{$uid}' "
        );
        wlog($userrow["uid"], $b, "{$b}[UID {$uid}]成功", 0);
        jsonReturn(1, "操作成功");

        break;
    case "loglist":
        $page = trim(strip_tags(daddslashes(trim($_POST["page"]))));
        $type = trim(strip_tags(daddslashes(trim($_POST["type"]))));
        $types = trim(strip_tags(daddslashes(trim($_POST["types"]))));
        $qq = trim(strip_tags(daddslashes(trim($_POST["qq"]))));
        $pagesize = 20;
        $pageu = ($page - 1) * $pagesize; //当前界面
        if ($userrow["uid"] != "1") {
            $sql1 = "where uid='{$userrow["uid"]}'";
        } else {
            $sql1 = "where 1=1";
        }
        if ($type != "") {
            $sql2 = " and type='$type'";
        }
        if ($types != "") {
            if ($types == "1") {
                $sql3 = " and uid='$qq'";
            } elseif ($types == "2") {
                $sql3 = " and text like '%" . $qq . "%' ";
            } elseif ($types == "3") {
                $sql3 = " and money like '%" . $qq . "%' ";
            } elseif ($types == "4") {
                $sql3 = " and addtime='$qq'";
            }
        }
        $sql = $sql1 . $sql2 . $sql3;
        $a = $DB->query(
            "select * from qingka_wangke_log {$sql} order by id desc limit  $pageu,$pagesize "
        );
        $count1 = $DB->count("select count(*) from qingka_wangke_log {$sql} ");
        while ($row = $DB->fetch($a)) {
            $data[] = $row;
        }
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
        ];
        exit(json_encode($data));
        break;
    case "getclassfl":
        $fenlei = trim(strip_tags(daddslashes($_POST["id"])));
        if ($fenlei == 0) {
            $a = $DB->query(
                "select * from qingka_wangke_class where status=1 order by sort desc"
            );
        } else {
            $a = $DB->query(
                "select * from qingka_wangke_class where status=1 and fenlei='$fenlei' order by sort desc"
            );
        }

        while ($row = $DB->fetch($a)) {
            if ($row["docking"] == "nana") {
                $miaoshua = 1;
            } else {
                $miaoshua = 0;
            }

            if ($row["yunsuan"] == "*") {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            } elseif ($row["yunsuan"] == "+") {
                $price = round($row["price"] + $userrow["addprice"], 2);
                $price1 = $price;
            } else {
                $price = round($row["price"] * $userrow["addprice"], 2);
                $price1 = $price;
            }
            //密价
            $mijia = $DB->get_row(
                "select * from qingka_wangke_mijia where uid='{$userrow["uid"]}' and cid='{$row["cid"]}' "
            );
            if ($mijia) {
                if ($mijia["mode"] == 0) {
                    $price = round($price - $mijia["price"], 2);
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 1) {
                    $price = round(
                        ($row["price"] - $mijia["price"]) *
                            $userrow["addprice"],
                        2
                    );
                    if ($price <= 0) {
                        $price = 0;
                    }
                } elseif ($mijia["mode"] == 2) {
                    $price = $mijia["price"];
                    if ($price <= 0) {
                        $price = 0;
                    }
                }
                $row["name"] = "【密价】{$row["name"]}";
            }
            if ($price >= $price1) {
                //密价价格大于原价，恢复原价
                $price = $price1;
            }

            //全站一个价
            if ($row["suo"] != 0) {
                $price = $row["suo"];
            }
            $data[] = [
                "sort" => $row["sort"],
                "cid" => $row["cid"],
                "name" => $row["name"],
                "noun" => $row["noun"],
                "price" => $price,
                "content" => $row["content"],
                "status" => $row["status"],
                "miaoshua" => $miaoshua,
            ];
        }
        foreach ($data as $key => $row) {
            $sort[$key] = $row["sort"];
            $cid[$key] = $row["cid"];
            $name[$key] = $row["name"];
            $noun[$key] = $row["noun"];
            $price[$key] = $row["price"];
            $info[$key] = $row["info"];
            $content[$key] = $row["content"];
            $status[$key] = $row["status"];
            $miaoshua[$key] = $row["miaoshua"];
        }
        array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
        $data = ["code" => 1, "data" => $data];
        exit(json_encode($data));

        break;
    case "djlist":
        $page = trim(strip_tags(daddslashes($_POST["page"])));
        $pagesize = 500;
        $pageu = ($page - 1) * $pagesize; //当前界面
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $a = $DB->query("select * from qingka_wangke_dengji");
        $count1 = $DB->count("select count(*) from qingka_wangke_dengji");
        while ($row = $DB->fetch($a)) {
            $data[] = [
                "id" => $row["id"],
                "sort" => $row["sort"],
                "name" => $row["name"],
                "rate" => $row["rate"],
                "money" => $row["money"],
                "addkf" => $row["addkf"],
                "gjkf" => $row["gjkf"],
                "status" => $row["status"],
                "time" => $row["time"],
            ];
        }
        foreach ($data as $key => $row) {
            $id[$key] = $row["id"];
            $sort[$key] = $row["sort"];
            $name[$key] = $row["name"];
            $rate[$key] = $row["rate"];
            $money[$key] = $row["money"];
            $addkf[$key] = $row["addkf"];
            $gjkf[$key] = $row["gjkf"];
            $status[$key] = $row["status"];
            $time[$key] = $row["time"];
        }
        array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
        ];
        exit(json_encode($data));
        break;
    case "dj":
        $data = daddslashes($_POST["data"]);
        $active = trim(strip_tags(daddslashes(trim($_POST["active"]))));
        $id = trim(strip_tags(daddslashes(trim($data["id"]))));
        $sort = trim(strip_tags(daddslashes(trim($data["sort"]))));
        $name = trim(strip_tags(daddslashes(trim($data["name"]))));
        $rate = trim(strip_tags(daddslashes(trim($data["rate"]))));
        $money = trim(strip_tags(daddslashes(trim($data["money"]))));
        $status = trim(strip_tags(daddslashes(trim($data["status"]))));
        $addkf = trim(strip_tags(daddslashes(trim($data["addkf"]))));
        $gjkf = trim(strip_tags(daddslashes(trim($data["gjkf"]))));
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚！");
        }
        if ($active == "1") {
            //添加
            $DB->query(
                "insert into qingka_wangke_dengji (sort,name,rate,money,addkf,gjkf,status,time) values ('$sort','$name','$rate','$money','$addkf','$gjkf','1',NOW())"
            );
            jsonReturn(1, "添加成功");
        } elseif ($active == "2") {
            //修改
            $DB->query(
                "update qingka_wangke_dengji set `sort`='$sort',`name`='$name',`rate`='$rate',`money`='$money',`addkf`='$addkf',`gjkf`='$gjkf',`status`='$status' where id='$id'"
            );
            jsonReturn(1, "修改成功");
        } else {
            jsonReturn(-1, "不知道你在干什么");
        }
        break;
    case "dj_del":
        $id = daddslashes($_POST["id"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_dengji where id='$id' ");
        jsonReturn(1, "删除成功");
        break;
    case "hy_del":
        $hid = daddslashes($_POST["hid"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_huoyuan where hid='$hid' ");
        jsonReturn(1, "删除成功");
        break;
    case "fllist":
        $page = trim(strip_tags(daddslashes($_POST["page"])));
        $pagesize = 500;
        $pageu = ($page - 1) * $pagesize; //当前界面
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $a = $DB->query("select * from qingka_wangke_fenlei");
        $count1 = $DB->count("select count(*) from qingka_wangke_fenlei");
        while ($row = $DB->fetch($a)) {
            $data[] = [
                "id" => $row["id"],
                "sort" => $row["sort"],
                "name" => $row["name"],
                "rate" => $row["rate"],
                "money" => $row["money"],
                "addkf" => $row["addkf"],
                "gjkf" => $row["gjkf"],
                "status" => $row["status"],
                "time" => $row["time"],
            ];
        }
        foreach ($data as $key => $row) {
            $id[$key] = $row["id"];
            $sort[$key] = $row["sort"];
            $name[$key] = $row["name"];
            $rate[$key] = $row["rate"];
            $money[$key] = $row["money"];
            $addkf[$key] = $row["addkf"];
            $gjkf[$key] = $row["gjkf"];
            $status[$key] = $row["status"];
            $time[$key] = $row["time"];
        }
        array_multisort($sort, SORT_ASC, $rate, SORT_ASC, $data);
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
        ];
        exit(json_encode($data));
        break;
    case "fl":
        $data = daddslashes($_POST["data"]);
        $active = trim(strip_tags(daddslashes(trim($_POST["active"]))));
        $id = trim(strip_tags(daddslashes(trim($data["id"]))));
        $sort = trim(strip_tags(daddslashes(trim($data["sort"]))));
        $name = trim(strip_tags(daddslashes(trim($data["name"]))));
        $status = trim(strip_tags(daddslashes(trim($data["status"]))));
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚！");
        }
        if ($active == "1") {
            //添加
            $DB->query(
                "insert into qingka_wangke_fenlei (sort,name,status,time) values ('$sort','$name','1',NOW())"
            );
            jsonReturn(1, "添加成功");
        } elseif ($active == "2") {
            //修改
            $DB->query(
                "update qingka_wangke_fenlei set `sort`='$sort',`name`='$name',`status`='$status' where id='$id'"
            );
            jsonReturn(1, "修改成功");
        } else {
            jsonReturn(-1, "不知道你在干什么");
        }
        break;
    case "fl_del":
        $id = daddslashes($_POST["id"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_fenlei where id='$id' ");
        jsonReturn(1, "删除成功");
        break;
    case "mijialist":
        $page = trim(strip_tags(daddslashes($_POST["page"])));
        $uid = trim(strip_tags(daddslashes($_POST["type"])));
        $pagesize = 5000;
        $pageu = ($page - 1) * $pagesize; //当前界面
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }

        if ($uid != "") {
            $sql = "where uid='$uid'";
        }

        $a = $DB->query("select * from qingka_wangke_mijia {$sql}");
        $count1 = $DB->count(
            "select count(*) from qingka_wangke_mijia {$sql} "
        );
        while ($row = $DB->fetch($a)) {
            $r = $DB->get_row(
                "select * from qingka_wangke_class where cid='{$row["cid"]}' "
            );
            $row["name"] = $r["name"];
            $data[] = $row;
        }
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = [
            "code" => 1,
            "data" => $data,
            "current_page" => (int) $page,
            "last_page" => $last_page,
            "uid" => $userrow["uid"],
        ];
        exit(json_encode($data));
        break;
    case "mijia":
        $data = daddslashes($_POST["data"]);
        $active = trim(strip_tags(daddslashes(trim($_POST["active"]))));
        $uid = trim(strip_tags(daddslashes(trim($data["uid"]))));
        $mid = trim(strip_tags(daddslashes(trim($data["mid"]))));
        $mode = trim(strip_tags(daddslashes(trim($data["mode"]))));
        $cid = trim(strip_tags(daddslashes(trim($data["cid"]))));
        $price = trim(strip_tags(daddslashes(trim($data["price"]))));
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "不知道你在干什么");
        }
        if ($active == "1") {
            //添加
            $DB->query(
                "insert into qingka_wangke_mijia (uid,cid,mode,price,addtime) values ('$uid','$cid','$mode','$price',NOW())"
            );
            jsonReturn(1, "添加成功");
        } elseif ($active == "2") {
            //修改
            $DB->query(
                "update qingka_wangke_mijia set `price`='$price',`mode`='$mode',`uid`='$uid',`cid`='$cid' where mid='$mid' "
            );
            jsonReturn(1, "修改成功");
        } else {
            jsonReturn(-1, "不知道你在干什么");
        }
        break;
    case "cl_del":
        $id = daddslashes($_POST["id"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_class where cid='$id' ");
        jsonReturn(1, "删除成功");
        break;
    case "mijia_del":
        $mid = daddslashes($_POST["mid"]);
        if ($userrow["uid"] != "1") {
            jsonReturn(-1, "滚");
        }
        $DB->query("delete from qingka_wangke_mijia where mid='$mid' ");
        jsonReturn(1, "删除成功");
        break;
    case "sjqy":
        $uuid = daddslashes($_POST["uid"]);
        $yqm = daddslashes($_POST["yqm"]);
        if ($uuid == "" || $yqm == "") {
            exit('{"code":0,"msg":"所有项目不能为空"}');
        }
        if ($conf["sjqykg"] == 0) {
            exit('{"code":0,"msg":"管理员未打开迁移功能"}');
        } elseif ($conf["sjqykg"] == 1) {
            $row = $DB->get_row(
                "select * from qingka_wangke_user where uid='$uuid' limit 1"
            );
            if ($row) {
                if ($yqm == $row["yqm"]) {
                    $row1 = $DB->get_row(
                        "select * from qingka_wangke_user where uid='{$userrow["uid"]}' limit 1"
                    );
                    if ($row1["uuid"] != $uuid) {
                        if ($row1["uid"] != $uuid) {
                            $ztdate = date("Y-m-d", strtotime("-7 day"));
                            $row11 = $DB->get_row(
                                "select * from qingka_wangke_user where uid='{$userrow["uuid"]}' limit 1"
                            );
                            if ($row11["endtime"] < $zhdl) {
                                $DB->query(
                                    "update qingka_wangke_user set `uuid`='$uuid' where uid='{$userrow["uid"]}' "
                                );
                                if ($DB) {
                                    jsonReturn(
                                        1,
                                        "迁移成功,您已迁移至[UID$uuid]的名下"
                                    );
                                } else {
                                    jsonReturn(-1, "迁移失败,未知错误");
                                }
                            } else {
                                jsonReturn(
                                    -1,
                                    "上级在七天内有登陆记录，禁止转移"
                                );
                            }
                        } else {
                            jsonReturn(-1, "禁止填写自己的UID");
                        }
                    } else {
                        jsonReturn(-1, "该用户已经是你的上级了");
                    }
                } else {
                    jsonReturn(-1, "非该用户邀请码，请重新输入");
                }
            } else {
                jsonReturn(-1, "UID不存在，请重新输入");
            }
        }

        break;
    case "plzt":
        $redis = new Redis();
        $redis->connect("127.0.0.1", "6379");
        $sex = daddslashes($_POST["sex"]);
        $rediscode = $redis->ping();
        if ($rediscode == true) {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $redis->lPush("nmbpltb", $oid);
                $DB->query(
                    "update qingka_wangke_order set status='待更新' where oid='{$oid}' "
                );
            }
            wlog(
                $userrow["uid"],
                "批量同步状态",
                "批量同步状态入队成功，共入队{$i}条",
                0
            );
            jsonReturn(1, "批量同步状态入队成功，共入队{$i}条，请耐心等待同步");
        } else {
            jsonReturn(-1, "入队失败");
        }

        break;
    case "ms":
        $oid = trim(strip_tags(daddslashes($_GET["oid"])));
        $b = $DB->get_row(
            "select cid,dockstatus from qingka_wangke_order where oid='{$oid}' "
        );
        if ($b["dockstatus"] == "99") {
            jsonReturn(1, "我的订单");
        } else {
            $b = msWk($oid);
            if ($b["code"] == 1) {
                $DB->query(
                    "update qingka_wangke_user set money=money-0.01 where uid='{$userrow["uid"]}' limit 1 "
                );
                wlog(
                    $userrow["uid"],
                    "进行中",
                    "订单{$oid}成功提交扣除0.1",
                    -0.1
                );
                jsonReturn(1, $b["msg"]);
            } else {
                jsonReturn(-1, $b["msg"]);
            }
        }
        break;
    case 'xgmm':
    $xgmm = trim(strip_tags(daddslashes($_GET['xgmm'])));
    $oid = $_GET['oid']; 
        if (empty($xgmm)) {
        jsonReturn(-1, "密码不能为空");
    }
        if (strlen($xgmm) < 3) {
        jsonReturn(-1, "密码长度至少为3位");
    }   else {
			$b = xgmm($oid,$xgmm);
			if ($b['code'] == 1) {
              
              $DB->query("UPDATE qingka_wangke_order SET pass = '{$xgmm}' WHERE oid = '{$oid}'");
              $DB->query("update qingka_wangke_user set money=money-0.01 where uid='{$userrow['uid']}' limit 1 ");
				wlog($userrow['uid'], "修改密码", "订单{$oid}修改密码成功扣除0.01", -0.01);
				jsonReturn(1, $b['msg']);
			} else {
				jsonReturn(-1, $b['msg']);
			}
		}
    break;
        case 'fasongyoujian':
    $to = trim(strip_tags(daddslashes($_POST['to'])));
    $title = trim(strip_tags(daddslashes($_POST['title'])));
    $content = trim(strip_tags(daddslashes($_POST['content'])));

    $isAnySuccess = false;

    if ($to == 1) {
        // 查询直属代理用户
        $query = $DB->query("SELECT * FROM `qingka_wangke_user` WHERE `uuid` = 1 AND `uid` != 1");
    } elseif ($to == 2) {
        // 查询全部代理用户
        $query = $DB->query("SELECT * FROM `qingka_wangke_user` WHERE `uid` != 1");
    }

    if ($query) {
        while ($row = $DB->fetch($query)) {
            $email = $row['user'] . "@qq.com";

            $url = $conf['email_url'] . '/email.php';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                'email' => $email,
                'title' => $title,
                'content' => $content
            )));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $responseData = json_decode($response, true);

            if ($responseData && $responseData['code'] == 1) {
                $isAnySuccess = true;
            }

            curl_close($ch);
        }
    }

    if ($isAnySuccess) {
        echo json_encode(array(
            "code" => 1,
            "msg" => "邮件发送成功"
        ));
    } else {
        echo json_encode(array(
            "code" => 0,
            "msg" => "邮件发送失败"
        ));
    }
    break;
    case 'zt':
		$oid = trim(strip_tags(daddslashes($_GET['oid'])));
		$b = $DB->get_row("select hid,cid,dockstatus from qingka_wangke_order where oid='{$oid}' ");
		$DB->query("update qingka_wangke_order set status='已停止',`bsnum`=bsnum+1 where oid='{$oid}' ");
		if ($b['dockstatus'] == '99') {
			jsonReturn(1, "我的订单");
		} else {
			$b = ztWk($oid);
			if ($b['code'] == 1) {
				$DB->query("update qingka_wangke_order set status='已停止',`bsnum`=bsnum+1 where oid='{$oid}' ");
				wlog($userrow['uid'], "暂停", "暂停订单: {$oid}", 0);
				jsonReturn(1, $b['msg']);
			} else {
				jsonReturn(-1, $b['msg']);
			}
		}
		break;
    case "plbs":
        $redis = new Redis();
        $redis->connect("127.0.0.1", "6379");
        $sex = daddslashes($_POST["sex"]);
        $rediscode = $redis->ping();
        if ($rediscode == true) {
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $redis->lPush("plbsoid", $oid);
                $DB->query(
                    "update qingka_wangke_order set status='待重刷' where oid='{$oid}' "
                );
            }
            wlog(
                $userrow["uid"],
                "批量补刷",
                "批量补刷入队成功，共入队{$i}条",
                0
            );
            jsonReturn(1, "批量补刷入队成功，共入队{$i}条，请耐心等待补刷成功");
        } else {
            jsonReturn(-1, "入队失败");
        }
        break;
    case 'tuboshu_route':
        try {
            require_once(__DIR__ . '/includes/TuBoShuClient.php');
            
            // 使用ServiceManager获取实例
            $tuboShuClient = new TuBoShuClient($DB, $userrow);

            // 普通API请求处理
            $rawData = file_get_contents('php://input');
            $postData = json_decode($rawData, true) ?? [];
            
            $method = $postData['method'] ?? 'GET';
            $path = $postData['path'] ?? '';
            $params = $postData['params'] ?? [];
            
            $result = $tuboShuClient->handleRequest($method, $path, $params);
			// 如果是 Blob 请求，则返回二进制数据
			if (isset($postData['isBlob']) && $postData['isBlob'] === true) {
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="download.file"');
				header('Cache-Control: no-cache, no-store, must-revalidate');
				header('Pragma: no-cache');
				header('Expires: 0');
				echo $result;
				exit;
			}

            exit(json_encode($result));
        } catch (Exception $e) {
            exit(json_encode(['success' => false, 'message' => $e->getMessage()]));
        }
	case 'tuboshu_route_formdata':
		require_once(__DIR__ . '/includes/TuBoShuClient.php');
		
		// 使用ServiceManager获取实例
		$tuboShuClient = new TuBoShuClient($DB, $userrow);
		$result = $tuboShuClient->handleFormDataRequest();
		exit(json_encode($result));
    case 'updatekeywords':
        if ($userrow['uid'] == 1) {
        $oldKeyword = $_POST['oldKeyword'];
        $newKeyword = $_POST['newKeyword'];
        $effectScope = $_POST['effectScope'];
        $scopeId = $_POST['scopeId'];

        $where = "1";
        if ($effectScope == 'category') {
            $where = "`fenlei` = '$scopeId'";
        } elseif ($effectScope == 'docking') {
            $where = "`docking` = '$scopeId'";
        }

        $sql = "UPDATE `qingka_wangke_class` SET `name` = REPLACE(`name`, '$oldKeyword', '$newKeyword') WHERE $where";
        $result = $DB->query($sql);

        if ($result) {
            echo json_encode(['code' => 1, 'msg' => '关键词替换成功']);
        } else {
            echo json_encode(['code' => 0, 'msg' => '关键词替换失败']);
        }
     }else{
            exit('{"code":-1,"msg":"无权限"}');
       }
        break;
       case 'addprefix':
        if ($userrow['uid'] == 1) {
        $prefix = $_POST['prefix'];
        $prefixEffectScope = $_POST['prefixEffectScope'];
        $prefixScopeId = $_POST['prefixScopeId'];
        $where = "1";
        if ($prefixEffectScope == 'category') {
            $where = "`fenlei` = '$prefixScopeId'";
        } elseif ($prefixEffectScope == 'docking') {
            $where = "`docking` = '$prefixScopeId'";
        }
        $sql = "UPDATE `qingka_wangke_class` SET `name` = CONCAT('$prefix', `name`) WHERE $where";
        $result = $DB->query($sql);
        if ($result) {
            echo json_encode(['code' => 1, 'msg' => '前缀添加成功']);
        } else {
            echo json_encode(['code' => 0, 'msg' => '前缀添加失败']);
        }
        }else{
            exit('{"code":-1,"msg":"无权限"}');
       }
        break;
        case 'checkbalance':
    if ($userrow['uid'] == 1) {
    $hid = intval($_POST['hid']);
    if (!$hid) {
        jsonReturn(0, '请选择货源');
    }
    $row = $DB->get_row("SELECT * FROM `qingka_wangke_huoyuan` WHERE hid = '$hid' LIMIT 1");
    if (!$row) {
        jsonReturn(0, '未找到该货源');
    }
    $url = $row['url'];
    $user = $row['user'];
    $pass = $row['pass'];
    $name = $row['name'];
    $er_url = $url . "/api.php?act=getmoney";
    $data = array("uid" => $user, "key" => $pass);
    $result = get_url($er_url, $data);
    $result_array = json_decode($result, true);
    if (isset($result_array['money'])) {
        $balance = $result_array['money'];
        $message = "当前接口 $name 余额为 $balance";
        //$DB->query("UPDATE qingka_wangke_huoyuan SET money='{$balance}' WHERE hid='{$hid}'");
        jsonReturn(1, $message);
    } else {
        jsonReturn(0, '查询余额失败');
    }
    }else{
            exit('{"code":-1,"msg":"无权限"}');
       }
    break;

case 'checkdeployedcount':
    if ($userrow['uid'] == 1) {
    $hid = intval($_POST['hid']);
    if (!$hid) {
        jsonReturn(0, '请选择货源');
    }
    $count1 = $DB->count("select count(*) from qingka_wangke_class where docking = '{$hid}' ");
    $message = "当前货源已上架数为 $count1";
    jsonReturn(1, $message);
    }else{
            exit('{"code":-1,"msg":"无权限"}');
       }
    break;
    case 'fetchAllProducts':
    if ($userrow['uid'] == 1) {
        $hid = intval($_POST['hid']);
        if (!$hid) {
            jsonReturn(0, '请选择货源');
        }
        $a = $DB->get_row("SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$hid}'");
        if (!$a) {
            jsonReturn(-1, "货源信息不存在");
        }
 
        $data = array("uid" => $a["user"], "key" => $a["pass"]);
        $er_url = "{$a["url"]}/api.php?act=getclass"; 
        $result = get_url($er_url, $data);
        $result1 = json_decode($result, true);
 
        if (json_last_error() !== JSON_ERROR_NONE || !isset($result1["data"])) {
            jsonReturn(-1, "API 返回数据格式错误或缺失");
        }
 
        $products = $result1["data"];
        exit(json_encode(['code' => 1, 'products' => $products]));
    } else {
        exit('{"code":-1,"msg":"无权限"}');
    }
    break;
case 'startIntegrationSelected':
    if ($userrow['uid'] == 1) {
        $hid = trim(strip_tags(daddslashes($_POST['hid'])));
        $localCategoryId = trim(strip_tags(daddslashes($_POST['localCategoryId'])));
        $cids = json_decode($_POST['cids'], true);
        $markupMultiplier = floatval($_POST['markupMultiplier']);
        $multiplyByFive = intval($_POST['multiplyByFive']);
        $skipExisting = intval($_POST['skipExisting']);
        $createNewCategory = intval($_POST['createNewCategory']);
        $newCategoryName = trim(strip_tags(daddslashes($_POST['newCategoryName'])));
 
        $a = $DB->get_row("SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$hid}'");
        if (!$a) {
            jsonReturn(-1, "货源信息不存在");
        }
 
        // 处理新建分类逻辑
        if ($createNewCategory === 1) {
            if (empty($newCategoryName)) {
                jsonReturn(-1, "请输入新建分类的名称");
            }
 
            // 插入新分类
            $DB->query("INSERT INTO qingka_wangke_fenlei (sort, name, status, time) VALUES ('0', '{$newCategoryName}', '1', NOW())");
            // 获取新分类的ID
            $b = $DB->get_row("SELECT * FROM qingka_wangke_fenlei WHERE name='{$newCategoryName}' ORDER BY id DESC LIMIT 1");
            if (!$b) {
                jsonReturn(-1, "新建分类失败");
            }
            $localCategoryId = $b['id'];
        } elseif (empty($localCategoryId)) {
            jsonReturn(-1, "请选择上架分类");
        }
 
        // 获取货源数据
        $data = array("uid" => $a["user"], "key" => $a["pass"]);
        $er_url = "{$a["url"]}/api.php?act=getclass";  
        $result = get_url($er_url, $data);
        $result1 = json_decode($result, true);
 
        if (json_last_error() !== JSON_ERROR_NONE || !isset($result1["data"])) {
            jsonReturn(-1, "API 返回数据格式错误或缺失");
        }
 
        $categories = $result1["data"];
        $numItemsInserted = 0;
 
        // 获取当前分类下的最大 sort 值
        $maxSortRow = $DB->get_row("SELECT MAX(sort) AS max_sort FROM qingka_wangke_class WHERE fenlei='{$localCategoryId}'");
        $maxSort = $maxSortRow ? $maxSortRow['max_sort'] : 0;
 
        foreach ($categories as $value) {
            if (!in_array($value['cid'], $cids)) {
                continue;
            }
 
            // 根据计算方式计算新价格 
            switch ($multiplyByFive) {
                case 2: // 乘法计算且乘5
                    $price = $value['price'] * $markupMultiplier * 5;
                    break;
                case 1: // 乘法计算且不乘5
                    $price = $value['price'] * $markupMultiplier;
                    break;
                case 0: // 加法计算直接加价
                    $price = $value['price'] + $markupMultiplier;
                    break;
                default:
                    $price = $value['price'];
                    break;
            }
 
            // 检查是否跳过已有商品
            if ($skipExisting) {
                $existingProduct = $DB->get_row("SELECT * FROM qingka_wangke_class WHERE docking='{$hid}' AND noun='{$value['cid']}'");
                if ($existingProduct) {
                    continue;
                }
            }
 
            // 插入新商品 
            $sort = $maxSort + 1;
            $DB->query("INSERT INTO qingka_wangke_class (name, getnoun, noun, fenlei, queryplat, docking, price, sort, content, addtime, status)
                VALUES ('{$value['name']}', '{$value['cid']}', '{$value['cid']}', '{$localCategoryId}', '$hid', '$hid', '{$price}', '{$sort}', '{$value['content']}', NOW(), '1')");
            $maxSort++;
            $numItemsInserted++;
        }
 
        jsonReturn(1, "本次对接上架了{$numItemsInserted}个商品");
    } else {
        exit('{"code":-1,"msg":"无权限"}');
    }
    break;
       case 'deleteDuplicates':
    if ($userrow['uid'] == 1) {
        $scope = trim(strip_tags(daddslashes($_POST['scope'])));
        $scopeId = trim(strip_tags(daddslashes($_POST['scopeId'])));
        $strategy = trim(strip_tags(daddslashes($_POST['strategy'])));
        $where = '';
        if ($scope == 'category') {
            $where = "AND t1.fenlei = '$scopeId'";
        } elseif ($scope == 'docking') {
            $where = "AND t1.docking = '$scopeId'";
        }
        $order = ($strategy == 'keep_larger') ? 't1.cid < t2.cid' : 't1.cid > t2.cid';

        $sql = "DELETE t1 FROM qingka_wangke_class t1
                JOIN qingka_wangke_class t2
                ON t1.noun = t2.noun AND t1.docking = t2.docking AND t1.fenlei = t2.fenlei $where
                WHERE $order";
        $result = $DB->query($sql);
        if ($result) {
            echo json_encode(['code' => 1, 'msg' => '删除重复商品成功']);
        } else {
            echo json_encode(['code' => 0, 'msg' => '删除重复商品失败']);
        }
    } else {
        exit('{"code":-1,"msg":"无权限"}');
    }
    break;
case 'updateprice':
    if ($userrow['uid'] == 1) {
        $hid = trim(strip_tags(daddslashes($_POST['hid'])));
        $upstreamCategoryId = trim(strip_tags(daddslashes($_POST['upstreamCategoryId'])));
        $priceRatio = trim(strip_tags(daddslashes($_POST['priceRatio'])));
        $multiplyByFive = trim(strip_tags(daddslashes($_POST['multiplyByFive'])));

        // 获取货源信息
        $a = $DB->get_row("SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$hid}'");
        if (!$a) {
            jsonReturn(-1, "货源信息不存在");
        }

        // 构建请求数据
        $data = array("uid" => $a["user"], "key" => $a["pass"]);
        $er_url = "{$a["url"]}/api.php?act=getclass";

        // 发送请求获取商品分类信息
        $result = get_url($er_url, $data);
        $result1 = json_decode($result, true);

        // 检查API返回数据是否正确
        if (json_last_error() !== JSON_ERROR_NONE || !isset($result1["data"])) {
            jsonReturn(-1, "API 返回数据格式错误或缺失");
        }

        $categories = $result1["data"];
        $numItemsUpdated = 0;

        // 如果 $multiplyByFive 为 5，先执行下架操作
        if ($multiplyByFive == '5') {
            $DB->query("UPDATE qingka_wangke_class SET status=0 WHERE docking='{$hid}'");
        }

        // 遍历所有分类，更新商品价格或内容
        foreach ($categories as $value) {
            // 如果指定了分类ID，则只更新该分类下的商品
            if ($upstreamCategoryId && $value['fenlei'] != $upstreamCategoryId) {
                continue;
            }

            // 根据计算方式计算新价格
            switch ($multiplyByFive) {
                case '2': // 乘法计算且乘5
                    $price = $value['price'] * $priceRatio * 5;
                    break;
                case '1': // 乘法计算且不乘5
                    $price = $value['price'] * $priceRatio;
                    break;
                case '0': // 加法计算直接加价
                    $price = $value['price'] + $priceRatio;
                    break;
                default:
                    $price = $value['price'];
                    break;
            }
            $existingProduct = $DB->get_row("SELECT * FROM qingka_wangke_class WHERE docking='{$hid}' AND noun='{$value['cid']}'");
            if ($existingProduct) {
                $updateFields = array();
                if ($multiplyByFive != '3' && $multiplyByFive != '4' && $multiplyByFive != '5') {
                    $updateFields['price'] = $price;
                }
                if ($multiplyByFive == '3' || $multiplyByFive == '4') {
                    $updateFields['content'] = $value['content'];
                }
                if ($multiplyByFive == '4') {
                    $updateFields['name'] = $value['name'];
                }
                if ($multiplyByFive == '5') {
                    $updateFields['status'] = 1; // 上架操作
                }
                $updateQuery = "UPDATE qingka_wangke_class SET ";
                $updateQuery .= implode(", ", array_map(function($key) use ($updateFields) {
                    return "$key='" . addslashes($updateFields[$key]) . "'";
                }, array_keys($updateFields)));
                $updateQuery .= " WHERE docking='{$hid}' AND noun='{$value['cid']}'";

                $DB->query($updateQuery);
                $numItemsUpdated++;
            }
        }
        jsonReturn(1, "本次更新了{$numItemsUpdated}个商品的价格或内容");
    }
    break;
        case 'qiandao':
    $uid = daddslashes($userrow['uid']); 
    $row = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE uid='{$uid}'");
    if (!$row) {
        jsonReturn(-1, "用户不存在");
    }
    $lastSignInDate = $row['last_sign_in_date'];
    $currentDate = date('Y-m-d');
    if (!empty($lastSignInDate) && $lastSignInDate == $currentDate) {
        jsonReturn(-1, "您今天已经签到过了，请明天再来！");
    }
    $minMoney = $conf['sign_in_min'];
    $maxMoney = $conf['sign_in_max'];
    $balanceLimit = $conf['sign_in_limit'];
    if ($minMoney > $maxMoney || $minMoney < 0 || $maxMoney < 0) {
        jsonReturn(-1, "签到金额范围配置错误，请联系管理员");
    }
    if ($row['money'] < $balanceLimit) {
        jsonReturn(-1, "您的余额不足【{$balanceLimit}】，无法签到，请充值后再试！");
    }
    $randomMoney = mt_rand($minMoney * 100, $maxMoney * 100) / 100; 
    $currentMoney = $row['money'];
    $newMoney = $currentMoney + $randomMoney;
    $currentTotalRecharge = $row['zcz']; 
    $newTotalRecharge = $currentTotalRecharge + $randomMoney; 

    $updateSql = "UPDATE qingka_wangke_user SET last_sign_in_date = '{$currentDate}', money = '{$newMoney}', zcz = '{$newTotalRecharge}' WHERE uid = '{$uid}'";
    if ($DB->query($updateSql)) {
        wlog($userrow['uid'], "签到", "签到成功，恭喜您获得 " . number_format($randomMoney, 2) . " 余额", $randomMoney);
        jsonReturn(1, "签到成功，增加 " . number_format($randomMoney, 2) . " 余额");
    } else {
        jsonReturn(-1, "更新用户签到信息失败：" . $DB->error());
    }
    break;
    case 'gglist':
    // Assuming you have database connection established ($DB) and user session available ($userrow)

    // Retrieve data from the database, add condition to filter visible announcements
    $data = array();
    // 添加 WHERE status = 1 条件过滤可见公告
    $a = $DB->query("SELECT * FROM qingka_wangke_gonggao WHERE status = 1 ORDER BY zhiding DESC, time DESC");
    while ($row = $DB->fetch($a)) {
        $data[] = $row;
    }

    // Prepare response
    $response = array(
        'code' => 1,
        'data' => $data
    );

    // Return JSON response
    exit(json_encode($response));
    break;
    case 'gglist1':
    // Assuming you have database connection established ($DB) and user session available ($userrow)

    // Retrieve data from the database
    $data = array();
    $a = $DB->query("SELECT * FROM qingka_wangke_gonggao ORDER BY zhiding DESC, time DESC");
    while ($row = $DB->fetch($a)) {
        $data[] = $row;
    }

    // Prepare response
    $response = array(
        'code' => 1,
        'data' => $data
    );

    // Return JSON response
    exit(json_encode($response));
    break;
    case 'ggadd':///***添加
    $data = daddslashes($_POST['data']);
    $title = trim(strip_tags(daddslashes(trim($data['title']))));
    $content = $data['content'];
    $status = trim(strip_tags(daddslashes(trim($data['status']))));
    $zhiding = trim(strip_tags(daddslashes(trim($data['zhiding']))));

    if ($userrow['uid'] != '1') {
        jsonReturn(-1, "Permission denied");
    }

    $DB->query("INSERT INTO qingka_wangke_gonggao (title, content, time, uid, status, zhiding) VALUES ('$title', '$content', NOW(), '{$userrow['uid']}', '$status', '$zhiding')");
    jsonReturn(1, "添加成功");
    break;
    case 'gg_del':
    $id = daddslashes($_POST['id']);
    if ($userrow['uid'] != '1') {
        jsonReturn(-1, "Permission denied");
    }
    $DB->query("DELETE FROM qingka_wangke_gonggao WHERE id='$id'");
    jsonReturn(1, "删除成功");
    break;

case 'upgg'://*更新
    $data = daddslashes($_POST['data']);
    $id = trim(strip_tags(daddslashes(trim($data['id']))));
    $title = trim(strip_tags(daddslashes(trim($data['title']))));
    $content = $data['content'];
    $status = trim(strip_tags(daddslashes(trim($data['status']))));
    $zhiding = trim(strip_tags(daddslashes(trim($data['zhiding']))));
    if ($userrow['uid'] != '1') {
        jsonReturn(-1, "Permission denied");
    }

    $DB->query("UPDATE qingka_wangke_gonggao SET title='$title', content='$content', status='$status', zhiding='$zhiding' WHERE id='$id'");
    jsonReturn(1, "更新成功");
    break;
    case 'toggleStatus':
        $id = daddslashes($_POST['id']);
        if ($userrow['uid'] != '1') {
            jsonReturn(-1, "Permission denied");
        }
        $result = $DB->query("SELECT status FROM qingka_wangke_gonggao WHERE id='$id'");
        $row = $result->fetch_assoc();
        $newStatus = $row['status'] == 1 ? 0 : 1;
        $DB->query("UPDATE qingka_wangke_gonggao SET status='$newStatus' WHERE id='$id'");
        if ($newStatus == 1) {
            jsonReturn(1, "已开启可见状态");
        } else {
            jsonReturn(1, "已关闭可见状态");
        }
        break;
    case 'toggleZhiding':
        $id = daddslashes($_POST['id']);
        if ($userrow['uid'] != '1') {
            jsonReturn(-1, "Permission denied");
        }
        $result = $DB->query("SELECT zhiding FROM qingka_wangke_gonggao WHERE id='$id'");
        $row = $result->fetch_assoc();
        $newZhiding = $row['zhiding'] == 1 ? 0 : 1;
        $DB->query("UPDATE qingka_wangke_gonggao SET zhiding='$newZhiding' WHERE id='$id'");
        if ($newZhiding == 1) {
            jsonReturn(1, "已成功置顶");
        } else {
            jsonReturn(1, "已取消置顶");
        }
        break;
case 'getzjcs':
        $uid = '1277';
        $key = 'qa8YYpPj9G2aCxX5';
        $oid = trim(strip_tags(daddslashes($_GET['oid'])));
        $a = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
        // 判断kcid是否包含任何字母
        if (preg_match('/[a-zA-Z]/', $a['kcid'])) {
            $kcid = $a['kcname'];
        } else {
            $kcid = $a['kcid'];
        }
        
        $data = array(
            "uid" => $uid,
            "key" => $key,
            "id" => $yid, // 确保$yid已经被定义，否则这里会有错误
            "school" => $a['school'],
            "user" => $a['user'],
            "pass" => $a['pass'],
            "kcid" => $kcid
        );
        
        $dx_rl = 'https://freedomp.icu/cjapi.php'; 
        $dx_url = "$dx_rl?act=getzjcs";
        $result = get_url($dx_url, $data); // 确保get_url函数存在且能正确发送请求
        $result = json_decode($result, true);
        exit(json_encode($result));
        break;
        case 'dd_passwd':
    $oid = trim(strip_tags(daddslashes($_POST['oid'])));
    $passwd = trim(strip_tags(daddslashes($_POST['pwd'])));
    $row = $DB->get_row("SELECT * FROM `qingka_wangke_order` WHERE `oid` = '$oid' ");
    if ($userrow['uid']!='1'){ 
        jsonReturn(-1,"滚");
    } else { 
        if ($row['oid'] == $oid) {
            // 此处没有对接相关的操作
            $DB->query("UPDATE `qingka_wangke_order` SET `remarks` = '$passwd' WHERE `oid` = '$oid'");
            wlog($userrow['uid'], "订单备注修改", "修改了订单号为{$row['oid']}备注为 {$passwd}", 0); // 添加日志记录
            jsonReturn(1, "备注修改成功");
        } else {
            jsonReturn(-1, "备注修改失败");
        }
    }
}


?>
