<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>订单查询</title>
    <!-- 引入样式库 -->
    <link href="https://fastly.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fastly.jsdelivr.net/npm/vant@4/lib/index.css" rel="stylesheet"/>
    <link href="https://fastly.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f8fa;
            color: #323233;
            font-family: -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Helvetica, Segoe UI, Arial, Roboto, 'PingFang SC', 'miui', 'Hiragino Sans GB', 'Microsoft Yahei', sans-serif;
            min-height: 100vh;
            padding-bottom: 20px;
        }
        .container {
            padding: 20px 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        .page-title {
            text-align: center;
            margin-bottom: 24px;
            color: #323233;
            font-size: 24px;
            font-weight: 600;
        }
        .search-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .search-tip {
            color: #969799;
            font-size: 13px;
            margin-top: 8px;
            padding: 8px 12px;
            background: #f5f7fa;
            border-radius: 6px;
            line-height: 1.5;
        }
        .order-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }
        .order-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #323233;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .order-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start; 
            white-space: nowrap;
        }
        .order-info i {
            margin-right: 8px;
            width: 16px;
            color: #1989fa;
            margin-top: 2px; 
        }
        .status-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-pending { 
            background: #fff7e6; 
            color: #d46b08;
            border: 1px solid #ffd591;
        }
        .status-processing { 
            background: #e6f4ff; 
            color: #0958d9;
            border: 1px solid #91caff;
        }
        .status-completed { 
            background: #f6ffed; 
            color: #389e0d;
            border: 1px solid #b7eb8f;
        }
        .status-error { 
            background: #fff2f0; 
            color: #cf1322;
            border: 1px solid #ffccc7;
        }
        .progress-container {
            flex: 1;
            margin-left: 8px;
        }
        .progress-bar {
            height: 6px;
            background: #f5f5f5;
            border-radius: 3px;
            overflow: hidden;
            margin: 8px 0;
        }
        .progress-inner {
            height: 100%;
            background: linear-gradient(90deg, #1989fa, #39b9fa);
            border-radius: 3px;
            transition: width 0.3s ease;
            width: 0;
        }
        .bind-btn {
            width: 100%;
            margin-top: 16px;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .bind-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25,137,250,0.2);
        }
        .bind-btn i {
            margin-right: 6px;
        }
        .empty-tip {
            text-align: center;
            padding: 40px 0;
            color: #969799;
        }
        .empty-tip i {
            font-size: 48px;
            color: #dcdee0;
            margin-bottom: 16px;
        }
        .qrcode-modal .modal-dialog {
            max-width: 360px;
            margin: 1.75rem auto;
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        .qrcode-modal .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
        }
        .qrcode-modal .modal-header {
            border-bottom: none;
            padding: 16px 20px;
        }
        .qrcode-modal .modal-body {
            padding: 0 20px 20px;
            text-align: center;
        }
        .qrcode-modal .modal-title {
            font-size: 16px;
            font-weight: 600;
        }
        #qrcodeContainer {
            padding: 12px;
            background: #fff;
            border-radius: 8px;
            display: inline-block;
            margin: 0 auto;
            margin-bottom: 12px;
        }
        #qrcodeContainer img {
            width: 180px;
            height: 180px;
            display: block;
        }
        .qrcode-tips {
            margin-top: 12px;
            font-size: 13px;
            color: #666;
            background: #f5f7fa;
            padding: 10px;
            border-radius: 8px;
            line-height: 1.5;
        }
        .qrcode-tips p {
            margin-bottom: 6px;
        }
        .qrcode-tips p:last-child {
            margin-bottom: 0;
        }
        .qrcode-tips i {
            color: #faad14;
            margin-right: 6px;
            font-size: 12px;
        }
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading-spinner i {
            font-size: 24px;
            color: #1989fa;
        }
        .unbind-btn {
            background-color: #fff2f0;
            border-color: #ffccc7;
            color: #cf1322;
        }
        .unbind-btn:hover {
            background-color: #fff1f0;
            border-color: #ffa39e;
            color: #a8071a;
        }
        /* Toast 提示样式 */
        .toast-container {
            z-index: 9999;
        }

        .custom-toast {
            background-color: rgba(0, 0, 0, 0.85);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            max-width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .custom-toast.success {
            background-color: rgba(56, 158, 13, 0.9);
        }

        .custom-toast.error {
            background-color: rgba(207, 19, 34, 0.9);
        }

        .custom-toast i {
            margin-right: 8px;
        }

        .recharge-btn {
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .recharge-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
        }

        .recharge-btn i {
            margin-right: 6px;
        }
        .button-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }
        .button-group button {
            margin-left: 8px;
        }
        /* 新增样式，固定订单说明部分 */
        .order-info-description {
            white-space: nowrap;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 页面标题 -->
        <h1 class="page-title">订单查询</h1>
        
        <!-- 搜索框 -->
        <div class="search-box">
            <form id="searchForm">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" id="account" name="account" 
                           placeholder="请输入您的账号" required>
                    <div class="search-tip">
                        <i class="fa-solid fa-info"></i>
                        输入账号即可查询您的所有订单信息，并可开通微信推送服务
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    <i class="fa-solid fa-magnifying-glass"></i> 查询订单
                </button>
            </form>
            
            <!-- 添加微信推送绑定按钮和状态 -->
            <div id="pushBindSection" class="mt-3" style="display: none;">
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                    <div class="d-flex align-items-center">
                        <!-- 微信图标无标准HTML实体，可省略或用文字替代 -->
                        <span id="pushStatusText">微信推送通知</span>
                    </div>
                    <button id="bindPushBtn" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-link"></i> 绑定推送
                    </button>
                </div>
            </div>
        </div>

        <!-- 加载动画 -->
        <div class="loading-spinner">
            <i class="fa-solid fa-spinner fa-spin"></i>
            <p>正在查询订单信息...</p>
        </div>

        <!-- 订单列表 -->
        <div id="orderList"></div>
    </div>

    <!-- 二维码弹窗模板 -->
    <div class="modal fade qrcode-modal" id="qrcodeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <!-- 二维码图标无标准HTML实体，可省略或用文字替代 --> 绑定推送
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qrcodeContainer"></div>
                    <div class="qrcode-tips">
                        <p><i class="fa-solid fa-info"></i> 请使用微信扫描上方二维码</p>
                        <p><i class="fa-solid fa-clock"></i> 二维码有效期5分钟</p>
                        <p><i class="fa-solid fa-bell"></i> 绑定后可实时接收订单状态变更通知</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加确认弹窗的 HTML 到页面底部 -->
    <div class="modal fade" id="unbindConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-triangle-exclamation"></i> 解除绑定确认
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="mb-0">确定要解除微信推送通知吗？</p>
                    <p class="text-secondary mt-2 mb-0" style="font-size: 14px;">
                        解除后将不再收到订单状态变更的通知
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> 取消
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmUnbindBtn">
                        <i class="fa-solid fa-unlink"></i> 确认解除
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加补刷确认弹窗 -->
    <div class="modal fade" id="rechargeConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-rotate"></i> 补刷订单确认
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="mb-0">确定要补刷此订单吗？</p>
                    <p class="text-secondary mt-2 mb-0" style="font-size: 14px;">
                        补刷操作将重新执行订单任务
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> 取消
                    </button>
                    <button type="button" class="btn btn-warning" id="confirmRechargeBtn">
                        <i class="fa-solid fa-rotate"></i> 确认补刷
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 引入脚本库 -->
    <script src="https://fastly.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            // 处理表单提交
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                const account = $('#account').val().trim();
                if (!account) {
                    showToast('请输入账号');
                    return;
                }
                $('.loading-spinner').show();
                $('#orderList').hide();
                searchOrders(account);
                checkPushBindStatus(account); // 检查推送绑定状态
            });

            // 查询订单
            function searchOrders(account) {
                $.ajax({
                    url: 'api.php?act=chadan', 
                    data: { account: account },
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $('.loading-spinner').hide();
                        $('#orderList').show();
                        if (res.code === 1) {
                            renderOrders(res.data);
                        } else {
                            $('#orderList').html(`
                                <div class="empty-tip">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <p>未找到相关订单</p>
                                    <p>请检查账号是否正确</p>
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $('.loading-spinner').hide();
                        $('#orderList').show();
                        showToast('查询失败，请稍后重试');
                    }
                });
            }

            // 渲染订单列表
            function renderOrders(orders) {
                if (!orders || orders.length === 0) {
                    $('#orderList').html(`
                        <div class="empty-tip">
                            <i class="fa-solid fa-box-open"></i>
                            <p>暂无订单数据</p>
                        </div>
                    `);
                    return;
                }

                const html = orders.map(order => {
                    let statusClass = 'status-pending';
                    let statusIcon = 'fa-regular fa-clock';
                    if (order.status === '进行中') {
                        statusClass = 'status-processing';
                        statusIcon = 'fa-solid fa-spinner fa-spin';
                    } else if (order.status === '已完成') {
                        statusClass = 'status-completed';
                        statusIcon = 'fa-solid fa-check';
                    } else if (order.status === '异常') {
                        statusClass = 'status-error';
                        statusIcon = 'fa-solid fa-triangle-exclamation';
                    }

                    let progress = order.process ? parseFloat(order.process.replace('%', '')) : 0;
                    progress = Math.min(Math.max(progress, 0), 100);

                    // 添加推送状态显示
                    const pushStatusHtml = `
                        <div class="order-info">
                            <i class="fa-solid fa-bell"></i> 推送状态：
                            <span class="${order.pushStatus === '1' ? 'text-success' : 'text-secondary'}">
                                ${order.pushStatus === '1' ? '已推送' : '未推送'}
                            </span>
                        </div>
                    `;

                    // 限制课程名字字数为 15 个字符，多余的用 ... 表示
                    let limitedKcname = order.kcname;
                    if (order.kcname.length > 15) {
                        limitedKcname = order.kcname.slice(0, 15) + '...';
                    }

                    return `
                        <div class="order-card">
                            <div class="order-title">
                                ${limitedKcname}
                                <span class="status-tag ${statusClass}">
                                    <i class="${statusIcon}"></i> ${order.status}
                                </span>
                            </div>
                            <div class="order-info">
                                <i class="fa-solid fa-user"></i> 下单账号：${order.user}
                            </div>
                            <div class="order-info">
                                <i class="fa-solid fa-book"></i> 课程名字：${order.kcname}
                            </div>
                            <div class="order-info">
                                <i class="fa-solid fa-chart-line"></i> 详细进度
                                    <div class="progress-container d-flex align-items-center">
                                        <div class="progress-bar flex-grow-1">
                                            <div class="progress-inner" style="width: ${progress}%"></div>
                                        </div>
                                    <span class="ml-2 font-weight-bold" style="min-width: 36px; text-align: right">${progress}%</span>
                                </div>
                            </div>
                            <div class="order-info">
                                <i class="fa-solid fa-calendar-days"></i> 下单时间：${order.addtime}
                            </div>
                            ${pushStatusHtml}
                            ${order.process ? `
                                <div class="order-info">
                                    <span class="order-info-description">
                                        <i class="fa-solid fa-info"></i>订单说明：
                                    </span>
                                    <span style="white-space: normal; overflow-wrap: break-word;">${order.remarks}</span>
                                </div>
                            ` : ''}
                            <div class="button-group">
                                <button class="btn btn-info recharge-btn" onclick="syncOrderProgress('${order.id}', this)">
                                    <i class="fa-solid fa-sync"></i> 同步进度
                                </button>
                                <button class="btn btn-warning recharge-btn" onclick="rechargeOrder('${order.id}')">
                                    <i class="fa-solid fa-rotate"></i> 补刷订单
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');

                $('#orderList').html(html);
            }

            // 修改检查推送绑定状态函数
            function checkPushBindStatus(account) {
                const pushBindSection = $('#pushBindSection');
                const pushStatusText = $('#pushStatusText');
                const bindPushBtn = $('#bindPushBtn');

                pushBindSection.show();
                
                // 查询订单中是否存在 pushUid
                $.ajax({
                    url: 'api.php?act=chadan',
                    data: { account: account },
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.code === 1 && res.data.length > 0) {
                            const hasPushUid = res.data.some(order => order.pushUid);
                            
                            if (hasPushUid) {
                                // 已绑定状态
                                pushStatusText.html(`
                                    <span class="text-success">
                                        <i class="fa-solid fa-check"></i>
                                        已开启微信推送通知
                                    </span>
                                `);
                                bindPushBtn
                                    .html('<i class="fa-solid fa-unlink"></i> 解除绑定')
                                    .removeClass('btn-outline-primary')
                                    .addClass('unbind-btn')
                                    .off('click')
                                    .on('click', function() {
                                        togglePush(account, true);
                                    });
                            } else {
                                // 未绑定状态
                                pushStatusText.html(`
                                    <span class="text-secondary">
                                        <i class="fa-solid fa-bell"></i>
                                        未开启微信推送通知
                                    </span>
                                `);
                                bindPushBtn
                                    .html('<i class="fa-solid fa-link"></i> 绑定推送')
                                    .removeClass('btn-outline-danger')
                                    .addClass('btn-outline-primary')
                                    .off('click')
                                    .on('click', function() {
                                        togglePush(account, false);
                                    });
                            }
                        }
                    }
                });
            }

            // 修改二维码扫描检查函数
            function checkQrcodeScan(code, username, checkTimer, qrcodeModal) {
                $.ajax({
                    url: 'wxpusher/api.php?act=getUid',
                    data: { 
                        code: code,
                        username: username
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.code === 200) {
                            clearInterval(checkTimer);
                            qrcodeModal.hide();
                            showToast('微信推送绑定成功', 'success');
                            checkPushBindStatus(username);
                        }
                    }
                });
            }

            // 修改 togglePush 函数
            window.togglePush = function(username, hasPushUid) {
                if (hasPushUid) {
                    // 显示确认弹窗
                    const unbindModal = new bootstrap.Modal(document.getElementById('unbindConfirmModal'));
                    unbindModal.show();
                    
                    // 绑定确认按钮事件
                    $('#confirmUnbindBtn').off('click').on('click', function() {
                        $.ajax({
                            url: 'tuisongapi.php?act=closePush',
                            data: { username: username },
                            type: 'GET',
                            dataType: 'json',
                            success: function(res) {
                                unbindModal.hide();
                                if (res.code === 200) {
                                    showToast('微信推送已解除绑定', 'success');
                                    checkPushBindStatus(username);
                                } else {
                                    showToast(res.msg || '解除绑定失败', 'error');
                                }
                            },
                            error: function() {
                                showToast('网络错误，请稍后重试', 'error');
                            }
                        });
                    });
                } else {
                    showQrcode(username);
                }
            }

            // 修改 showQrcode 函数的成功回调
            function showQrcode(username) {
                // 清空之前的二维码
                $('#qrcodeContainer').empty();
                
                // 显示弹窗
                const qrcodeModal = new bootstrap.Modal(document.getElementById('qrcodeModal'));
                qrcodeModal.show();

                // 获取二维码
                $.ajax({
                    url: 'tuisongapi.php?act=Qrcreate',
                    data: {
                        extra: JSON.stringify({ username: username }),
                        validTime: 1800
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.code === 200) {
                            // 生成二维码
                            $('#qrcodeContainer').html(`<img src="${res.data.url}" style="width:200px;height:200px;">`);
                            // 轮询检查是否已扫码
                            const checkTimer = setInterval(function() {
                                $.ajax({
                                    url: 'tuisongapi.php?act=getUid',
                                    data: { 
                                        code: res.data.code,
                                        username: username
                                    },
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(checkRes) {
                                        if (checkRes.code === 200) {
                                            clearInterval(checkTimer);
                                            qrcodeModal.hide();
                                            showToast('绑定成功', 'success');
                                            checkPushBindStatus(username);
                                        }
                                    }
                                });
                            }, 3000);

                            // 弹窗关闭时清除定时器
                            document.getElementById('qrcodeModal').addEventListener('hidden.bs.modal', function() {
                                clearInterval(checkTimer);
                            });
                        } else {
                            alert(res.msg || '二维码生成失败');
                            qrcodeModal.hide();
                        }
                    }
                });
            }

            // 显示提示信息
            function showToast(message, type = 'success') {
                // 移除已存在的 toast
                $('.toast-container').remove();
                
                const icon = type === 'success' ? 'fa-solid fa-check' : 'fa-solid fa-triangle-exclamation';
                const toast = `
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div class="custom-toast ${type}">
                            <i class="${icon}"></i>${message}
                        </div>
                    </div>
                `;
                
                $('body').append(toast);
                const toastEl = $('.custom-toast');
                
                // 淡入动画
                toastEl.hide().fadeIn(200);
                
                // 3秒后淡出并移除
                setTimeout(() => {
                    toastEl.fadeOut(200, function() {
                        $('.toast-container').remove();
                    });
                }, 3000);
            }

            // 修改 rechargeOrder 函数
            window.rechargeOrder = function(orderId) {
                // 显示确认弹窗
                const rechargeModal = new bootstrap.Modal(document.getElementById('rechargeConfirmModal'));
                rechargeModal.show();
                
                // 绑定确认按钮事件
                $('#confirmRechargeBtn').off('click').on('click', function() {
                    $.ajax({
                        url: 'api.php?act=budan',
                        data: { id: orderId },
                        type: 'POST', // 修改为 POST 请求
                        dataType: 'json',
                        success: function(res) {
                            rechargeModal.hide();
                            if (res.code === 1) {
                                showToast('补刷请求已提交', 'success');
                                // 刷新当前账号的订单列表
                                const account = $('#account').val().trim();
                                if (account) {
                                    searchOrders(account);
                                }
                            } else {
                                showToast(res.msg || '补刷失败', 'error');
                            }
                        },
                        error: function() {
                            rechargeModal.hide();
                            showToast('网络错误，请稍后重试', 'error');
                        }
                    });
                });
            };

            // 同步进度函数
            window.syncOrderProgress = function(orderId, button) {
                // 禁用按钮并显示加载动画
                $(button).prop('disabled', true);
                $(button).html('<i class="fa-solid fa-spinner fa-spin"></i> 同步中...');

                $.ajax({
                    url: 'api.php?act=uporder',
                    data: { oid: orderId },
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.code === 1) {
                            showToast('同步成功', 'success');
                            // 刷新当前账号的订单列表
                            const account = $('#account').val().trim();
                            if (account) {
                                searchOrders(account);
                            }
                        } else {
                            showToast(res.msg || '同步失败', 'error');
                        }
                        // 启用按钮并恢复原始文本
                        $(button).prop('disabled', false);
                        $(button).html('<i class="fa-solid fa-sync"></i> 同步进度');
                    },
                    error: function() {
                        showToast('网络错误，请稍后重试', 'error');
                        // 启用按钮并恢复原始文本
                        $(button).prop('disabled', false);
                        $(button).html('<i class="fa-solid fa-sync"></i> 同步进度');
                    }
                });
            };
        });
    </script>
</body>
</html>    