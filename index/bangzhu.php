<?php
$mod='blank';
$title='帮助中心';
require_once('head.php');
$fl=$DB->count("select addprice from qingka_wangke_user where uid='{$userrow['uid']}'");
?>
<link href="//unpkg.com/layui@2.8.6/dist/css/layui.css" rel="stylesheet">
<div class="app-content-body ">
    <div class="wrapper-md control">
        <div class="layui-row layui-col-space8 layui-anim layui-anim-upbit">
            <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active">
                      <a data-toggle="tab" href="#ckxd">查课下单</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#xxt">学习通问题</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#zhs">智慧树问题</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#dl">代理添加教程</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="ckxd">
                       <blockquote class="layui-elem-quote layui-quote-nm">
							<span style='color: #FF0033;'>左边功能栏找到订单提交页面具体操作如下</span>
							<img src="6.png" alt="操作步骤" />
						</blockquote> 
                      </div> 
                      
                
                    <div class="tab-pane fade" id="xxt">
                       <blockquote class="layui-elem-quote layui-quote-nm">  
  <span style='color: #FF0033;'>学习通常见问题</span>  
</blockquote>
<div class="panel-body">完成时间：<span style="color: orange;">慢刷3天/科 快看1天/科 秒刷1～3小时/科</span><br />处理内容：<a>视频+章测+考试</a><br />注意事项：<br /><a>1，目前平台内慢刷的学习通清除概率小于5%<br />2，在没有认为干扰情况下，夜间将不在进行任何操作。<br />3，目前夜间不操作的情况下，白天的上号时间为8-23点，看视频的时长大概在500分钟左右。<br /></a><hr /><br /><span style="color: blue;">❤常见问题解决方案：<br /></span>①被清除了进度的<br />②别的平台清除了的<br />③点了重刷卡住的<br />按照以下操作：<br />1.白天尽可能避免登录账号，同时在夜间禁止点击重刷，重刷会在夜里重启账号，将会突破防检测机制<br />2.别的平台清除的，请不要进行任何操作，给账号一天的真空期，在24h后在下单到本平台的慢刷<br />3,重刷卡住的，禁上下单平台多个项目，不同的项目是不同服务器在跑单， 下了秒刷又下慢刷，平台不会因为你下了多个 项目就暂停一个，所有的服务器都会一起刷。切忌下了秒刷后平台未显示完成又下其他项目，同样需要24h的真空期。<br />4.看到慢就点重刷：请先熟知目前的刷课效率：夜间不会刷，白天8-23点上号 ，刷完一个视频休息5分钟，查节测试提供10s间隔，所以白 天只能完成400-500分钟的学习时长，如果是1500分钟的课程，则需要最少三天左右，千万不要看着第一门课刷的慢以为是卡住了就重刷。</div>
</div>
                   <div class="tab-pane fade" id="zhs">
                       <blockquote class="layui-elem-quote layui-quote-nm">  
  <span style='color: #FF0033;'>智慧树常见问题</span>  
</blockquote>
<div class="panel-body">完成时间：<span style="color: orange;">慢刷10-20天 秒刷基本秒上号 10分钟完成</span><br />处理内容：<a>视频+测试+习惯分+见面课+考试 ps:秒刷没有习惯分</a><br />注意事项：<br /><a>1，每天走30分钟视频进度，当习惯天数学习完毕后，会一次性将剩下的内容完成！<br />2，具体如何查看当天刷没刷，请在课程-成绩-查看我的平时分中查看！<br />3，截止前48小时会一次性全部学完，不用担心学不完！<br /><a>4，秒刷会一次性将所有内容全部刷完，如果见面课未开放，后续请点补刷！<br />5，秒刷不包习惯分，非必要不要下秒刷</a>
</div>
</div>

            
            <div class="tab-pane fade" id="dl">
  
<blockquote class="layui-elem-quote layui-quote-nm">
							<span style='color: #FF0033;'>左边功能栏找到代理管理页面具体操作如下</span>
							<br />1.点击添加用户
							<br />2.填写相应信息
							<br />3.选择合适费率
							<br />（费率影响如下：如果你是0.2的费率，添加0.3费率，则他充值10元你赚3.333元，添加0.4费率，则他充值10元你赚5元 以此类推）
							<br />
							你旗下代理充值的时候页面将显示你的QQ<br />
充值扣费：扣除费用=充值金额*(我的总价格/代理价格)<br />
改价扣费：改价一次需要3元手续费，且代理余额会按照比例做相应调整<br />
费率价格：代理费率必须是0.05的倍数，如：0.4,0.45,0.5 等等，以此类推，但不能高于你的费率<br />

							
						</blockquote> 
            
             
                    
                    
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
<script src="//unpkg.com/layui@2.8.6/dist/layui.js"></script>  
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