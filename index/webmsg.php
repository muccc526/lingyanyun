<?php
include('head.php');
if ($userrow['uid']!= 1) {
    exit("<script language='javascript'>window.location.href='login.php';</script>");
}
$domain = $_SERVER['SERVER_NAME'];
$server_ip = gethostbyname($domain);
$php_version = phpversion();
?>
<style>
        #loadMoreButton {
            transition: all 0.3s ease;
        }
        #loadingIndicator {
            display: none;
            margin-left: 10px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border-top-color: #66b3ff;
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
<div class="app-content-body ">
    <div class="wrapper-md control" id="userindex">
        <div class="col-lg-6">
            <div class="card" style="box-shadow: 18px 18px 30px #d1d9e6, -18px -18px 30px #fff;border-radius: 8px;">
                <div class="panel-heading font-bold bg-white">系统信息</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <div class="server-info">
                                <h3>系统信息</h3><br>
                                <li>【模板名称】：凌烟云网课模板</li><br>
                                <li>【版本信息】：Version 3.1.0</li><br>
                                <li>【系统作者】：凌烟云</li><br>
                                 <li> <span style="color: red;">【相关说明】：授权价格不得低于88，发现低于限制将禁封处理！为了维护良好的环境，请勿低价授权！各位授权用户均可举报低价授权，查实后举报用户可以获得被举报代理的权限，代理举报代理转化赠送授权站余额！</span>
                                本模板基于小月模板二开而来，如有侵权，请联系：【1759561600】进行删除</li>
                            </div><br>
                            <div class="server-info">
                                <h3>服务器相关信息</h3><br>
                                <li>【网站域名】：<?php echo $domain. " ";?></li><br>
                                <li>【服务器 IP】：<?php echo "$server_ip";?></li><br>
                                <li>【当前时间】：<span id="current-time"></span></li><br>
                                <li>【PHP 版本】：<?php echo $php_version;?></li>
                            </div><br>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card" style="box-shadow: 18px 18px 30px #d1d9e6, -18px -18px 30px #fff;border-radius: 8px;">
                <div class="panel-heading font-bold bg-white">更新日志</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <div class="layui-timeline" id="timeline" style="padding: 20px; line-height: 5px; color: #fff; font-weight: 300px;">
                                <?php
                                $updates = array(
                                    array("date" => "开源声明", "changes" => array(
                                    "本程序仅适用于个人学习，严禁任何单位或个人将本程序用于违法犯罪、违规侵权行为，包括但不限于：逆向破解网课平台、伪造学习数据、代刷网课、窃取传播他人账号 / 课程资源、违反平台用户协议及法律法规的其他行为。
使用者应自行对使用行为的合法性负责，若因违规使用本程序引发法律纠纷、平台处罚等一切后果，均由使用者本人承担，与本程序开发者及开源贡献者无关。本项目将持续坚守合规底线，对任何基于本程序的违法违规衍生行为不承担连带责任。",
                                    
                                    )),
                                        array("date" => "更早以前......", "changes" => array())
                                    );

                                    foreach ($fullUpdates as $update) {
                                        echo '<div class="layui-timeline-item">';
                                        echo '<i class="layui-icon layui-timeline-axis"></i>';
                                        echo '<div class="layui-timeline-content layui-text">';
                                        echo '<h3 class="layui-timeline-title">'. $update["date"]. '</h3>';
                                        echo '<ul>';
                                        foreach ($update["changes"] as $change) {
                                            echo '<li>'. $change. '</li>';
                                        }
                                        echo '</ul>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                   ?>
                                </div>
                                <div style="text-align: center; margin: 20px 0;">
        <button id="loadMoreButton" onclick="showFullTimeline()" style="background-color: #66b3ff; color: white; border: 2px solid #66b3ff; padding: 10px 20px; border-radius: 5px; cursor: pointer;">加载更多</button>
        <span id="loadingIndicator"></span>
    </div>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php");?>


<script>
    function showFullTimeline() {
        var fullTimeline = document.getElementById('fullTimeline');
        var loadMoreButton = document.getElementById('loadMoreButton');
        fullTimeline.style.display = 'block';
        loadMoreButton.style.display = 'none';
    }
</script>
<script>
    function updateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const formattedTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        document.getElementById('current-time').textContent = formattedTime;
    }
    updateTime();
    setInterval(updateTime, 1000); 
</script>
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
</html>