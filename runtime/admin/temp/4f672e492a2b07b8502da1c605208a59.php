<?php /*a:1:{s:43:"E:\Users\web\tp\app\admin\view\ad\edit.html";i:1768447686;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>编辑广告</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body style="padding: 20px;">
    <form class="layui-form" action="">
        <input type="hidden" name="id" value="<?php echo htmlentities((string) (isset($info['id']) && ($info['id'] !== '')?$info['id']:'0')); ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">广告标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo htmlentities((string) (isset($info['title']) && ($info['title'] !== '')?$info['title']:'')); ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告图片</label>
            <div class="layui-input-block">
                <input type="text" name="image" id="image" required lay-verify="required" placeholder="图片地址(本地或网络)" autocomplete="off" class="layui-input" value="<?php echo htmlentities((string) (isset($info['image']) && ($info['image'] !== '')?$info['image']:'')); ?>">
                <div style="margin-top: 10px;">
                    <button type="button" class="layui-btn layui-btn-sm" id="uploadBtn">上传图片</button>
                    <div class="layui-word-aux" style="display: inline-block; margin-left: 10px;">支持直接填写网络图片地址</div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跳转链接</label>
            <div class="layui-input-block">
                <input type="text" name="link" placeholder="请输入跳转链接" autocomplete="off" class="layui-input" value="<?php echo htmlentities((string) (isset($info['link']) && ($info['link'] !== '')?$info['link']:'')); ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" placeholder="数字越大越靠前" autocomplete="off" class="layui-input" value="<?php echo htmlentities((string) (isset($info['sort']) && ($info['sort'] !== '')?$info['sort']:'0')); ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|关闭" <?php if(!isset($info['status']) || $info['status'] == 1): ?>checked<?php endif; ?> value="1">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="save">立即提交</button>
            </div>
        </div>
    </form>

    <script src="/static/layui/layui.js"></script>
    <script>
    layui.use(['form', 'layer', 'upload', 'jquery'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var upload = layui.upload;
        var $ = layui.jquery;

        // 上传图片
        upload.render({
            elem: '#uploadBtn',
            url: "<?php echo url('upload/image'); ?>", // 假设有一个统一的上传接口
            done: function(res){
                if(res.code === 0){
                    $('#image').val(res.url);
                    layer.msg('上传成功');
                } else {
                    layer.msg(res.msg || '上传失败');
                }
            }
        });

        // 监听提交
        form.on('submit(save)', function(data){
            $.post("<?php echo url('edit'); ?>", data.field, function(res){
                if(res.code === 0){
                    layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
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
