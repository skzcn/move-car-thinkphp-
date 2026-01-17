<?php /*a:1:{s:47:"E:\Users\web\tp\app\admin\view\admin\index.html";i:1768402612;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-fluid" style="padding: 15px;">
    <div class="layui-card">
        <div class="layui-card-header">管理员列表</div>
        <div class="layui-card-body">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto" style="padding-bottom: 10px;">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input type="text" name="keyword" placeholder="用户名/昵称/邮箱" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" id="add-admin">添加管理员</button>
                    </div>
                </div>
            </div>
            
            <table id="admin-table" lay-filter="admin-table"></table>
            
            <script type="text/html" id="table-toolbar">
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
            
            <script type="text/html" id="status-tpl">
                {{# if(d.status == 1){ }}
                <span class="layui-badge layui-bg-green">正常</span>
                {{# } else { }}
                <span class="layui-badge layui-bg-red">禁用</span>
                {{# } }}
            </script>
        </div>
    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script>
layui.use(['table', 'form', 'jquery'], function(){
    var table = layui.table;
    var form = layui.form;
    var $ = layui.jquery;

    // 渲染表格
    table.render({
        elem: '#admin-table',
        url: "<?php echo url('admin/index'); ?>",
        page: true,
        cols: [[
            {field: 'id', title: 'ID', width: 80, sort: true},
            {field: 'username', title: '用户名', width: 120},
            {field: 'nickname', title: '昵称', width: 120},
            {field: 'email', title: '邮箱', width: 180},
            {field: 'status', title: '状态', width: 100, templet: '#status-tpl'},
            {field: 'create_time', title: '创建时间', width: 180, templet: function(d){
                return layui.util.toDateString(d.create_time * 1000);
            }},
            {title: '操作', minWidth: 150, align: 'center', fixed: 'right', toolbar: '#table-toolbar'}
        ]]
    });

    // 搜索
    form.on('submit(search)', function(data){
        table.reload('admin-table', {
            where: data.field,
            page: {curr: 1}
        });
        return false;
    });

    // 添加
    $('#add-admin').click(function(){
        layer.open({
            type: 2,
            title: '添加管理员',
            content: "<?php echo url('add'); ?>",
            area: ['500px', '450px'],
            end: function(){
                table.reload('admin-table');
            }
        });
    });

    // 监听工具条
    table.on('tool(admin-table)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
            layer.confirm('确定删除该管理员吗？', function(index){
                $.post("<?php echo url('delete'); ?>", {id: data.id}, function(res){
                    if(res.code === 0){
                        layer.msg(res.msg, {icon: 1});
                        obj.del();
                    } else {
                        layer.msg(res.msg, {icon: 2});
                    }
                }, 'json');
                layer.close(index);
            });
        } else if(obj.event === 'edit'){
            layer.open({
                type: 2,
                title: '编辑管理员',
                content: "<?php echo url('edit'); ?>?id=" + data.id,
                area: ['500px', '450px'],
                end: function(){
                    table.reload('admin-table');
                }
            });
        }
    });
});
</script>
</body>
</html>
