<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>通知设置</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/vue.min.js"></script>
    <script src="assets/js/vue-resource.min.js"></script>
    <script src="assets/js/axios.min.js"></script>
    <script src="assets/js/aes.js"></script>
    <script src="assets/js/index.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.min.js"></script>
    <style>
      .notification-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

      .button-container {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <?php
    include('head.php');
    ?>
    <div id="userindex">
        <div class="container-fluid p-t-15">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">通知设置</div>
                        <div class="card-body">
                            <div class="notification-section">

                                <div class="form-group notification-item">
                                    <!-- 订单完成通知 -->
                                    <label>订单完成通知：</label>
                                    <span v-if="row.wctzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.wctzkg!== 'on'" @click="wctzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.wctzkg === 'on'" @click="wctzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 订单异常通知 -->
                                    <label>订单异常通知：</label>
                                    <span v-if="row.yctzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.yctzkg!== 'on'" @click="yctzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.yctzkg === 'on'" @click="yctzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 登陆通知 -->
                                    <label>后台登陆通知：</label>
                                    <span v-if="row.dltzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.dltzkg!== 'on'" @click="dltzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.dltzkg === 'on'" @click="dltzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 数据通知 -->
                                    <label>每日数据通知：</label>
                                    <span v-if="row.sjtzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.sjtzkg!== 'on'" @click="sjtzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.sjtzkg === 'on'" @click="sjtzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 登陆失败通知 -->
                                    <label>登录失败通知：</label>
                                    <span v-if="row.dlsbtzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.dlsbtzkg!== 'on'" @click="dlsbtzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.dlsbtzkg === 'on'" @click="dlsbtzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 修改密码通知 -->
                                    <label>修改密码通知：</label>
                                    <span v-if="row.xgmmtzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.xgmmtzkg!== 'on'" @click="xgmmtzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.xgmmtzkg === 'on'" @click="xgmmtzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 邀请注册通知 -->
                                    <label>邀请注册通知：</label>
                                    <span v-if="row.dlzctzkg === 'on'">已开启</span>
                                    <span v-else>已关闭</span>
                                    <div class="button-container">
                                        <button v-if="row.dlzctzkg!== 'on'" @click="dlzctzkgkgOpen" class="el-button btn-sm btn-success">开启</button>
                                        <button v-if="row.dlzctzkg === 'on'" @click="dlzctzkgkgClose" class="el-button btn-sm btn-danger">关闭</button>
                                    </div>
                                </div>
                                <div class="form-group notification-item">
                                    <!-- 推送 Token 设置 -->
                                    <label>推送 Token 设置：</label>
                                    <div>
                                        <el-input v-model="pushToken" placeholder="推送 Token,留空关闭" style="width: 180px;"></el-input>
                                        <el-button type="danger" size="big" @click="testPushToken">测试</el-button>
                                        <el-button type="success" size="big" @click="savePushToken">保存</el-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var vm = new Vue({
            el: "#userindex",
            data: {
                row: {
                    wctzkg: 'off',
                    yctzkg: 'off',
                    dltzkg: 'off',
                    sjtzkg: 'off',
                    dlsbtzkg: 'off',
                    czcgtzkg: 'off',
                    xgmmtzkg: 'off',
                    dlzctzkg: 'off',
                    tktzkg: 'off',
                    uid: null 
                },
                inte: '',
                pushToken: ''
            },
            methods: {
                checkToken: function() {
                    if (!this.pushToken) {
                        this.$message.error('请先绑定推送 Token 才能开启相关通知');
                        return false;
                    }
                    return true;
                },
                userinfo: function() {
                    var load = layer.load(2);
                    this.$http.post("/apisub.php?act=userinfo")
                      .then(function(data) {
                            layer.close(load);
                            if (data.data.code == 1) {
                                this.row = data.data;
                            } else {
                                layer.alert(data.data.msg, { icon: 2 });
                            }
                        });
                },
                wctzkgkgOpen: function() {
                    if (!this.checkToken()) return;
                    const uid = this.row.uid;
                    axios.post("/apisub.php?act=wctzkgkzOpen", {
                        uid: uid
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    })
                      .then(response => {
                            if (response.data.code === 1) {
                                this.row.wctzkg = 'on';
                                layer.msg('订单完成通知已开启', { icon: 6 });
                            } else {
                                layer.msg(response.data.msg || '开启失败', { icon: 2 });
                            }
                        })
                      .catch(error => {
                            layer.msg('请求失败，请稍后再试', { icon: 2 });
                            console.error('请求失败:', error);
                        });
                },
                wctzkgkgClose: function() {
                    this.$confirm('确定要关闭订单完成通知吗？', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        const uid = this.row.uid;
                        axios.post("/apisub.php?act=wctzkgkzClose", {
                            uid: uid
                        }, {
                            headers: { 'Content-Type': 'application/json' }
                        })
                          .then(response => {
                                if (response.data.code === 1) {
                                    this.row.wctzkg = 'off';
                                    layer.msg('订单完成通知已关闭', { icon: 5 });
                                } else {
                                    layer.msg(response.data.msg || '关闭失败', { icon: 2 });
                                }
                            })
                          .catch(error => {
                                layer.msg('请求失败，请稍后再试', { icon: 2 });
                                console.error('请求失败:', error);
                            });
                    }).catch(() => {
                    });
                },
                yctzkgkgOpen: function() {
                    if (!this.checkToken()) return;
                    const uid = this.row.uid;
                    axios.post("/apisub.php?act=yctzkgkzOpen", {
                        uid: uid
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    })
                      .then(response => {
                            if (response.data.code === 1) {
                                this.row.yctzkg = 'on';
                                layer.msg('订单异常通知已开启', { icon: 6 });
                            } else {
                                layer.msg(response.data.msg || '开启失败', { icon: 2 });
                            }
                        })
                      .catch(error => {
                            layer.msg('请求失败，请稍后再试', { icon: 2 });
                            console.error('请求失败:', error);
                        });
                },
                yctzkgkgClose: function() {
                    this.$confirm('确定要关闭订单异常通知吗？', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        const uid = this.row.uid;
                        axios.post("/apisub.php?act=yctzkgkzClose", {
                            uid: uid
                        }, {
                            headers: { 'Content-Type': 'application/json' }
                        })
                          .then(response => {
                                if (response.data.code === 1) {
                                    this.row.yctzkg = 'off';
                                    layer.msg('订单异常通知已关闭', { icon: 5 });
                                } else {
                                    layer.msg(response.data.msg || '关闭失败', { icon: 2 });
                                }
                            })
                          .catch(error => {
                                layer.msg('请求失败，请稍后再试', { icon: 2 });
                                console.error('请求失败:', error);
                            });
                    }).catch(() => {
                    });
                },
                dltzkgkgOpen: function() {
                    if (!this.checkToken()) return;
                    const uid = this.row.uid;
                    axios.post("/apisub.php?act=dltzkgkzOpen", {
                        uid: uid
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    })
                      .then(response => {
                            if (response.data.code === 1) {
                                this.row.dltzkg = 'on';
                                layer.msg('后台登陆通知已开启', { icon: 6 });
                            } else {
                                layer.msg(response.data.msg || '开启失败', { icon: 2 });
                            }
                        })
                      .catch(error => {
                            layer.msg('请求失败，请稍后再试', { icon: 2 });
                            console.error('请求失败:', error);
                        });
                },
                dltzkgkgClose: function() {
                    this.$confirm('确定要关闭后台登陆通知吗？', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        const uid = this.row.uid;
                        axios.post("/apisub.php?act=dltzkgkzClose", {
                            uid: uid
                        }, {
                            headers: { 'Content-Type': 'application/json' }
                        })
                          .then(response => {
                                if (response.data.code === 1) {
                                    this.row.dltzkg = 'off';
                                    layer.msg('后台登陆通知已关闭', { icon: 5 });
                                } else {
                                    layer.msg(response.data.msg || '关闭失败', { icon: 2 });
                                }
                            })
                          .catch(error => {
                                layer.msg('请求失败，请稍后再试', { icon: 2 });
                                console.error('请求失败:', error);
                            });
                    }).catch(() => {
                    });
                },
                sjtzkgkgOpen: function() {
                    if (!this.checkToken()) return;
                    const uid = this.row.uid;
                    axios.post("/apisub.php?act=sjtzkgkzOpen", {
                        uid: uid
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    })
                      .then(response => {
                            if (response.data.code === 1) {
                                this.row.sjtzkg = 'on';
                                layer.msg('每日数据通知已开启', { icon: 6 });
                            } else {
                                layer.msg(response.data.msg || '开启失败', { icon: 2 });
                            }
                        })
                      .catch(error => {
                            layer.msg('请求失败，请稍后再试', { icon: 2 });
                            console.error('请求失败:', error);
                        });
                },
                sjtzkgkgClose: function() {
    this.$confirm('确定要关闭每日数据通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
        const uid = this.row.uid;
        axios.post("/apisub.php?act=sjtzkgkzClose", {
            uid: uid
        }, {
            headers: { 'Content-Type': 'application/json' }
        })
          .then(response => {
                if (response.data.code === 1) {
                    this.row.sjtzkg = 'off';
                    layer.msg('每日数据通知已关闭', { icon: 5 });
                } else {
                    layer.msg(response.data.msg || '关闭失败', { icon: 2 });
                }
            })
          .catch(error => {
                layer.msg('请求失败，请稍后再试', { icon: 2 });
                console.error('请求失败:', error);
            });
    }).catch(() => {
    });
},
dlsbtzkgkgOpen: function() {
    if (!this.checkToken()) return;
    const uid = this.row.uid;

    axios.post("/apisub.php?act=dlsbtzkgkzOpen", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.dlsbtzkg = 'on'; // 更新本地状态
            layer.msg('登录失败通知已开启', { icon: 6});
        } else {
            layer.msg(response.data.msg || '开启失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
},

dlsbtzkgkgClose: function() {
        this.$confirm('确定要关闭登陆失败通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
    const uid = this.row.uid;

    axios.post("/apisub.php?act=dlsbtzkgkzClose", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.dlsbtzkg = 'off'; // 更新本地状态
            layer.msg('登录失败通知已关闭', { icon: 5 });
        } else {
            layer.msg(response.data.msg || '关闭失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
}).catch(() => {
    });
},
czcgtzkgkgOpen: function() {
    if (!this.checkToken()) return;
    const uid = this.row.uid;

    axios.post("/apisub.php?act=czcgtzkgkzOpen", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.czcgtzkg = 'on'; // 更新本地状态
            layer.msg('充值成功通知已开启', { icon: 1 });
        } else {
            layer.msg(response.data.msg || '开启失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
},

czcgtzkgkgClose: function() {
        this.$confirm('确定要关闭充值成功通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
    const uid = this.row.uid;

    axios.post("/apisub.php?act=czcgtzkgkzClose", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.czcgtzkg = 'off'; // 更新本地状态
            layer.msg('充值成功通知已关闭', { icon: 5 });
        } else {
            layer.msg(response.data.msg || '关闭失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
}).catch(() => {
    });
},
xgmmtzkgkgOpen: function() {
     if (!this.checkToken()) return;
    const uid = this.row.uid;

    axios.post("/apisub.php?act=xgmmtzkgkzOpen", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.xgmmtzkg = 'on'; // 更新本地状态
            layer.msg('修改密码通知已开启', { icon: 6 });
        } else {
            layer.msg(response.data.msg || '开启失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
},

xgmmtzkgkgClose: function() {
    this.$confirm('确定要关闭修改密码通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
    const uid = this.row.uid;

    axios.post("/apisub.php?act=xgmmtzkgkzClose", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.xgmmtzkg = 'off'; // 更新本地状态
            layer.msg('修改密码通知已关闭', { icon: 5 });
        } else {
            layer.msg(response.data.msg || '关闭失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
}).catch(() => {
    });
},
dlzctzkgkgOpen: function() {
    if (!this.checkToken()) return;
    const uid = this.row.uid;

    axios.post("/apisub.php?act=dlzctzkgkzOpen", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.dlzctzkg = 'on'; // 更新本地状态
            layer.msg('邀请注册通知已开启', { icon: 6 });
        } else {
            layer.msg(response.data.msg || '开启失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
},

dlzctzkgkgClose: function() {
        this.$confirm('确定要关闭邀请注册通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
    const uid = this.row.uid;

    axios.post("/apisub.php?act=dlzctzkgkzClose", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.dlzctzkg = 'off'; // 更新本地状态
            layer.msg('邀请注册通知已关闭', { icon: 5 });
        } else {
            layer.msg(response.data.msg || '关闭失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
}).catch(() => {
    });
},
tktzkgkgOpen: function() {
    if (!this.checkToken()) return;
    const uid = this.row.uid;

    axios.post("/apisub.php?act=tktzkgkzOpen", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.tktzkg = 'on'; // 更新本地状态
            layer.msg('退款通知已开启', { icon: 6 });
        } else {
            layer.msg(response.data.msg || '开启失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
},

// 关闭退款通知
tktzkgkgClose: function() {
        this.$confirm('确定要关闭退款通知吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(() => {
    const uid = this.row.uid;

    axios.post("/apisub.php?act=tktzkgkzClose", {
        uid: uid
    }, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.data.code === 1) {
            this.row.tktzkg = 'off'; // 更新本地状态
            layer.msg('退款通知已关闭', { icon: 5 });
        } else {
            layer.msg(response.data.msg || '关闭失败', { icon: 2 });
        }
    })
    .catch(error => {
        layer.msg('请求失败，请稍后再试', { icon: 2 });
        console.error('请求失败:', error);
    });
    }).catch(() => {
    });
},
savePushToken: function() {
    var token = this.pushToken;
    this.$http.get("/gd.php?act=savePushToken&token=" + encodeURIComponent(token)).then((response) => {
        if (response.data.code == 1) {
            this.$message({
                message: '推送 Token 保存成功',
                type: 'success'
            });
        } else {
            this.$message.error('推送 Token 保存失败');
        }
    }).catch((error) => {
        console.error(error);
        this.$message.error('推送 Token 保存失败');
    });
},
getPushToken: function() {
    this.$http.get("/gd.php?act=getPushToken").then((response) => {
        if (response.data.code == 1) {
            this.pushToken = response.data.token;
            if (!this.pushToken) {
                this.$alert('系统检测到您未绑定推送 token！<br> 为了您正常使用本功能，请先进行绑定！<br> 敬请放心，我们不会向您推送任何敏感内容。', '警告', {
                    confirmButtonText: '我已知晓',
                    showClose: false,
                    dangerouslyUseHTMLString: true,
                    callback: action => {
                        this.$alert(' <div style="padding: 20px; text-align: center;"><img src="https://wxpusher.zjiecode.com/api/qrcode/RwjGLMOPTYp35zSYQr0HxbCPrV9eU0wKVBXU1D5VVtya0cQXEJWPjqBdW3gKLifS.jpg" alt="二维码" style="max-width: 100%; height: auto; max-height: 100px;"><br>1、打开微信并扫码关注公众号<br> 2、推送公众号会向您发送“你的 SPT...push token)为：___”<br> 请将“SPT”开头的推送 token（包括 SPT）填入输入框中，点击保存即可完成绑定', '绑定教程', {
                            confirmButtonText: '我学会了',
                            showClose: false,
                            dangerouslyUseHTMLString: true,
                            callback: action => {}
                        });
                    }
                });
            }
        } else {
            this.$message.error('获取推送 Token 失败');
        }
    }).catch((error) => {
        console.error(error);
        this.$message.error('获取推送 Token 失败');
    });
},
testPushToken: function() {
    if (!this.pushToken) {
        this.$message.error('请先输入推送 Token');
        return;
    }
    this.$http.get("/gd.php?act=testPushToken&token=" + encodeURIComponent(this.pushToken)).then((response) => {
        if (response.data.code == 1) {
            this.$message({
                message: '测试消息已发送',
                type: 'success'
            });
        } else {
            this.$message.error('测试推送失败');
        }
    }).catch((error) => {
        console.error(error);
        this.$message.error('测试推送失败');
    });
}
},
mounted: function() {
    this.userinfo();
    this.getPushToken();
}
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
