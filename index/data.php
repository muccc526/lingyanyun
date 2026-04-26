<?php
$title='数据统计';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}

 $php_Self = substr($_SERVER['PHP_SELF'],strripos($_SERVER['PHP_SELF'],"/")+1); 
if($php_Self!="data.php"){
    exit('1');
}
require_once('./head.php');
if ($userrow['uid'] != 1) {
  exit("<script language='javascript'>window.location.href='./404';</script>");
}
$jtdate = date('Y-m-d 00:00:00'); // 今天0点（午夜）的时间
$now = date('Y-m-d H:i:s'); // 当前时间
$yesterdayStart = date('Y-m-d 00:00:00', strtotime('yesterday'));

$uid=$_GET['uid'];

// 计算旗下订单销售总金额
$totalSales = 0;
$allOrders = $DB->query("SELECT fees FROM qingka_wangke_order");
while ($order = $DB->fetch($allOrders)) {
    $totalSales += $order['fees'];
}

// 计算近7天内销售总金额
$sevenDaysAgo = date('Y-m-d 00:00:00', strtotime("-7 days"));
$sevenDaysSales = 0;
$sevenDaysOrders = $DB->query("SELECT fees FROM qingka_wangke_order WHERE addtime >= '$sevenDaysAgo'");
while ($sevenDaysOrder = $DB->fetch($sevenDaysOrders)) {
    $sevenDaysSales += $sevenDaysOrder['fees'];
}
?>

 <div class="layui-container" style="padding: 20px;">
    <div class="layui-row" style="margin-bottom: 15px;">
        <div class="layui-card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">数据统计</div>
            <div class="layui-card-body">
         
                
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td><i class="fas fa-users"></i> 旗下代理总数:<span class="badge badge-secondary"><?php echo $DB->count("select count(*) from qingka_wangke_user ") . "人"; ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-clipboard-list"></i> 旗下订单总数:<span class="badge badge-secondary"><?php echo $DB->count("select count(*) from qingka_wangke_order") . "条"; ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-dollar-sign"></i> 旗下订单销售总金额:<span class="badge badge-secondary"><?php echo $totalSales . "元"; ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-user-plus"></i> 今日新增代理:<span class="badge badge-secondary"><?php echo $DB->count("SELECT COUNT(*) FROM qingka_wangke_user WHERE addtime BETWEEN '$jtdate' AND '$now'") . "人"; ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-clipboard-list"></i> 今日订单数量:<span class="badge badge-secondary"><?php echo $DB->count("SELECT COUNT(*) FROM qingka_wangke_order WHERE addtime BETWEEN '$jtdate' AND '$now'") . "条"; ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-dollar-sign"></i> 今日销售金额:<span class="badge badge-secondary"><?php
                                $zcz1 = 0;
                                $a = $DB->query("SELECT * FROM qingka_wangke_order WHERE addtime BETWEEN '$jtdate' AND '$now'");
                                while ($c = $DB->fetch($a)) {
                                    $zcz1 += $c['fees'];
                                }
                                echo $zcz1 . "元";
                                ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-clipboard-list"></i> 今日充值金额:<span class="badge badge-secondary"><?php
                               $a=$DB->query("select * from qingka_wangke_pay where status='1' and addtime>'$jtdate'  ");
                                $jrcz=0;
                                while($c=$DB->fetch($a)){
                                    $jrcz+=$c['money'];
                                }
                                echo $jrcz;
                                ?>元</td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-clipboard-list"></i> 昨日订单数量:<span class="badge badge-secondary"><?php
                                $yesterdayStart = date('Y-m-d 00:00:00', strtotime('yesterday'));
                                $yesterdayEnd = date('Y-m-d 23:59:59', strtotime('yesterday'));
                                echo $DB->count("select count(*) from qingka_wangke_order where addtime>='$yesterdayStart' and addtime<='$yesterdayEnd'") . "条";
                                ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-dollar-sign"></i> 昨日销售金额:<span class="badge badge-secondary"><?php
                                $yesterdayStart = date('Y-m-d 00:00:00', strtotime('yesterday'));
                                $yesterdayEnd = date('Y-m-d 23:59:59', strtotime('yesterday'));
                                $zcz = 0;
                                $a = $DB->query("select * from qingka_wangke_order where addtime>='$yesterdayStart' and addtime<='$yesterdayEnd'");
                                while ($c = $DB->fetch($a)) {
                                    $zcz += $c['fees'];
                                }
                                echo $zcz . "元";
                                ?></span></td>
                        </tr>
                        
                        <tr>
                            <td><i class="fas fa-clipboard-list"></i> 近7天内总订单:<span class="badge badge-secondary"><?php
                                $thirtyDaysAgo = date('Y-m-d', strtotime("-7 days"));
                                echo $DB->count("select count(*) from qingka_wangke_order where date(addtime) >= '$thirtyDaysAgo'") . "条";
                                ?></span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-dollar-sign"></i> 近7天内销售总金额:<span class="badge badge-secondary"><?php echo $sevenDaysSales . "元"; ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
             //禁止鼠标右击
      document.oncontextmenu = function() {
        event.returnValue = false;
      };
      //禁用开发者工具F12
      document.onkeydown = document.onkeyup = document.onkeypress = function(event) {
        let e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 123) {
          e.returnValue = false;
          return false;
        }
      };
      let userAgent = navigator.userAgent;
      if (userAgent.indexOf("Firefox") > -1) {
        let checkStatus;
        let devtools = /./;
        devtools.toString = function() {
          checkStatus = "on";
        };
        setInterval(function() {
          checkStatus = "off";
          console.log(devtools);
          console.log(checkStatus);
          console.clear();
          if (checkStatus === "on") {
            let target = "";
            try {
              window.open("about:blank", (target = "_self"));
            } catch (err) {
              let a = document.createElement("button");
              a.onclick = function() {
                window.open("about:blank", (target = "_self"));
              };
              a.click();
            }
          }
        }, 200);
      } else {
        //禁用控制台
        let ConsoleManager = {
          onOpen: function() {
            alert("Console is opened");
          },
          onClose: function() {
            alert("Console is closed");
          },
          init: function() {
            let self = this;
            let x = document.createElement("div");
            let isOpening = false,
              isOpened = false;
            Object.defineProperty(x, "id", {
              get: function() {
                if (!isOpening) {
                  self.onOpen();
                  isOpening = true;
                }
                isOpened = true;
                return true;
              }
            });
            setInterval(function() {
              isOpened = false;
              console.info(x);
              console.clear();
              if (!isOpened && isOpening) {
                self.onClose();
                isOpening = false;
              }
            }, 200);
          }
        };
        ConsoleManager.onOpen = function() {
          //打开控制台，跳转
          let target = "";
          try {
            window.open("about:blank", (target = "_self"));
          } catch (err) {
            let a = document.createElement("button");
            a.onclick = function() {
              window.open("about:blank", (target = "_self"));
            };
            a.click();
          }
        };
        ConsoleManager.onClose = function() {
          alert("Console is closed!!!!!");
        };
        ConsoleManager.init();
      }
        </script>
<?php require_once("footer.php"); ?>