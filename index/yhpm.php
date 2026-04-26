<?php
include('head.php');
$xdb = round($xd / $ck, 4) * 100;
?>
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
        
        /* 移除前三名的特殊背景色 */
        .rank-gold, .rank-silver, .rank-bronze {
            background-color: inherit !important;
        }
    </style>
</head>
<body>
    <?php require_once('head.php'); ?>
    <div class="container my-4">
        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <i class="fa-solid fa-calendar-day"></i>今日用户下单排行榜
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>UID</th>
                            <th>用户名</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT u.uid AS uid, u.name AS username, COUNT(o.uid) AS order_count 
                                  FROM qingka_wangke_order AS o 
                                  JOIN qingka_wangke_user AS u ON o.uid = u.uid 
                                  WHERE DATE(o.addtime) = CURDATE() 
                                  GROUP BY o.uid 
                                  ORDER BY order_count DESC 
                                  LIMIT 10";
                        $result = $DB->query($query);
                        $rank = 1;
                        while ($row = $DB->fetch($result)) {
                            $uid = $row['uid'];
                            $username = $row['username'];
                            $orderCount = $row['order_count'];

                            echo "<tr>
                                    <td>TOP.$rank</td>
                                    <td>$uid</td>
                                    <td class=\"text-start\">$username</td>
                                    <td>$orderCount 单</td>
                                </tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <i class="fa-solid fa-calendar-day"></i>昨日用户下单排行榜
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>UID</th>
                            <th>用户名</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT u.uid AS uid, u.name AS username, COUNT(o.uid) AS order_count 
                                  FROM qingka_wangke_order AS o 
                                  JOIN qingka_wangke_user AS u ON o.uid = u.uid 
                                  WHERE DATE(o.addtime) = CURDATE() - INTERVAL 1 DAY 
                                  GROUP BY o.uid 
                                  ORDER BY order_count DESC 
                                  LIMIT 10";
                        $result = $DB->query($query);
                        $rank = 1;
                        while ($row = $DB->fetch($result)) {
                            $uid = $row['uid'];
                            $username = $row['username'];
                            $orderCount = $row['order_count'];

                            echo "<tr>
                                    <td>TOP.$rank</td>
                                    <td>$uid</td>
                                    <td class=\"text-start\">$username</td>
                                    <td>$orderCount 单</td>
                                </tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <i class="fa-solid fa-calendar-week"></i>本周用户下单排行榜
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>UID</th>
                            <th>用户名</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT u.uid AS uid, u.name AS username, COUNT(o.uid) AS order_count 
                                  FROM qingka_wangke_order AS o 
                                  JOIN qingka_wangke_user AS u ON o.uid = u.uid 
                                  WHERE YEARWEEK(o.addtime, 1) = YEARWEEK(NOW(), 1) 
                                  GROUP BY o.uid 
                                  ORDER BY order_count DESC 
                                  LIMIT 10";
                        $result = $DB->query($query);
                        $rank = 1;
                        while ($row = $DB->fetch($result)) {
                            $uid = $row['uid'];
                            $username = $row['username'];
                            $orderCount = $row['order_count'];

                            echo "<tr>
                                    <td>TOP.$rank</td>
                                    <td>$uid</td>
                                    <td class=\"text-start\">$username</td>
                                    <td>$orderCount 单</td>
                                </tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <i class="fa-solid fa-calendar-month"></i>本月用户下单排行榜
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>UID</th>
                            <th>用户名</th>
                            <th>订单数量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT u.uid AS uid, u.name AS username, COUNT(o.uid) AS order_count 
                                  FROM qingka_wangke_order AS o 
                                  JOIN qingka_wangke_user AS u ON o.uid = u.uid 
                                  WHERE MONTH(o.addtime) = MONTH(NOW()) AND YEAR(o.addtime) = YEAR(NOW()) 
                                  GROUP BY o.uid 
                                  ORDER BY order_count DESC 
                                  LIMIT 10";
                        $result = $DB->query($query);
                        $rank = 1;
                        while ($row = $DB->fetch($result)) {
                            $uid = $row['uid'];
                            $username = $row['username'];
                            $orderCount = $row['order_count'];

                            echo "<tr>
                                    <td>TOP.$rank</td>
                                    <td>$uid</td>
                                    <td class=\"text-start\">$username</td>
                                    <td>$orderCount 单</td>
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
</body>
</html>