<?php
$title = '工单系统';
require_once('head.php');
?>
<link rel="stylesheet" href="assets/css/element.css">
<style>
    .liclass {
        font-size: 14px;
        text-indent: 2em;
        margin: 5px;
    }
    .null {
        font-size: 18px;
        text-align: center;
    }
    .short-title {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .history-dialog {
        box-shadow: none;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        max-width: 600px;
        margin: 0 auto;
    }
    .history-content {
        padding: 15px;
        max-height: 400px;
        overflow-y: auto;
    }
</style>
<div class="app-content-body ">
    <div class="wrapper-md control" id="gdlist">
        <div class="col-sm-12">
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <div class="panel-heading font-bold " style="border-top-left-radius: 8px; border-top-right-radius: 8px;background-color:#fff;">
                        
                        <el-button type="primary" @click="showAddTicketForm">提交工单</el-button>
                        <el-dialog title="新增工单" :visible.sync="addTicketFormVisible" width="90%">
                            <el-form :model="newTicketForm">
                                <el-form-item label="请输入你遇到的“其它”问题（非已有订单的问题，订单问题前往订单详情处提交反馈）">
                                    <el-input type="textarea" v-model="newTicketForm.content"></el-input>
                                </el-form-item>
                            </el-form>
                            <div slot="footer" class="dialog-footer">
                                <el-button @click="addTicketFormVisible = false">取 消</el-button>
                                <el-button type="primary" @click="submitNewTicket">确 定</el-button>
                            </div>
                        </el-dialog>
                    </div>
                </div>
                <div class="text item">
                    <div class="search-box">
                        <div>
                            <el-input v-model="pushToken" placeholder="推送Token,留空关闭" style="width: 180px;"></el-input>&nbsp;
                            <el-button type="danger" size="big" @click="testPushToken">测试</el-button>
                            <el-button type="success" size="big" @click="savePushToken">保存</el-button>
                        </div><br>
                        <div>
                            <el-select v-model="statusFilter" placeholder="筛选状态" style="width: 300px;">
                                <el-option label="选择处理状态" value=""></el-option>
                                <el-option label="待回复" value="待回复"></el-option>
                                <el-option label="已回复" value="已回复"></el-option>
                                <el-option label="已完成" value="已完成"></el-option>
                            </el-select>
                            <el-input v-model="searchQuery" placeholder="可搜索订单ID/账号/密码/商品名" style="width: 300px;"></el-input>
                            <el-button type="primary" @click="get">搜索</el-button>
                        </div>
                    </div>
                    <div class="table-responsive" lay-size="sm" v-if="show == false">
                        <el-divider><span style="color:red">工单列表</span></el-divider>
                        <el-table ref="multipleTable" :data="order" size="small" header-cell-style="text-align:center;font-weight:1500" cell-style="text-align:center" empty-text=暂无反馈内容 highlight-current-row border>
                            <?php if ($userrow['uid'] == 1) { ?>
                                <el-table-column property="uid" label="提交者" width="100" sortable></el-table-column>
                            <?php } ?>
                            <el-table-column property="status" label="工单状态" width="100">
                                <template slot-scope="scope">
                                    <el-tag size="small" v-if="scope.row.state == '待处理'" effect="plain">{{ scope.row.state }}</el-tag>
                                    <el-tag type="success" size="small" v-else-if="scope.row.state == '已完成'" effect="plain">{{ scope.row.state }}</el-tag>
                                    <el-tag type="danger" size="small" v-else-if="scope.row.state == '已回复'" effect="plain">{{ scope.row.state }}</el-tag>
                                    <el-tag type="warning" size="small" v-else="" effect="plain">{{ scope.row.state }}</el-tag>
                                </template>
                            </el-table-column>
                            <?php if ($userrow['uid'] == 1) { ?>
                            <el-table-column label="操作" width="120">
                                <template slot-scope="scope">
                                    <el-dropdown trigger="click" @command="commandvalue">
                                        <el-button type="primary" size="mini" plain>
                                            操作<i class="el-icon-arrow-down el-icon--right"></i>
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-dropdown-item :command="{ gid: scope.row.gid, type: 'hf' }">回复</el-dropdown-item>
                                            <el-dropdown-item :command="{ gid: scope.row.gid, type: 'bh' }">完成</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </template>
                            </el-table-column>
                            <?php } ?>
                            <el-table-column label="历史对话详情" width="110">
                                <template slot-scope="scope">
                                    <el-button type="primary"  size="mini" @click="showHistoryDialog(scope.row)" plain>查看对话</el-button>
                                    <el-dialog :visible.sync="historyDialogVisible" width="80%" :before-close="handleClose" custom-class="history-dialog">
                                        <el-skeleton :rows="6" :loading="loading" animated>
                                            <div class="history-content" v-if="!loading">
                                                <div v-if="selectedTicket.title">
                                                    <h4>主题</h4>
                                                    <pre style="text-align: left;">{{ selectedTicket.title }}</pre>
                                                </div>
                                                <div v-if="selectedTicket.content">
                                                    <h4>聊天记录</h4>
                                                    <pre style="text-align: left;">{{ selectedTicket.content }}</pre>
                                                </div>
                                                <div v-if="selectedTicket.answer">
                                                    <h4>管理员回复历史（已弃用）</h4>
                                                    <pre>{{ selectedTicket.answer }}</pre>
                                                </div>
                                            </div>
                                        </el-skeleton>
                                        <span slot="footer" class="dialog-footer">
                                            <el-button @click="historyDialogVisible = false">关闭</el-button>
                                        </span>
                                    </el-dialog>
                                </template>
                            </el-table-column>
                            <el-table-column label="催促/追问" width="110">
                                <template slot-scope="scope">
                                    <el-popconfirm placement="top-start" confirm-button-text='确定' cancel-button-text='还是算了吧' cancel-button-type="danger" icon="el-icon-info" icon-color="red" title="是否要催促/追问这个工单" @confirm="toanswer(scope.row.gid)">
                                        <el-button type="success" size="mini" slot="reference" plain>追加提问</el-button>
                                    </el-popconfirm>
                                </template>
                            </el-table-column>
                            <el-table-column property="region" label="订单id" width="80" show-overflow-tooltip></el-table-column>
                            <el-table-column label="商品详细信息" width="280">
                                <template slot-scope="scope">
                                    <el-popover placement="top-start" trigger="click" width="400">
                                        <div>{{ scope.row.title }}</div>
                                        <span slot="reference" class="short-content">{{ scope.row.title | truncate(500) }}</span>
                                    </el-popover>
                                </template>
                            </el-table-column>
                            <el-table-column label="问题内容" width="280">
                                <template slot-scope="scope">
                                    <el-popover placement="top-start" trigger="click" width="400">
                                        <div>{{ scope.row.content }}</div>
                                        <span slot="reference" class="short-content">{{ scope.row.content | truncate(500) }}</span>
                                    </el-popover>
                                </template>
                            </el-table-column>
                            <el-table-column property="addtime" label="添加时间" width="100" sortable>
                            </el-table-column>
                            <el-table-column label="删除" width="140">
                                <template slot-scope="scope">
                                    <el-popconfirm placement="top-start" confirm-button-text='确定删除' cancel-button-text='我再想想' cancel-button-type="danger" icon="el-icon-info" icon-color="red" title="是否删除该条工单？" @confirm="shan(scope.row.gid)">
                                        <el-button type="danger" size="mini" slot="reference" plain>删除</el-button>
                                    </el-popconfirm>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </div>
                <div class="block">
                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page.sync="currentPage"
                        :pager-count="4"
                        layout="total,  prev, pager, next, jumper"
                        :total="total">
                    </el-pagination>
                </div>
            </el-card>
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
<script src="assets/js/element.js"></script>
<script>
    Vue.filter('truncate', function(value, length) {
        if (!value) return '';
        length = length || 20;
        if (value.length <= length) {
            return value;
        }
        return value.substring(0, length) + '...';
    });

    var vm = new Vue({
        el: "#gdlist",
        data: {
            row: null,
            show: false,
            ddsize: 'small',
            order: [],
            list: {
                region: '',
                title: '',
                content: '',
                answer: ''
            },
            form: {
                title: '',
                content: '',
                region: '',
            },
            rules: {
                region: [{
                    required: true,
                    message: '必填！',
                    trigger: 'blur'
                }],
                title: [{
                    required: true,
                    message: '必填！',
                    trigger: 'blur'
                }],
                content: [{
                    required: true,
                    message: '必填！',
                    trigger: 'blur'
                }]
            },
            searchQuery: '',
            statusFilter: '',
            isSearch: false,
            addTicketFormVisible: false,
            newTicketForm: {
                content: ''
            },
            pushToken: '',
            historyDialogVisible: false,
            selectedTicket: {},
            loading: true,
            currentPage: '1',
            pageSize: 10,
            total: '',
        },
        methods: {
            showHistoryDialog(row) {
                this.selectedTicket = row;
                this.loading = true;
                this.historyDialogVisible = true;
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000);
                });
            },
            handleClose(done) {
                this.selectedTicket = {};
                done();
            },
            showAddTicketForm() {
                this.addTicketFormVisible = true;
            },
            submitNewTicket() {
                var content = this.newTicketForm.content;
                this.$http.get("/gd.php?act=addTicket&content=" + encodeURIComponent(content)).then(function(response) {
                    if (response.data.code == 1) {
                        this.addTicketFormVisible = false;
                        this.get();
                        this.$message({
                            message: '工单新增成功',
                            type: 'success'
                        });
                    } else {
                        this.$message.error('工单新增失败');
                    }
                }).catch(function(error) {
                    console.error(error);
                    this.$message.error('工单新增失败');
                });
            },
            savePushToken() {
                var token = this.pushToken;
                this.$http.get("/gd.php?act=savePushToken&token=" + encodeURIComponent(token)).then(function(response) {
                    if (response.data.code == 1) {
                        this.$message({
                            message: '推送Token保存成功',
                            type: 'success'
                        });
                    } else {
                        this.$message.error('推送Token保存失败');
                    }
                }).catch(function(error) {
                    console.error(error);
                    this.$message.error('推送Token保存失败');
                });
            },
            getPushToken() {
                this.$http.get("/gd.php?act=getPushToken").then(function(response) {
                    if (response.data.code == 1) {
                        this.pushToken = response.data.token;
                        if (!this.pushToken) {
                            this.$alert('系统检测到您未绑定推送token！<br> 为了您正常使用本功能，请先进行绑定！<br> 敬请放心，我们不会向您推送任何敏感内容。', '警告', {
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
                        this.$message.error('获取推送Token失败');
                    }
                }).catch(function(error) {
                    console.error(error);
                    this.$message.error('获取推送Token失败');
                });
            },
            commandvalue(command) {
                if (command.type == 'hf') {
                    layer.prompt({
                        title: '工单回复',
                        formType: 2,
                        area: ['300px', '200px']
                    }, function(answer, index) {
                        layer.close(index);
                        var load = layer.load();
                        $.post("/gd.php?act=answer", {
                            gid: command.gid,
                            answer: answer
                        }, function(data) {
                            layer.close(load);
                            if (data.code == 1) {
                                layer.msg(data.msg, {
                                    icon: 1
                                });
                                vm.get();
                            } else {
                                layer.msg(data.msg, {
                                    icon: 2
                                });
                            }
                        });
                    });
                }
                if (command.type == 'bh') {
                    layer.prompt({
                        title: '工单完成信息',
                        formType: 2,
                        area: ['300px', '200px']
                    }, function(answer, index) {
                        layer.close(index);
                        var load = layer.load();
                        $.post("/gd.php?act=bohui", {
                            gid: command.gid,
                            answer: answer
                        }, function(data) {
                            layer.close(load);
                            if (data.code == 1) {
                                layer.msg(data.msg, {
                                    icon: 1
                                });
                                vm.get();
                            } else {
                                layer.msg(data.msg, {
                                    icon: 2
                                });
                            }
                        });
                    });
                }
            },
            handleSizeChange(val) {
                this.pageSize = val;
                this.get();
            },
            handleCurrentChange(val) {
                this.currentPage = val;
                this.get();
            },
            get: function() {
                var load = layer.load(2);
                var data = {
                    searchQuery: this.searchQuery,
                    statusFilter: this.statusFilter,
                    page: this.currentPage,
                    limit: this.pageSize
                };
                this.$http.post("/gd.php?act=gdlist", data, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(load);
                    if (data.data.code == 1) {
                        this.row = data.body;
                        this.order = data.body.data;
                        this.total = parseInt(data.body.total);
                        this.isSearch = false;
                    } else {
                        layer.msg(data.data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            shan: function(gid) {
                var loading = layer.load();
                $.post("/gd.php?act=shan", {
                    gid: gid
                }, function(data) {
                    layer.close(loading);
                    if (data.code == 1) {
                        layer.msg(data.msg, {
                            icon: 1
                        });
                        setTimeout(function() {
                            window.location.href = "";
                        }, 500);
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            testPushToken() {
        if (!this.pushToken) {
            this.$message.error('请先输入推送Token');
            return;
        }

        this.$http.get("/gd.php?act=testPushToken&token=" + encodeURIComponent(this.pushToken)).then(function(response) {
            if (response.data.code == 1) {
                this.$message({
                    message: '测试消息已发送',
                    type: 'success'
                });
            } else {
                this.$message.error('测试推送失败');
            }
        }).catch(function(error) {
            console.error(error);
            this.$message.error('测试推送失败');
        });
    },
            toanswer: function(gid) {
                layer.confirm('提交二次提问后<br>工单处理状态会更新为待回复<br>管理员会立即接收您的信息并尽快为您解答', {
                    title: '温馨提示',
                    icon: 1,
                    btn: ['继续', '取消']
                }, function() {
                    layer.prompt({
                        title: '请仔细描述您遇到的问题，我们会尽快为您处理',
                        formType: 2,
                        area: ['300px', '200px']
                    }, function(toanswer, index) {
                        layer.close(index);
                        var load = layer.load();
                        $.post("/gd.php?act=toanswer", {
                            gid: gid,
                            toanswer: toanswer
                        }, function(data) {
                            layer.close(load);
                            if (data.code == 1) {
                                layer.msg(data.msg, {
                                    icon: 1
                                });
                                setTimeout(function() {
                                    window.location.href = "";
                                }, 2000);
                            } else {
                                layer.msg(data.msg, {
                                    icon: 2
                                });
                            }
                        });
                    });
                });
            }
        },
        mounted() {
            this.get();
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