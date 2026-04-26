<?php
require_once(__DIR__ . '/../confing/function.php');
$currentTime = date('Y-m-d H:i:s');
echo "[$currentTime] 开始检查用户余额...<br>";
$warning = 5; // 这里设置告警余额限制，可以修改为其他任意数值，如1、10等

// 获取所有开启余额告警通知且余额低于告警余额限制的用户
$users = $DB->query("SELECT `uid`, `money`, `tuisongtoken` FROM `qingka_wangke_user` WHERE `money` < $warning AND `yetzkg` = 'on'");
$totalUsers = 0;
$sentNotifications = 0;
foreach ($users as $user) {
    $uid = $user['uid'];
    $money = $user['money'];
    $token = $user['tuisongtoken'];
    $totalUsers++;
    if (empty($token)) {
        echo "用户ID: $uid - 推送token为空，跳过<br>";
        continue;
    }
    // 构建通知消息
    $message = "
        <div style='
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            background-color: #fff6f6;
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 0 auto;
        '>
            <h2 style='color: #d9534f; text-align: center; margin-bottom: 16px;'>⚠️ 凌烟云余额告警通知 ⚠️</h2>
            <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
            <div style='margin-bottom: 12px;'>
                <strong>尊敬的用户，您当前余额为:</strong>
                <span style='color: #d9534f; font-weight: bold;'>¥{$money}</span>
            </div>
            <div style='margin-bottom: 12px;'>
                <p style='color: #555;'>您的账户余额已低于【{$warning}元】，请及时充值，以免影响正常使用。</p>
            </div>
            <hr style='border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0;'>
            <p style='color: #777; text-align: center;'>
                感谢使用本系统！
            </p>
        </div>
    ";
    
    // 准备推送数据
    $data = [
        'content' => $message,
        'summary' => '余额警告通知',
        'contentType' => 2, // HTML格式
        'spt' => $token,
    ];
    
    // 设置HTTP请求选项
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($data)
        ]
    ];
    
    // 创建HTTP上下文
    $context = stream_context_create($options);
    
    // 发送推送请求
    try {
        $response = @file_get_contents('https://wxpusher.zjiecode.com/api/send/message/simple-push', false, $context);
        
        // 检查响应
        if ($response === false) {
            echo "用户ID: $uid - 推送失败，网络请求错误<br>";
            continue;
        }
        
        // 解析响应
        $responseData = json_decode($response, true);
        if ($responseData && isset($responseData['code']) && $responseData['code'] == 1000) {
            echo "用户ID: $uid - 推送成功，当前余额: ¥{$money}<br>";
            $sentNotifications++;
        } else {
            echo "用户ID: $uid - 推送失败，错误代码: " . ($responseData ? $responseData['code'] : '未知') . "<br>";
        }
    } catch (Exception $e) {
        echo "用户ID: $uid - 推送异常: " . $e->getMessage() . "<br>";
    }
}

// 输出统计信息
$endTime = date('Y-m-d H:i:s');
echo "[$endTime] 余额警告检查完成<br>";
echo "共检查用户: $totalUsers,";
echo "成功发送通知: $sentNotifications<br>";
?>
