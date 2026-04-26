<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include('../confing/common.php'); 
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
@header('Content-Type: application/json; charset=UTF-8');
require("wxpusher.class.php");

$Token = 'AT_4IxmpeO5ZmkcXxrcw5QFHSZtwzbg6fhC';
$wxpusher = new Wxpusher($Token);

switch ($act) {
    // 创建二维码
    case 'Qrcreate':
        // 调用WxPusher类的Qrcreate方法，生成二维码
        $extra = isset($_GET['extra']) ? daddslashes($_GET['extra']) : ''; // 自定义参数，默认为空
        $validTime = isset($_GET['validTime']) ? intval($_GET['validTime']) : 1800; // 设置有效时间，默认1800秒
        
        $qrcodeData = $wxpusher->Qrcreate($extra, $validTime); // 创建二维码
        
        if (is_array($qrcodeData)) {
            // 返回成功的二维码信息
            echo json_encode([
                'code' => 200,
                'success' => true,
                'data' => [
                    'expires' => $qrcodeData['expires'],
                    'code' => $qrcodeData['code'],
                    'shortUrl' => $qrcodeData['shortUrl'],
                    'extra' => $qrcodeData['extra'],
                    'url' => $qrcodeData['url']
                ]
            ]);
        } else {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => $qrcodeData
            ]);
        }
        break;
    
    // 订单绑定
    case 'getUid':
        $code = isset($_GET['code']) ? daddslashes($_GET['code']) : '';
        $username = isset($_GET['username']) ? daddslashes($_GET['username']) : '';

        if (empty($code) || empty($username)) {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '参数不能为空'
            ]);
            exit;
        }

        // 调用WxPusher类的getScanQrcodeUid方法，查询扫码用户的UID
        $uid = $wxpusher->getScanQrcodeUid($code);
        if ($uid) {
            // 更新订单表中的pushUid并检查影响行数
            $sql = "update qingka_wangke_order set pushUid='$uid' where user='$username'";
            $DB->query($sql);
            $affected = $DB->affected();
            
            if ($affected > 0) {
                echo json_encode([
                    'code' => 200,
                    'success' => true,
                    'uid' => $uid
                ]);
            } else {
                echo json_encode([
                    'code' => 501,
                    'success' => false,
                    'msg' => '未找到相关订单，绑定失败'
                ]);
            }
        } else {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '未绑定成功，可能二维码还未被扫描'
            ]);
        }
        break;
    
    // 订单关闭推送
    case 'closePush':
        $username = isset($_GET['username']) ? daddslashes($_GET['username']) : '';
        
        if (empty($username)) {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '用户名不能为空'
            ]);
            exit;
        }
        
        // 清空pushUid
        $sql = "update qingka_wangke_order set pushUid='' where user='$username'";
        $DB->query($sql);       

        echo json_encode([
            'code' => 200,
            'success' => true,
            'msg' => '推送已关闭'
        ]);
        
        break;


    // 用户绑定
    case 'getUserUid':
        $code = isset($_GET['code']) ? daddslashes($_GET['code']) : '';
        $username = isset($_GET['username']) ? daddslashes($_GET['username']) : '';

        if (empty($code) || empty($username)) {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '参数不能为空'
            ]);
            exit;
        }

        // 调用WxPusher类的getScanQrcodeUid方法，查询扫码用户的UID
        $uid = $wxpusher->getScanQrcodeUid($code);
        if ($uid) {
            // 更新用户表中的pushUid
            $sql = "UPDATE qingka_wangke_user SET pushUid='$uid' WHERE user='$username'";
            $DB->query($sql);
            $affected = $DB->affected();
            
            if ($affected > 0) {
                echo json_encode([
                    'code' => 200,
                    'success' => true,
                    'uid' => $uid
                ]);
            } else {
                echo json_encode([
                    'code' => 501,
                    'success' => false,
                    'msg' => '未找到用户，绑定失败'
                ]);
            }
        } else {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '未绑定成功，可能二维码还未被扫描'
            ]);
        }
        break;

    // 用户关闭推送
    case 'closeUserPush':
        $username = isset($_GET['username']) ? daddslashes($_GET['username']) : '';
        
        if (empty($username)) {
            echo json_encode([
                'code' => 500,
                'success' => false,
                'msg' => '用户名不能为空'
            ]);
            exit;
        }
        
        // 清空用户表的pushUid
        $sql = "UPDATE qingka_wangke_user SET pushUid=NULL WHERE user='$username'";
        $DB->query($sql);       

        echo json_encode([
            'code' => 200,
            'success' => true,
            'msg' => '推送已关闭'
        ]);
        break;
    default:
        echo json_encode([
            'code' => 500,
            'success' => false,
            'msg' => '无效的操作'
        ]);
        break;
}
?>