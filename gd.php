<?php
include('confing/common.php');
include('ayconfig.php');

$php_Self = substr($_SERVER['PHP_SELF'], strripos($_SERVER['PHP_SELF'], "/") + 1);
if ($php_Self != "gd.php") {
    $msg = '%E6%96%87%E4%BB%B6%E9%94%99%E8%AF%AF';
    $msg = urldecode($msg);
    exit(json_encode(['code' => -1, 'msg' => $msg]));
}
$supertoken = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid`='1'");
switch ($act) {
    
    case 'addTicket':
    $content = trim(strip_tags(daddslashes($_GET['content'])));
    if (empty($content)) {
        exit('{"code":-1,"msg":"问题内容不能为空"}');
    }
    if (strlen($content) > 1000 ) {
        echo json_encode(['code' => 0, 'msg' => '问题不能超过1000个字']);
        exit;
    }
    $title = "无";
    $region = "其他问题";
    $date = date('Y-m-d H:i:s');
    $Content = $date . " 用户提问: " . $content;
    $insertQuery = "INSERT INTO `qingka_wangke_gongdan` (`title`, `region`, `content`, `uid`, `state`, `addtime`) VALUES ('$title', '$region', '$Content', '{$userrow['uid']}', '待回复', '$date')";
    if ($DB->query($insertQuery)) {
        $message = "用户{$userrow['uid']}刚刚向您反馈了{$region}，请尽快处理。";
        $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($supertoken['tuisongtoken']) . '/' . urlencode($message);
        $response = file_get_contents($apiUrl);
        exit('{"code":1,"msg":"工单新增成功"}');
    } else {
        exit('{"code":-1,"msg":"工单新增失败"}');
    }
    break;
    
case 'feedback':
    $oid = intval($_GET['oid']);
    $feedback = trim(strip_tags(daddslashes($_GET['feedback'])));
    if (empty($oid) || empty($feedback)) {
        echo json_encode(['code' => 0, 'msg' => '订单ID或反馈内容不能为空']);
        exit;
    }
    if (strlen($feedback) > 500 || preg_match('/[0-9a-zA-Z]/', $feedback)) {
        echo json_encode(['code' => 0, 'msg' => '反馈内容不能超过500个字，且不能包含数字和字母']);
        exit;
    }
    $result = $DB->query("SELECT * FROM `qingka_wangke_order` WHERE `oid` = '$oid'");
    $date = date('Y-m-d H:i:s');
    if ($result && $row = $result->fetch_assoc()) {
        $title = $row['ptname'] . "\n" . $row['school'] . ' ' . $row['user'] . ' ' . $row['pass'] . "\n" . $row['kcname']."\n状态: " . $row['status']." 备注: " . $row['remarks']."\n下单时间: " . $row['addtime'];
        $region = $oid;
        $content = $date . " 用户反馈: ".$feedback;
        
        //该订单下单时间: " . $row['addtime'] . "\n当前状态: " . $row['status'] . "\n进度: " . $row['process'] . "\n详细信息: " . $row['remarks'] . "\n开考信息: " . $row['examStartTime'] . " - " . $row['examEndTime']
        $checkQuery = "SELECT * FROM `qingka_wangke_gongdan` WHERE `title` = '$title'";
        $checkResult = $DB->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            echo json_encode(['code' => 0, 'msg' => '该工单已存在']);
            exit;
        }

        // 检查用户是否绑定了推送 token
        $usertoken = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid`='{$row['uid']}'");
        $hasToken = !empty($usertoken['tuisongtoken']);

        $insertQuery = "INSERT INTO `qingka_wangke_gongdan` (`title`, `region`, `content`, `uid`, `state`, `addtime`) VALUES ('$title', '$region', '$content', '{$userrow['uid']}', '待回复', '$date')";
        if ($DB->query($insertQuery)) {
            $message = "用户{$userrow['uid']}刚刚向您反馈了{$oid}，请尽快处理。";
            $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($supertoken['tuisongtoken']) . '/' . urlencode($message);
            $response = file_get_contents($apiUrl);

            if ($hasToken) {
                echo json_encode(['code' => 1, 'msg' => '反馈成功']);
            } else {
                echo json_encode(['code' => 1, 'msg' => '未绑定推送token，请前往工单系统绑定推送token以获取最新回复。']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '反馈失败，请重试']);
        }
    } else {
        echo json_encode(['code' => 0, 'msg' => '订单不存在']);
    }
    break;
    
    case 'gdlist':
    $searchQuery = trim(strip_tags($_POST['searchQuery']));
    $statusFilter = trim(strip_tags($_POST['statusFilter'])); // 新增状态筛选参数
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1; // 获取当前页码
    $limit = 10; // 每页显示的记录数
    $offset = ($page - 1) * $limit; // 计算偏移量

    if ($userrow['uid'] != '1') {
        $sql1 = "where uid='{$userrow['uid']}'";
    } else {
        $sql1 = "where 1=1";
    }

    if (!empty($searchQuery)) {
        $sql1 .= " AND (title LIKE '%$searchQuery%' OR region LIKE '%$searchQuery%')";
    }

    if (!empty($statusFilter)) {
        $sql1 .= " AND state='$statusFilter'"; // 新增状态筛选条件
    }

    // 获取总记录数
    $totalQuery = $DB->query("SELECT COUNT(*) as total FROM qingka_wangke_gongdan {$sql1}");
    $totalResult = $DB->fetch($totalQuery);
    $total = $totalResult['total'];

    // 获取分页数据
    $a = $DB->query("SELECT * FROM qingka_wangke_gongdan {$sql1} ORDER BY gid DESC LIMIT $limit OFFSET $offset");
    $data = [];
    while ($row = $DB->fetch($a)) {
        $data[] = $row;
    }

    $responseData = array('code' => 1, 'data' => $data, 'total' => $total);
    exit(json_encode($responseData));
    break;
    
    case 'savePushToken':
    $token = trim(strip_tags(daddslashes($_GET['token'])));
    $updateQuery = "UPDATE `qingka_wangke_user` SET `tuisongtoken`='$token' WHERE `uid`='{$userrow['uid']}'";
    if ($DB->query($updateQuery)) {
        exit('{"code":1,"msg":"推送Token保存成功"}');
    } else {
        exit('{"code":-1,"msg":"推送Token保存失败"}');
    }
    break;
    case 'getPushToken':
    $token = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid`='{$userrow['uid']}'");
    if ($token) {
        exit(json_encode(['code' => 1, 'token' => $token['tuisongtoken']]));
    } else {
        exit(json_encode(['code' => -1, 'msg' => '暂未设置推送token']));
    }
    break;
    
    case 'shan':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != $b['uid'] && $userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"该工单不是你的！无法删除！"}');
        }
        $DB->query("delete from qingka_wangke_gongdan where gid='{$gid}'");
        exit('{"code":1,"msg":"删除成功！"}');
    break;

    case 'answer':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $answer = trim(strip_tags(daddslashes($_POST['answer'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"无权限！"}');
        }
        $newAnswer = $b['content'] . "\n\n" . $date . " 管理员回复: " . $answer;
        $DB->query("update qingka_wangke_gongdan set `content`='$newAnswer',`state`='已回复' where gid='$gid'");
        $token = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid`='{$b['uid']}'");
        $message = "您反馈的{$b['region']}有新变动，请及时前往查看！";
        $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($token['tuisongtoken']) . '/' . urlencode($message);
        $response = file_get_contents($apiUrl);
        exit('{"code":1,"msg":"回复成功！"}');
        break;

    case 'bohui':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $answer = trim(strip_tags(daddslashes($_POST['answer'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"无权限！"}');
        }
        $newAnswer = $b['content'] . "\n\n" . $date . " 管理员修改工单状态为已完成，回复: " . $answer;
        $DB->query("update qingka_wangke_gongdan set `content`='$newAnswer',`state`='已完成' where gid='$gid'");
        $token = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid`='{$b['uid']}'");
        $message = "您反馈的{$b['region']}已经完成，请及时前往查看！";
        $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($token['tuisongtoken']) . '/' . urlencode($message);
        $response = file_get_contents($apiUrl);
        exit('{"code":1,"msg":"该订单已处理完成"}');
        break;
        
     case 'toanswer':
     $gid = trim(strip_tags(daddslashes($_POST['gid'])));
     $toanswer = trim(strip_tags(daddslashes($_POST['toanswer'])));
     $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
    if (strlen($toanswer) > 100 ) {
        echo json_encode(['code' => 0, 'msg' => '问题不能超过100个字']);
        exit;
    }
    if ($b['state'] == '已完成') {
        exit('{"code":-1,"msg":"工单已完成，无法再追问"}');
    } else {
        $message = "用户{$userrow['uid']}向你追问{$b['region']}处理进展，请尽快回复。";
        $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($supertoken['tuisongtoken']) . '/' . urlencode($message);
        $response = file_get_contents($apiUrl);
        $newContent = $b['content'] . "\n\n" . $date . " 用户追问: " . $toanswer;
        $DB->query("update qingka_wangke_gongdan set `content`='$newContent',`state`='待回复' where gid='$gid'");
        exit('{"code":1,"msg":"二次提问完成"}');
    }
    break;
    
    case 'testPushToken':
     $token = trim(strip_tags(daddslashes($_GET['token'])));
     $apiUrl = 'https://wxpusher.zjiecode.com/api/send/message/' . urlencode($token) . '/' . urlencode("消息推送测试");
     $response = file_get_contents($apiUrl);
     exit('{"code":1,"msg":"成功"}');
    break;
    
    
}
?>