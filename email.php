<?php

include('confing/system.config.php');

$email = $_POST['email'];
$title = $_POST['title'];
$content = $_POST['content'];

$temMailUrl = $emailUrl ;
// 邮件模板
$template = '
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>
</head>
<body style="font-family: sans-serif; background-color: #f8e8e8; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 2px solid #ffc0cb; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $emailUrl . '/logo.png" alt="logo" style="max-width: 200px; max-height: 100px;">
        </div>
        <h2 style="font-size: 22px; color: #ff69b4; margin-bottom: 20px; font-weight: bold;">' . $title . '</h2>
        <p style="font-size: 16px; color: #333; margin-bottom: 10px;">尊敬的用户，您好！</p>

        <div style="background-color: #fff0f5; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <table style="width: 100%; font-size: 15px; color: #333;">
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffc0cb;">' . $content . '</td>
                </tr>
            </table>
        </div>

        <a href="' . $emailUrl . '" style="display: block; background: linear-gradient(to right, #ff7f7f, #ff69b4); color: white; padding: 12px 0; border-radius: 25px; text-decoration: none; font-size: 16px; font-weight: bold; box-shadow: 0 4px 8px rgba(255, 105, 180, 0.4); transition: background 0.3s ease; text-align: center; width: 100%; box-sizing: border-box;">
            点击前往用户中心
        </a>
        <br>
        <p style="font-size: 12px; color: #aaa; margin-top: 30px; text-align: center;">此为系统邮件，请勿回复。</p>
        <p style="font-size: 12px; color: #aaa; margin-top: 10px; text-align: center;">Copyright © '. date("Y") .' <a href="' . $emailUrl . '" >
        ' . $siteName . '</a>  All rights reserved</p>

    </div>
</body>
</html>';


$MailHost = $emailService; 
$MailPort = $emailPort; 
$MailUsername = $emailUser; 
$MailPassword = $emailPass; 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = $MailHost;                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = $MailUsername;                     //SMTP username
  $mail->Password   = $MailPassword;                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
  $mail->Port       = $MailPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom($MailUsername, $siteName);
  // $mail->addAddress($email, $name);     //Add a recipient
  $mail->addAddress($email);
  // $mail->addAddress('ellen@example.com');               //Name is optional
  $mail->addReplyTo($adminEmail, $siteName);
  // $mail->addCC('cc@example.com');
  // $mail->addBCC('bcc@example.com');

  //Attachments
  // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = $title;
  $mail->Body    = $template;
  $mail->AltBody = '该设备暂不支持查看此文件，请使用谷歌浏览器查看！';

  $mail->send();
  echo json_encode(array(
    "code" => 1,
    "msg" => "邮件发送成功"
));
} catch (Exception $e) {
    echo json_encode(array(
    "code" => 0,
    "msg" => "邮件发送失败， 失败原因: {$mail->ErrorInfo}"
));
  
}
