<?php
$mod = 'blank';
$title = '价格列表';
require_once('head.php');
$levelData = [];
$levelQuery = $DB->query("select name, rate from qingka_wangke_dengji");
while ($levelRow = $DB->fetch($levelQuery)) {
    $levelData[$levelRow['name']] = $levelRow['rate'];
}
?>
<div class="app-content-body">
    <div class="wrapper-md control">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">我的价格</div>
                <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                    <div class="table-responsive">
                        <table class="table table-striped">

                            <thead>
                                <tr>
                                    <th style="text-align:center;">课程ID</th>
                                    <th style="text-align:center;">课程名称</th>
                                    <?php foreach ($levelData as $levelName => $rate) {?>
                                        <th style="text-align:center;"><?php echo $levelName;?></th>
                                    <?php }?>
                                    <th style="text-align:center;">我的价格</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = $DB->query("select * from qingka_wangke_class where status = 1 ");
                                while ($rs = $DB->fetch($a)) {
                                    echo "<tr><td style=\"text-align:center;\">". $rs['cid']. "</td>
                                            <td style=\"text-align:center;\">". $rs['name']. "</td>";
                                    foreach ($levelData as $levelName => $rate) {
                                        $price = $rs['price'] * $rate;
                                        // 仅显示当前用户等级费率及更高费率的等级价格
                                        if ($rate >= $userrow['your_level_rate']) {
                                            echo "<td style=\"text-align:center;\">". $price. "</td>";
                                        } else {
                                            echo "<td style=\"text-align:center;\"></td>";
                                        }
                                    }
                                    echo "<td style=\"text-align:center;\">". ($rs['price'] * $userrow['addprice']). "</td>
                                            </tr>";
                                }
                          ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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