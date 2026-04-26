<?php
$title='编辑用户密价';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}

$uid=$_GET['uid'];
?>
     <div class="app-content-body ">
    <div class="wrapper-md control" id="orderlist">
        <div class="panel panel-default" >
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">密价列表&nbsp;<button class="btn btn-xs btn-light" data-toggle="modal" data-target="#modal-add">添加</button></div>
            <div class="panel-body">
                <label for="keyword">按商品搜索</label>
                <el-select id="select" v-model="cx.cid" filterable placeholder="选择商品" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
                    <el-option label="输入关键词搜索并选择商品" value=""></el-option>
                    <?php
                        $a = $DB->query("select * from qingka_wangke_class");
                        while ($row = $DB->fetch($a)) {
                            echo '<el-option label="' . $row['name'] . '" value="' . $row['cid'] . '"></el-option>';
                        }
                    ?>
                </el-select>
                <div class="form-group">
                    <label for="keyword">按用户搜索</label>
                    <input type="text" class="form-control" v-model="search.keyword" placeholder="请输入用户UID">
                </div>
                <button class="btn btn-primary" @click="get(1, search.keyword, cx.cid)">查询</button>
                <button class="btn btn-warning" @click="confirmBatchUpdate">批量修改</button>
                <button class="btn btn-danger" @click="confirmBatchDelete">批量删除</button>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" v-model="isAllChecked" @change="checkAll"></th>
                                <th>MID</th>
                                <th>UID</th>
                                <th>课程</th>
                                <th>类型</th>
                                <th>金额/倍数</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(res, index) in row.data">
                                <td><input type="checkbox" v-model="checkedItems[index]" @change="updateSelectedRows"></td>
                                <td>{{res.mid}}</td>
                                <td>{{res.uid}}</td>
                                <td>[{{res.cid}}] {{res.name}}</td>
                                <td><span v-if="res.mode==0">价格的基础上扣除</span><span v-if="res.mode==1">倍数的基础上扣除</span><span v-if="res.mode==2">直接定价</span></td>
                                <td><input type="text" v-model="res.price" class="form-control"></td>
                                <td>{{res.addtime}}</td>
                                <td>
                                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-update" @click="upm=res">编辑</button>
                                    &nbsp;<button class="btn btn-xs btn-danger"  @click="confirmDelete(res.mid)">删除</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination" v-if="row.last_page>1"><!--by 青卡 Vue分页 -->
                    <li class="disabled"><a @click="get(1, search.keyword, cx.cid)">首页</a></li>
                    <li class="disabled"><a @click="row.current_page>1?get(row.current_page-1, search.keyword, cx.cid):''">&laquo;</a></li>
                    <li @click="get(row.current_page-3, search.keyword, cx.cid)" v-if="row.current_page-3>=1"><a>{{ row.current_page-3 }}</a></li>
                    <li @click="get(row.current_page-2, search.keyword, cx.cid)" v-if="row.current_page-2>=1"><a>{{ row.current_page-2 }}</a></li>
                    <li @click="get(row.current_page-1, search.keyword, cx.cid)" v-if="row.current_page-1>=1"><a>{{ row.current_page-1 }}</a></li>
                    <li :class="{'active':row.current_page==row.current_page}" @click="get(row.current_page, search.keyword, cx.cid)" v-if="row.current_page"><a>{{ row.current_page }}</a></li>
                    <li @click="get(row.current_page+1, search.keyword, cx.cid)" v-if="row.current_page+1<=row.last_page"><a>{{ row.current_page+1 }}</a></li>
                    <li @click="get(row.current_page+2, search.keyword, cx.cid)" v-if="row.current_page+2<=row.last_page"><a>{{ row.current_page+2 }}</a></li>
                    <li @click="get(row.current_page+3, search.keyword, cx.cid)" v-if="row.current_page+3<=row.last_page"><a>{{ row.current_page+3 }}</a></li>
                    <li class="disabled"><a @click="row.last_page>row.current_page?get(row.current_page+1, search.keyword, cx.cid):''">&raquo;</a></li>
                    <li class="disabled"><a @click="get(row.last_page, search.keyword, cx.cid)">尾页</a></li>
                </ul>
            </div>
        </div>

        <div class="modal fade primary" id="modal-update">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">密价修改</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-update">
                            <input type="hidden" name="action" value="update"/>
                            <input type="hidden" name="cid" :value="storeInfo.cid"/>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">UID</label>
                                <div class="col-sm-9">
                                    <input type="text" v-model="upm.uid" class="form-control" :value="upm.uid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">商品</label>
                                <div class="col-sm-9">
                                    <select v-model="upm.cid" class="form-control">
                                        <?php
                                            $a=$DB->query("select * from qingka_wangke_class where status=1");
                                            while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['cid'].'">['.$b['cid'].'] '.$b['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">类型</label>
                                <div class="col-sm-9">
                                    <select v-model="upm.mode" class="form-control">
                                        <option value="0">价格的基础上扣除</option>
                                        <option value="1">倍数的基础上扣除</option>
                                        <option value="2">直接定价</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">金额/倍数</label>
                                <div class="col-sm-9">
                                    <input type="text" v-model="upm.price" class="form-control" :value="upm.price" >
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="up_m">确定</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade primary" id="modal-add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">密价添加</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-add">
                            <input type="hidden" name="action" value="add"/>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">UID</label>
                                <div class="col-sm-9">
                                    <input type="text" v-model="addm.uid" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">商品ID</label>
                                <div class="col-sm-9">
                                    <select v-model="addm.cid" class="form-control">
                                        <?php
                                            $a=$DB->query("select * from qingka_wangke_class where status=1");
                                            while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['cid'].'">['.$b['cid'].'] '.$b['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">类型</label>
                                <div class="col-sm-9">
                                    <select v-model="addm.mode" class="form-control">
                                        <option value="0">价格的基础上扣除</option>
                                        <option value="1">倍数的基础上扣除</option>
                                        <option value="2">直接定价</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">金额/倍数</label>
                                <div class="col-sm-9">
                                    <input type="text" v-model="addm.price"class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="add_m">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php");?>
<script src="assets/js/element.js"></script>
<script>
vm = new Vue({
    el: "#orderlist",
    data: {
        row: null,
        uid: "<?php echo $uid ?>",
        storeInfo: {},
        addm: {
            uid: "<?php echo $uid ?>"
        },
        upm: {},
        search: {
            keyword: ""
        },
        cx: {
            cid: ""
        },
        isAllChecked: false, 
        checkedItems: [], 
        selectedRows: [] 
    },
    methods: {
        get: function (page, uid = '', cid = '') {
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=mijialist", { page: page, uid: uid, cid: cid }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.row = data.body;
                    this.checkedItems = new Array(this.row.data.length).fill(false);
                    this.selectedRows = [];
                    this.isAllChecked = false;
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        add_m: function () {
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=mijia", { data: this.addm, active: 1 }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.get(1);
                    layer.msg(data.data.msg, { icon: 1 });
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        up_m: function () {
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=mijia", { data: this.upm, active: 2 }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.get(1);
                    layer.msg(data.data.msg, { icon: 1 });
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        del: function (mid) {
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=mijia_del", { mid: mid }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.get(1);
                    layer.msg(data.data.msg, { icon: 1 });
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        batchUpdate: function () {
            if (this.selectedRows.length === 0) {
                layer.msg("请选择要批量修改的行", { icon: 2 });
                return;
            }
            var updates = [];
            this.selectedRows.forEach(mid => {
                var row = this.row.data.find(item => item.mid === mid);
                if (row) {
                    updates.push({
                        mid: row.mid,
                        newPrice: row.price
                    });
                }
            });
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=mijiaxiugai", { updates: updates }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.get(1, this.search.keyword, this.cx.cid);
                    layer.msg(data.data.msg, { icon: 1 });
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        batchDelete: function () {
            if (this.selectedRows.length === 0) {
                layer.msg("请选择要批量删除的行", { icon: 2 });
                return;
            }
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=batchdelete", { mids: this.selectedRows }, { emulateJSON: true }).then((data) => {
                layer.close(load);
                if (data.data.code == 1) {
                    this.get(1, this.search.keyword, this.cx.cid); 
                    layer.msg(data.data.msg, { icon: 1 });
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        checkAll: function () {
            this.checkedItems = this.checkedItems.map(() => this.isAllChecked);
            this.updateSelectedRows();
        },
        updateSelectedRows: function () {
            this.selectedRows = [];
            this.checkedItems.forEach((checked, index) => {
                if (checked) {
                    this.selectedRows.push(this.row.data[index].mid);
                }
            });
            this.isAllChecked = this.checkedItems.every(item => item);
        },
        confirmBatchUpdate: function () {
    layer.confirm('确定要批量修改选中的密价信息？', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
    }, () => {
        this.batchUpdate();
    }, () => {
    });
},
confirmBatchDelete: function () {
    layer.confirm('确定要批量删除选中的密价信息？', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
    }, () => {
        this.batchDelete();
    }, () => {
    });
},
confirmDelete: function (mid) {
    layer.confirm('确定要删除该条密价信息？', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
    }, () => {
        this.del(mid);
    }, () => {
    });
}
},
mounted() {
    this.get(1);
}
});
</script>