<?php
require_once(__DIR__ . '/../confing/function.php');


$jtdate = date('Y-m-d', strtotime('today')) . ' 00:00:00';
$ztdate = date('Y-m-d', strtotime('yesterday')) . ' 00:00:00';
$sevenDaysAgo = date('Y-m-d', strtotime('-6 days')) . ' 00:00:00';


$uids = $DB->query("SELECT `uid` FROM `qingka_wangke_user` WHERE `sjtzkg` = 'on'");
foreach ($uids as $row) {
    $uid = $row['uid'];

    if ($uid == 1) {
        $today_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE addtime >= '$jtdate'");
        $yesterday_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE addtime >= '$ztdate' AND addtime < '$jtdate'");
        $seven_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE addtime >= '$sevenDaysAgo'");
        $today_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE addtime >= '$jtdate'"))['total'] ?? 0, 2);
        $yesterday_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE addtime >= '$ztdate' AND addtime < '$jtdate'"))['total'] ?? 0, 2);
        $seven_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE addtime >= '$sevenDaysAgo'"))['total'] ?? 0, 2);


        $today_users = $DB->count("SELECT COUNT(*) FROM qingka_wangke_user WHERE addtime >= '$jtdate'");
        $yesterday_users = $DB->count("SELECT COUNT(*) FROM qingka_wangke_user WHERE addtime >= '$ztdate' AND addtime < '$jtdate'");
        $seven_users = $DB->count("SELECT COUNT(*) FROM qingka_wangke_user WHERE addtime >= '$sevenDaysAgo'");
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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🎉 每日数据通知 🎉</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <div style='margin-bottom: 12px;'>
                            <strong>今日新增用户:</strong>
                            <span style='color: #555;'>$today_users</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>今日订单销量:</strong>
                            <span style='color: #555;'> $today_orders</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>今日销售总额:</strong>
                            <span style='color: #555;'>$today_total</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>昨日新增用户:</strong>
                            <span style='color: #555;'>$yesterday_users</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>昨日订单销量:</strong>
                            <span style='color: #555;'>$yesterday_orders</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>昨日销售总额:</strong>
                            <span style='color: #555;'>$yesterday_total</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>7天内新增用户:</strong>
                            <span style='color: #555;'>$seven_users</span>
                        </div><div style='margin-bottom: 12px;'>
                            <strong>7天内订单销量:</strong>
                            <span style='color: #555;'>$seven_orders</span>
                        </div><div style='margin-bottom: 12px;'>
                            <strong>7天内销售总额:</strong>
                            <span style='color: #555;'> $seven_total</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢使用本系统，还望再接再励！
                        </p>
                    </div>
                    ";
    } else {
        $uid = $row['uid'];

        $today_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$jtdate'");
        $yesterday_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$ztdate' AND addtime < '$jtdate'");
        $seven_orders = $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$sevenDaysAgo'");
        $today_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$jtdate'"))['total'] ?? 0, 2);
        $yesterday_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$ztdate' AND addtime < '$jtdate'"))['total'] ?? 0, 2);
        $seven_total = number_format($DB->fetch($DB->query("SELECT SUM(fees) as total FROM qingka_wangke_order WHERE uid = '$uid' AND addtime >= '$sevenDaysAgo'"))['total'] ?? 0, 2);
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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🎉 每日数据通知 🎉</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <div style='margin-bottom: 12px;'>
                            <strong>今日订单销量:</strong>
                            <span style='color: #555;'> $today_orders</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>今日销售总额:</strong>
                            <span style='color: #555;'>$today_total</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>昨日订单销量:</strong>
                            <span style='color: #555;'>$yesterday_orders</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>昨日销售总额:</strong>
                            <span style='color: #555;'>$yesterday_total</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>7天内订单销量:</strong>
                            <span style='color: #555;'>$seven_orders</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>7天内销售总额:</strong>
                            <span style='color: #555;'> $seven_total</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢使用本系统，还望再接再励！
                        </p>
                    </div>
                    ";
    }


   $supertoken = $DB->get_row("SELECT `tuisongtoken` FROM `qingka_wangke_user` WHERE `uid` = '$uid' AND `tuisongtoken` IS NOT NULL");
if (!$supertoken || empty($supertoken['tuisongtoken'])) {
    echo "Error: tuisongtoken is empty or UID not found: $uid\n";
    continue;
}
$simplePushToken = $supertoken['tuisongtoken'];


    $data = [
        'content' => $message,
        'summary' => '今日数据报告！', // 消息摘要
        'contentType' => 2, // HTML 格式
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

    echo $response;
}
?>