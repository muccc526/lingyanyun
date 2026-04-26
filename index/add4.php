<?php
$title='定制交单';
include('../confing/common.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>
<link rel="stylesheet" href="assets/css/element.css">
<meta name="author" content="qingka">
<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="../assets/layui/css/layui.css" type="text/css" />
<link href="assets/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
<link href="assets/LightYear/css/style.min.css" rel="stylesheet"/>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/layer/3.1.1/layer.js"></script>
<link href="./assets/css/tailwind.min.css" rel="stylesheet">
<script src="https://at.alicdn.com/t/font_1185698_xknqgkk0oph.js?spm=a313x.7781069.1998910419.40&file=font_1185698_xknqgkk0oph.js"></script>
<style type="text/css">
    .susuicon {
        position: absolute;
    left: 21px;
    top: 14px;
       width: 1.3em; height: 1.3em;
       vertical-align: -0.15em;
       fill: currentColor;
       overflow: hidden;
    }
     .susuicon2 {
     position: absolute;
    top: 50%;
    right: 20px;
    margin-top: -7px;
    transition: transform .3s;
       width: 1.1em; height: 1.1em;
       vertical-align: -0.15em;
       fill: currentColor;
       overflow: hidden;
    }
    .flex{height: 2em; width: 2em;   vertical-align: -0.15em;
       fill: currentColor;float:left; position: absolute;
    bottom: 7px;
    left: 5px;
       overflow: hidden;}
       
       .flex2{height: 1.4em; width: 1.4em;   vertical-align: -0.15em;
       fill: currentColor;float:left;margin-top:2px;margin-right: 5px;
       overflow: hidden;}
       .malet{padding-left:20px;font-size:11px;}
    .nav>li:hover{
        background-color: #f8f8ff;
    }
    hr {
    height: 1px;
    margin: 4px;
        
    }
    
    
    .frosss{    height: 38px;
    border-radius: 8px !important; border: 2px solid rgb(236, 236, 236);
    border-color: #ebebeb;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    padding: 5px 12px;
    line-height: inherit;
    -webkit-transition: 0.2s linear;
    transition: 0.2s linear;
    -webkit-box-shadow: none;
    box-shadow: none;}
      .frosss2{ 
           border-radius: 8px !important; border: 2px solid rgb(236, 236, 236);
           display: block;
    width: 100%;
          height: 38px;
    border-color: #ebebeb;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    padding: 5px 12px;
    line-height: inherit;
    -webkit-transition: 0.2s linear;
    transition: 0.2s linear;
    -webkit-box-shadow: none;
    box-shadow: none;}
    .table>thead>tr>th {
    padding: 20px;
</style>
<style>
.lioverhide {
     width: 300px
  }
</style>
   <div class="app-content-body ">
        <div class="wrapper-md control" id="add">
	       <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
		    <div class="panel-heading font-bold " style="border-top-left-radius: 8px; border-top-right-radius: 8px;background-color:#fff;">
		    <div style="float:right;margin-right:20px"><el-link type="info"></el-link></div>
			    请选择分类 
			    <span>（剩余积分： <?php echo $userrow['money'] ; ?>）</span>
		     </div>
				<div class="panel-body">
					<form class="form-horizontal devform">
					    <?php if ($conf['flkg'] == "1" && $conf['fllx'] == "1") {?>
<div class="form-group">
    <label class="col-sm-2 control-label">项目分类</label>
    <div class="col-sm-9">
        <select class="layui-select" v-model="selectedFenleiId" @change="updateSelectedFenleiId"  style="scroll 99%; border-radius: 8px; width:100%" >
            <option value="">全部分类</option>
            <?php 
            $a = $DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` ASC");
            while($rs = $DB->fetch($a)){
          ?>
            <option :value="<?=$rs['id']?>"><?=$rs['name']?></option>
            <?php }?>
        </select>
    </div>
</div>
<?php }?>

<?php if ($conf['flkg'] == "1" && $conf['fllx'] == "2") {?>
<div class="form-group">
    <label class="col-sm-2 control-label">项目分类</label>
    <div class="col-sm-9">
        <div class="col-xs-12">
            <div class="example-box">
                <?php
                $a = $DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` ASC");
                while($rs = $DB->fetch($a)){
              ?>
                <label class="lyear-radio radio-inline radio-primary">
                    <input type="radio" :value="<?=$rs['id']?>" @change="updateSelectedFenleiId" v-model="selectedFenleiId"><span style="color: #1e9fff;"><?=$rs['name']?></span>
                </label>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>
           
				<div class="form-group">
    <label class="col-sm-2 control-label">选择平台</label>
    <div class="col-sm-9">
        <el-select id="select" v-model="cid" @change="tips(cid)" popper-class="lioverhide" :popper-append-to-body="false" filterable placeholder="点击选择下单平台" style="scroll 99%;width:100%">
           <el-option
            v-for="class2 in class1"
            :key="class2.cid"
            :label="`${class2.name}`"
            :value="class2.cid">
            </el-option>
       
           <!-- 显示选中的价格 -->

    </div>
 
</div>

<div class="form-group">
							<label class="col-sm-2 control-label">项目信息</label>
						<div class="col-sm-9">
        <span class="help-block m-b-none inline-display" style="color:blue;">项目ID：<span v-html="duijieid"></span>&nbsp;&nbsp;&nbsp;分类ID：<span v-html="selectedFenleiId"></span>&nbsp;&nbsp;&nbsp;金额：<span v-html="rmb"> </span>&nbsp;&nbsp;&nbsp;积分</span>
    </div>
						</div>
						
					
                        <!--单学时备注定位点-->
                       

<div class="form-group">
    <label class="col-sm-2 control-label">信息填写</label>
    <div class="col-sm-9">
        <input type="text" class="frosss2" style="height:38px;" v-model="userinfo" v-if="isSingleLine" />
        <el-input placeholder="请输入详细信息" type="textarea" :rows="3" v-model="userinfo" v-else></el-input>
        <button @click="(event) => toggleInputType(event)" class="el-button el-button--small">{{ isSingleLine? '切换到多行输入' : '切换到单行输入' }}</button>
    </div>
</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">项目说明</label>
							<div class="col-sm-9">
						    <span class="help-block m-b-none"
																		style="color: rgb(54, 154, 255);"><span
																			v-html="content"></span>
							</div>
						</div>
	
				  	    <div class="col-sm-offset-2" v-if="nochake==1">
				  	    	<button style="margin-left: 6px; font-size: 13px;" type="button" @click="add" value="立即提交" class="el-button el-button--primary is-plain"/><i class="glyphicon glyphicon-ok"></i>  提交</button>
				  	    </div>
				  	    <div class="col-sm-offset-2" v-else>
				  	    	<button style="margin-left: 6px; font-size: 13px;" type="button" @click="get" value="立即查询" class="el-button el-button--primary is-round"/><i class="	glyphicon glyphicon-zoom-in"></i>  查询</button>
				  	    	<button style="margin-left: 6px; font-size: 13px;" type="button" @click="add" value="立即提交" class="el-button el-button--primary is-round"/><i class="glyphicon glyphicon-ok"></i>  提交</button>
				  	    	<button @click="resetInput($event)" class="btn btn-label btn-round btn-warning" value="清空数据"><label><i class="mdi mdi-delete-empty"></i></label> 重置</button>
				  	    </div>

			        </form>
		        </div>
	     </div>
	     


	    <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
		   
		   <div class="panel-heading font-bold " >
    查询结果 &nbsp;
    <button id="copyButton" class="el-button el-button--primary is-plain el-button--mini" style="padding: 4px 10px;" > 复制</button>&nbsp;
    <a class="el-button el-button--primary is-plain el-button--mini" style="padding: 4px 10px;" @click="selectAll()">全选</a>
    <span id="selectedCourseCount">您选择了 0 门课</span>
    <span id="totalPrice">本次提交总价格：0元</span> <!-- 添加这个用于显示总价格 -->
</div>
       
				<div class="panel-body">
					<form class="form-horizontal devform">		
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div v-for="(rs,key) in row">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+key" aria-expanded="true" >
                        <b>{{rs.userName}}</b>  {{rs.userinfo}} <span v-if="rs.msg=='查询成功'"><b style="color: green;">{{rs.msg}}</b></span><span v-else-if="rs.msg!='查询成功'"><b style="color: red;">{{rs.msg}}</b></span>
                    </a>
                </h4>
            </div>
            <div :id="key" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div v-for="(res,key) in rs.data">
                        <label class="layui-table lyear-checkbox checkbox-inline checkbox-success">
                            <li>
                                <input style="margin-left: 0px;" :checked="checked" name="checkbox" type="checkbox" :value="res.name" @click="checkResources(rs.userinfo,rs.userName,rs.data,res.id,res.name)"><label for="checkbox1"></label>
                                <span :class="{ 'red-text': res.state === '' }">{{ res.name }} <b v-if="res.state!== ''">{{ res.state }}</b><b v-else> - 开课中 </b></span><span v-show="res.id">[课程ID:{{ res.id }}]</span>
                                <!-- 使用v-if和v-else-if来判断教师和班级信息是否存在，若不存在则不生成对应的HTML元素 -->
                                <span v-if="res.teacher">{{'教师：' + res.teacher}}</span>
                                <span v-else-if="!res.teacher"></span>
                                <span v-if="res.class">{{'班级：' + res.class}}</span>
                                <span v-else-if="!res.class"></span>
                            </li>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
			        </form>
		        </div>
       </div>
       
       <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
               <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">注意事项</div>
               <div class="panel-body">
                  <ul class="layui-timeline">
                      <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>请务必查看项目下单须知和说明，防止出现错误！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>多账号下单必须换行，务必保证一行一条信息！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>同商品重复下单，请修改密码后再下！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>默认下单格式为账号、密码(空格分开)！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>查课出问题及时反馈！</p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
            


	
    </div>
<script>
    
$(document).ready(function(){
 $("#btn4").click(function(){ 
$("input[name='checkbox']").each(function(){ 
if($(this).attr("checked")) 
{ 
$(this).removeAttr("checked"); 
} 
else
{ 
$(this).attr("checked","true"); 
} 
}) 
}) 




}); 
</script>


<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="../assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/layui/js/axios.min.js"></script>
<script src="./assets/js/element.js"></script>




<script>
var vm = new Vue({
    el: "#add",
    data: {
        row: [],
        shu: '',
        bei: '',
        nochake: 0,
        check_row: [],
        userinfo: '',
        cid: '',
        miaoshua: '',
        class1: '',
        class3: '',
        activems: false,
        checked: false, // 确认这里初始值符合业务需求，比如是否某些情况应该初始为true
        content: '',
        isSingleLine: true,
        money: 0,
        duijieid: '',
        selectedFenleiId:'',
        rmb:'',
        
        
       
 },

 methods:{
     resetInput: function (event) {
        // 阻止按钮点击的默认行为，防止出现页面刷新等不符合预期的情况
        event.preventDefault();
        // 将userinfo的值重置为空字符串，实现清空对应输入框内容的效果
        this.userinfo = ''
    },
     // 获取数据的方法
     updateSelectedFenleiId: function () {
        // 获取当前选中的分类id
        var selectedId = this.selectedFenleiId;

        // 调用fenlei方法，传入选中的分类id，获取对应分类下的商品信息
        this.fenlei(selectedId);

        console.log('当前选中的分类id为：', this.selectedFenleiId);
    },
     get: function(salt) {
    if (this.cid === '' || this.userinfo === '') {
        layer.msg("所有项目不能为空");
        return false;
    }
    userinfo = this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");
    userinfo = userinfo.split('[br]');
    this.row = [];
    this.check_row = [];
    for (var i = 0; i < userinfo.length; i++) {
        info = userinfo[i];
        if (info === '') {
            continue;
        }
        var hash = getENC('<?php echo $addsalt;?>');
        var loading = layer.load();
        this.$http.post("/apisub.php?act=get", { cid: this.cid, userinfo: info, hash }, { emulateJSON: true }).then(function(data) {
            layer.close(loading);
            if (data.body.code === -7) {
                salt = getENC(data.body.msg);
                vm.get(salt);
            } else {
                // 直接将后端返回的数据整体存入 row 数组，无需再单独处理课程名重复问题（假设后端返回数据无重复课程名问题）
                this.row.push(data.body);
            }
        });
    }
    document.getElementById('selectedCourseCount').innerText = `您选择了 0 门课 `;
    document.getElementById('totalPrice').innerText = `本次提交总价格：0元`;
    this.checked = false;
},
     // 添加数据的方法
      add: function () {
    if (this.cid === '') {
        if (this.nochake!== 1) {
            layer.msg("请先查课");
            return false;
        }
    }
    if (this.check_row.length < 1) {
        if (this.nochake!== 1) {
            layer.msg("请先选择课程");
            return false;
        }
    }
    var loading = layer.load();
    this.$http.post("/apisub.php?act=add", {
        cid: this.cid,
        data: this.check_row,
        shu: this.shu,
        bei: this.bei,
        userinfo: this.userinfo,
        nochake: this.nochake
    }, {
        emulateJSON: true
    }).then(function (data) {
        layer.close(loading);
        if (data.data.code === 1) {
            this.row = [];
            this.check_row = [];
            // 重置选择课程数量相关数据和显示
            this.checked = false;
            document.getElementById('selectedCourseCount').innerText = `您选择了 0 门课`;
            // 重置总价格相关数据和显示
            this.money = 0;
            document.getElementById('totalPrice').innerText = `本次提交总价格：0元`;
            layer.msg('提交成功！', { icon: 1, time: 2000 });
        } else {
            this.$message({ type: 'error', showClose: true, message: data.data.msg });
        }
    });
},
     // 检查888的方法
     check888:function(userinfo,userName,rs,name){
         var btns=document.getElementById("btns");
         var  zk= document.getElementById("s1");
         var x= zk.getElementsByTagName("input");
         if(btns.checked==true) {
          for(var i=0   ; i < x.length; ++i) {
                    data={userinfo,userName,data:rs[i]};
           x[i].checked=true;
              vm.check_row.push(data);
          }
         }else {
          for(var i=0; i < x.length; ++i) {
           x[i].checked=false; 
          }
           this.check_row = []
         }
     },
     tips(cid) {
},
    getPriceByCid(cid) {
        const selectedClass = this.class1.find(class2 => class2.cid === cid);
        return selectedClass ? selectedClass.price : 0; // 返回选中平台的价格
    },
     // 全选的方法
     selectAll: function () {
    if (this.cid === '') {
        layer.msg("请先查课");
        return false;
    }

    this.checked =!this.checked;

    if (this.checked) {
        // 如果全选
        vm.check_row = [];
        for (let i = 0; i < vm.row.length; i++) {
            let userinfo = vm.row[i].userinfo;
            let userName = vm.row[i].userName;
            let rs = vm.row[i].data;
            for (let a = 0; a < rs.length; a++) {
                let aa = rs[a];
                let data = { userinfo, userName, data: aa };
                vm.check_row.push(data);
            }
        }
    } else {
        // 如果取消全选
        vm.check_row = [];
    }

    // 遍历所有复选框元素，更新其勾选状态以匹配this.checked的值
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });

    // 更新选择课程数量的显示
    document.getElementById('selectedCourseCount').innerText = `您选择了 ${vm.check_row.length} 门课`;

    // 计算总价格并更新显示
    let total = 0;
    vm.check_row.forEach(item => {
        const selectedClass = this.class1.find(class2 => class2.cid === this.cid);
        if (selectedClass) {
            total += selectedClass.price;
        }
    });
    document.getElementById('totalPrice').innerText = `本次提交总价格：${total.toFixed(2)}元`;

    console.log(vm.check_row);
},
     // 检查资源的方法
     checkResources: function (userinfo, userName, rs, id, name) {
    // 先准确找到要操作的课程数据
    let targetCourse = null;
    for (let i = 0; i < rs.length; i++) {
        if ((id && rs[i].id === id) || (!id && rs[i].name === name)) {
            targetCourse = rs[i];
            break;
        }
    }

    if (!targetCourse) {
        layer.msg("未找到对应的课程数据，请刷新页面后重试", {icon: 2});
        return;
    }

    let dataObj = { userinfo, userName, data: targetCourse };

    // 查找当前数据在check_row中的索引
    let indexInCheckRow = this.check_row.findIndex((item) => {
        return item.data.id === targetCourse.id && item.userinfo === userinfo;
    });

    if (indexInCheckRow!== -1) {
        // 如果已经存在，说明是取消勾选操作
        this.check_row.splice(indexInCheckRow, 1);
        layer.msg("已取消选择该课程");
    } else {
        // 如果不存在，说明是勾选操作
        this.check_row.push(dataObj);
        layer.msg("已成功添加课程");
    }

    // 更新选择课程数量的显示
    document.getElementById('selectedCourseCount').innerText = `您选择了 ${this.check_row.length} 门课`;

    // 计算总价格并更新显示
    let total = 0;
    this.check_row.forEach((item) => {
        const selectedClass = this.class1.find((class2) => class2.cid === this.cid);
        if (selectedClass) {
            total += selectedClass.price;
        }
    });
    document.getElementById('totalPrice').innerText = `本次提交总价格：${total.toFixed(2)}元`;

    // 确保视图能正确更新复选框状态，这里手动触发一次视图更新（在某些情况下可能需要）
    this.$forceUpdate();
},
     // 分类的方法
     fenlei:function(id){
    var load=layer.load(2);
    this.$http.post("/apisub.php?act=getclassfl",{id:id},{emulateJSON:true}).then(function(data){
            layer.close(load);
            if(data.data.code==1){
                this.class1=data.body.data;

                // 遍历class1数组查找与当前分类id相关的商品信息，假设通过classId属性关联
                for (var i = 0; this.class1.length > i; i++) {
                    if (this.class1[i].classId == id) {
                        // 使用this.$set()方法更新currentClass2的classId属性，确保Vue能检测到变化
                        this.$set(this.currentClass2, 'classId', this.class1[i].classId);
                        break;
                    }
                }

            }else{
                 layer.msg(data.data.msg,{icon:2});
            }
         });
},
     // 获取分类的方法
     getclass:function(){
    var load=layer.load();
    this.$http.post("/apisub.php?act=getclass").then(function(data){	
            layer.close(load);
            if(data.data.code==1){			                     	
             this.class1=data.body.data;			             			                     
            }else{
                 layer.msg(data.data.msg,{icon:2});
            }
         });	
      
     },
     // 获取未打卡的方法
     toggleInputType() {
    // 阻止按钮点击的默认行为，防止页面刷新
    event.preventDefault(); 

    console.log('切换前的isSingleLine值：', this.isSingleLine);
    this.isSingleLine =!this.isSingleLine;
    console.log('切换后的isSingleLine值：', this.isSingleLine);

    // 当切换到多行输入框时，设置焦点到多行输入框（可选步骤）
    if (!this.isSingleLine) {
        this.$nextTick(() => {
            const textarea = document.querySelector('textarea');
            if (textarea) {
                textarea.focus();
            }
        });
    }
},
     // 提示信息的方法
     tips: function (message) {
          for(var i=0;this.class1.length>i;i++){
           if(this.class1[i].cid==message){
               this.show = true;
               this.content = this.class1[i].content;
               this.duijieid = this.class1[i].cid;
                this.rmb = this.class1[i].price;
                    /*layer.open({
                        type: 0 
                                ,title: '商品说明'
                                ,content: this.class1[i].content
                                ,time: 5000
                                ,shade: 1  //不显示遮罩
                                ,anim: 1
                                ,maxmin: true
                                ,
                            });*/
       return false;	
            if(this.class1[i].miaoshua==1){
          this.activems=true;
        }else{
          this.activems=false;
        }
            return false;
            
           }
           
          }
 
        },

        tips2: function () {
         layer.tips('开启秒刷将额外收0.05的费用', '#miaoshua');      	  
    
        }    
 },

});
</script>
<script>
     
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
      } 
        </script>
          <script>


        document.getElementById('copyButton').addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const selectedValues = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
            const allValues = Array.from(checkboxes).map(checkbox => checkbox.value);

            // 根据选中情况决定复制的内容
            const valuesToCopy = selectedValues.length > 0 ? selectedValues : allValues;

            // 添加序号并加上【】
            const textToCopy = valuesToCopy.map((value, index) => `【${index + 1}】 ${value}`).join('\n');

            // 添加固定语句
            const finalText = `请选择代看课程【回复数字即可】\n-----你当前的课程列表-----\n${textToCopy}\n---------------------`;

            // 创建一个临时的文本区域
            const textArea = document.createElement('textarea');
            textArea.value = finalText;
            document.body.appendChild(textArea);

            // 选择文本区域中的文本
            textArea.select();
            textArea.setSelectionRange(0, 99999); // 对于移动设备

            // 复制文本到剪切板
            document.execCommand('copy');

            // 移除临时文本区域
            document.body.removeChild(textArea);

            // 使用不同的提示消息
            const message = selectedValues.length > 0 ? '已复制选中项！' : '已复制所有项！';
            layer.msg(message);
        });
        </script>