<?php
include('head.php');
$dailitongji = [
    'jrjd' => (int)$DB->count("SELECT COUNT(oid) FROM qingka_wangke_order WHERE uid='{$userrow['uid']}' AND DATE(addtime)=CURDATE()"),
    'dlzc' => (int)$DB->count("SELECT COUNT(id) FROM qingka_wangke_user WHERE uuid='{$userrow['uid']}' AND DATE(addtime)=CURDATE()"),
    'dlzs' => (int)$DB->count("SELECT COUNT(id) FROM qingka_wangke_user WHERE uuid='{$userrow['uid']}'")
];
?>
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
    }
    .stats-card {
        height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 15px; 
        transition: all 0.3s ease; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer; 
    }
    .stats-card:hover,
    .stats-card.clicked {
        transform: translateY(-5px); 
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); 
    }
   .btn,
   .badge {
        transition: all 0.3s ease; 
    }
   .btn:hover,
   .badge:hover {
        transform: translateY(-2px); 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); 
    }
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
        .stats-card {
            height: 100px;
        }
        .stats-value {
            font-size: 1.5rem !important;
        }
    }
   .layui-col-md6.layui-col-sm6.layui-col-xs12 .card {
        margin-left: 15px;
        margin-right: 15px;
    }
</style>

<div class="container-fluid" id="userindex">
    <div class="wrapper-md control">
        <div class="row">
            <div class="stats-grid">
                <div class="stats-card card bg-primary card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white opacity-75 mb-1">今日订单</h6>
                                <h3 class="text-white mb-0 stats-value"><?=$dailitongji['jrjd']?></h3>
                            </div>
                            <i class="mdi mdi-file-document display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="stats-card card bg-success card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white opacity-75 mb-1">全部订单</h6>
                                <h3 class="text-white mb-0 stats-value">{{row.dd ? row.dd : 0}}</h3>
                            </div>
                            <i class="mdi mdi-chart-line display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="stats-card card bg-danger card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white opacity-75 mb-1">新增代理</h6>
                                <h3 class="text-white mb-0 stats-value">{{row.dailitongji.dlzc}}</h3>
                            </div>
                            <i class="mdi mdi-account-plus display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card card bg-purple card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white opacity-75 mb-1">账户余额</h6>
                                <h3 class="text-white mb-0 stats-value">
                                    <?=number_format($userrow['money'], 2)?>
                                </h3>
                            </div>
                            <i class="mdi mdi-wallet display-4 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="layui-row layui-col-space10">

                    <div class="layui-col-md6 layui-col-sm6 layui-col-xs12">
                        <div class="card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 6px;">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a data-toggle="tab" href="#wdxx">基础信息</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" href="#sjtj">数据统计</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="wdxx">
                                    <li class="list-group-item">
                                        <div class="clearfix">
                                            <a class="pull-left thumb-md avatar b-3x m-r">
                                                <img src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['user'];?>&spec=100" class="img-circle" alt="User Image" />
                                            </a>
                                            <div class="clear">
                                                <div class="h5 m-t-xs"><?=$userrow['name'];?></div>
                                                <div v-else class="h5 m-t-xs">{{row.nickname}}</div>
                                                <div class="text-muted">
                                                    <span style="color:red;">UID: {{row.uid}}</span>（{{row.user}}）
                                                    <br>
                                                    <span style="color:green">KEY:</span>&nbsp;
                                                    <span v-if="row.key==0">未开通 API 接口&nbsp;&nbsp;<button @click="ktapi" class="btn btn-xs btn-success" style="border-radius: 5px;">开通 KEY</button>
                                                    </span>
                                                    <span v-else>
                                                        <span v-if="isKeyHidden">{{'*'.repeat(row.key.length)}}</span>
                                                        <span v-else>{{row.key}}</span>
                                                        <br>
                                                        <button @click="toggleKeyVisibility" class="btn btn-xs btn-primary" style="border-radius: 5px;">{{isKeyHidden ? '显示 KEY' : '隐藏 KEY'}}</button>
                                                        <button @click="ghapi" class="btn btn-xs btn-success" style="border-radius: 5px;">更换 KEY</button>
                                                        <button @click="copyKey(row.key)" class="btn btn-xs btn-primary" style="border-radius: 5px;">复制 KEY</button>
                                                        <button @click="closeapi" class="btn btn-xs btn-danger" style="border-radius: 5px;">关闭 KEY</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <ul>
                                        <?php if ($conf["sign_in_switch"] == "1") { ?>
                                        <li class="list-group-item"> 每日签到<a @click="checkIn" class="badge bg-success">点击签到</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <li class="list-group-item"> 账户余额<a href="#!" class="js-create-tab badge btn-primary" data-title="在线充值" data-url="pay">充值余额</a>
                                        </span>
                                        <span class="badge bg-success">&yen;{{row.money}}</span>
                                    </li>
                                    <li class="list-group-item"> 我的订单<a href="#!" class="js-create-tab badge btn-primary" data-title="订单列表" data-url="list">查看订单</a><span class="badge bg-primary">{{row.dd ? row.dd : 0}}单</span>
                                    </li>
                                    <li class="list-group-item"> 我的费率<a href="#!" class="js-create-tab badge bg-info" data-title="价格列表" data-url="myprice">查看价格</a>
                                        <span class="badge bg-info">{{row.addprice}}</span>
                                        </span>
                                    </li>
                                    <li class="list-group-item"> 累计充值<span class="badge bg-danger">&yen;{{row.zcz==null?'0':row.zcz}}</span>
                                    </li>
                                    <li class="list-group-item"> 邀请费率<span class="badge bg-warning" @click="szyqprice">设置费率</span>
                                        <span class="badge bg-warning">{{row.yqprice==''?'无':row.yqprice}}
                                    </li>
                                    <li class="list-group-item"> 邀请注册<span class="badge bg-warning">邀请码：{{row.yqm==''?'无':row.yqm}}</span>
                                    </li>

                                    <br />
                                </div>

                                <div class="tab-pane fade" id="sjtj">
                                    <li class="list-group-item">今日订单：<span class="badge bg-success">{{row.dailitongji.jrjd}}单</span>
                                    </li>
                                    <li class="list-group-item">全部订单：<span class="badge bg-success">{{row.dd ? row.dd : 0}}单</span>
                                    </li>
                                    <li class="list-group-item">新增代理：<span class="badge bg-success">{{row.dailitongji.dlzc}}人</span>
                                    </li>
                                    <li class="list-group-item">代理总数：<span class="badge bg-success">{{row.dailitongji.dlzs}}人</span>
                                    </li>
                                    <br />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6 layui-col-sm6 layui-col-xs12">
                        <div class="card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 5px;">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a data-toggle="tab" href="#home-basic">网站公告</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" href="#profile-basic">上级公告</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home-basic">
                                    <span v-html="row.notice"></span>
                                </div>
                                <div class="tab-pane fade" id="profile-basic">
                                    <span v-html="row.sjnotice"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    const cards = document.querySelectorAll('.stats-card');
                    cards.forEach(card => {
                        card.addEventListener('click', function () {
                            this.classList.toggle('clicked');
                        });
                    });
                });
            </script>
            <script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
            <script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
            <script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
            <script type="text/javascript" src="assets/LightYear/js/Chart.js"></script>
            <script src="assets/js/aes.js"></script>
            <script src="assets/js/vue.min.js"></script>
            <script src="assets/js/vue-resource.min.js"></script>
            <script src="assets/js/axios.min.js"></script>
            <script type="text/javascript">
                layer.open({
                    type: 1,
                    title: '公告',
                    content: '<div style="padding: 20px; line-height: 22px; background-color: #FFFFFF; color: #000; font-weight: 300px;">' + <?php echo json_encode($conf['tcgonggao']);?> + '</div>',
                    time: 15000,
                    btn: '好的明白',
                    btnAlign: 'c', // 按钮居中
                    shade: 0, // 不显示遮罩
                    area: ['300px']
                });
                function checkIn() {
                    layer.confirm(
                        "是否签到？",
                        {
                            title: "签到",
                            icon: 1,
                            btn: ["确定", "取消"] // 添加取消按钮
                        },
                        function () {
                            // 确定按钮的回调函数
                            var load = layer.load();
                            axios.get("/apisub.php?act=qiandao").then(function (response) {
                                layer.close(load);
                                if (response.data.code == 1) {
                                    layer.alert(
                                        response.data.msg,
                                        { icon: 1, title: "签到结果" },
                                        function () {
                                            setTimeout(function () {
                                                window.location.href = "";
                                            });
                                        }
                                    );
                                } else {
                                    layer.msg(response.data.msg, { icon: 2 });
                                }
                            }).catch(function (error) {
                                layer.close(load);
                                layer.msg("签到失败，请稍后再试", { icon: 2 });
                            });
                        },
                        function () {
                            // 取消按钮的回调函数
                            layer.msg("您取消了签到", { icon: 2 });
                        }
                    );
                }
            </script>
            <script type="text/javascript">
                var vm = new Vue({
                    el: "#userindex",
                    data: {
                        row: null,
                        inte: '',
                        isKeyHidden: true // 新增一个变量来控制 KEY 的显示和隐藏状态
                    },
                    methods: {
                        userinfo: function () {
                            var load = layer.load(2);
                            this.$http.post("/apisub.php?act=userinfo")
                                .then(function (data) {
                                    layer.close(load);
                                    if (data.data.code == 1) {
                                        this.row = data.data;
                                    } else {
                                        layer.alert(data.data.msg, { icon: 2 });
                                    }
                                });
                        },
                        yecz: function () {
                            layer.alert('请联系您的上级QQ：' + this.row.sjuser + '，进行充值。（下级点充值，此处将显示您的QQ）', { icon: 1, title: "温馨提示" });
                        },
                        ktapi: function () {
                            layer.confirm('后台余额满300元可免费开通，反之需花费10元开通', { title: '温馨提示', icon: 1,
                                btn: ['确定', '取消'] //按钮
                            }, function () {
                                var load = layer.load(2);
                                axios.get("/apisub.php?act=ktapi&type=1")
                                    .then(function (data) {
                                        layer.close(load);
                                        if (data.data.code == 1) {
                                            layer.alert(data.data.msg, { icon: 1, title: "温馨提示" }, function () {
                                                setTimeout(function () {
                                                    window.location.href = "";
                                                });
                                            });
                                        } else {
                                            layer.msg(data.data.msg, { icon: 2 });
                                        }
                                    });
                            });
                        },
                        ghapi: function () {
                            layer.confirm('确定更换key吗，更换之后之前的就不能用了', { title: '温馨提示', icon: 1,
                                btn: ['确定', '取消'] //按钮
                            }, function () {
                                var load = layer.load(2);
                                axios.get("/apisub.php?act=ktapi&type=3")
                                   .then(function (data) {
                                        layer.close(load);
                                        if (data.data.code == 1) {
                                            layer.alert(data.data.msg, { icon: 1, title: "温馨提示" }, function () {
                                                setTimeout(function () {
                                                    window.location.href = "";
                                                });
                                            });
                                        } else {
                                            layer.msg(data.data.msg, { icon: 2 });
                                        }
                                    });
                            });
                        },
                        copyKey(key) {
                            // Create a temporary input element
                            const tempInput = document.createElement('input');
                            // Set the input's value to the key
                            tempInput.value = key;
                            // Append the input to the body
                            document.body.appendChild(tempInput);
                            // Select the input's value
                            tempInput.select();
                            // Copy the selected value to the clipboard
                            document.execCommand('copy');
                            // Remove the temporary input from the body
                            document.body.removeChild(tempInput);
                            // Show a success message
                            layer.msg('KEY已复制到剪贴板', { icon: 1, time: 1000 }); // Display a message using the existing layer.msg function
                        },
                        closeapi: function () {
                            layer.confirm('确定关闭KEY吗，关闭之后的你对接服务将不能使用', { title: '温馨提示', icon: 1,
                                btn: ['确定', '取消'] //按钮
                            }, function () {
                                var load = layer.load(2);
                                axios.get("/apisub.php?act=ktapi&type=4")
                                   .then(function (data) {
                                        layer.close(load);
                                        if (data.data.code == 1) {
                                            layer.alert(data.data.msg, { icon: 1, title: "温馨提示" }, function () {
                                                setTimeout(function () {
                                                    window.location.href = "";
                                                });
                                            });
                                        } else {
                                            layer.msg(data.data.msg, { icon: 2 });
                                        }
                                    });
                            });
                        },
                        szyqprice: function () {
                            layer.prompt({ title: '设置邀请费率，首次设置将自动生成邀请码', formType: 3 }, function (yqprice, index) {
                                layer.close(index);
                                var load = layer.load(2);
                                $.post("/apisub.php?act=yqprice", { yqprice }, function (data) {
                                    layer.close(load);
                                    if (data.code == 1) {
                                        vm.userinfo();
                                        layer.alert(data.msg, { icon: 1 });
                                    } else {
                                        layer.msg(data.msg, { icon: 2 });
                                    }
                                });
                            });
                        },
                        connect_qq: function () {
                            var ii = layer.load(0, {
                                shade: [0.1, '#fff']
                            });
                            $.ajax({
                                type: "POST",
                                url: "../qq_login.php",
                                data: { "type": 'qq' },
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
                        },
                        szgg: function () {
                            layer.prompt({ title: '设置代理公告，您的代理可看到', formType: 2 }, function (notice, index) {
                                layer.close(index);
                                var load = layer.load(2);
                                $.post("/apisub.php?act=user_notice", { notice }, function (data) {
                                    layer.close(load);
                                    if (data.code == 1) {
                                        vm.userinfo();
                                        layer.msg(data.msg, { icon: 1 });
                                    } else {
                                        layer.msg(data.msg, { icon: 2 });
                                    }
                                });
                            });
                        },
                        toggleKeyVisibility: function () {
                            this.isKeyHidden = !this.isKeyHidden;
                        }
                    },
                    mounted() {
                        this.userinfo();
                    }
                });
            </script>    