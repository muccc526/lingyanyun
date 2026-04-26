<?php
include('../confing/common.php');
include('../get/wxpusher.class.php'); // 引入Wxpusher类

$time = 1;   // 每轮检查间隔时间，单位：分钟
$sleep = 5;  // 每条推送间隔时间，单位：秒


$Token = 'AT_4IxmpeO5ZmkcXxrcw5QFHSZtwzbg6fhC';
// 初始化Wxpusher
$wxpusher = new Wxpusher($Token); // 替换为您的appToken

function pushMessage($wxpusher, $uid, $order) {
    global $DB;  
    
    // 构建推送内容
    $content = "✅ 订单完成通知\n\n";
    $content .= "📚 课程名称：{$order['kcname']}\n";
    $content .= "📋 订单状态：{$order['status']}\n";
    if ($order['process']) {
        $content .= "💡 处理说明：{$order['process']}\n";
    }
    $content .= "\n⏰推送时间" . date("Y-m-d H:i:s");

    // 使用Wxpusher发送消息
    $result = $wxpusher->send($content,'订单完成通知','2','true',$uid);
    
    // 添加调试信息
    $status = $result === true ? '成功' : '失败';
    
    // 打印SQL语句和相关变量
    echo "订单ID: {$order['oid']}\n";
    echo "用户ID: {$order['uid']}\n";
    echo "推送状态: {$status}\n";
    
    $sql = "INSERT INTO qingka_wangke_push_logs (order_id, uid, status) VALUES (
        '{$order['oid']}', 
        '{$order['uid']}',
        '{$status}'
    )";
    echo "SQL语句: {$sql}\n";
    
    // 执行SQL并检查错误
    if(!$DB->query($sql)) {
        echo "SQL执行错误: " . $DB->error() . "\n";
    } else {
        echo "日志记录成功!\n";
    }

    return $result === true;
}

while (true) {
    $now = date("Y-m-d H:i:s");
    echo "开始检查需要推送的订单... {$now}\n";

    // 查询需要推送的订单
    $orders = $DB->query("SELECT * FROM qingka_wangke_order WHERE 
        pushUid IS  not NULL 
        AND pushStatus = 0 
        AND status = '已完成'");
    if ($orders->num_rows === 0) {
        echo "没有需要推送的订单，{$time}分钟后重新检查...\n\n";
        sleep($time * 60);
        continue;
    }

    foreach ($orders as $order) {
        echo "处理订单ID：{$order['oid']}\n";
        
        // 推送消息
        $success = pushMessage($wxpusher, $order['pushUid'], $order);
        if ($success) {
            // 推送成功，更新推送状态
            $DB->query("UPDATE qingka_wangke_order SET 
                pushStatus = 1
                WHERE oid = '{$order['oid']}'");
            
            echo "订单ID：{$order['oid']} 推送成功！\n";
        } else {
            // 推送失败，更新推送状态
            $DB->query("UPDATE qingka_wangke_order SET 
                pushStatus = 2
                WHERE oid = '{$order['oid']}'");
            echo "订单ID：{$order['oid']} 推送失败！\n";
        }
        
        echo "------------------------------------------------------\n";
        sleep($sleep);
    }
}
?> 