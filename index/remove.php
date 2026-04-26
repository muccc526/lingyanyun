<?php
$mod = 'blank';
$title = '下架专区';
require_once('head.php');
// 查询下架课程的总数
$countQuery = $DB->query("SELECT COUNT(*) as total 
                          FROM qingka_wangke_class c
                          JOIN qingka_wangke_fenlei f ON c.fenlei = f.id
                          WHERE c.status = 0");
$countResult = $DB->fetch($countQuery);
$totalRecords = $countResult['total'];
$recordsPerPage = 25;
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}
$offset = ($currentPage - 1) * $recordsPerPage;
// 修改查询语句，获取分类ID
$query = $DB->query("SELECT c.cid, c.fenlei as category_id, c.name as course_name, f.name as category_name 
                     FROM qingka_wangke_class c
                     JOIN qingka_wangke_fenlei f ON c.fenlei = f.id
                     WHERE c.status = 0
                     LIMIT $offset, $recordsPerPage");
?>
<div class="layui-container" style="padding: 20px;" id="sx">
    <div class="layui-row" style="margin-bottom: 15px;">
        <div class="layui-card">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                下架专区&nbsp;&nbsp;<button class="btn btn-xs btn-warning">请勿对接</button>
            </div>
            <div class="layui-card-body">
                <style>
                    table.layui-table th,
                    table.layui-table td {
                        text-align: center;
                    }
                   .layui-row .layui-col-md12 {
                        display: flex;
                        justify-content: center;
                    }
                </style>
                <table class="layui-table" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th>项目名称</th>
                            <th>课程 ID</th>
                            <th>分类 ID</th>
                            <th>分类名称</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $DB->fetch($query)) {
                            $course_id = $row["cid"];
                            $category_id = $row["category_id"];
                            $course_name = $row["course_name"];
                            $category_name = $row["category_name"];

                            echo "<tr>";
                            echo "<td>$course_name</td>";
                            echo "<td>$course_id</td>";
                            echo "<td>$category_id</td>";
                            echo "<td>$category_name</td>";
                            echo "</tr>";
                        }
                        if ($DB->affected() == 0) {
                            echo "<tr><td colspan='4'>暂无下架课程。</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-box layui-laypage layui-laypage-default">
                <a href="?page=1" <?php if ($currentPage == 1) echo 'style="pointer-events: none; color: #ccc;"';?>>&lt;&lt;</a>
                <a href="?page=<?php echo ($currentPage > 1)? $currentPage - 1 : 1; ?>" <?php if ($currentPage == 1) echo 'style="pointer-events: none; color: #ccc;"';?>>&lt;</a>
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $currentPage) {
                        echo "<span class='layui-laypage-curr'>$i</span>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
                ?>
                <a href="?page=<?php echo ($currentPage < $totalPages)? $currentPage + 1 : $totalPages; ?>" <?php if ($currentPage == $totalPages) echo 'style="pointer-events: none; color: #ccc;"';?>>&gt;</a>
                <a href="?page=<?php echo $totalPages; ?>" <?php if ($currentPage == $totalPages) echo 'style="pointer-events: none; color: #ccc;"';?>>&gt;&gt;</a>
            </div>
        </div>
    </div>
</div>
<?php require_once("footer.php");?>	
<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>
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