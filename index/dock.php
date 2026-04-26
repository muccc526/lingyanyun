<?php
$mod='blank';
$title='平台对接';
require_once('head.php');
$fl=$DB->count("select addprice from qingka_wangke_user where uid='{$userrow['uid']}'");
$ck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API查课' AND uid='{$userrow['uid']}' ");
$xd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API添加任务' AND uid='{$userrow['uid']}' ");
$xdbxz=15;
$xdb=round($xd/$ck,4)*100;
?>
     <div class="app-content-body ">
        <div class="wrapper-md control">
        <div class="layui-row layui-col-space8 layui-anim layui-anim-upbit">
        <div  class="card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <ul class="nav nav-tabs" role="tablist">
            <li class="active">
              <a data-toggle="tab" href="#ck">查课接口</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#xd">下单接口</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#bs">补刷接口</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#jd">进度同步</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#kcid">课程对接ID</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#xx">我的信息</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active in" id="ck">
                <pre><h5>POST:</h5>https://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=get</pre>
                                <table class="table table-bordered table-striped">
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
            <div class="tab-pane fade" id="xd">
             <pre><h5>POST:</h5>https://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=add</pre>
                                    <table class="table table-bordered table-striped">
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
                                            <td><code>账号密码</code></td>
                                            <td class="text-center"><code>必传</code></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center" scope="row">kcname</th>
                                            <td><code>课程名字</code></td>
                                            <td class="text-center"><code>必传</code></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center" scope="row">kcid</th>
                                            <td><code>课程ID</code></td>
                                            <td class="text-center"><code>必传</code></td>
                                        </tr>
                                        </tbody>
                                    </table>
            </div>
            <div class="tab-pane fade" id="bs">
                <pre><h5>POST:</h5>https://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=budan</pre>
                    <table class="table table-bordered table-striped">
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
                                        <th class="text-center" scope="row">id</th>
                                        <td><code>订单账号</code></td>
                                        <td class="text-center"><code>必传</code></td>
                                    </tr>
                                    </tbody>
                                </table>
            </div>
            <div class="tab-pane fade" id="jd">
                <pre><h5>POST:</h5>https://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=chadan</pre>
                    <table class="table table-bordered table-striped">
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
                                            <th class="text-center" scope="row">user</th>
                                            <td><code>订单账号</code></td>
                                            <td class="text-center"><code>必传</code></td>
                                        </tr>
                                        </tbody>
                                    </table>
            </div>
            <div class="tab-pane fade" id="kcid">
                <div class="modal-content">
                    <div class="table-responsive"> 
						<table class="table table-striped">
							<thead><tr><th>对接ID</th><th>商品名称</th><th>你的价格</th></thead>
								<tbody>
									<?php 
										$a=$DB->query("select * from qingka_wangke_class where status=1 ");
										while($rs=$DB->fetch($a)){
										echo "<tr><td>".$rs['cid']."</td><td>".$rs['name']."</td><td>".$rs['price']*$fl."</td></tr>"; 
										}
									?>
                            	</tbody>
						</table>
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
										    if($rs['key']==0){
										    $rs['key']="未开通KEY";
										    echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>".$xdbxz."%</td><td>".$xdb."%</td></tr>"; 
										    }else{
										        echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>".$xdbxz."%</td><td>".$xdb."%</td></tr>"; 
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
 

<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
<script src="assets/layui/layui.js"></script>
<script src="assets/js/element.js"></script>


<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
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