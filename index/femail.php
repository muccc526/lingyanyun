<?php
$title = '发送邮件';
require_once('head.php');
if ($userrow['uid'] != 1) {
    exit("<script language='javascript'>window.location.href='login.php';</script>");
}
$uid = $_GET['uid'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="assets/layui/js/vue.js"></script>
    <script src="assets/layer/3.1.1/layer.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .main-container {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #1E9FFF;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            color: white; /* 确保标题文字为白色 */
        }
        .form-container {
            padding: 20px;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 5px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #007BFF;
            outline: none;
        }
        .recipient-group {
            display: flex;
            align-items: center;
            margin-top: 5px;
            margin-bottom: 20px;
        }
        .recipient-group label:first-child {
            margin-right: 10px;
        }
        .recipient-group input[type="radio"] {
            margin-right: 5px;
            margin-top: -2px; /* 微调单选按钮的垂直位置 */
        }
        .recipient-group label:not(:first-child) {
            margin-right: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease, box-shadow 0.3s ease; /* 添加 box-shadow 过渡 */
        }
        .btn-light {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ccc;
        }
        .btn-light:hover {
            background-color: #e2e6ea;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-warning {
            background-color: #ffc107;
            color: white;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn:active {
            transform: scale(0.95);
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .button-container .btn {
            margin-left: 15px;
        }
        .form-label i {
            margin-right: 5px;
        }

        /* 鼠标悬停时的悬浮效果 */
        .btn:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* 添加阴影效果 */
            transform: translateY(-2px); /* 向上移动 2px */
        }
    </style>
</head>

<body>
    <div id="orderlist">
        <div class="main-container">
            <div class="header">
                <h1>邮件发送系统</h1>
            </div>
            <div class="form-container">
                <form @submit.prevent="" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                    <div class="recipient-group form-group">
                        <label class="fs-6 form-label fw-boldest"><i class="fa-solid fa-user"></i> 收件人</label>
                        <input type="radio" id="to1" value="1" v-model="mailForm.to">
                        <label for="to1">直属代理</label>
                        <input type="radio" id="to2" value="2" v-model="mailForm.to">
                        <label for="to2">全部代理</label>
                    </div>
                    <div class="form-group">
                        <label class="fs-6 form-label fw-boldest"><i class="fa-solid fa-heading"></i> 邮件标题</label>
                        <input type="text" v-model="mailForm.title" class="form-control form-control-solid" placeholder="请输入邮件标题">
                    </div>
                    <div class="form-group">
                        <label class="fs-6 form-label fw-boldest"><i class="fa-solid fa-file-lines"></i> 邮件内容</label>
                        <textarea class="form-control form-control-solid" rows="8" v-model="mailForm.content" placeholder="请输入邮件内容"></textarea>
                    </div>
                    <div class="button-container">
                        <button type="button" @click="reset" class="btn btn-warning">重置内容</button>
                        <button type="button" class="btn btn-primary" @click="sendMail" id="kt_account_profile_details_submit">确认发送</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script>
        vm = new Vue({
            el: "#orderlist",
            data: {
                mailForm: {
                    to: '',
                    title: '',
                    content: ''
                },
            },
            methods: {
                sendMail: function () {
                    var postData = {
                        to: this.mailForm.to,
                        title: this.mailForm.title,
                        content: this.mailForm.content,
                    };
                    var load = layer.load(2);
                    this.$http.post("/apisub.php?act=fasongyoujian", postData, { emulateJSON: true }).then(function (response) {
                        layer.close(load);
                        if (response.data && response.data.code == 1) {
                            layer.msg('邮件发送成功', { icon: 1 });
                        } else {
                            layer.msg(response.data.msg, { icon: 2 });
                        }
                    });
                },
                reset: function () {
                    this.mailForm = { to: '', title: '', content: '' };
                }
            },
        });
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
</body>

</html>