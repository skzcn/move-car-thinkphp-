<?php /*a:1:{s:46:"E:\Users\web\tp\app\admin\view\notice\add.html";i:1768441787;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>发布公告</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>
<div style="padding: 20px;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">公告标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公告内容</label>
            <div class="layui-input-block">
                <textarea name="content" placeholder="请输入内容" class="layui-textarea" style="height: 150px;"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">发送对象</label>
            <div class="layui-input-block">
                <input type="radio" name="target" value="all" title="所有用户" checked lay-filter="target">
                <input type="radio" name="target" value="specific" title="指定用户" lay-filter="target">
            </div>
        </div>
        <div class="layui-form-item" id="user-select" style="display: none;">
            <label class="layui-form-label">选择用户</label>
            <div class="layui-input-block">
                <?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <input type="checkbox" name="user_ids[]" value="<?php echo htmlentities((string) $vo['id']); ?>" title="<?php echo !empty($vo['nickname']) ? htmlentities((string) $vo['nickname']) : htmlentities((string) $vo['username']); ?>">
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="save">立即提交</button>
            </div>
        </div>
    </form>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['form', 'layer', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.jquery;

    form.on('radio(target)', function(data){
        if(data.value === 'specific'){
            $('#user-select').show();
        } else {
            $('#user-select').hide();
        }
    });

    form.on('submit(save)', function(data){
        $.post('<?php echo url("add"); ?>', data.field, function(res){
            if(res.code === 0){
                layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                    parent.location.reload();
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
