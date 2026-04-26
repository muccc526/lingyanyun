<?php
include('../confing/function.php');
if($islogin!=1){exit("<script language='javascript'>window.location.href='login';</script>");}
$sj=$DB->get_row("select uid,user,yqm,money,notice from qingka_wangke_user WHERE uid='{$userrow['uuid']}'");
$spsm=$DB->get_row("select content from qingka_wangke_class where cid='$cid'");

$dd=$DB->count("select count(oid) from qingka_wangke_order WHERE uid='{$userrow['uid']}' ");
$ck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API查课' AND uid='{$userrow['uid']}' ");
$xd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API添加任务' AND uid='{$userrow['uid']}' ");
if($ck==0 || $xd==0){
    $xdb=100;
}else{
    $xdb=round($xd/$ck,4)*100;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?=$conf['sitename']?></title>
<meta name="keywords" content="<?=$conf['keywords'];?>" />
<meta name="description" content="<?=$conf['description'];?>" />
<link rel="icon" href="../favicon.ico" type="image/ico">
<meta name="author" content=" ">
<link rel="stylesheet" href="assets/css/element.css">
<link rel="stylesheet" href="assets/css/apps.css" type="text/css" />
<link rel="stylesheet" href="assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="assets/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="assets/LightYear/js/bootstrap-multitabs/multitabs.min.css">
<link href="assets/LightYear/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/LightYear/css/style.min.css" rel="stylesheet">
<link href="assets/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
<script src="assets/js/jquery.min.js"></script>
<script src="layer/3.1.1/layer.js"></script>


</head>
<style>
    .COVERID{
        
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999999999999999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
    }
    .COVERID .COVERID_BOX .COVERID_LOAD {
      width: 20px;
      aspect-ratio: 1;
      border-radius: 50%;
      background: #695757;
      box-shadow: 0 0 0 0 #0004;
      animation: COVERID_LOAD 1.5s infinite linear;
      position: relative;
    }
    .COVERID .COVERID_BOX .COVERID_LOAD:before,
    .COVERID .COVERID_BOX .COVERID_LOAD:after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: inherit;
      box-shadow: 0 0 0 0 #0004;
      animation: inherit;
      animation-delay: -0.5s;
    }
    .COVERID .COVERID_BOX .COVERID_LOAD:after {
      animation-delay: -1s;
    }
    @keyframes COVERID_LOAD {
        100% {box-shadow: 0 0 0 40px #0000}
    }
    
    .COVERID .COVERID_BOX{
        width: 100px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    
    .COVERID .COVERID_BOX .COVERID_TEXT{
        margin-top: 40px;
        font-weight: bold;
    }
</style>


<script>
    $(window).on('load', () => {
        setTimeout(()=>{
            document.getElementById("PAGECOVERID").style.display = 'none';
        },1000)
    });
    setTimeout(()=>{
        document.getElementById("PAGECOVERID").style.display = 'none';
    },1500)
</script>
<?php
if($userrow['active']=="0"){
alert('您的账号已被封禁！','login');
}
?>
<body>
