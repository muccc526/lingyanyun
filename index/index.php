<?php
include('head.php');
?>
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="JavaScript:;"><img src="/logo.png" title="<?=$conf['sitename']?>" alt="<?=$conf['sitename']?>" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">
              <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-home"></i> <span>控制中心</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="main">用户中心</a> </li>
                <li> <a class="multitabs" href="home">公告列表</a> </li>
              </ul>
            </li>
            
            <?php if($userrow['uid']==1){ ?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-settings"></i> <span>系统设置</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="webmsg">系统信息</a> </li>
                <li> <a class="multitabs" href="zzbz">站长帮助</a> </li>
                <li> <a class="multitabs" href="webest">系统设置</a> </li>
                <li> <a class="multitabs" href="femail">发送邮件</a> </li>
                <li> <a class="multitabs" href="gglist">实时公告</a> </li>
                <li> <a class="multitabs" href="dengji">等级设置</a> </li>
                <li> <a class="multitabs" href="mijia">密价设置</a> </li>
                <li> <a class="multitabs" href="huoyuan">接口配置</a> </li>
                <li> <a class="multitabs" href="yjdj">一键对接</a> </li>
                <li> <a class="multitabs" href="../custom_goods/admin.php">自定义商品对接</a> </li>
                <li> <a class="multitabs" href="fenlei">分类设置</a> </li>
                <li> <a class="multitabs" href="class">网课设置</a> </li>
                <li> <a class="multitabs" href="data">数据统计</a> </li>
                <li> <a class="multitabs" href="lspm">排行榜单</a> </li>
                <li> <a class="multitabs" href="guanx">卡密管理</a> </li>
                <li> <a class="multitabs" href="paylist">充值记录</a> </li>
              </ul>
            </li>
            <?php } ?>  
           <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-book-open-page-variant"></i> <span>学习中心</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="add2">马上学习</a> </li>
                <li> <a class="multitabs" href="add">订单提交</a> </li>
                <li> <a class="multitabs" href="add3">小猿提交</a> </li>
                <li> <a class="multitabs" href="add_ll">批量提交</a> </li>
                <li> <a class="multitabs" href="adds">无查提交</a> </li>
                <li> <a class="multitabs" href="../custom_goods/order.php">自定义商品下单</a> </li>
                <li> <a class="multitabs" href="../custom_goods/orders.php">自定义商品查单</a> </li>
              </ul>
            </li>
            <li class="nav-item"><a class="multitabs" href="list"><i class="mdi mdi-file"></i> <span>订单管理</span></a> </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-view-grid"></i> <span>我的信息</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="userinfo">我的资料</a> </li>
                <li> <a class="multitabs" href="tourist_spsz">接单商城</a> </li>
                <li> <a class="multitabs" href="notice">通知设置</a> </li>
                <li> <a class="multitabs" href="myprice">我的价格</a> </li>
                <li> <a class="multitabs" href="charge">上级信息</a> </li>
                <li> <a class="multitabs" href="kcid">课程比对</a> </li>
                <li> <a class="multitabs" href="paih">销量排行</a> </li>
                <li> <a class="multitabs" href="latest">最新上架</a> </li>
                <li> <a class="multitabs" href="remove">下架专区</a> </li>
                <li> <a class="multitabs" href="log">操作日志</a> </li>
              </ul>
            </li>
            <li class="nav-item"><a class="multitabs" href="userlist"><i class="mdi mdi-account"></i> <span>代理管理</span></a> </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-square-inc-cash"></i> <span>余额充值</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="pay">在线充值</a> </li>
                <li> <a class="multitabs" href="kmpay">卡密充值</a> </li>
              </ul>
            </li>
            <li class="nav-item"><a class="multitabs" href="gongdan"><i class="mdi mdi-headset"></i> <span>提交工单</span></a> </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-code-not-equal-variant"></i> <span>串货对接</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="docking">对接文档</a> </li>
                <li> <a class="multitabs" href="fllb">分类列表</a> </li>
                <li> <a class="multitabs" href="help">课程说明</a> </li>
                <li> <a class="multitabs" href="bangzhu">帮助中心</a> </li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-cube"></i> <span>其他工具</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="https://www.doubao.com/chat/">AI小助手</a> </li>
              </ul>
            </li>
          </ul>
        </nav>
        
        <div class="sidebar-footer">
          <p class="copyright">Copyright &copy; 2024. <a href="javascript:void(0)"><?=$conf['sitename']?></a> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All rights reserved.</p>
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->
    
    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar navbar-default">
        <div class="topbar">
          
          <div class="topbar-left">
            <div class="lyear-aside-toggler">
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
            </div>
            <li class="dropdown">
    <a href="javascript:;" title="刷新" id="refresh-btn" style="color: #333333;">
      <i class="mdi mdi-refresh" style="font-size: 20px;"></i>
    </a>
  </li>
          </div>
          
          <ul class="topbar-right">
            <li class="dropdown dropdown-profile">
              <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['user'];?>&spec=100" alt="<?=$userrow['name'];?>" />
                <span><?=$userrow['name'];?> <span class="caret"></span></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li> <a id="sjqy"><i class="mdi mdi-account"></i>上级迁移</a> </li>
                <li> <a class="multitabs" data-url="passwd" href="javascript:void(0)"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li>
                <li> <a id="szyqprice"><i class="mdi mdi-chart-line"></i>设置邀请费率</a> </li>
                <li class="divider"></li>
                <li> <a href="../apisub.php?act=logout"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
              </ul>
            </li>
            <!--切换主题配色-->
		    <li class="dropdown dropdown-skin">
			  <span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
			  <ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
			    <li class="drop-title"><p>LOGO</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
                    <label for="logo_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                    <label for="logo_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                    <label for="logo_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                    <label for="logo_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
                    <label for="logo_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                    <label for="logo_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                    <label for="logo_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                    <label for="logo_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>头部</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
                    <label for="header_bg_1"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                    <label for="header_bg_2"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                    <label for="header_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                    <label for="header_bg_4"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_5" id="header_bg_5">
                    <label for="header_bg_5"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                    <label for="header_bg_6"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                    <label for="header_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                    <label for="header_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>侧边栏</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
                    <label for="sidebar_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                    <label for="sidebar_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                    <label for="sidebar_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                    <label for="sidebar_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
                    <label for="sidebar_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                    <label for="sidebar_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                    <label for="sidebar_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                    <label for="sidebar_bg_8"></label>
                  </span>
				</li>
			  </ul>
			</li>
            <!--切换主题配色-->
          </ul>
          
        </div>
      </nav>
      
    </header>
    <!--End 头部信息-->
    
    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div id="iframe-content"></div>
      
    </main>
    <!--End 页面主要内容-->
  </div>
</div>
<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap-multitabs/multitabs.js"></script>
<script type="text/javascript" src="assets/LightYear/js/index.min.js"></script>
<script src="assets/js/sy.js"></script>
<!--水印开关，其他页面可以复制过去-->
<?php if ($conf['sykg']==1) {?>
<script type="text/javascript">
watermark('禁止截图，截图封户','<?=$conf['sitename'];?>','UID:<?=$userrow['uid'];?>');
</script>
<?php } ?>
<script type="text/javascript">
        $('#sjqy').click(function() {
            layer.prompt({title: '请输入要转移的上级UID', formType: 3}, function(uid, index){
			  layer.close(index);
	           layer.prompt({title: '请输入要转移的上级邀请码', formType: 3}, function(yqm, index){
			  layer.close(index);
	           var load=layer.load(2);
	           $.ajax({
	               type: "POST",
	               url: "../apisub.php?act=sjqy",
	               data: {"uid":uid,"yqm":yqm},
	               dataType: 'json',
	               success: function(data) {
	                   layer.close(load);
	                   if (data.code == 1) {
	                       layer.msg(data.msg,{icon:1});
	                   } else {
	                       layer.msg(data.msg,{icon:2});
	                   }
	               }
	           });           
		  });           
		  });		
    });
         $('#szyqprice').click(function(){		    	    	
						layer.prompt({title: '设置邀请费率，首次自动生成邀请码', formType: 3}, function(yqprice, index){
						  layer.close(index);
						  var load=layer.load();
			              $.post("/apisub.php?act=yqprice",{yqprice},function (data) {
					 	     layer.close(load);
				             if (data.code==1){
				             	vm.userinfo();  
				                layer.alert(data.msg,{icon:1});
				             }else{
				                layer.msg(data.msg,{icon:2});
				             }
			              });		    		    
					  });
		    	    });
       </script>




<script type="text/javascript">
$('#refresh-btn').on('click', function() {
  var $currentTab = $('#iframe-content iframe:visible');
  
  if ($currentTab.length > 0) {
    $currentTab[0].contentWindow.location.reload(true);
  } else if (typeof multitabs !== 'undefined') {
    multitabs.refreshCurrentTab(); 
  } else {
    window.location.reload();
  }
});
</script>
