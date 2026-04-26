<?php
include('confing/common.php');
if (!isset($_GET['act'])) {
    echo json_encode(array(
        "code" => 0,
        "msg" => "缺少 'act' 参数"
    ));
    exit;
}

$act = $_GET['act'];

switch($act){
     case 'send_code':
        // 获取用户账号
        $user = $_POST['user']; 

        // 生成验证码，六位数，数字和英文混合
        $characters = '0123456789';
        $vercode = '';
        for ($i = 0; $i < 6; $i++) {
            $vercode .= $characters[rand(0, strlen($characters) - 1)];
        }

        // 获取当前时间
        $currentTime = date('Y-m-d H:i:s');

        // 保存验证码到数据库
        $DB->query("INSERT INTO `qingka_wangke_code` (`vercode`, `time`) VALUES ( '$vercode', '$currentTime')");

        // 发送邮件
        $email = $user . "@qq.com"; 
        $url = $conf['email_url'] . '/email.php';
        $title = '验证码';
        $content = '您的验证码为：' . $vercode.',五分钟后失效！！！';

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

        if ($responseData['code'] == 1) {
            echo json_encode(array(
                "code" => 1,
                "msg" => "邮件发送成功"
            ));
        } else {
            echo json_encode(array(
                "code" => 0,
                "msg" => "邮件发送失败，失败原因: " . $responseData['msg']
            ));
        }
        break;
}

?>