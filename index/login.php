<?php
include('../confing/function.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?=$conf['sitename']?></title>
    <meta name="keywords" content="<?=$conf['keywords'];?>" />
    <meta name="description" content="<?=$conf['description'];?>" />
    <link href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/layui/css/layui.css" />

    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        body {
            background-image: url("https://www.dmoe.cc/random.php");
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
        }

        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            padding: 40px;
            margin: 20px auto;
            transform: translate(-50%, -55%);
            background: rgba(0, 0, 0, .9);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
        }

        .login-box p:first-child {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus~label,
        .login-box .user-box input:valid~label {
            top: -20px;
            left: 0;
            color: #fff;
            font-size: 12px;
        }

        #button {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 3px
        }

        .login-box a:hover {
            background: #fff;
            color: #272727;
            border-radius: 5px;
        }

        .login-box a span {
            position: absolute;
            display: block;
        }

        .login-box a span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #fff);
            animation: btn-anim1 1.5s linear infinite;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }

            50%,
            100% {
                left: 100%;
            }
        }

        .login-box a span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #fff);
            animation: btn-anim2 1.5s linear infinite;
            animation-delay: .375s
        }

        @keyframes btn-anim2 {
            0% {
                top: -100%;
            }

            50%,
            100% {
                top: 100%;
            }
        }

        .login-box a span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #fff);
            animation: btn-anim3 1.5s linear infinite;
            animation-delay: .75s
        }

        @keyframes btn-anim3 {
            0% {
                right: -100%;
            }

            50%,
            100% {
                right: 100%;
            }
        }

        .login-box a span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #fff);
            animation: btn-anim4 1.5s linear infinite;
            animation-delay: 1.125s
        }

        @keyframes btn-anim4 {
            0% {
                bottom: -100%;
            }

            50%,
            100% {
                bottom: 100%;
            }
        }

        .login-box p:last-child {
            color: #aaa;
            font-size: 14px;
        }

        .login-box a.a2 {
            color: #fff;
            text-decoration: none;
        }

        .login-box a.a2:hover {
            background: transparent;
            color: #aaa;
            border-radius: 5px;
        }

        @media(max-width:760px) {
            .login-box {
                width: 90%;
                opacity: 0.9;
            }
        }

        a {
            color: black;
            text-decoration: none;
        }

       .denglu {
            position: absolute;
            right: 0;
            top: 0;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            background: rgba(0, 0, 0, 0);
            border: none;
            cursor: pointer;
            transition: .5s;
        }

       .denglu:hover {
            background: #fff;
            color: #272727;
            border-radius: 5px;
        }

       .denglu[disabled] {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <div id="login1">
        <div v-if="loginType" class="login-box">
            <p><?=$conf['sitename']?>-登录系统<a @click="newlogin" class="a2"></a></p>
            <div class="user-box">
                <input required="" v-model="dl.user" type="text">
                <label>账号</label>
            </div>
            <div class="user-box">
                <input required="" v-model="dl.pass" type="password">
                <label>密码</label>
                <p>还没有账号? <a @click="newlogin" class="a2">点击注册</a></p>
            </div>
            <a id="button" @click="login">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                登录系统
            </a>
            
        </div>
        <div v-else class="login-box">
            <p><?=$conf['sitename']?>-注册系统<a @click="newlogin" class="a2"></a></p>
            <div class="user-box">
                <input required="" v-model="reg.name" type="text">
                <label>昵称</label>
            </div>
            <div class="user-box">
                <input required="" v-model="reg.user" type="text">
                <label>QQ</label>
            </div>
            <div class="user-box">
                <input required="" v-model="reg.pass" type="password">
                <label>密码</label>
            </div>
            <div class="user-box">
                <input required="" v-model="reg.yqm" type="text">
                <label>邀请码</label>
            </div>
            <div class="user-box" v-if="isCaptchaEnabled">
                <input required="" v-model="reg.vercode" type="text">
                <label>验证码</label>
                <button type="button" class="denglu" :disabled="countdown > 0" @click="sendCode">
                    {{ countdown > 0 ? countdown + '秒后重试' : '发送验证码' }}
                </button>
                <p> 有账号了？ <a @click="newlogin" class="a2">返回登录</a></p>
            </div>
            <a id="button" @click="register">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                注册账号
            </a>
            
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="layer/3.1.1/layer.js"></script>
    <script src="assets/js/vue.min.js"></script>
    <script src="assets/js/vue-resource.min.js"></script>
    <script src="assets/js/axios.min.js"></script>
    <script>
            var vm = new Vue({
        el: "#login1",
        data: {
            loginType: true,
            title: "你在看什么呢？我写的代码好看吗",
            dl: {},
            reg: {
                vercode: ''
            },
            loginCaptchaSwitch: <?php echo $conf['yzmkg']; ?>, 
            countdown: 0,
            isSecondVerifyPopup: false 
        },
        computed: {
            isCaptchaEnabled: function () {
                return this.loginCaptchaSwitch === 1;
            }
        },
        methods: {
            newlogin: function () {
                this.loginType = !this.loginType
            },
            login: function () {
                if (!this.dl.user || !this.dl.pass) {
                    layer.msg('账号密码不能为空', {
                        icon: 2
                    });
                    return
                }
                var loading = layer.load();
                vm.$http.post("/apisub.php?act=login", {
                    user: this.dl.user,
                    pass: this.dl.pass
                }, {
                    emulateJSON: true
                }).then(function (data) {
                    layer.close(loading);
                    if (data.data.code == 1) {
                        layer.msg(data.data.msg, {
                            icon: 1
                        });
                        setTimeout(function () {
                            window.location.href = "mzsm.php"
                        }, 1000);
                    } else if (data.data.code == 5) {
                        vm.login2();
                    } else {
                        layer.msg(data.data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            register: function () {
                if (!this.reg.user || !this.reg.pass || !this.reg.name || !this.reg.yqm) {
                    layer.msg('所有项不能为空', {
                        icon: 2
                    });
                    return
                }
                if (this.isCaptchaEnabled && !this.reg.vercode) {
                    layer.msg('验证码不能为空', {
                        icon: 2
                    });
                    return
                }
                var loading = layer.load();
                this.$http.post("/apisub.php?act=register", {
                    name: this.reg.name,
                    user: this.reg.user,
                    pass: this.reg.pass,
                    yqm: this.reg.yqm,
                    vercode: this.reg.vercode  // 将验证码传递到后端
                }, {
                    emulateJSON: true
                }).then(function (data) {
                    layer.close(loading);
                    if (data.data.code == 1) {
                        this.loginType = true;
                        this.dl.user = this.reg.user;
                        this.dl.pass = this.reg.pass;
                        layer.msg(data.data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg(data.data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            sendCode: function () {
                if (!this.reg.user) {
                    layer.msg('请输入账号', {
                        icon: 2
                    });
                    return;
                }
                var loading = layer.load();
                this.$http.post("/code.php?act=send_code", {
                    user: this.reg.user
                }, {
                    emulateJSON: true
                }).then(function (data) {
                    layer.close(loading);
                    if (data.data.code == 1) {
                        layer.msg('验证码已发送', {
                            icon: 1
                        });
                        vm.countdown = 60;
                        var timer = setInterval(function () {
                            vm.countdown--;
                            if (vm.countdown <= 0) {
                                clearInterval(timer);
                            }
                        }, 1000);
                    } else {
                        layer.msg(data.data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            login2: function () {
                this.isSecondVerifyPopup = true; 
                layer.prompt({
                    title: '管理二次验证',
                    formType: 3
                }, function (pass2, index) {
                    var loading = layer.load();
                    vm.$http.post("/apisub.php?act=login", {
                        user: vm.dl.user,
                        pass: vm.dl.pass,
                        pass2: pass2
                    }, {
                        emulateJSON: true
                    }).then(function (data) {
                        layer.close(loading);
                        vm.isSecondVerifyPopup = false; 
                        if (data.data.code == 1) {
                            layer.msg(data.data.msg, {
                                icon: 1
                            });
                            setTimeout(function () {
                                window.location.href = "index.php"
                            }, 1000);
                        } else {
                            layer.msg(data.data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            }
        },
        mounted() {
            // 监听键盘事件
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' &&!this.isSecondVerifyPopup) { 
                    if (this.loginType) {
                        this.login();
                    } else {
                        this.register();
                    }
                }
            });
            layer.on('prompt', function (index, value, end) {
            });
        }
    });
    $('#connect_qq').click(function () {
        var ii = layer.load(0, {
            shade: [0.1, '#fff']
        });
        $.ajax({
            type: "POST",
            url: "../qq_login.php",
            data: {
                "type": 'qq'
            },
            dataType: 'json',
            success: function (data) {
                layer.close(ii);
                if (data.code == 1) {
                    window.location.href = data.url;
                } else {
                    layer.alert(data.msg, {
                        icon: 7
                    });
                }
            }
        });
    });
    var a_idx = 0;
    jQuery(document).ready(function ($) {
        $("body").click(function (e) {
            var a = new Array("富强", "民主", "文明", "和谐", "自由", "平等", "公正", "法治", "爱国", "敬业", "诚信", "友善");
            var $i = $("<span />").text(a[a_idx]);
            a_idx = (a_idx + 1) % a.length;
            var x = e.pageX,
                y = e.pageY;
            $i.css({
                "z-index": 999999999999999999999999999999999999999999999999999999999999999999999,
                "top": y - 20,
                "left": x,
                "position": "absolute",
                "font-weight": "bold",
                "color": "#ff6651"
            });
            $("body").append($i);
            $i.animate({
                "top": y - 180,
                "opacity": 0
            }, 1500, function () {
                $i.remove();
            });
        });
    });
    //禁止鼠标右击
    document.oncontextmenu = function () {
        event.returnValue = false;
    };
    //禁用开发者工具F12
    document.onkeydown = document.onkeyup = document.onkeypress = function (event) {
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
        devtools.toString = function () {
            checkStatus = "on";
        };
        setInterval(function () {
            checkStatus = "off";
            console.log(devtools);
            console.clear();
            if (checkStatus === "on") {
                let target = "";
                try {
                    window.open("about:blank", (target = "_self"));
                } catch (err) {
                    let a = document.createElement("button");
                    a.onclick = function () {
                        window.open("about:blank", (target = "_self"));
                    };
                    a.click();
                }
            }
        }, 200);
    } else {
        //禁用控制台
        let ConsoleManager = {
            onOpen: function () {
                alert("Console is opened");
            },
            onClose: function () {
                alert("Console is closed");
            },
            init: function () {
                let self = this;
                let x = document.createElement("div");
                let isOpening = false,
                    isOpened = false;
                Object.defineProperty(x, "id", {
                    get: function () {
                        if (!isOpening) {
                            self.onOpen();
                            isOpening = true;
                        }
                        isOpened = true;
                        return true;
                    }
                });
                setInterval(function () {
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
        ConsoleManager.onOpen = function () {
            let target = "";
            try {
                window.open("about:blank", (target = "_self"));
            } catch (err) {
                let a = document.createElement("button");
                a.onclick = function () {
                    window.open("about:blank", (target = "_self"));
                };
                a.click();
            }
        };
        ConsoleManager.onClose = function () {
            alert("Console is closed!!!!!");
        };
        ConsoleManager.init();
    }
    </script>
</body>

</html>