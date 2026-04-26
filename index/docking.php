<?php
$mod='blank';
$title='平台对接';
require_once('head.php');
$fl=$DB->count("select addprice from qingka_wangke_user where uid='{$userrow['uid']}'");
/*$ck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API查课' AND uid='{$userrow['uid']}' ");
$xd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API添加任务' AND uid='{$userrow['uid']}' ");
$xdbxz=15;
$xdb=round($xd/$ck,4)*100;*/
?>
<link href="//unpkg.com/layui@2.8.6/dist/css/layui.css" rel="stylesheet">
<div class="app-content-body ">
    <div class="wrapper-md control">
        <div class="layui-row layui-col-space8 layui-anim layui-anim-upbit">
            <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active">
                      <a data-toggle="tab" href="#ck">29对接代码</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#xc">小储/彩虹对接</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#kcid">课程ID</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#flid">分类ID</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#dj">POST对接</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#cd">POST售后</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#xx">我的信息</a>
                    </li>
                    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="ck">
                        <blockquote class="layui-elem-quote layui-quote-nm">
                            <span style="color: #6699FF;">API查课:<?php echo $ck ?>次 / API下单:<?php echo $xd ?>单 / 比例:<?php echo $xdb.'%' ?> </span><br>
							<span style='color: #FF0033;'>注: API下单/API查课＜<?php echo $conf['api_proportion'].'%' ?>调用API查课，每查一次将会扣0.1积分</span>
						</blockquote>
                        <pre class="layui-code code-demo" lay-title="对接地址">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=add</pre>
                                        
                        <pre class="layui-code code-demo" lay-title="标识" lay-options="{}">
//本站标识 放在/Checkorder/xdjk.php 文件
"xy" => "小月", 

                        </pre>
                        <pre class="layui-code code-demo" lay-title="29查课代码" lay-options="{}">
//本站学习平台查课接口 放在/Checkorder/ckjk.php 文件
    if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
</pre>
<pre class="layui-code code-demo" lay-title="29进度代码" lay-options="{}">
//本站学习平台进度接口放在checkorder/jdjk.php内
else if ($type == "xy") { 
    $uu_rl = $a["url"];
    if (!empty($yid)) {
        $uu_url = "$uu_rl/api.php?act=chadan2"; 
        $data = array("yid" => $yid);
    } else {
        $uu_url = "$uu_rl/api.php?act=chadan";
        $data = array("username" => $user);
    }
    $result = get_url($uu_url, $data); 
    $result = json_decode($result, true); 
    
    if ($result["code"] == "1") { 
        foreach ($result["data"] as $res) { 
            $yid = $res["id"]; 
            $kcname = $res["kcname"]; 
            $status = $res["status"]; 
            $process = $res["process"]; 
            $remarks = $res["remarks"]; 
            $kcks = $res["courseStartTime"]; 
            $kcjs = $res["courseEndTime"]; 
            $ksks = $res["examStartTime"]; 
            $ksjs = $res["examEndTime"];

            $b[] = array(
                "code" => 1, 
                "msg" => "查询成功", 
                "yid" => $yid, 
                "kcname" => $kcname, 
                "user" => $user, 
                "pass" => $pass, 
                "ksks" => $ksks, 
                "ksjs" => $ksjs, 
                "status_text" => $status, 
                "process" => $process, 
                "remarks" => $remarks
            ); 
        } 
    } else { 
        $b[] = array("code" => -1, "msg" => $result["msg"]); 
    } 
    
    return $b;
}
</pre>
<pre class="layui-code code-demo" lay-title="29下单代码" lay-options="{}">
//本站学习平台下单接口放在checkorder/xdjk.php内
        if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid, "shichang" => $shichang, "score" => $score);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
        } else {
        $b = array("code" => -1, "msg" => $result["msg"]);
        }
    return $b;
    }
</pre>
<pre class="layui-code code-demo" lay-title="29补刷代码" lay-options="{}">
//本站学习平台补刷接口放在checkorder/bsjk.php内
    if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
                        </pre>
                    </div>
                    <div class="tab-pane fade" id="flid">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<thead><tr><th>分类ID</th><th>分类名称</th></thead>
        								<tbody>
        									<?php 
        										$a=$DB->query("select * from qingka_wangke_fenlei where status=1 ");
        										while($rs=$DB->fetch($a)){
        										echo "<tr><td>".$rs['id']."</td><td>".$rs['name']."</td></tr>"; 
        										}
        									?>
                                    	</tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                      <div class="tab-pane fade" id="dj">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<pre class="layui-code code-demo" lay-title="查课">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=get</pre>
        							<pre class="layui-code code-demo" lay-title="对接">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=add</pre>
        							
                                        <table class="layui-table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width:100px">请求参数</th>
                                                <th>
                                                    说明<br>
                                                </th>
                                                <th class="text-center" style="width:100px">
                                                    传输类型<br>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <tr>
                                                    <th class="text-center" scope="row">uid</th>
                                                    <td><code>登录验证</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" scope="row">key</th>
                                                    <td><code>登录验证</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" scope="row">platform</th>
                                                    <td><code>平台ID</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
        
                                                <tr>
                                                    <th class="text-center" scope="row">user</th>
                                                    <td><code>学生账号</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" scope="row">pass</th>
                                                    <td><code>学生密码</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
                                                 <tr>
                                                    <th class="text-center" scope="row">school</th>
                                                    <td><code>学生学校</code></td>
                                                    <td class="text-center"><code>必传</code></td>
                                                </tr>
                                            </tr>
                                            </tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    <div class="tab-pane fade" id="cd">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<pre class="layui-code code-demo" lay-title="补单">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=budan</pre>
        							<pre class="layui-code code-demo" lay-title="29查单">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=chadan</pre>
        							<pre class="layui-code code-demo" lay-title="进阶查单（非专业人士别动）">http://<?echo($_SERVER['SERVER_NAME']);?>/api/search?uid=</pre>
        							
                                        <table class="layui-table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width:100px">请求参数</th>
                                                <th>
                                                    说明<br>
                                                </th>
                                                <th class="text-center" style="width:100px">
                                                    传输类型<br>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <tr>
                                                <th class="text-center" scope="row">uid</th>
                                                <td><code>登录验证</code></td>
                                                <td class="text-center"><code>补单必传(查单非必传)</code></td>
                                            </tr>
                                            <tr>
                                                <th class="text-center" scope="row">key</th>
                                                <td><code>登录验证</code></td>
                                                <td class="text-center"><code>补单必传(查单非必传)</code></td>
                                                </tr>
                                            <tr>
                                                <th class="text-center" scope="row">id</th>
                                                <td><code>订单账号</code></td>
                                                <td class="text-center"><code>必传</code></td>
                                            </tr>
                                            </tr>
                                            </tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kcid">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<thead><tr><th>对接ID</th><th>分类ID</th><th>商品名称</th><th>你的价格</th></thead>
        								<tbody>
        									<?php 
        										$a=$DB->query("select * from qingka_wangke_class where status=1 ");
        										while($rs=$DB->fetch($a)){
        										echo "<tr><td>".$rs['cid']."</td><td>".$rs['fenlei']."</td><td>".$rs['name']."</td><td>".$rs['price']*$fl."</td></tr>"; 
        										}
        									?>
                                    	</tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="xx">
                    <div class="modal-content">
                        <div class="table-responsive"> 
    						<table class="table table-striped">
    							<thead><tr><th>对接ID</th><th>对接KEY</th><th>下单比限制</th><th>当前下单比</th></thead>
    								<tbody>
    									<?php 
    										$a=$DB->query("select * from qingka_wangke_user where uid='{$userrow['uid']}'");
    										
    										while($rs=$DB->fetch($a)){
    										    if($userrow['key']=="0"){
    										    $rs['key']="未开通KEY";
    										    echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>". $conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }else{
    										        echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>".$conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }
    										}
    									?>
                                	</tbody>
    							</table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="xc">
                     <div class="modal-content">
        <div class="wrapper-md control">
        	
	      <div class="panel panel-default">
		    <div class="panel-heading font-bold bg-white">小储云对接（自定义访问URL</div>
				 <div class="panel-body">
				     
				     <br>
				     
                                 发货配置选择：自定义访问域名URL，URL如下所示
                                 <pre class="layui-code code-demo" lay-title="自定义访问域名URL">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=add</pre>   <br>
								 
								 请求头信息 Header内容  ： 空着不填写  <br><br>
								 
								 
接下来就是填写  POST提交参数  ，但是请注意，平台的网课分为两种，需要kcid和不需要kcid。请自行查课测试<br>
比如课程名后没有id的就不需要kcid。<br>
比如课程名后有id的就需要且必须要有kcid。<br><br><br>


第一种，不需要kcid参数的分类，POST提交参数如下：<pre class="layui-code code-demo" lay-title="输入框规格参数" lay-options="{}">
uid|你自己的uid
key|你自己的KEY
platform|平台的ID
school|[input3]
user|[input1]
pass|[input2]
kcname|[input4] </pre>

输入框规格参数 如下：<pre class="layui-code code-demo" lay-title="输入框规格参数" lay-options="{}">
手机号|密码|学校|课程名</pre><br><br>


第二种，需要且必须要有kcid参数的分类，POST提交参数如下：<pre class="layui-code code-demo" lay-title="POST提交参数" lay-options="{}">
uid|你自己的uid
key|你自己的uid
platform|平台的ID
school|[input3]
user|[input1]
pass|[input2]
kcid|[input4]
kcname|[input5]</pre>

输入框规格参数 如下：<pre class="layui-code code-demo" lay-title="输入框规格参数" lay-options="{}">
手机号|密码|学校|课程ID|课程名
</pre>
		    </div>
		  </div>
                    
                    <div class="tab-pane fade" id="xx">
                    <div class="modal-content">
                        <div class="table-responsive"> 
    						<table class="table table-striped">
    							<thead><tr><th>对接ID</th><th>对接KEY</th><th>下单比限制</th><th>当前下单比</th></thead>
    								<tbody>
    									<?php 
    										$a=$DB->query("select * from qingka_wangke_user where uid='{$userrow['uid']}'");
    										
    										while($rs=$DB->fetch($a)){
    										    if($userrow['key']=="0"){
    										    $rs['key']="未开通KEY";
    										    echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>". $conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }else{
    										        echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>".$conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }
    										}
    									?>
                                	</tbody>
    							</table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 

<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="assets/layui/layui.js"></script>  
<script src="assets/js/element.js"></script>


<script>
    layui.use('element', function(){
      var element = layui.element;
      
      //…
    });
</script>

<script>
new Vue({
	el:"#loglist",
	data:{
		row:null
	},
	methods:{
		get:function(page){

		}
	},
	mounted(){
		this.get(1);
	}
});
</script>
<script>
layui.use(function(){
  // code
  layui.code({
    elem: '.code-demo',
    skin: 'dark',
    about: false,
    ln: false,
    header: true,
    preview: false,
    //tools: ['full', 'copy']
  });
})
//点击复制
/*function copyToClip(content, message = null) {
        var aux = document.createElement("input");
        aux.setAttribute("value", content);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        if (message == null) {
            layer.msg("复制成功", {icon: 1});
        } else {
            layer.msg(message, {icon: 1});
        }
    }*/
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