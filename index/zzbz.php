<?php
$title='站长帮助';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
?>
<link href="//unpkg.com/layui@2.8.6/dist/css/layui.css" rel="stylesheet">
<div class="app-content-body ">
    <div class="wrapper-md control">
        <div class="layui-row layui-col-space8 layui-anim layui-anim-upbit">
            <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active">
                      <a data-toggle="tab" href="#jc">基础设置</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#jj">多线程设置</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#cs">出生redis4.0</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#get">自助查单</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#ts">推送通知</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#gy">关于模板</a>
                    </li>
                </ul>
                
               <div class="tab-content">  
    <div class="tab-pane fade active in" id="jc">  
        <blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">如果你能看到这里，恭喜你已经成功了一大步，那么接下进行一些基础操作吧</span><br>
            <span style="color: #6699FF;">本教程适合新入行小站长，日订单在20-200左右的新手</span><br> 
            <span style='color: #FF0033;'>基础版本配置要求服务器2H2G起步 宝塔—计划任务-访问URL 监控如下地址（还是强烈建议使用redis，这个容易提交重复订单）</span>  
        </blockquote>  
<pre class="layui-code code-demo" lay-title="提交订单，建议一分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=add</pre>
<pre class="layui-code code-demo" lay-title="同步非完成，建议10分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=update</pre>
<pre class="layui-code code-demo" lay-title="提交补刷中，建议10分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=update2</pre>
<pre class="layui-code code-demo" lay-title="提交进行中，建议10分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=update4</pre>
<pre class="layui-code code-demo" lay-title="提交待处理，建议10分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=update5</pre>
    </div>  


                    <div class="tab-pane fade" id="jj">
                        <div class="modal-content">
                                    <blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">进阶版也就是多线程，本模板配备有极为先进的多线程文件</span><br>
            <span style="color: #6699FF;">本教程适合中大型站长，日订单在200+左右的大佬</span><br> 
            <span style='color: #FF0033;'>基础版本配置要求服务器4H4G起步 宝塔—计划任务-访问URL 监控如下地址</span>  
        </blockquote>  
<pre class="layui-code code-demo" lay-title="提交入队,3-5分钟1次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis/redis_addru.php</pre>
<pre class="layui-code code-demo" lay-title="同步入队,10-30分钟1次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis/redis_ru.php</pre>
<pre class="layui-code code-demo" lay-title="实时入队,1分钟1次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis/bbru.php</pre>
<blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">PHP安装redis扩展 安装进程守护任意版本 安装完毕建议重启一下服务器</span><br> 
            <span style='color: #FF0033;'>软件商店 进程守护 添加如下进程守护</span>  
        </blockquote>  
<pre class="layui-code code-demo" lay-title="提交出队">名称 add 数量 1 启动命令 nohup php redis_addchu.php & 进程目录:网站根目录/redis/</pre>
<pre class="layui-code code-demo" lay-title="同步出队">名称 tb 数量 10 启动命令 nohup php redis_chu.php & 进程目录:网站根目录/redis/</pre>
<pre class="layui-code code-demo" lay-title="实时出队">名称 ss 数量 10 启动命令 nohup php bbchu.php & 进程目录：网站根目录/redis/</pre>
<pre class="layui-code code-demo" lay-title="批量补刷">名称 bs 数量 5  启动命令 nohup php plbs.php &  进程目录：网站根目录/redis/</pre>
<pre class="layui-code code-demo" lay-title="批量同步">名称 pl 数量 5  启动命令 nohup php pltb.php &  进程目录：网站根目录/redis/</pre>
        </div>
    </div>
<div class="tab-pane fade" id="gy">
    <div class="modal-content">
        <div class="table-responsive">
            <table class="table table-striped">
        		<blockquote class="layui-elem-quote layui-quote-nm">  
                <span style="color: #6699FF;">1.一键对接：
                <br>本模板已支持一键对接、支持上游分类对接、自定义Cid对接，可一键更新商品信息、可按分类
                </span><br>
                <span style='color: #CC6CE7;'>2.关于模板：
                <br>本模板是基于小月模板采用光年(Light Year Admin)后台管理系统重构而来，界面更加简洁、美观，修复了许多问题
                </span><br> 
                <span style='color: #FF0033;'>3.删除0充值用户：
                <br>本模板自带删除0充值用户，PHP安装redis扩展，然后在宝塔—计划任务-访问URL 监控如下地址
                <br>（直接访问下方地址也能删除！所以建议自行修改【delete.php】文件名）
                </span>  
                </blockquote>  
            <pre class="layui-code code-demo" lay-title="删除0充值用户，建议30天1次">http://<?echo($_SERVER['SERVER_NAME']);?>/tuisong/delete.php</pre><br> 
            <span style='color: #FF0033;'>（默认文件名为delete.php，建议修改文件名！如果有修改文件名，把【delete.php】改成您已修改的文件名即可）
                </span>
        	</table>
        </div>
    </div>
</div>
<div class="tab-pane fade active in" id="cs">  
        <blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">本模板已支持出生Redis 4.0，原版的cron、Redis如果提交订单有问题的话用出生Redis即可，同理，出生Redis4.0有问题换原版的多线程即可，灵活变换，不要死磕！</span> <br>
            <span style='color: #FF0033;'>下面内容为入队部分，请前往【宝塔—计划任务-访问URL】 监控如下地址</span> 
        </blockquote>  
<pre class="layui-code code-demo" lay-title="建议3-7分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/aaru.php</pre>
<pre class="layui-code code-demo" lay-title="建议1-3分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/chushengadd.php</pre>
<pre class="layui-code code-demo" lay-title="建议2分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/bbru.php</pre>
<pre class="layui-code code-demo" lay-title="建议10-20分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/ccru.php</pre>
<pre class="layui-code code-demo" lay-title="建议每天早上8点一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/ddru.php</pre>
<pre class="layui-code code-demo" lay-title="建议15-30分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/redis4.0/eeru.php</pre>
<br>
<blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">PHP安装【redis扩展】、【进程守护】安装任意版本，安装完毕之后建议重启一下服务器</span><br> 
            <span style='color: #FF0033;'>然后进入【软件商店-进程守护-添加守护进程】守护如下进程，启动命令复制【】里面的即可</span>  
        </blockquote>  
<pre class="layui-code code-demo" lay-title="提交出队">名称 chusheng1 进程数量：建议服务器CPU*2（但是不要超过20） 启动命令 【nohup php chusheng1.php &】 进程目录:网站根目录/redis4.0/</pre>

<pre class="layui-code code-demo" lay-title="同步出队">名称 chusheng2 进程数量：建议服务器CPU*2（但是不要超过20） 启动命令 【nohup php chusheng2.php &】 进程目录:网站根目录/redis4.0/</pre>
<pre class="layui-code code-demo" lay-title="实时出队">名称 chusheng3 进程数量：建议服务器CPU*2（但是不要超过20） 启动命令 【nohup php chusheng3.php &】 进程目录：网站根目录/redis4.0/</pre>
<pre class="layui-code code-demo" lay-title="批量补刷">名称 chushengplbs 进程数量：建议服务器CPU*2（但是不要超过20）  启动命令 【nohup php chushengplbs.php &】  进程目录：网站根目录/redis4.0/</pre>
<pre class="layui-code code-demo" lay-title="提交出队">名称 chushengaddchu 进程数量：建议服务器CPU*2（但是不要超过20） 启动命令 【nohup php chushengaddchu.php &】 进程目录:网站根目录/redis4.0/</pre><br>
<blockquote class="layui-elem-quote layui-quote-nm">
<span style="color: #FF0033;">为了日志显示正常，建议修改进程守护日志的最大存储大小</span><br>
<span style="color:  #FF0033;">打开【进程守护管理器】，在相应的进程守护后方的【配置文件】里找到原来的【stdout_logfile_maxbytes=2MB】-改成【stdout_logfile_maxbytes=200MB】</span><br>
<span style="color: #6699FF;">原先的大小是2MB，改成20MB或者200MB都行</span><br>
</blockquote> 
</div>
                    <div class="tab-pane fade" id="get">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">本模板自带查单单页，已适配丸子推送查单，可用于用户售后查单</span><br> 
            <span style='color: #FF0033;'>无需任何手动配置，直接访问：<a href="http://<?echo($_SERVER['SERVER_NAME']);?>/get" target="_blank">http://<?echo($_SERVER['SERVER_NAME']);?>/get</a> &nbsp; 即可使用！</span>
            <span style='color: #FF0033;'>在宝塔—软件商店-进程守护 添加如下进程守护<br>
            <pre class="layui-code code-demo" lay-title="查单推送">名称 push 进程数量：建议服务器CPU*2  启动命令 【nohup php push.php &】  进程目录：网站根目录/tuisong/</pre>
        </blockquote>  
        							
                                        
        						</table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="ts">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<blockquote class="layui-elem-quote layui-quote-nm">
        							 <span style='color: #FF0033;'>由于是通过WxPusher的极简消息推送，只需填入Token，无需进行任何其他配置，即可发送简易消息<br>  
            <span style='color: #FF0033;'>在宝塔—计划任务-访问URL 监控如下地址<br>
            <pre class="layui-code code-demo" lay-title="订单完成及异常通知，建议五分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/tuisong/ddtz.php</pre>
            <pre class="layui-code code-demo" lay-title="每日数据通知，建议每天执行一次">http://<?echo($_SERVER['SERVER_NAME']);?>/tuisong/sjtz.php</pre>
            <pre class="layui-code code-demo" lay-title="客户推送通知，建议五分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/tuisong/khts.php</pre>
            <pre class="layui-code code-demo" lay-title="订单失败通知（注意是通知站长），建议五分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/tuisong/ddshibai.php</pre>
            </span>
        </blockquote>  
        							
                                        
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