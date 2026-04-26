<?php
$title = '提交订单';
require_once('head.php');
$addsalt = md5(mt_rand(0, 999) . time());
$_SESSION['addsalt'] = $addsalt;
?>

<!DOCTYPE html>
<html lang="zh">
<style>
    /* 在屏幕宽度小于768px时，使用这个CSS类隐藏元素 */
    @media screen and (max-width: 767px) {
        .hide-on-mobile {
            display: none;
        }
    }

    /* 颜色类合并 */
    .color-blue { color: #3498db; }
    .color-red { color: #e74c3c; }
    .color-green { color: #2ecc71; }
    .color-purple { color: #9b59b6; }
    .color-yellow { color: #f1c40f; }
    .color-navy { color: #34495e; }
    .color-teal { color: #1abc9c; }
    .color-orange { color: #d35400; }
    .color-grey { color: #7f8c8d; }

    /* 图标类合并 */
    .susuicon, .susuicon2, .flex, .flex2 {
        position: absolute;
        vertical-align: -0.15em;
        fill: currentColor;
        overflow: hidden;
    }

    .susuicon {
        left: 21px;
        top: 14px;
        width: 1.3em;
        height: 1.3em;
    }

    .susuicon2, .flex2 {
        top: 50%;
        right: 20px;
        margin-top: -7px;
        transition: transform .3s;
        width: 1.1em;
        height: 1.1em;
    }

    .flex {
        bottom: 7px;
        left: 5px;
        width: 2em;
        height: 2em;
    }

    .flex2 {
        float: left;
        margin-top: 2px;
        margin-right: 5px;
        width: 1.4em;
        height: 1.4em;
    }

    .malet {
        padding-left: 20px;
        font-size: 11px;
    }

    .nav>li:hover {
        background-color: #f8f8ff;
    }

    hr {
        height: 1px;
        margin: 4px;
    }

    /* 表单样式合并 */
    .frosss, .frosss2 {
        height: 38px;
        border-radius: 8px !important;
        border: 2px solid #ebebeb;
        padding: 5px 12px;
        line-height: inherit;
        transition: 0.2s linear;
        box-shadow: none;
    }

    .frosss2 {
        display: block;
        width: 100%;
    }

    .table>thead>tr>th {
        padding: 20px;
    } /* 修复了缺少闭合括号的问题 */

    /* 响应式布局 */
    .column-container {
        columns: 1;
        -webkit-columns: 1;
        -moz-columns: 1;
    }

    .column-item {
        break-inside: avoid;
        page-break-inside: avoid;
        -webkit-column-break-inside: avoid;
    }

    @media (min-width: 768px) {
        .column-container {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
        }
    }

    /* Element UI样式覆盖 */
    .form-group .el-textarea .el-textarea__inner {
        color: blue !important;
    }

    .lioverhide {
        width: 300px;
    }

    .flex-row {
        display: flex;
        align-items: stretch;
    }

    @media (min-width: 992px) {
        .col-md-7 {
            flex: 0 0 70%;
            max-width: 70%;
        }

        .col-md-3 {
            flex: 0 0 30%;
            max-width: 30%;
        }
    }

    .custom-notification-list {
        list-style: none;
        padding: 0;
    }

    .custom-notification-list li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 10px;
    }

    .custom-notification-list li:before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #3498db;
    }

    .notification-number {
        font-weight: bold;
        color: #3498db;
        margin-right: 5px;
    }
    @media (max-width: 767px) {
  .layui-col-xs12.layui-col-md4 {
    padding-left: 0 !important;
  }
}
.layui-row {
  display: flex;
  flex-wrap: wrap; /* 允许元素在必要时换行 */
}

.layui-col-xs12 {
  display: flex;
  flex-direction: column; /* 让子元素垂直排列 */
}

.panel {
  display: flex;
  flex-direction: column; /* 让.panel内的元素垂直排列 */
  flex: 1; /* 让.panel元素伸展并占据父元素的全部高度 */
}

.panel-body {
  flex-grow: 1; /* 让.panel-body元素在有多余空间时伸展 */
}
.panel-body img {
  max-height: 300px; /* 设置图片的最大高度，根据需要调整 */
  object-fit: cover; /* 如果您希望图片覆盖整个区域，可以使用这个属性 */
  /* 其他样式根据需要添加 */
}
</style>
<style>
  /* 在宽度小于768px的设备上不显示该元素 */
  @media only screen and (max-width: 768px) {
    .hide-on-mobile {
      display: none;
    }
  }
  
  
   body, html { margin: 0; padding: 0; width: 100%; height: 100%; }
  .scrolling-wrapper {
    background-color: #f0f4f8;
    padding: 20px;
    box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    width: 100%;
    box-sizing: border-box;
  }
  .scrolling-content {
    white-space: nowrap;
    animation: scroll 20s linear infinite; /* 控制滚动速度 */
  }
  @keyframes scroll {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
  }
  .announcement {
    display: inline-block;
    padding: 0 50px;
    font-size: 16px;
    font-weight: bold;
    /* 添加动态颜色变化效果 */
    animation: colorChange 5s infinite alternate;
  }
  @keyframes colorChange {
    0% { color: blue; }
    25% { color: red; }
    50% { color: green; }
    75% { color: orange; }
    100% { color: blue; }
  }
    .column-container {
    display: flex;
    flex-wrap: wrap;
  }

.column-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}

.column-item {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 5px;
}

.column-item.selected {
  background-color: #1E9FFF; /* 浅蓝色 */
}

@media (max-width: 768px) {
  .column-container {
    grid-template-columns: repeat(1, 1fr);
  }
}
</style>
   <div class="app-content-body ">
        <div class="wrapper-md control" id="add">
             <div class="layui-row">
      <div class="layui-col-xs12 layui-col-md8" style="padding-right: 1px; box-sizing: border-box;">
    <div class="grid-demo grid-demo-bg1">
         
           <div class="panel panel-default" style="box-shadow: 7px 7px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
            <div class="panel-heading font-bold " style="border-top-left-radius: 8px; border-top-right-radius: 8px;background-color:#fff;">
            <div style="float:right;margin-right:20px;"><el-link type="primary"></el-link></div>
                订单提交&nbsp;&nbsp; <span style="color: purple;">余额：{{ money }} 积分</span>（找不到项目可搜索）&nbsp;&nbsp;
                <span v-if="freeadd > 0" class="hide-on-mobile">剩余下单次数：{{ freeadd }} 次</span>
                <div style="float: right;">
    
                                <!-- AI校正开关 -->
                                <el-switch v-model="useVfidder" active-color="#13ce66" inactive-color="#ff4949"
                                    active-text="校正">
                                </el-switch>
                                <el-tooltip effect="dark" placement="top" :open-delay="500"
                                    :popper-class="'my-tooltip'">
                                    <i class="el-icon-question" style="margin-left: 10px;"></i>
                                    <div slot="content">
                                        新增AI矫正功能（自动删减除账号密码的其他内容）。<br>如:账号:188888888 密码:8888888，<br>自动删减为:188888888
                                        8888888。<br>方便查课，避免客户发一串内容需要自己替换。<br>AI校正会自动提取客户发来的账号密码信息，<br>大部分情况都可用，<br>如果查课时确定账号密码正确但是显示密码错误，<br>请关闭AI校正之后重新查课。<br>如遇到提取信息有误，请工单反馈问题，<br>写清楚校正前的格式
                                    </div>
                                </el-tooltip>
    </div>
<button class="btn btn-xs btn-info"  data-toggle="modal" onclick="TgTips()">今日推荐(请点击阅读)</button>
             </div>
            
                              <div class="panel-body">
                    <el-form class="form-horizontal devform">
                        <?php if ($conf['flkg']=="1"&&$conf['fllx']=="2") {?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>常用项目</strong></label>
                            <div class="col-sm-9">
                                <div class="col-xs-14">
                                    <div class="example-box">
                                  
                                            <div role="radiogroup" class="el-radio-group">
                                            
                      		    <label role="radio" tabindex="0" class="el-radio-button el-radio-button--small is-active" aria-checked="true">
                                            <input  type="radio" tabindex="-1" autocomplete="off" class="el-radio-button__orig-radio"  name="e" checked="" @change="fenlei('');"><span class="el-radio-button__inner" >全部</span></label></div>
                                        <?php
                                        $a=$DB->query("select * from qingka_wangke_fenlei where sort=0  ORDER BY `sort` ASC");
                                        while($rs=$DB->fetch($a)){
                                        ?>
                                        <div role="radiogroup" class="el-radio-group">
            <label role="radio" tabindex="0" class="el-radio-button el-radio-button--small is-active" aria-checked="true">
                            <input type="radio" tabindex="-1" autocomplete="off" class="el-radio-button__orig-radio" name="e" @change="fenlei(<?=$rs['id']?>);"><span class="el-radio-button__inner"><?=$rs['name']?></span></label></div> 
                                        <?php } ?>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <?php }?>
                        <?php if ($conf['flkg']=="1"&&$conf['fllx']=="2") {?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>渠道项目</strong></label>
                            <div class="col-sm-9">
                                <div class="col-xs-14">
                                    <div class="example-box">
                                        <?php
                                        $a=$DB->query("SELECT * FROM qingka_wangke_fenlei WHERE status!= 0 AND status!= 2 AND status!= 4 ORDER BY `sort` ASC;");
                                        while($rs=$DB->fetch($a)){
                                        ?>
                                        <div role="radiogroup" class="el-radio-group">
            <label role="radio" tabindex="0" class="el-radio-button el-radio-button--small is-active" aria-checked="true">
                            <input type="radio" tabindex="-1" autocomplete="off" class="el-radio-button__orig-radio" name="e" @change="fenlei(<?=$rs['id']?>);"><span class="el-radio-button__inner"><?=$rs['name']?></span></label></div> 
                                        <?php } ?>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <?php }?>
                        						<div class="form-group">
                            <label class="col-sm-2 control-label">选择平台</label>
                        <div class="col-sm-9">
                            <el-select id="select" v-model="cid" filterable @change="tips(cid)" popper-class="lioverhide" :popper-append-to-body ="false" placeholder="请先选择平台(支持搜索)" style=" scroll 99%;   width:100%">
                                    <el-option v-for="class2 in class1" :key="class2.cid" :label="class2.name+'('+class2.price+'积分)'" :value="class2.cid">
                                    <span style="float: left">&nbsp;{{ class2.name }}</span>
                                    <span style="float: right; color: #8492a6; font-size: 13px">{{ class2.price }}积分</span>
                                        </el-option>
                                  </el-select>					
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">信息填写</label>
                            <div class="col-sm-9">	
                            <el-input v-model="userinfo" placeholder="请输入下单信息" prefix-icon="el-icon-search"></el-input>
                            </div>
                        </div>
                        
                        <!--只显示哪些cid-->
                        <div class="form-group" v-if="cid == 846">
    <label class="col-sm-2 control-label">区域选择</label>
    <div class="col-sm-9">
        <el-radio-group v-model="selectedRegion">
        <el-radio label="随机">随机</el-radio>
            <el-radio label="南京">南京</el-radio>
            <el-radio label="青岛">青岛</el-radio>
            <el-radio label="拉萨">拉萨</el-radio>
            <el-radio label="成都">成都</el-radio>
            <el-radio label="重庆">重庆</el-radio>
            <el-radio label="河北">河北</el-radio>
            <el-radio label="佛山">佛山</el-radio>
            <el-radio label="新疆">新疆</el-radio>
            <el-radio label="芜湖">芜湖</el-radio>
            <el-radio label="长沙">长沙</el-radio>
            <el-radio label="黑龙江">黑龙江</el-radio>
            <el-radio label="长春">长春</el-radio>
        </el-radio-group>
    </div>
</div>


                        

                                                         <div class="form-group">
                                                        <label class="col-sm-2 control-label">商品介绍</label>
                                                        <div class="col-sm-9">
                                                            <b>
                                                                <span class="help-block m-b-none"
                                                                    style="color:blue;">项目对接ID：<span
                                                                        v-html="duijieid"></span>
                                                                    <span class="help-block m-b-none"
                                                                        style="color: rgb(54, 154, 255);"><span
                                                                            v-html="content"></span>

                                                                    </span>
                                                            </b>
                                                        </div>
                                                    </div>
                  	    <div class="col-sm-offset-2">
    <el-button type="primary" @click="get" icon="el-icon-search" round>立即查询</el-button>
    <el-button type="primary" @click="add" icon="el-icon-circle-check" round>提交订单</el-button>
    <el-button type="success" @click="saveclass" icon="el-icon-star-on" round>收藏项目</el-button>
    <el-button type="danger" @click="dellclass" icon="el-icon-star-off" round>移出收藏</el-button>
</div>
             </el-form>
           </div>
         </div>
        </div>
      </div>
       
       
      <div class="layui-col-xs12 layui-col-md4 hide-on-mobile" style="padding-left: 10px; box-sizing: border-box;">
  <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px; position: relative;">
    <!-- 调整图片位置，使其向下 -->
    <div class="panel-image" style="position: absolute; top: 150px; right: 10px; width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
      <img src="/assets/images/1.gif" alt="Announcement" style="width: 100%; height: auto;">
    </div>
    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">最新通知</div>
    <div class="panel-body" style="margin-left:0;">
      <!-- 公告列表 -->
      <ul class="custom-notice-list">
        <li style="color: #ff4757;">欢迎老板们下单，任何项目嫌贵只要有量包价格满意</li><br>
        <li style="color: #1e90ff;">1000可开本站VIP密价扶持~并且赠送自助下单商城一条龙~</li><br>
        <li style="color: #2ed573;">客户自助查单：<a href="http://<?echo($_SERVER['SERVER_NAME']);?>/get"  target="_blank"><?echo($_SERVER['SERVER_NAME']);?>/get</a></li><br>
        <li style="color: #ff6348;">下单有疑虑可看今日推荐</li><br>
        <li style="color: #1e90fh;">每30天自动清理15天以上不登陆且0充值用户</li><br>
        <li style="color: #20b2aa;">项目能查课的基本上都能下</li><br>
        <li style="color: #778899;">有问题请及时联系上级或提交工单</li>
      </ul>
    </div>
  </div>
</div>
       
       
 </div>
         <div class="scrolling-wrapper">
  <div class="scrolling-content">
    <span class="announcement">欢迎老板们下单！</span>
  </div>
</div>

 
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
  <div class="panel-heading font-bold" style="border-radius: 8px; background: linear-gradient(135deg, #f9f9f9, #ececec); padding: 15px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    查询结果 &nbsp;
    

   <a class="el-button el-button--primary is-plain el-button--mini" style="padding: 6px 12px; border-radius: 4px; color: #3498db; background-color: #eaf4fc; border: 1px solid #3498db; transition: all 0.3s ease; text-decoration: none;" @click="selectAll()">全选</a>
    <button type="button" class="el-button el-button--primary is-plain el-button--mini" style="padding: 6px 12px; border-radius: 4px; color: #3498db; background-color: #eaf4fc; border: 1px solid #3498db; transition: all 0.3s ease; cursor: pointer;" @click="copyCourses">
        复制
<button type="button" 
        class="el-button el-button--primary is-plain el-button--mini" 
        :class="{ 'red-button': showCourseImagesFlag }" 
        style="padding: 6px 12px; border-radius: 4px; color: #3498db; background-color: #eaf4fc; border: 1px solid #3498db; transition: all 0.3s ease; cursor: pointer;"
        @click="showCourseImages">
    {{ showCourseImagesFlag? '关闭图片' : '显示图片' }}
</button>
   
</div>

<div class="panel-body">
    <form class="form-horizontal devform">    
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div v-for="(rs, key) in row">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">                
                <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+key" aria-expanded="true" >
                  <b>{{ rs.userName }}</b>  {{ rs.userinfo }} <span v-if="rs.msg=='查询成功'"><b style="color: green;">{{ rs.msg }}</b></span><span v-else-if="rs.msg!='查询成功'"><b style="color: red;">{{ rs.msg }}</b></span>
                </a>
              </h4>
            </div>
            <div :id="key" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
               <!-- Column container -->
                    <div class="column-container" :style="{'--show-images': showCourseImagesFlag? '1' : '0'}">
               <!-- Column items -->
                  <div v-for="(res, key) in rs.data" class="column-item" :class="{ 'selected': res.checked }">
                    <label class="layui-table lyear-checkbox checkbox-inline checkbox-success">
                      <li>
                        <input style="margin-left: 0px;" v-model="res.checked" name="checkbox" type="checkbox" :value="res.name" @click="checkResources(rs.userinfo, rs.userName, rs.data, res.id, res.name)">
                        <span>
                          <!-- 课程图片 -->
                          <img
                            v-if="res.imageurl&& showCourseImagesFlag"
                            :src="res.imageurl"
                            alt="课程图片"
                            referrerpolicy="no-referrer"
                            :style="{ borderRadius: '10%' }" />
                          <p>
                            <!-- 课程名称和状态 -->
                            {{ res.name }}
                            <b v-if="res.state !== ''"> {{ res.state }} </b>
                            <b v-else> - 开课中 </b>
                          </p>
                          <!-- 课程ID和教师信息，分别显示在两行 -->
                          <div v-show="res.id">课程ID：{{ res.id ? (res.id.length > 25 ? res.id.slice(0,25)+'...' : res.id) : '暂无' }}</div>
                          <div v-show="res.teachername">教师：{{ res.teachername || '暂无' }}</div>
                        </span>
                      </li>
                    </label>
                  </div>
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
    <div class="panel-heading font-bold bg-white" style="border-radius: 10px; color: #3498db;">注意事项</div>
    <div class="panel-body">
        <ul class="layui-timeline">
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis" style="color: #e74c3c;"></i>
                <div class="layui-timeline-content layui-text" style="color: #2ecc71;">
                    <p>请务必查看项目下单须知和说明，防止出现错误！</p>
                </div>
            </li>
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis" style="color: #9b59b6;"></i>
                <div class="layui-timeline-content layui-text" style="color: #f1c40f;">
                    <p>同商品重复下单，请修改密码后再下！</p>
                </div>
            </li>
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis" style="color: #34495e;"></i>
                <div class="layui-timeline-content layui-text" style="color: #1abc9c;">
                    <p>默认下单格式为学校、账号、密码(空格分开)！</p>
                </div>
            </li>
            <li class="layui-timeline-item">
                <i class="layui-icon layui-timeline-axis" style="color: #d35400;"></i>
                <div class="layui-timeline-content layui-text" style="color: #7f8c8d;">
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


<script>
function TgTips() {
    var jrtjValue = `✅有问题请提交工单<br>
✅学习通推荐下：<br>
✅智慧树推荐下：<br>
✅智慧职教推荐：<br>
✅随行课堂推荐下：<br>
✅U校园推荐下：<br>
✅学习强国推荐下：<br>
（自行前往add2.php第590-596行修改添加推荐）`;//添加完推荐后删除括号以及括号里面的内容！！！注意括号后面的引号不要删了,<br>是换行符
    layer.alert('<span style="color: red;">' + jrtjValue + '</span>', {
        title: '今日推荐',
        skin: 'layui-layer-molv layui-layer-wxd',
        shadeClose: true
    });
}
</script>
<script>
function TgTips2() {
    var jrtjValue = `本台只上架市面热门项目,需要全面项目可联系上级~`;
    layer.alert('<span style="color: red;">' + jrtjValue + '</span>', {
        title: '最近上新',
        skin: 'layui-layer-molv layui-layer-wxd',
        shadeClose: true
    });
}
</script>


<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="js/ai.js"></script>
<script type="text/javascript" src="../index/assets/js/vue.min.js"></script>
<script type="text/javascript" src="../index/assets/js/vue-resource.min.js"></script>
<script type="text/javascript" src="assets/js/axios.min.js"></script>

<script src="./assets/js/element.js"></script>
     <script>
        layer.alert('各位老板，下单之前请仔细查看下方下单通知以及商品的详细介绍哦！'
        , {
            time: 8 * 1000,
            btn: ['确定'],  // 定义一个确定按钮
            closeBtn: 0,   // 禁用关闭按钮
            maxmin: false, // 禁用最大化按钮
            yes: function(index) {  // “确定”按钮的回调
                layer.msg('注意看下单推荐。');  // 显示消息
                layer.close(index);  // 关闭当前弹窗
            },
            success: function(layero, index) {
                var timeNum = this.time / 1000;
                var setText = function(start) {
                    layer.title((start ? timeNum : --timeNum) + ' 秒后关闭', index);
                };
                setText(true);
                this.timer = setInterval(setText, 1000);
                if (timeNum <= 0) clearInterval(this.timer);
            },
            end: function() {
                clearInterval(this.timer);
            }
        });
    </script>
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
        duijieid: '',
        class1: '',
        class3: '',
        activems: false,
        checked: false,
        content: '',
        useVfidder: false, // 默认关闭
        money: 0, // 初始化余额为0
        freeadd: 0,
        selectedRegion: '随机',
        showCourseImagesFlag: false,
        selectedPlatformPrice: 0 // 新增：存储当前选择平台的价格
    },
    methods: {
        get: function(salt) {
            if (this.cid == '' || this.userinfo == '') {
                layer.msg("所有项目不能为空");
                return false;
            }
            if (this.useVfidder) {
                this.userinfo = vfidder(this.userinfo);
            }
            userinfo = this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");
            userinfo = userinfo.split('[br]'); //分割
            this.row = [];
            this.check_row = [];
            this.checked = false; // Reset the checked status when performing a new query
            for (var i = 0; i < userinfo.length; i++) {
                info = userinfo[i]
                if (info == '') { continue; }
                var hash = getENC('<?php echo $addsalt;?>');
                var loading = layer.load(3);
                this.$http.post("/apisub.php?act=get", {
                    cid: this.cid,
                    userinfo: info,
                    hash
                }, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(loading);
                    if (data.body.code == -7) {
                        salt = getENC(data.body.msg);
                        vm.get(salt);
                    } else {
                        this.row.push(data.body);
                    }
                });
            }
        },
        saveclass: function() {
        this.$http.post("/apisub.php?act=add_favorite", { cid: this.cid }, { emulateJSON: true }).then(function(response) {
            if (response.data.code == 1) {
                layer.msg("收藏成功", { icon: 1 });
            } else {
                layer.msg(response.data.msg, { icon: 2 });
            }
        });
    },  
        dellclass: function() {
        this.$http.post("/apisub.php?act=remove_favorite", { cid: this.cid }, { emulateJSON: true }).then(function(response) {
            if (response.data.code == 1) {
                layer.msg("移除成功", { icon: 1 });
            } else {
                layer.msg(response.data.msg, { icon: 2 });
            }
        });
    },
        copyCourses() {
            if (this.row.length === 0) {
                layer.msg("没有可复制的课程信息");
                return;
            }

            let message = `温馨提示：请选择安排的课程-回复数字即可-务必正确否则自负\n--------------你当前的课程列表--------------\n`;

            let courseNumber = 1;
            for (let rs of this.row) {
                for (let res of rs.data) {
                    message += `课程${courseNumber}：${res.name}\n`;
                    courseNumber++;
                }
            }

            message += `------------------------------------------`;

            // 创建一个临时的文本区域，复制内容到剪贴板
            const tempTextArea = document.createElement("textarea");
            tempTextArea.value = message;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();
            document.execCommand("copy");
            document.body.removeChild(tempTextArea);

            layer.msg("课程列表已复制到剪贴板");
        },
        add: function() {
            if (this.cid == '') {
                if (this.nochake != 1) {
                    layer.msg("请先查课");
                    return false;
                }
            }
            if (this.check_row.length < 1) {
                if (this.nochake != 1) {
                    layer.msg("请先选择课程");
                    return false;
                }
            }
            var loading = layer.load();
            score = $("#range_02").val();
            shichang = $("#range_01").val();
            this.$http.post("/apisub.php?act=add", {
                cid: this.cid,
                data: this.check_row,
                shichang: shichang,
                score: score,
                shu: this.shu,
                bei: this.bei,
                userinfo: this.userinfo,
                nochake: this.nochake,
                region: this.selectedRegion
            }, {
                emulateJSON: true
            }).then(function(data) {
                layer.close(loading);
                if (data.data.code == 1) {
                    var submittedCoursesCount = this.check_row.length; // 获取提交的课程数量
                    this.row = [];
                    this.check_row = [];
                    // 显示提交成功的消息，并包含提交的课程数量
                    layer.msg('提交成功' + submittedCoursesCount + '门课程', { icon: 1, time: 2000 });
                } else {
                    this.$message({ type: 'error', showClose: true, message: data.data.msg });
                }
            });
        },

        getUserInfo() {
            //调用主页的用户信息接口
            this.$http.get('/apisub.php?act=userinfo').then(response => {
                if (response.body.code === 1) {
                    this.money = response.body.money; // 更新余额
                    this.freeadd = response.body.freeadd; // 更新余额
                } else {
                    console.error("获取用户信息失败:", response.body.msg);
                }
            }).catch(error => {
                console.error("请求用户信息接口失败", error);
            });
        },

        check888: function(userinfo, userName, rs, name) {
            var btns = document.getElementById("btns");
            var zk = document.getElementById("s1");
            var x = zk.getElementsByTagName("input");
            if (btns.checked == true) {
                for (var i = 0; i < x.length; ++i) {
                    data = { userinfo, userName, data: rs[i] };
                    x[i].checked = true;
                    vm.check_row.push(data);
                }
            } else {
                for (var i = 0; i < x.length; ++i) {
                    x[i].checked = false;
                }
                this.check_row = []
            }
        },
        selectAll: function() {
    if (this.cid == '') {
        layer.msg("请先查课");
        return false;
    }
    this.checked = !this.checked;
    if (this.checked) {
        this.check_row = []; // 清空数组，确保全选时是全新的选择
        let selectedCount = 0;
        this.row.forEach((item) => {
            const userinfo = item.userinfo;
            const userName = item.userName;
            item.data.forEach((course) => {
                const data = { userinfo, userName, data: course };
                this.check_row.push(data);
                course.checked = true;
                selectedCount++;
            });
        });
        const totalPoints = (selectedCount * this.selectedPlatformPrice).toFixed(2); // 使用当前选择平台的价格计算积分并保留两位小数
        layer.msg(`已全选 ${selectedCount} 门课程，需扣除 ${totalPoints} 积分`);
    } else {
        this.check_row = [];
        this.row.forEach((item) => {
            item.data.forEach((course) => {
                course.checked = false;
            });
        });
        layer.msg('已取消全选');
    }
    this.$forceUpdate(); // 强制更新视图
    console.log(this.check_row);
},
        checkResources: function (userinfo, userName, rs, id, name) {
    var course;
    if (id) {
        course = rs.find(function (course) {
            return course.id === id;
        });
    } else {
        course = rs.find(function (course) {
            return course.name === name;
        });
    }

    var data = {
        userinfo: userinfo,
        userName: userName,
        data: course
    };

    var index = this.check_row.findIndex(function (item) {
        return item.data.id === course.id && item.userinfo === userinfo;
    });

    if (index!== -1) {
        this.check_row.splice(index, 1);
        course.checked = false;
    } else {
        this.check_row.push(data);
        course.checked = true;
    }

    var selectedCount = this.check_row.length;
    var totalPoints = (selectedCount * this.selectedPlatformPrice).toFixed(2); // 使用当前选择平台的价格计算积分并保留两位小数
    layer.msg(`已勾选 ${selectedCount} 门课程，需扣除 ${totalPoints} 积分`);
    this.$forceUpdate(); // 强制更新视图
},
        fenlei: function(id) {
            var load = layer.load(3);
            this.$http.post("/apisub.php?act=getclassfl", { id: id }, { emulateJSON: true }).then(function(data) {
                layer.close(load);
                if (data.data.code == 1) {
                    this.class1 = data.body.data;
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        getclass: function() {
            var load = layer.load(3);

            this.$http.post("/apisub.php?act=getclass").then(function(data) {
                layer.close(load);
                if (data.data.code == 1) {
                    this.class1 = data.body.data;
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        getnock: function(cid) {
            this.$http.post("/apisub.php?act=getnock").then(function(data) {
                if (data.data.code == 1) {
                    this.nock = data.body.data;
                    for (i = 0; this.nock.length > i; i++) {
                        if (cid == this.nock[i].cid) {
                            this.nochake = 1;
                            break;
                        } else {
                            this.nochake = 0;
                        }
                    }
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        tips: function(message) {
            for (var i = 0; i < this.class1.length; i++) {
                if (this.class1[i].cid == message) {
                    this.show = true;
                    this.content = this.class1[i].content;
                    this.duijieid = this.class1[i].cid;
                    this.selectedPlatformPrice = Number(this.class1[i].price); // 获取当前选择平台的价格
                    return;
                }
            }
        },
        tips2: function() {
            layer.tips('开启秒刷将额外收0.05 的费用 ', '#miaoshua');
        },
        showCourseImages () {
            this.showCourseImagesFlag = !this.showCourseImagesFlag;
        }
    },
    mounted () {
        this.getclass ();
        this.getUserInfo (); // 在页面加载时调用 getUserInfo 方法来获取并显示余额
    }
});
</script>