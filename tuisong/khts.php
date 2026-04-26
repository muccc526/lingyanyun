<?php
require_once(__DIR__ . '/../confing/function.php');



$orders = $DB->query("SELECT oid, uid, user, kcname, tuisongtoken, status FROM qingka_wangke_order WHERE tuisongtoken IS NOT NULL");

while ($order = $orders->fetch_assoc()) {
    $oid = $order['oid'];
    $user = $order['user'];
    $kcname = $order['kcname'];
    $tuisongtoken = $order['tuisongtoken'];
    $status = $order['status'];


    if ($tuisongtoken == 0 && $status == '已完成') {
        $message = <<<EOD
<p style='font-size: 16px;'>账号: $user</p>
<p style='font-size: 16px;'>课程名称: $kcname</p>
<p style='font-size: 16px;'>您的订单已完成！</p>
EOD;
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
                        <h2 style='color: #333; text-align: center; margin-bottom: 16px;'>🥇 订单完成通知 🥇</h2>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        
                        <div style='margin-bottom: 12px;'>
                            <strong>下单账号:</strong>
                            <span style='color: #555;'>$user</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <strong>下单课程:</strong>
                            <span style='color: #555;'> $kcname</span>
                        </div>
                        <div style='margin-bottom: 12px;'>
                            <span style='color: #555;'> 尊敬的用户您好，您下单的课程已完成，请自行上号查询进度！</span>
                        </div>
                        <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
                        <p style='color: #777; text-align: center;'>
                            感谢您的使用与支持！
                        </p>
                    </div>
EOD;

        $data = [
            'content' => $message,
            'summary' => '订单已完成通知',
            'contentType' => 2,
            'spt' => $tuisongtoken, // 使用tuisongtoken
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
echo "订单 $oid 已推送给客户。\n";

        $DB->query("UPDATE qingka_wangke_order SET tuisongtoken = 1 WHERE oid = '$oid'");
    }
}
?>
