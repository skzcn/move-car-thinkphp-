<?php /*a:1:{s:48:"E:\Users\web\tp\app\index\view\user\profile.html";i:1768537166;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>个人中心 - MoveCar</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', 'PingFang SC', 'Microsoft YaHei', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .profile-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
        }

        .layui-form-label {
            width: 120px;
            font-weight: 500;
            color: var(--text-main);
        }

        .layui-input-block {
            margin-left: 150px;
        }

        .layui-input {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .layui-input:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-save {
            background: var(--primary-color) !important;
            border-radius: 12px !important;
            padding: 0 30px;
            height: 44px;
            line-height: 44px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: var(--primary-hover) !important;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-main);
            margin: 30px 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 4px;
            height: 18px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .nav-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .nav-back:hover {
            color: var(--primary-color);
        }

        .preview-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 20px;
            margin-top: 10px;
            border: 1px dashed #cbd5e1;
        }

        .preview-url-box {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-url-input {
            flex: 1;
            background: #fff !important;
            cursor: text !important;
        }

        .notice-btn {
            position: relative;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            margin-right: 15px;
        }

        .notice-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .notice-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .notice-list-item {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: background 0.3s;
        }

        .notice-list-item:hover {
            background: #f8fafc;
        }

        .notice-list-item.unread {
            background: #f0f9ff;
        }

        .notice-title {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notice-time {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .notice-content {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .profile-container {
                margin: 20px auto;
                padding: 20px;
                border-radius: 16px;
            }

            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .profile-header h2 {
                font-size: 20px;
            }

            .layui-form-label {
                width: 100%;
                text-align: left;
                padding-left: 0;
                margin-bottom: 5px;
            }

            .layui-input-block {
                margin-left: 0;
            }

            .preview-url-box {
                flex-direction: column;
            }

            .btn-save {
                width: 100%;
            }
            
            .nav-back {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="<?php echo url('index/index'); ?>" class="nav-back">
            <i class="layui-icon layui-icon-left"></i> 返回首页
        </a>
        <div class="notice-btn" id="btn-notice" style="margin-right: 0;">
            <i class="layui-icon layui-icon-notice" style="font-size: 20px; color: var(--text-main);"></i>
            <?php if($unreadCount > 0): ?>
            <span class="notice-dot"></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="profile-header">
        <h2>个人信息设置</h2>
        <a href="<?php echo url('logout'); ?>" class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 50px;">退出登录</a>
    </div>

    <form class="layui-form" action="">
        <div class="section-title">基础资料</div>
        
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" value="<?php echo htmlentities((string) $user['username']); ?>" class="layui-input" disabled style="background: #f8fafc; color: #94a3b8;">
                <div class="layui-word-aux">用户名不可修改</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" value="<?php echo htmlentities((string) $user['nickname']); ?>" placeholder="请输入昵称" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">修改密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" placeholder="不修改请留空" class="layui-input">
            </div>
        </div>

        <div class="section-title">车辆与联系方式</div>

        <div class="layui-form-item">
            <label class="layui-form-label">车牌号</label>
            <div class="layui-input-block">
                <input type="text" name="plate" value="<?php echo htmlentities((string) $user['plate']); ?>" placeholder="请输入车牌号" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
                <input type="text" name="mobile" value="<?php echo htmlentities((string) $user['mobile']); ?>" placeholder="请输入手机号" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" value="<?php echo htmlentities((string) (isset($user['email']) && ($user['email'] !== '')?$user['email']:'')); ?>" placeholder="请输入邮箱，用于找回密码" class="layui-input">
            </div>
        </div>

        <div class="section-title">通知设置</div>

        <div class="layui-form-item">
            <label class="layui-form-label">Bark URL</label>
            <div class="layui-input-block">
                <input type="text" name="bark_url" value="<?php echo htmlentities((string) $user['bark_url']); ?>" placeholder="请输入 Bark 通知地址" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">Server酱 Key</label>
            <div class="layui-input-block">
                <input type="text" name="server_chan_key" value="<?php echo htmlentities((string) $user['server_chan_key']); ?>" placeholder="请输入 Server酱 Key" class="layui-input">
            </div>
        </div>

        <div class="section-title">挪车界面预览</div>
        <div class="layui-form-item">
            <div class="layui-input-block" style="margin-left: 0;">
                <div class="preview-card">
                    <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 10px;">这是您的专属挪车通知页面链接，您可以将其制作成二维码贴在车窗上。</p>
                    <div class="preview-url-box">
                        <input type="text" id="preview-url" value="<?php echo url('user/index', ['u' => $user['username']], true, true); ?>" class="layui-input preview-url-input" readonly>
                        <button type="button" class="layui-btn layui-btn-primary" id="btn-copy" style="border-radius: 12px;">
                            <i class="layui-icon layui-icon-release"></i> 复制
                        </button>
                        <a href="<?php echo url('user/index', ['u' => $user['username']]); ?>" target="_blank" class="layui-btn layui-btn-normal" style="border-radius: 12px;">
                            <i class="layui-icon layui-icon-screen-full"></i> 预览
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-form-item" style="margin-top: 40px; text-align: center;">
            <button class="layui-btn btn-save" lay-submit lay-filter="save-profile">保存修改</button>
        </div>
    </form>
</div>

<!-- 公告列表弹窗内容 -->
<div id="notice-list-container" style="display: none;">
    <div style="max-height: 400px; overflow-y: auto;">
        <?php if(empty($notices)): ?>
        <div style="padding: 40px; text-align: center; color: var(--text-muted);">
            <i class="layui-icon layui-icon-face-surprised" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
            暂无公告内容
        </div>
        <?php else: if(is_array($notices) || $notices instanceof \think\Collection || $notices instanceof \think\Paginator): $i = 0; $__LIST__ = $notices;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="notice-list-item <?php if($vo['is_read'] == 0): ?>unread<?php endif; ?>" data-id="<?php echo htmlentities((string) $vo['id']); ?>" data-title="<?php echo htmlentities((string) $vo['title']); ?>" data-content="<?php echo htmlentities((string) $vo['content']); ?>">
            <div class="notice-title">
                <?php echo htmlentities((string) $vo['title']); ?>
                <span class="notice-time"><?php echo htmlentities((string) date('Y-m-d H:i',!is_numeric($vo['create_time'])? strtotime($vo['create_time']) : $vo['create_time'])); ?></span>
            </div>
            <div class="notice-content"><?php echo htmlentities((string) mb_substr($vo['content'],0,50)); ?>...</div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <?php endif; ?>
    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['form', 'layer', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.jquery;

    // 监听提交
    form.on('submit(save-profile)', function(data){
        var loadIndex = layer.load(2);
        $.post("<?php echo url('profile'); ?>", data.field, function(res){
            layer.close(loadIndex);
            if(res.code === 0){
                layer.msg(res.msg, {icon: 1, time: 1500});
            } else {
                layer.msg(res.msg, {icon: 2});
            }
        }, 'json');
        return false;
    });

    // 查看公告列表
    $('#btn-notice').on('click', function(){
        layer.open({
            type: 1,
            title: '系统公告',
            area: ['90%', '500px'],
            maxWidth: 450,
            content: $('#notice-list-container').html(),
            success: function(layero, index){
                // 绑定点击公告详情
                layero.find('.notice-list-item').on('click', function(){
                    var id = $(this).data('id');
                    var title = $(this).data('title');
                    var content = $(this).data('content');
                    var $item = $(this);

                    layer.open({
                        type: 1,
                        title: title,
                        area: ['85%', 'auto'],
                        maxWidth: 400,
                        content: '<div style="padding: 20px; line-height: 1.6; color: #333;">' + content + '</div>',
                        btn: ['关闭'],
                        success: function(){
                            // 标记为已读
                            if($item.hasClass('unread')){
                                $.post('<?php echo url("readNotice"); ?>', {id: id}, function(res){
                                    if(res.code === 0){
                                        $item.removeClass('unread');
                                        // 同时更新隐藏容器中的状态，确保下次打开也是已读
                                        $('#notice-list-container').find('.notice-list-item[data-id="'+id+'"]').removeClass('unread');
                                        
                                        // 检查是否还有未读（在隐藏容器中检查最准确）
                                        if($('#notice-list-container').find('.notice-list-item.unread').length === 0){
                                            $('.notice-dot').remove();
                                        }
                                    }
                                });
                            }
                        }
                    });
                });
            }
        });
    });

    // 复制链接
    $('#btn-copy').on('click', function(){
        var urlInput = document.getElementById('preview-url');
        urlInput.select();
        urlInput.setSelectionRange(0, 99999); // 移动端适配
        try {
            document.execCommand('copy');
            layer.msg('链接已复制到剪贴板', {icon: 1, time: 1500});
        } catch (err) {
            layer.msg('复制失败，请手动复制', {icon: 2});
        }
    });
});
</script>
</body>
</html>
