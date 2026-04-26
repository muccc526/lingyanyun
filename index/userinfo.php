<?php
include('head.php');
?>
<style>
    .btn-floating {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .btn-floating:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
</style>
<div id="userindex">
    <div class="container-fluid p-t-15">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">个人资料</div>
                    <div class="card-body">
                        <div class="edit-avatar">
                            <img src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['user'];?>&spec=100" alt="..." class="img-avatar">
                            <div class="avatar-divider"></div>
                            <div class="clear">
                                <div v-if="row.name==''" class="h5 m-t-xs"><?=$conf['sitename'];?></div>
                                <div v-else class="h5 m-t-xs"><?=$userrow['name'];?></div>
                                <div class="text-muted">
                                    <span style="color:red;">UID: {{row.uid}}</span>（{{row.user}}）<br>
                                    <span style="color:green">KEY:</span>&nbsp;
                                    <span v-if="row.key==0">未开通 API 接口&nbsp;
                                        <button @click="ktapi" class="btn btn-xs btn-success">开通 KEY</button>
                                    </span>
                                    <span v-else>
                                        <span v-if="isKeyHidden">{{'*'.repeat(row.key.length)}}</span>
                                        <span v-else>{{row.key}}</span>
                                        <button @click="toggleKeyVisibility" class="btn btn-xs btn-primary btn-floating">
                                            {{isKeyHidden ? '显示 KEY' : '隐藏 KEY'}}
                                        </button>
                                        <button @click="ghapi" class="btn btn-xs btn-info btn-floating">更换 KEY</button>
                                        <button @click="gbapi" class="btn btn-xs btn-warning btn-floating">关闭 KEY</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form class="site-form">
                            <div class="form-group">
                                <label>UID</label>
                                <input type="text" class="form-control" :value="row.uid" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>用户名</label>
                                <input type="text" class="form-control" :value="row.user" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>剩余积分</label>
                                <input type="text" class="form-control" :value="row.money" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>总充值</label>
                                <input type="text" class="form-control" :value="row.zcz" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>费率</label>
                                <input type="text" class="form-control" :value="row.addprice" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>邀请码</label>
                                <input type="text" class="form-control" :value="row.yqm==''?'无':row.yqm" disabled="disabled" />
                            </div>
                            <div class="form-group">
                                <label>邀请费率</label>
                                <span class="btn btn-xs btn-success btn-floating" @click="szyqprice">设置</span>
                                <input type="text" class="form-control" :value="row.yqprice==''?'无':row.yqprice" disabled="disabled" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
<script src="assets/js/aes.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.min.js"></script>
<script type="text/javascript">
    var vm = new Vue({
        el: "#userindex",
        data: {
            row: null,
            inte: '',
            isKeyHidden: true
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
                layer.alert('请联系您的上级 QQ：' + this.row.sjuser + '，进行充值。（下级点充值，此处将显示您的 QQ）', { icon: 1, title: "温馨提示" });
            },
            ktapi: function () {
                layer.confirm('后台剩余积分满 300 积分可免费开通，反之需花费 10 积分开通', { title: '温馨提示', icon: 1,
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
                layer.confirm('确定更换 key 吗，更换之后原有的 key 将失效！', { title: '温馨提示', icon: 1,
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
            gbapi: function () {
                layer.confirm('确定关闭 key 吗，关闭之后无法使用对接功能！', { title: '温馨提示', icon: 1,
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
                layer.prompt({ title: '设置下级默认费率，首次自动生成邀请码', formType: 3 }, function (yqprice, index) {
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