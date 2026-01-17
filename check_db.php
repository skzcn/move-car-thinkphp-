<?php
namespace app;
require __DIR__ . '/vendor/autoload.php';
$app = new \think\App();
$http = $app->http;
$response = $http->run();

use think\facade\Db;

try {
    $config = Db::name('system_config')->select();
    echo json_encode($config);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
