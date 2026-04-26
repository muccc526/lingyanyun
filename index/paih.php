<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="icon" href="images/IMG_0118.png" type="image/ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

     .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

     .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-bottom: none;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px;
        }

     .table {
            border: 1px solid #dee2e6;
        }

     .table thead th {
            background-color: #e9ecef;
            color: #212529;
            border-bottom: 2px solid #dee2e6;
            text-align: center;
        }

     .table tbody tr {
            background-color: white;
        }

     .table th,
     .table td {
            border: 1px solid #dee2e6; 
            text-align: center; 
        }
    </style>
</head>

<body>
    <?php
    $title = '销量排行';
    require_once('head.php');
    
   ?>
    <div class="container my-4">
        
        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">今日销量排行榜</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>课程 ID</th>
                            <th>课程名称</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $a = $DB->query("SELECT cid, ptname, COUNT(*) AS count 
                                         FROM qingka_wangke_order 
                                         WHERE to_days(addtime) = to_days(now()) 
                                         GROUP BY cid, ptname 
                                         ORDER BY count DESC 
                                         LIMIT 10");
                        $rank = 1;
                        while ($rs = $DB->fetch($a)) {
                            $courseId = $rs['cid'];
                            $projectName = $rs['ptname'];
                            $orderCount = $rs['count'];
                            echo "<tr>
                                    <td>TOP.". $rank. "</td>
                                    <td>". $courseId. "</td>
                                    <td>". $projectName. "</td>
                                    <td>". $orderCount. "单</td>
                                </tr>";
                            $rank++;
                        }
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">昨日销量排行榜</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>课程 ID</th>
                            <th>课程名称</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $a = $DB->query("SELECT cid, ptname, COUNT(*) AS count 
                                         FROM qingka_wangke_order 
                                         WHERE to_days(addtime) = to_days(now()) - 1 
                                         GROUP BY cid, ptname 
                                         ORDER BY count DESC 
                                         LIMIT 10");
                        $rank = 1;
                        while ($rs = $DB->fetch($a)) {
                            $courseId = $rs['cid'];
                            $projectName = $rs['ptname'];
                            $orderCount = $rs['count'];
                            echo "<tr>
                                    <td>TOP.". $rank. "</td>
                                    <td>". $courseId. "</td>
                                    <td>". $projectName. "</td>
                                    <td>". $orderCount. "单</td>
                                </tr>";
                            $rank++;
                        }
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">本周巅峰用户排行榜</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>UID</th>
                            <th>用户昵称</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT u.uid AS uid, u.name AS nickname, COUNT(o.uid) AS order_count 
                                  FROM qingka_wangke_order AS o 
                                  JOIN qingka_wangke_user AS u ON o.uid = u.uid 
                                  WHERE o.addtime >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
                                  GROUP BY o.uid 
                                  ORDER BY order_count DESC 
                                  LIMIT 10";
                        $result = $DB->query($query);
                        $rank = 1;
                        while ($row = $DB->fetch($result)) {
                            $uid = $row['uid'];
                            $nickname = $row['nickname'];
                            $orderCount = $row['order_count'];
                            echo '<tr>
                                    <td>TOP.'. $rank. '</td>
                                    <td>'. $uid. '</td>
                                    <td>'. $nickname. '</td>
                                    <td>'. $orderCount. '单</td>
                                </tr>';
                            $rank++;
                        }
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">本周课程销量排行榜</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>课程 ID</th>
                            <th>课程名称</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $a = $DB->query("SELECT cid, ptname, COUNT(*) AS count 
                                         FROM qingka_wangke_order 
                                         WHERE addtime >= DATE_FORMAT(NOW(), '%Y-%m-%d') - INTERVAL (WEEKDAY(NOW()) + 1) DAY 
                                         GROUP BY cid, ptname 
                                         ORDER BY count DESC 
                                         LIMIT 10");
                        $rank = 1;
                        while ($rs = $DB->fetch($a)) {
                            $courseId = $rs['cid'];
                            $projectName = $rs['ptname'];
                            $orderCount = $rs['count'];
                            echo "<tr>
                                    <td>TOP.". $rank. "</td>
                                    <td>". $courseId. "</td>
                                    <td>". $projectName. "</td>
                                    <td>". $orderCount. "单</td>
                                </tr>";
                            $rank++;
                        }
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require_once("footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</body>

</html>