<?php
namespace app\admin\controller;

use think\facade\Db;

class Install
{
    public function index()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `system_config` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(50) NOT NULL COMMENT '配置名称',
          `value` text COMMENT '配置值',
          `config_group` varchar(20) DEFAULT 'basic' COMMENT '分组',
          `title` varchar(50) DEFAULT NULL COMMENT '配置说明',
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';";

        try {
            Db::execute($sql);
            
            $data = [
                ['name' => 'site_title', 'value' => '我的网站', 'config_group' => 'basic', 'title' => '网站标题'],
                ['name' => 'smtp_host', 'value' => 'smtp.qq.com', 'config_group' => 'email', 'title' => 'SMTP服务器'],
                ['name' => 'smtp_port', 'value' => '465', 'config_group' => 'email', 'title' => 'SMTP端口'],
                ['name' => 'smtp_user', 'value' => '', 'config_group' => 'email', 'title' => 'SMTP用户名'],
                ['name' => 'smtp_pass', 'value' => '', 'config_group' => 'email', 'title' => 'SMTP密码'],
                ['name' => 'smtp_from', 'value' => '', 'config_group' => 'email', 'title' => '发件人邮箱'],
            ];

            foreach ($data as $item) {
                if (!Db::name('system_config')->where('name', $item['name'])->find()) {
                    Db::name('system_config')->insert($item);
                }
            }
            
            echo "Table created and data inserted successfully.";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
