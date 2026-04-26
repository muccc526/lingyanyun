<?php
$title = '小猿提交';
require_once('head.php');
$addsalt = md5(mt_rand(0, 999) . time());
$_SESSION['addsalt'] = $addsalt;
?>

<link rel="stylesheet" href="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.css">
<script type="text/javascript" src="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="assets/css/element.css" type="text/css" />

<div class="app-content-body">
    <div class="wrapper-md control" id="add">
        <div class="layui-row layui-col-space5">
            <div class="layui-col-md">
                <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 10px;">
                    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 7px;">小猿提交<span>（剩余积分： <?php echo $userrow['money'] ; ?> 积分）</span></div>
                    <div class="panel-body" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 7px;">
                        <form class="form-horizontal devform">
                            <!-- 选择项目分类 和 选择项目 -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">项目分类</label>
                                <div class="col-sm-9">
                                    <el-select v-model="id" @change="fenlei(id)" filterable placeholder="全部分类" style="width: 100%;">
                                        <el-option value="">全部分类</el-option>
                                        <?php 
                                        $a = $DB->query("SELECT * FROM qingka_wangke_fenlei WHERE status=1 ORDER BY `sort` ASC");
                                        while ($rs = $DB->fetch($a)) {
                                            echo '<el-option label="' . $rs['name'] . '" value="' . $rs['id'] . '"></el-option>';
                                        }
                                        ?>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">项目搜索</label>
                                <div class="col-sm-9">
                                    <el-input v-model="keyword" @input="search" placeholder="输入关键词搜索-苹果双击粘贴" style="width: 100%;"></el-input>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">项目选择</label>
                                <div class="col-sm-9">
                                    <el-select v-model="cid" @change="tips(cid)" filterable placeholder="选择所需的商品-支持二次搜索" style="width: 100%;">
                                        <el-option v-for="class2 in filteredClass1" :label="class2.name + '→' + class2.price + '积分'" :value="class2.cid">
                                            <span style="float: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px;">{{ class2.name }}</span>
                                            <span style="float: right; color: #8492a6; font-size: 13px">{{ class2.price }}积分</span>
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <!-- 参数设置 和 信息填写 -->
                            <div v-show="show">
                                <div class="form-group" id="score" style="display: none;">
                                    <label class="col-sm-2 control-label">参数设置1</label>
                                    <div class="col-sm-9 col-xs-8">
                                        <input id="range_02">
                                        <small class="form-text text-muted">{{ score_text }}</small>
                                    </div>
                                </div>
                                <div class="form-group" id="shic" style="display: none;">
                                    <label class="col-sm-2 control-label">参数设置2</label>
                                    <div class="col-sm-9 col-xs-8">
                                        <input id="range_01">
                                        <small class="form-text text-muted">{{ shichang_text }}</small>
                                    </div>
                                </div>
                                                                <div class="form-group">
                                    <label class="col-sm-2 control-label">填写模板</label>
                                    <div class="col-sm-9">
                                        <el-switch
                                            v-model="isSingleMode"
                                            active-text="单账号"
                                            inactive-text="多账号">
                                        </el-switch>
                                    </div>
                                </div>
                                <div v-if="isSingleMode">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">信息填写</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="layui-input" v-model="newpassword" placeholder="下单格式：账号 密码（中间用空格分隔）" style="border-radius: 8px;" autocomplete="off">
                                            <span class="help-block m-b-none" style="color:blue;"><span v-if="cid" v-html="'项目对接 ID：' + cid"></span></span>
                                            <span class="help-block m-b-none" style="color:red;" id="warning">
                                                <span v-html="content"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
						<div class="form-group">
							<label class="col-sm-2 control-label">信息填写</label>
							<div class="col-sm-9">
						    <textarea rows="5" class="layui-textarea" v-model="userinfo" placeholder="下单格式：&#10学校 账号 密码（中间用空格分隔开,前后不要有空格）&#10账号 密码（中间用空格分隔开,前后不要有空格）&#10多账号下单必须换行,务必一行一条信息"   style="border-radius: 8px;"></textarea>	
				<span class="help-block m-b-none" style="color:blue;"><span v-if="cid" v-html="'项目对接 ID：' + cid"></span></span>
                <span class="help-block m-b-none" style="color:red;"><span v-html="content"></span></span>
							</span>
                                        </div>
                                    </div>
                                </div>
				  	    <div class="col-sm-offset-2 col-sm-12">
                           <button type="button" @click="get" style="border-radius: 10px;" class="layui-btn layui-btn-sm" />查询课程</button>
                           <button type="button" @click="add" style="border-radius: 10px;" class="layui-btn layui-btn-sm layui-btn-normal" />立即提交</button>
                           <button type="reset" style="border-radius: 10px;" class="layui-btn layui-btn-sm layui-btn-primary" />重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

             <div class="layui-col-md12" v-show="show1">
                <div class="panel panel-default" style="border-radius: 10px;">
                    <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">
                        查询结果（多账号查询时请耐心等待显示）
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal devform">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div v-for="(rs, key) in row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" :id="'heading' + key">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse' + key" aria-expanded="true">
                                                    <b>{{ rs.userName }}</b> {{ rs.userinfo }}
                                                    <span v-if="rs.msg == '查询成功'"><b style="color: green;">{{ rs.msg }}</b></span>
                                                    <span v-else-if="rs.msg != '查询成功'"><b style="color: red;">{{ rs.msg }}</b></span>
                                                </a>
                                                <label style="margin-left: 10px;">
                                                    <input type="checkbox" v-model="rs.syncSelection" @change="handleSyncSelection(key)"> 为其他账号选择相似结果
                                                </label>
                                            </h4>
                                        </div>
                                        <div :id="'collapse' + key" class="panel-collapse collapse in" role="tabpanel" :aria-labelledby="'heading' + key">
                                            <div class="panel-body">
                                                <el-select v-model="rs.selectedCourses" style="width: 100%;" multiple placeholder="请选择课程---输入课程名可搜索" @change="handleCourseSelection(rs.userinfo, rs.userName, rs.data, rs.selectedCourses)" filterable>
                                                         <el-option v-for="res in rs.data" :key="res.id || res.name" :label="res.name + (res.id ? ' [课程ID:' + res.id + ']' : '')" :value="res.id ? res.id : res.name">
                                                         <span style="float: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px;">{{ res.name }}</span>
                                                             <span style="float: right; color: #8492a6; font-size: 12px; overflow: hidden; text-overflow: ellipsis; max-width: 50px;">[课程ID{{ res.id }}]</span>
                                                        </el-option>
                                                  </el-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="assets/js/element.js"></script>
<script>
var vm = new Vue({
    el: "#add",
   data: {
    row: [],
    check_row: [],
    userinfo: '',
    cid: '',
    id: '',
    score_text: '',
    shichang_text: '',
    class1: [],
    class3: '',
    show: false,
    show1: false,
    content: '',
    keyword: '',
    filteredClass1: [],
    isSingleMode: false,
    school: '',
    newaccount: '',
    newpassword: ''
},
    created: function() {
        this.getclass();
    },
    methods: {
        getclass: async function() {
            try {
                let response = await this.$http.post("/apisub.php?act=getclass");
                if (response.data.code === 1) {
                    this.class1 = response.body.data;
                    this.filteredClass1 = this.class1;
                } else {
                    layer.msg(response.data.msg, { icon: 2 });
                }
            } catch (error) {
                console.error(error);
            }
        },
        fenlei: async function(id) {
            this.selectedButton = id;
            try {
                let response = await this.$http.post("/apisub.php?act=getclassfl", { id: id }, { emulateJSON: true });
                if (response.data.code === 1) {
                    this.class1 = response.body.data;
                    this.filteredClass1 = this.class1;
                    this.keyword = '';
                } else {
                    layer.msg(response.data.msg, { icon: 2 });
                }
            } catch (error) {
                console.error(error);
            }
        },
        search: function() {
            const keyword = this.keyword.trim().toLowerCase();
            if (keyword === '') {
                this.filteredClass1 = this.class1;
            } else {
                this.filteredClass1 = this.class1.filter(item => {
                    return item.name.toLowerCase().includes(keyword);
            
                });
            }
        },
        get: function() {
        if (this.isSingleMode) {
            if(this.account=='' || this.password==''){
	    		layer.msg("账号和密码不能为空");
	    		return false;
	    	}
	        this.userinfo = this.school ? this.school + ' ' + this.newaccount + ' ' + this.newpassword : this.newaccount + ' ' + this.newpassword;
            }
            if (this.cid == '' || this.userinfo == '') {
                layer.msg("信息格式错误，请检查");
                return false;
            }
            userinfo = this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");
            userinfo = userinfo.split('[br]');
            this.row = [];
            this.check_row = [];
            for (var i = 0; i < userinfo.length; i++) {
                info = userinfo[i];
                var hash = getENC('<?php echo $addsalt;?>');
                var loading = layer.load(2);
                this.$http.post("/apisub.php?act=get", { cid: this.cid, userinfo: info, hash }, { emulateJSON: true }).then(function(data) {
                    layer.close(loading);
                    this.show1 = true;
                    data.body.selectedCourses = [];
                    data.body.syncSelection = false;
                    this.row.push(data.body);
                });
            }
        },
        add: function() {
            if (this.cid == '') {
                layer.msg("请先查课");
                return false;
            }
            if (this.check_row.length < 1) {
                layer.msg("请先选择课程");
                return false;
            }
            this.check_row = [];
            this.row.forEach(rs => {
               rs.selectedCourses.forEach(courseId => {
                    let course = rs.data.find(res => res.id == courseId || res.name == courseId);
                    if (course) {
                        this.check_row.push({ userinfo: rs.userinfo, userName: rs.userName, data: course });
                    }
                });
            });
            var loading = layer.load(2);
            score = $("#range_02").val();
            shichang = $("#range_01").val();
            this.$http.post("/apisub.php?act=add", {
                cid: this.cid,
                data: this.check_row,
                shichang: shichang,
                score: score
            }, { emulateJSON: true }).then(function(data) {
                layer.close(loading);
                if (data.data.code == 1) {
                    this.row = [];
                    this.check_row = [];
                    layer.alert(data.data.msg, { icon: 1, title: "温馨提示" }, function() { setTimeout(function() { window.location.href = "" }); });
                } else {
                    layer.alert(data.data.msg, { icon: 2, title: "温馨提示" });
                }
            });
        },
        handleCourseSelection: function(userinfo, userName, rs, selectedCourses) {
                this.check_row = this.check_row.filter(item => item.userinfo !== userinfo);
                selectedCourses.forEach(courseValue => {
                    let courseObj = rs.find(res => (res.id ? res.id === courseValue : res.name === courseValue));
                    if (courseObj) {
                        this.check_row.push({ userinfo, userName, data: courseObj });
                    }
                });
                this.row.forEach((rowItem, index) => {
                if (rowItem.syncSelection && rowItem.userinfo !== userinfo) {
                    rowItem.selectedCourses = selectedCourses.filter(courseValue => rowItem.data.some(res => res.name === (res.id ? res.id : res.name)));
                }
            });
        },
        handleSyncSelection: function(key) {
            const currentRow = this.row[key];
            if (currentRow.syncSelection) {
                this.row.forEach((rs, index) => {
                    if (index !== key && rs.data) {
                        rs.selectedCourses = [];
                        currentRow.selectedCourses.forEach(courseValue => {
                    let courseObj = currentRow.data.find(res => res.id === courseValue || res.name === courseValue);
                    if (courseObj) {
                        let matchingCourse = null;
                        for (let res of rs.data) {
                           if (res.id && res.id === courseObj.id) {
                                matchingCourse = res;
                                break;
                                    } else if (res.name === courseObj.name) {
                                        matchingCourse = res;
                                    }
                                }
                                if (matchingCourse) {
                                    rs.selectedCourses.push(matchingCourse.id || matchingCourse.name);
                                }
                            }
                        });
                    }
                });
            } else {
                this.row.forEach((rs, index) => {
                    if (index !== key && rs.data) {
                        rs.selectedCourses = [];
                    }
                });
            }
        },
        scsz: function(min, max, from) {
            $("#range_01").ionRangeSlider({
                min: min,
                max: max,
                from: from,
            });
        },
        scoresz: function(min, max, from) {
            $("#range_02").ionRangeSlider({
                min: min,
                max: max,
                from: from,
            });
        },
        tips: function(message) {
            if (message == '178' || message == '179' || message == '466' || message == '4497') {
                this.scoresz(70, 100, 99);
                this.score_text = '设置的分数小于100分的，具有1-2分的弹性范围';
                this.scsz(1, 50, 25);
                this.shichang_text = '具有1-2小时的弹性范围，更具合理性，小节时长随机';
                $("#score").show();
                $("#shic").show();
            } 
            else if (message == '469') {
                this.scoresz(1000, 15000, 2500);
                this.score_text = '设置的积分范围1000到15000，设置过多也没用，无法达到要求';
        $("#score").show();
        $("#shic").hide();
    } 

    for (var i = 0; this.class1.length > i; i++) {
        if (this.class1[i].cid == message) {
            this.show = true;
            this.content = this.class1[i].content;
            return false;
        }
    }
}

	}
});
</script>