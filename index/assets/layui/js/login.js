
    var vm = new Vue({
        el: "#login1",
        data: {
            loginType: true,
            title: "你在看什么呢？我写的代码好看吗",
            dl: {},
            reg: {},
            input:'',
        },
        methods: {
            newlogin: function() {
                this.loginType = !this.loginType
            },
            login: function() {
                if (!this.dl.user || !this.dl.pass) {
                    this.$message.error('账号密码不能为空！');
                    return
                }
                var loading = layer.load();
                vm.$http.post("/apisub.php?act=login", {
                    user: this.dl.user,
                    pass: this.dl.pass
                }, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(loading);
                    if (data.data.code == 1) {
                        this.$message({message: '靓仔，欢迎回家！',type: 'success'});
                        setTimeout(function() {
                            window.location.href = "index.php"
                        }, 1000);
                    } else if (data.data.code == 5) {
                        vm.login2();
                    } else {
                        this.$message.error(data.data.msg);
                    }
                });

            },
            register: function() {
                if (!this.reg.user || !this.reg.pass || !this.reg.name || !this.reg.yqm) {
                    this.$message.error('所有项目不能为空！');
                    return
                }
                var loading = layer.load();
                this.$http.post("/apisub.php?act=register", {
                    name: this.reg.name,
                    user: this.reg.user,
                    pass: this.reg.pass,
                    yqm: this.reg.yqm
                }, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(loading);
                    if (data.data.code == 1) {
                        this.loginType = true;
                        this.dl.user = this.reg.user;
                        this.dl.pass = this.reg.pass;
                        this.$message.success(data.data.msg);
                    } else {
                        this.$message.error(data.data.msg);
                    }
                });
            },
            login2: function() {
                layer.prompt({
                    title: '管理二次验证',
                    formType: 3
                }, function(pass2, index) {
                    var loading = layer.load();
                    vm.$http.post("/apisub.php?act=login", {
                        user: vm.dl.user,
                        pass: vm.dl.pass,
                        pass2: pass2
                    }, {
                        emulateJSON: true
                    }).then(function(data) {
                        layer.close(loading);
                        if (data.data.code == 1) {
                            this.$message({message: data.data.msg,type: 'success'});
                            setTimeout(function() {
                                window.location.href = "index.php"
                            }, 1000);
                        } else {
                            this.$message.error(data.data.msg);
                        }
                    });
                });
            }
        }
    });

    $('#connect_qq').click(function() {
        var ii = layer.load(0, {
            shade: [0.1, '#fff']
        });
        $.ajax({
            type: "POST",
            url: "../apisub.php?act=connect",
            data: {},
            dataType: 'json',
            success: function(data) {
                layer.close(ii);
                if (data.code == 0) {
                    window.location.href = data.url;
                } else {
                    layer.alert(data.msg, {
                        icon: 7
                    });
                }
            }
        });
    });