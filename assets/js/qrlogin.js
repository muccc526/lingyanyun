var interval1, interval2;
function getqrpic() {
    var getvcurl = '../qq/getsid/qrlogin.php?do=getqrpic&r=' + Math.random(1);
    $.get(getvcurl, function (d) {
        if (d.saveOK == 0) {
            $('#qrimg').attr('qrsig', d.qrsig);
            $('#qrimg').html('<img onclick="getqrpic()" src="data:image/png;base64,' + d.data + '" title="点击刷新">');
        } else {
            alert(d.msg);
        }
    }, 'json');
}
function ptuiCB(code, uin, sid, skey, pskey, superkey, nick) {
    var msg = '请扫描二维码';
    switch (code) {
        case '0':
            $.ajax({
                type: "post",
                url: "ajax.php?act=check",
                data: {
                    uin: uin
                },
                dataType: "json",
                success: function (arr) {
                    if (arr.code == 0) {
                        var addstr = '';
                        $.each(arr.data, function (i, item) {
                            addstr += '<option value="' + item.qq + '">' + item.qq + '</option>';
                        });
                        ii = layer.open({
                            type: 1,
                            skin: 'layui-layer-demo',
                            closeBtn: 0,
                            anim: 2,
                            content: '<center><div class="modal-body"><p>请选择需要更改授权的机器人QQ账号</p><div class="form-group"><div class="input-group"><div class="input-group-addon">选择账号</div><select id="select" class="form-control">' + addstr + '</select></div></div><a class="btn btn-info btn-block" onclick="ok($(\'#select option:selected\').val());layer.close(ii)">确定</a></div></center><script>function ok(qq){layer.prompt({title: \'输入新的机器人QQ号\', formType: 0}, function(text, index){var uin="' + uin + '";$.ajax({type:"post",url:"ajax.php?act=edit_qq",data:{oqq:uin,qq:qq,newqq:text},dataType:"json",success:function(edit){if(edit.code){layer.msg(edit.msg,{icon:1,time:1500,shade:0.3});}else{layer.alert(edit.msg);}}});});}</\script>'
                        });
                    } else {
                        layer.alert(arr.msg);
                    }
                }
            });
            cleartime();
            break;
        case '1':
            getqrpic();
            msg = '请重新扫描二维码';
            break;
        case '2':
            msg = '使用QQ手机版扫描二维码';
            break;
        case '3':
            msg = '扫描成功，请在手机上确认授权登录';
            break;
        default:
            msg = sid;
            break;
    }
}
function loadScript(c) {
    var qrsig = $('#qrimg').attr('qrsig');
    c = c || "../qq/getsid/qrlogin.php?do=qqlogin&qrsig=" + decodeURIComponent(qrsig) + "&r=" + Math.random(1);
    var a = document.createElement("script");
    a.onload = a.onreadystatechange = function () {
        if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
            if (typeof d == "function") {
                d()
            }
            a.onload = a.onreadystatechange = null;
            if (a.parentNode) {
                a.parentNode.removeChild(a)
            }
        }
    };
    a.src = c;
    document.getElementsByTagName("head")[0].appendChild(a)
}
function cleartime() {
    clearInterval(interval2);
}
$(document).ready(function () {
    $('#submit_qr').click(function () {
        i = layer.load(1);
        var qrsig = $('#qrimg').attr('qrsig');
        $.ajax({
            type: "get",
            url: "../qq/getsid/qrlogin.php?do=qqlogin&qrsig=" + decodeURIComponent(qrsig) + "&r=" + Math.random(1),
            dataType: "html",
            success: function (qr) {
                layer.close(i);
                if (qr.indexOf("未失效") != -1) {
                    layer.alert('请先扫描二维码！');
                }
            }
        });
        loadScript();
    });
});