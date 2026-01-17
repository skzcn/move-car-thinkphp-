<?php /*a:1:{s:44:"E:\Users\web\tp\app\admin\view\ad\index.html";i:1768447688;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>广告管理</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body style="padding: 20px;">
    <div class="layui-card">
        <div class="layui-card-header">广告列表</div>
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layui-btn-normal" onclick="edit(0)">添加广告</button>
            </div>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>图片</th>
                        <th>链接</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo htmlentities((string) $vo['id']); ?></td>
                        <td><?php echo htmlentities((string) $vo['title']); ?></td>
                        <td><img src="<?php echo htmlentities((string) $vo['image']); ?>" style="max-height: 30px;"></td>
                        <td><?php echo htmlentities((string) $vo['link']); ?></td>
                        <td><?php echo htmlentities((string) $vo['sort']); ?></td>
                        <td>
                            <?php if($vo['status'] == 1): ?>
                            <span class="layui-badge layui-bg-green">开启</span>
                            <?php else: ?>
                            <span class="layui-badge layui-bg-gray">关闭</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="layui-btn layui-btn-xs" onclick="edit(<?php echo htmlentities((string) $vo['id']); ?>)">编辑</button>
                            <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del(<?php echo htmlentities((string) $vo['id']); ?>)">删除</button>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <?php echo $list; ?>
        </div>
    </div>

    <script src="/static/layui/layui.js"></script>
    <script>
    layui.use(['form', 'layer', 'jquery'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var $ = layui.jquery;

        window.edit = function(id) {
            layer.open({
                type: 2,
                title: id > 0 ? '编辑广告' : '添加广告',
                content: "<?php echo url('edit'); ?>?id=" + id,
                area: ['600px', '500px'],
                end: function() {
                    location.reload();
                }
            });
        }

        window.del = function(id) {
            layer.confirm('确定删除吗？', function(index){
                $.post("<?php echo url('delete'); ?>", {id: id}, function(res){
                    if(res.code === 0){
                        layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                            location.reload();
                        });
                    } else {
                        layer.msg(res.msg, {icon: 2});
                    }
                });
            });
        }
    });
    </script>
</body>
</html>
