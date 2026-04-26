<?php
require_once(__DIR__ . '/../confing/function.php'); 

// 获取所有货源
$huoyuans = $DB->query("SELECT * FROM `qingka_wangke_huoyuan`");

$lowBalanceSources = [];
while ($row = $DB->fetch($huoyuans)) {
    $hid = $row['hid'];
    $url = $row['url'];
    $user = $row['user'];
    $pass = $row['pass'];
    $name = $row['name'];
    $warning = $row['warning'];

    if ($warning == 0) {
        continue; // 未设置阈值，不进行检测
    }

    $er_url = $url . "/api.php?act=getmoney";
    $data = array("uid" => $user, "key" => $pass);
    $result = get_url($er_url, $data);
    $result_array = json_decode($result, true);

    if (isset($result_array['money'])) {
        $balance = $result_array['money'];

        // 如果余额低于阈值，记录该货源信息
        if ($balance < $warning) {
            $lowBalanceSources[] = [
                'name' => $name,
                'balance' => $balance,
                'warning' => $warning
            ];
        }
    }
}

// 如果有低于阈值的货源，构建并发送一条推送
if (!empty($lowBalanceSources)) {
    $user_result = $DB->query("SELECT tuisongtoken FROM qingka_wangke_user WHERE uid = 1 LIMIT 1");
    if ($user_result->num_rows === 0) {
        die("错误：用户uid=1不存在");
    }
    $user_data = $user_result->fetch_assoc();
    $tuisongtoken = trim($user_data['tuisongtoken']);

    if (empty($tuisongtoken)) {
        die("错误：用户uid=1未设置推送token");
    }

    $message = "<div style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>";
    $message .= "<h2 style='color: #333; text-align: center; margin-bottom: 16px;'>⚠️ 货源余额预警 ⚠️</h2>";
    foreach ($lowBalanceSources as $source) {
        $message .= "<p style='border-left: 3px solid #ff4444; padding-left: 10px; margin: 10px 0;'>";
        $message .= "货源 <strong style='color: #2c3e50;'>{$source['name']}</strong> 的 ";
        $message .= "<span style='display: inline-block; margin: 0 5px;'>";
        $message .= "余额 <strong style='color: #e74c3c; font-size: 16px; padding: 2px 5px; background: #f9ebec; border-radius: 3px;'>{$source['balance']}</strong> ";
        $message .= "</span>";
        $message .= "已低于 ";
        $message .= "<span style='display: inline-block; margin-left: 5px; padding: 2px 6px; background: #f0f0f0; border-radius: 3px;'>";
        $message .= "<strong style='color: #2980b9;'>{$source['warning']}</strong>";
        $message .= "</span>";
        $message .= "<span style='display: block; margin-top: 8px; color: #e67e22;'>请及时充值！</span>";
        $message .= "</p>";
    }
    $message .= "<p style='color: #777; text-align: center;'>请及时前往货源站点充值余额！</p>";
    $message .= "</div>";

    // 构建推送数据
    $data = [
        'content' => $message,
        'summary' => "余额警告",
        'contentType' => 2,
      'spt' => $tuisongtoken,
    ];

    // 发送推送
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);

    echo $response;
}
?>    