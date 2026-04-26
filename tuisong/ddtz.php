<?php
include(__DIR__ . '/../confing/function.php');

// 获取所有 wctzkg 或 yctzkg 为 on 的用户
$users_with_notifications = $DB->query("SELECT uid FROM qingka_wangke_user WHERE wctzkg = 'on' OR yctzkg = 'on'");

foreach ($users_with_notifications as $user) {
    $uid = $user['uid'];

    // 获取该用户的所有订单
    $orders = $DB->query("SELECT oid, uid, user, kcname, status, laststatus FROM qingka_wangke_order WHERE uid = '$uid'");

    foreach ($orders as $order) {
        $oid = $order['oid'];
        $user = $order['user'];
        $kcname = $order['kcname'];
        $current_status = $order['status'];
        $last_status = $order['laststatus'];

        if ($last_status === null || $last_status === '') {
            $DB->query("UPDATE qingka_wangke_order SET laststatus = '$current_status' WHERE oid = '$oid'");
            echo "订单 $oid 首次运行，已将 status ($current_status) 记录到 laststatus，不发送通知。\n";
            continue;
        }

        if ($last_status !== $current_status) {
            $user_info = $DB->get_row("SELECT tuisongtoken, wctzkg, yctzkg FROM qingka_wangke_user WHERE uid = '$uid'");
            $simplePushToken = $user_info['tuisongtoken'];
            $wctzkg = $user_info['wctzkg'] ?? 'off';
            $yctzkg = $user_info['yctzkg'] ?? 'off';

            if (in_array($current_status, ['异常', '异常待处理']) && $wctzkg == 'on') {
                if ($simplePushToken) {
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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>⚠️ 订单异常通知 ⚠️</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <div style='margin-bottom: 12px;'>
                            <strong>用户账号:</strong>
                            <span style='color: #555;'> $user</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>课程名称:</strong>
                            <span style='color: #555;'>$kcname </span>
                        </div>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>通知时间:</strong>
                            <span style='color: #555;'>" . date("Y-m-d H:i:s") . "</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>通知内容:</strong>
                            <span style='color: #555;'> 您的订单状态为异常，请及时处理！</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢使用本平台！
                        </p>
                    </div>
                    ";

                    $data = [
                        'content' => $message,
                        'summary' => '订单异常通知！',
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

                    echo "订单 $oid 异常通知已发送给ID: $uid。\n";
                } else {
                    echo "ID: $uid 的推送token未找到，无法发送通知。\n";
                }
            } elseif (in_array($current_status, ['已完成', '考试完成']) && $wctzkg == 'on') {
                if ($simplePushToken) {
                    $message = "<p style='font-size: 16px;'>账号: $user</p>" .
                              "<p style='font-size: 16px;'>课程名称: $kcname</p>" .
                              "<p style='font-size: 16px;'>您的订单已完成！</p>";
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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🌟 订单完成通知 🌟</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <div style='margin-bottom: 12px;'>
                            <strong>用户账号:</strong>
                            <span style='color: #555;'> $user</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>课程名称:</strong>
                            <span style='color: #555;'>$kcname </span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>通知内容:</strong>
                            <span style='color: #555;'> 您的订单已完成！</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>通知时间:</strong>
                            <span style='color: #555;'>" . date("Y-m-d H:i:s") . "</span>
                        </div>
                        
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢使用本平台！
                        </p>
                    </div>
                    ";

                    $data = [
                        'content' => $message,
                        'summary' => '订单完成通知！',
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

                    echo "订单 $oid 已完成通知已发送给ID: $uid。\n";
                } else {
                    echo "ID: $uid 的推送token未找到，无法发送通知。\n";
                }
            }

            $DB->query("UPDATE qingka_wangke_order SET laststatus = '$current_status' WHERE oid = '$oid'");
            echo "订单 $oid 的 laststatus 已更新为 $current_status。\n";
        }
    }
}
?>