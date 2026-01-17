<?php
namespace app;
require __DIR__ . '/vendor/autoload.php';
$app = new \think\App();
$http = $app->http;
$response = $http->run();

use think\facade\Db;

$configs = [
    ['name' => 'site_keywords', 'value' => '', 'config_group' => 'basic', 'title' => '网站关键词'],
    ['name' => 'site_description', 'value' => '', 'config_group' => 'basic', 'title' => '网站描述'],
    ['name' => 'site_contact', 'value' => '', 'config_group' => 'basic', 'title' => '联系方式'],
    ['name' => 'site_icp', 'value' => '', 'config_group' => 'basic', 'title' => 'ICP备案号']
];

try {
    foreach ($configs as $config) {
        $exist = Db::name('system_config')->where('name', $config['name'])->find();
        if (!$exist) {
            Db::name('system_config')->insert($config);
            echo "Inserted: " . $config['name'] . "\n";
        } else {
            echo "Exists: " . $config['name'] . "\n";
        }
    }
    echo "Done.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
