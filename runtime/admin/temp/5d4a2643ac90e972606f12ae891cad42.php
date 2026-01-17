<?php /*a:1:{s:45:"E:\Users\web\tp\app\admin\view\user\edit.html";i:1768534766;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>编辑车主</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-form" style="padding: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="username" value="<?php echo htmlentities((string) (isset($user['username']) && ($user['username'] !== '')?$user['username']:'')); ?>" lay-verify="required" placeholder="用于URL，如 zhangsan" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-block">
            <input type="text" name="nickname" value="<?php echo htmlentities((string) (isset($user['nickname']) && ($user['nickname'] !== '')?$user['nickname']:'')); ?>" lay-verify="required" placeholder="显示姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" placeholder="不修改请留空" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">车牌号</label>
        <div class="layui-input-block">
            <input type="text" name="plate" value="<?php echo htmlentities((string) (isset($user['plate']) && ($user['plate'] !== '')?$user['plate']:'')); ?>" placeholder="如：粤B12345" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号</label>
        <div class="layui-input-block">
            <input type="text" name="mobile" value="<?php echo htmlentities((string) (isset($user['mobile']) && ($user['mobile'] !== '')?$user['mobile']:'')); ?>" placeholder="可选" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Bark URL</label>
        <div class="layui-input-block">
            <input type="text" name="bark_url" value="<?php echo htmlentities((string) (isset($user['bark_url']) && ($user['bark_url'] !== '')?$user['bark_url']:'')); ?>" placeholder="Bark通知地址" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Server酱Key</label>
        <div class="layui-input-block">
            <input type="text" name="server_chan_key" value="<?php echo htmlentities((string) (isset($user['server_chan_key']) && ($user['server_chan_key'] !== '')?$user['server_chan_key']:'')); ?>" placeholder="Server酱 SendKey" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="正常" <?php if(($user['status'] ?? 1) == 1): ?>checked<?php endif; ?>>
            <input type="radio" name="status" value="0" title="禁用" <?php if(($user['status'] ?? 1) == 0): ?>checked<?php endif; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="save">保存</button>
        </div>
    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['form', 'layer', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.jquery;

    form.on('submit(save)', function(data){
        $.post(window.location.href, data.field, function(res){
            if(res.code === 0){
                layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                    parent.layer.closeAll();
                });
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
