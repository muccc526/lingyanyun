<?php
require_once(__DIR__ . '/../confing/function.php'); 


$user_result = $DB->query("SELECT tuisongtoken FROM qingka_wangke_user WHERE uid = 1 LIMIT 1");
if ($user_result->num_rows === 0) {
    die("错误：用户uid=1不存在");
}
$user_data = $user_result->fetch_assoc();
$tuisongtoken = trim($user_data['tuisongtoken']);

if (empty($tuisongtoken)) {
    die("错误：用户uid=1未设置推送token");
}


$orders = $DB->query("SELECT oid FROM qingka_wangke_order WHERE dockstatus = 2");

while ($order = $orders->fetch_assoc()) {
    $oid = $order['oid'];
    

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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>❌ 对接失败通知 ❌ </h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>失败订单ID:</strong>
                            <span style='color: #555;'> {$oid} </span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <span style='color: #555;'>对接失败，请及时处理！</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            请及时登录系统处理异常订单！
                        </p>
                    </div>
EOD;

    $payload = [
        'content'    => $message,
        'summary'    => '对接失败通知！',
        'contentType' => 2,
        'spt'        => $tuisongtoken
    ];

    // 发送推送请求
    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n",
            'content' => json_encode($payload)
        ]
    ];
    
    $context  = stream_context_create($options);
    $response = @file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);
    
    // 更新订单状态（无论推送是否成功）
    $DB->query("UPDATE qingka_wangke_order SET dockstatus = 2 WHERE oid = '{$oid}'");
    echo "订单 {$oid} 已处理，状态更新为2\n";
}
?>