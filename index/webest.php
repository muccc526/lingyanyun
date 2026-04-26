<?php
$title='系统设置';
require_once('head.php');

if($userrow['uid']!=1){
    alert("你来错地方了","index.php");
}
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="add">
           <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 6px;">
                <div class="panel-body">
                    <form class="form-horizontal devform" id="form-web">
                        <div  class="card">
          <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a data-toggle="tab" href="#wzpz">网站配置</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#dlpz">代理配置</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#zfpz">支付配置</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#khcz">跨户充值</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#flpz">分类配置</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#ckpz">API配置</a>
            </li>
            <li class="nav-item">
               <a data-toggle="tab" href="#qdsz">签到设置</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#yxpz">邮箱配置</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active in" id="wzpz">
                    <div class="form-group">
                            <label class="col-sm-2 control-label">站点名字</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="sitename" value="<?=$conf['sitename']?>" placeholder="请输入站点名字" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">SEO关键词</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="keywords" value="<?=$conf['keywords']?>" placeholder="请输入站点名字" required>
                            </div>
                        </div>
                                                
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SEO介绍</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="description" value="<?=$conf['description']?>" placeholder="请输入站点名字" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启水印</label>
                                <div class="col-sm-9">
                                    <select name="sykg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">   
                                       <option value="1" <?php if($conf['sykg']==1){ echo 'selected';}?>>1_允许</option>   
                                       <option value="0" <?php if($conf['sykg']==0){ echo 'selected';}?>>0_拒绝</option>                           	                            	
                                    </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">主页公告</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="notice" class="layui-textarea"  rows="15"><?=$conf['notice']?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">弹窗公告</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="tcgonggao" class="layui-textarea"  rows="5" ><?=$conf['tcgonggao']?></textarea>
                            </div>
                        </div>
            </div>
            <div class="tab-pane fade" id="dlpz">
                <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启上级迁移功能</label>
                                <div class="col-sm-9">
                                    <select name="sjqykg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">   
                                       <option value="1" <?php if($conf['sjqykg']==1){ echo 'selected';}?>>1_开启</option>   
                                       <option value="0" <?php if($conf['sjqykg']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
                                    </select>
                            </div>
                        </div>
                <div class="form-group">
                            <label class="col-sm-2 control-label">是否允许邀请码注册</label>
                                <div class="col-sm-9">
                                    <select name="user_yqzc" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['user_yqzc']==1){ echo 'selected';}?>>1_允许</option> 
                                       <option value="0" <?php if($conf['user_yqzc']==0){ echo 'selected';}?>>0_拒绝</option>                           	                            	
                                    </select>
                               </div>
                        </div>    

                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否允许后台开通代理</label>
                                <div class="col-sm-9">
                                    <select name="user_htkh" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">   
                                       <option value="1" <?php if($conf['user_htkh']==1){ echo 'selected';}?>>1_允许</option>   
                                       <option value="0" <?php if($conf['user_htkh']==0){ echo 'selected';}?>>0_拒绝</option>                           	                            	
                                    </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">代理开通价格（开户费）</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="user_ktmoney" value="<?=$conf['user_ktmoney']?>" placeholder="" required>
                            </div>
                        </div>
            </div>
            <div class="tab-pane fade" id="zfpz">
                <div class="form-group">
                            <label class="col-sm-2 control-label">最低充值金额</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="zdpay" value="<?=$conf['zdpay']?>" placeholder="请输入你的商户KEY" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启<span style="color:red;">在线充值</span></label>
                                <div class="col-sm-9">
                                    <select name="zxczkg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['zxczkg']==1){ echo 'selected';}?>>1_开启</option> 
                                       <option value="0" <?php if($conf['zxczkg']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
                                    </select>
                               </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启<span style="color:red;">QQ</span>支付</label>
                                <div class="col-sm-9">
                                    <select name="is_qqpay" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['is_qqpay']==1){ echo 'selected';}?>>1_开启</option> 
                                       <option value="0" <?php if($conf['is_qqpay']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
                                    </select>
                               </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启<span style="color:red;">微信</span>支付</label>
                                <div class="col-sm-9">
                                    <select name="is_wxpay" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['is_wxpay']==1){ echo 'selected';}?>>1_开启</option> 
                                       <option value="0" <?php if($conf['is_wxpay']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
                                    </select>
                               </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启<span style="color:red;">支付宝</span>支付</label>
                                <div class="col-sm-9">
                                    <select name="is_alipay" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['is_alipay']==1){ echo 'selected';}?>>1_开启</option> 
                                       <option value="0" <?php if($conf['is_alipay']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
                                    </select>
                               </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付API</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="epay_api" value="<?=$conf['epay_api']?>" placeholder="格式：http://www.baidu.com/" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">商户ID</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="epay_pid" value="<?=$conf['epay_pid']?>" placeholder="请输入你的商户ID" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商户KEY</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="epay_key" value="<?=$conf['epay_key']?>" placeholder="请输入你的商户KEY" required>
                            </div>
                        </div>
                       
            </div>
            <div class="tab-pane fade" id="khcz">
                <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启跨户充值功能</label>
                                <div class="col-sm-9">
                                    <select name="khkg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['khkg']==1){ echo 'selected';}?>>1_开启</option> 
                                       <option value="0" <?php if($conf['khkg']==0){ echo 'selected';}?>>0_关闭</option>
                                    </select>
                               </div>
                        </div>
                        <div class="form-group">
    <label class="col-sm-2 control-label">最低跨户余额限制</label>
    <div class="col-sm-9">
        <input type="text" class="layui-input" name="khyue" value="<?=$conf['khyue']?>" placeholder="请输入跨户余额限制" required>
    </div>
</div>
<div class="form-group">
						    <label class="col-sm-2 control-label"></label>
						    <div class="col-sm-9">
						<span style="color: red;">当用户余额（不是总充值）低于【最低跨户余额限制】时，将无法完成跨户充值操作，并且跨户充值按钮隐藏！</span>
						</div>
						</div>
            </div>
            <div class="tab-pane fade" id="flpz">
                <div class="form-group">
                            <label class="col-sm-2 control-label">分类开关</label>
                                <div class="col-sm-9">
                                    <select name="flkg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['flkg']==1){ echo 'selected';}?>>开启</option> 
                                       <option value="0" <?php if($conf['flkg']==0){ echo 'selected';}?>>关闭</option>                           	                            	
                                    </select>
                               </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类类型</label>
                                <div class="col-sm-9">
                                    <select name="fllx" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                        <!--<option value="0" <?php if($conf['fllx']==0){ echo 'selected';}?>>侧边栏分类</option>              
                                       <option value="1" <?php if($conf['fllx']==1){ echo 'selected';}?>>下单页面选择框分类</option> -->
                                       <option value="2" <?php if($conf['fllx']==2){ echo 'selected';}?>>下单页面单选框分类</option> 
                                                                                                
                                    </select>
                               </div>
                        </div>    
            </div>
            <div class="tab-pane fade" id="qdsz">
    <div class="form-group">
        <label class="col-sm-2 control-label">是否<span style="color:red;">开启</span>签到功能</label>
        <div class="col-sm-9">
            <select name="sign_in_switch" class="layui-select" style="background: url('../index/arrow.png') no-repeat scroll 99%; width:100%">
                <option value="1" <?php if ($conf['sign_in_switch'] == 1) { echo 'selected'; }?>>1_开启</option>
                <option value="0" <?php if ($conf['sign_in_switch'] == 0) { echo 'selected'; }?>>0_关闭</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">签到<span style="color:red;">最低</span>余额限制</label>
        <div class="col-sm-9">
            <input type="text" class="layui-input" name="sign_in_limit" value="<?=$conf['sign_in_limit']?>" placeholder="请输入签到最低余额限制" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">签到获得的<span style="color:red;">最小</span>余额</label>
        <div class="col-sm-9">
            <input type="text" class="layui-input" name="sign_in_min" value="<?=$conf['sign_in_min']?>" placeholder="请输入最小余额" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">签到获得的<span style="color:red;">最大</span>余额</label>
        <div class="col-sm-9">
            <input type="text" class="layui-input" name="sign_in_max" value="<?=$conf['sign_in_max']?>" placeholder="请输入最大余额" required>
        </div>
    </div>
    <div class="form-group">
						    <label class="col-sm-2 control-label"></label>
						    <div class="col-sm-9">
						<span style="color: red;">当用户余额（不是总充值）低于【最低签到余额限制】时，将无法完成签到！</span>
						</div>
						</div>
</div>
<div class="tab-pane fade" id="yxpz">
     <div class="form-group">
							<label class="col-sm-2 control-label">  SMTP服务器</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="email_service" value="<?=$conf['email_service']?>" placeholder="默认填:smtp.qq.com" required>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-sm-2 control-label">SMTP服务器端口</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="email_port" value="<?=$conf['email_port']?>" placeholder="默认填:465" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">发件邮箱账号</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="email_user" value="<?=$conf['email_user']?>" placeholder="示例：123456@qq.com" required>
							</div>
						</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">发件邮箱密码</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="email_pass" value="<?=$conf['email_pass']?>" placeholder="邮箱授权码" required>
							</div>
						</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">本站站点域名</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="email_url" value="<?=$conf['email_url']?>" placeholder="本站的网站链接，不需要最后的/" required>
							</div>
						</div>
						<div class="form-group">
    <label class="col-sm-2 control-label">是否开启登陆验证码</label>
    <div class="col-sm-9">
        <select name="yzmkg" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">   
            <option value="1" <?php if($conf['yzmkg']==1){ echo 'selected';}?>>1_开启</option>   
            <option value="0" <?php if($conf['yzmkg']==0){ echo 'selected';}?>>0_关闭</option>                           	                            	
        </select>
    </div>
</div>
						<div class="form-group">
						    <label class="col-sm-2 control-label"></label>
						    <div class="col-sm-9">
						<span style="color: red;">目前仅支持QQ邮箱收件，当用户的账号不是QQ号时无法正常注册账号，并且已有不是QQ号作为账号的用户将在后台无法正常发送邮件<br></span>
						QQ邮箱发件填写示例：
						<br>SMTP服务器:smtp.qq.com
						<br>SMTP服务器端口:465
						<br>发件邮箱账号:123456@qq.com
						<br>密码不是QQ密码也不是邮箱独立密码，而是QQ邮箱设置界面生成的<a href='https://service.mail.qq.com/detail/0/75' target="_blank">授权码</a>！
						<br>本站站点域名:https://baidu.com   （无需最后的<span style="color: red;"> /</span> ！）
						</div>
						</div>
            </div>

            <div class="tab-pane fade" id="ckpz">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否开启API调用功能</label>
                                <div class="col-sm-9">
                                    <select name="settings" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                       <option value="1" <?php if($conf['settings']==1){ echo 'selected';}?>>开启API调用</option> 
                                       <option value="0" <?php if($conf['settings']==0){ echo 'selected';}?>>关闭API调用</option>
                                    </select>
                               </div>
                        </div>
                                                <div class="form-group">
                            <label class="col-sm-2 control-label">API调用扣费限制(单位:%)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="layui-input" name="api_proportion" value="<?=$conf['api_proportion']?>" placeholder="请输入API调用比例扣费限制比例（单位：%）" required>
                            </div>
                        </div>
                        <div class="form-group">
    <label class="col-sm-2 control-label">API查课余额限制(单位:元)</label>
    <div class="col-sm-9">
        <input type="text" class="layui-input" name="api_ck" value="<?=$conf['api_ck']?>" placeholder="请输入API查课余额限制金额" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">API下单余额限制(单位:元)</label>
    <div class="col-sm-9">
        <input type="text" class="layui-input" name="api_xd" value="<?=$conf['api_xd']?>" placeholder="请输入API下单余额限制金额" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">API同步随机时间限制(单位:分钟)</label>
    <div class="col-sm-9">
        <input type="text" class="layui-input" name="api_tongb" value="<?=$conf['api_tongb']?>" placeholder="限制的最小值建议1：限制同步频率最短60秒一次" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">API同步随机时间限制(单位:分钟)</label>
    <div class="col-sm-9">
        <input type="text" class="layui-input" name="api_tongbc" value="<?=$conf['api_tongbc']?>" placeholder="限制的最大值建议3：限制同步频率最高180秒一次" required>
    </div>
</div>
</div>
<div class="col-sm-offset-2 col-sm-4">
				  	    	<input type="button" @click="add" value="立即修改" class="layui-btn"/>
				  	    </div>

			        </form>
			      

		        </div>
	     </div>
      </div>
    </div>

<?php require_once("footer.php");?>

<script>
new Vue({
    el:"#add",
    data:{

    },
    methods:{
        add:function(){
            var minMoney = parseFloat($('input[name="sign_in_min"]').val());
            var maxMoney = parseFloat($('input[name="sign_in_max"]').val());
            var balanceLimit = parseFloat($('input[name="sign_in_limit"]').val());
            var khyue = parseFloat($('input[name="khyue"]').val());

            if (isNaN(minMoney) || isNaN(maxMoney) || minMoney > maxMoney || minMoney < 0 || maxMoney < 0) {
                layer.alert("签到金额范围配置错误，请检查输入", {icon:2, title:"温馨提示"});
                return;
            }

            if (isNaN(balanceLimit) || balanceLimit < 0) {
                layer.alert("签到余额限制配置错误，请检查输入", {icon:2, title:"温馨提示"});
                return;
            }

            if (isNaN(khyue) || khyue < 0) {
                layer.alert("跨户余额限制配置错误，请输入有效的数字", {icon:2, title:"温馨提示"});
                return;
            }

            var loading=layer.load(2);
            this.$http.post("/apisub.php?act=webset",{data:$("#form-web").serialize()},{emulateJSON:true}).then(function(data){
                layer.close(loading);
                if(data.data.code==1){
                    layer.alert(data.data.msg,{icon:1,title:"温馨提示"},function(){setTimeout(function(){window.location.href=""});});
                }else{
                    layer.alert(data.data.msg,{icon:2,title:"温馨提示"});
                }
            });
        }   
    },
    mounted(){
        //this.getclass();        
    }
});
</script>