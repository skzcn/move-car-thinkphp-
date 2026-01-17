<?php /*a:1:{s:48:"E:\Users\web\tp\app\admin\view\system\index.html";i:1768641943;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>系统设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-fluid" style="padding: 15px;">
    <div class="layui-card">
        <div class="layui-card-header">系统设置</div>
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" lay-filter="component-tabs-brief">
                <ul class="layui-tab-title">
                    <li class="layui-this">基本设置</li>
                    <li>邮件设置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form" action="" lay-filter="basic">
                            <div class="layui-form-item">
                                <label class="layui-form-label">网站标题</label>
                                <div class="layui-input-block">
                                    <input type="text" name="site_title" value="<?php echo htmlentities((string) (isset($config['site_title']) && ($config['site_title'] !== '')?$config['site_title']:'')); ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">关键词</label>
                                <div class="layui-input-block">
                                    <input type="text" name="site_keywords" value="<?php echo htmlentities((string) (isset($config['site_keywords']) && ($config['site_keywords'] !== '')?$config['site_keywords']:'')); ?>" placeholder="多个关键词用英文逗号分隔" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">描述</label>
                                <div class="layui-input-block">
                                    <textarea name="site_description" placeholder="网站描述信息" class="layui-textarea"><?php echo htmlentities((string) (isset($config['site_description']) && ($config['site_description'] !== '')?$config['site_description']:'')); ?></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">联系方式</label>
                                <div class="layui-input-block">
                                    <input type="text" name="site_contact" value="<?php echo htmlentities((string) (isset($config['site_contact']) && ($config['site_contact'] !== '')?$config['site_contact']:'')); ?>" placeholder="底部显示的联系方式" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">ICP备案号</label>
                                <div class="layui-input-block">
                                    <input type="text" name="site_icp" value="<?php echo htmlentities((string) (isset($config['site_icp']) && ($config['site_icp'] !== '')?$config['site_icp']:'')); ?>" placeholder="底部显示的ICP备案号" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="save">保存配置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="layui-tab-item">
                        <form class="layui-form" action="" lay-filter="email">
                            <div class="layui-form-item">
                                <label class="layui-form-label">SMTP服务器</label>
                                <div class="layui-input-block">
                                    <input type="text" name="smtp_host" value="<?php echo htmlentities((string) (isset($config['smtp_host']) && ($config['smtp_host'] !== '')?$config['smtp_host']:'')); ?>" placeholder="如：smtp.qq.com" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">SMTP端口</label>
                                <div class="layui-input-block">
                                    <input type="text" name="smtp_port" value="<?php echo htmlentities((string) (isset($config['smtp_port']) && ($config['smtp_port'] !== '')?$config['smtp_port']:'465')); ?>" placeholder="如：465" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">SMTP用户</label>
                                <div class="layui-input-block">
                                    <input type="text" name="smtp_user" value="<?php echo htmlentities((string) (isset($config['smtp_user']) && ($config['smtp_user'] !== '')?$config['smtp_user']:'')); ?>" placeholder="邮箱账号" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">SMTP密码</label>
                                <div class="layui-input-block">
                                    <input type="password" name="smtp_pass" value="<?php echo htmlentities((string) (isset($config['smtp_pass']) && ($config['smtp_pass'] !== '')?$config['smtp_pass']:'')); ?>" placeholder="邮箱密码或授权码" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">发件人邮箱</label>
                                <div class="layui-input-block">
                                    <input type="text" name="smtp_from" value="<?php echo htmlentities((string) (isset($config['smtp_from']) && ($config['smtp_from'] !== '')?$config['smtp_from']:'')); ?>" placeholder="与SMTP用户一致" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="save">保存配置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['form', 'layer', 'element', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.jquery;
    var element = layui.element;

    form.on('submit(save)', function(data){
        $.post("<?php echo url('index'); ?>", data.field, function(res){
            if(res.code === 0){
                layer.msg(res.msg, {icon: 1});
            } else {
                layer.msg(res.msg, {icon: 2});
            }
        });
        return false;
    });
});
</script>
</body>
</html>
