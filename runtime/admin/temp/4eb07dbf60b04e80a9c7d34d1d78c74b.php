<?php /*a:1:{s:48:"E:\Users\web\tp\app\admin\view\notice\index.html";i:1768441785;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>公告管理</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>
<div style="padding: 15px;">
    <div class="layui-btn-group">
        <button class="layui-btn" id="btn-add">发布公告</button>
    </div>
    <table class="layui-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>标题</th>
                <th>发布时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo htmlentities((string) $vo['id']); ?></td>
                <td><?php echo htmlentities((string) $vo['title']); ?></td>
                <td><?php echo htmlentities((string) date('Y-m-d H:i',!is_numeric($vo['create_time'])? strtotime($vo['create_time']) : $vo['create_time'])); ?></td>
                <td>
                    <button class="layui-btn layui-btn-danger layui-btn-xs btn-delete" data-id="<?php echo htmlentities((string) $vo['id']); ?>">删除</button>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php echo $list; ?>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['layer', 'jquery'], function(){
    var layer = layui.layer;
    var $ = layui.jquery;

    $('#btn-add').on('click', function(){
        layer.open({
            type: 2,
            title: '发布公告',
            area: ['600px', '500px'],
            content: '<?php echo url("add"); ?>'
        });
    });

    $('.btn-delete').on('click', function(){
        var id = $(this).data('id');
        layer.confirm('确定删除该公告吗？', function(index){
            $.post('<?php echo url("delete"); ?>', {id: id}, function(res){
                if(res.code === 0){
                    layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                        location.reload();
                    });
                } else {
                    layer.msg(res.msg, {icon: 2});
                }
            });
        });
    });
});
</script>
</body>
</html>
