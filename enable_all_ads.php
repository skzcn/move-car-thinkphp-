<?php
require 'vendor/autoload.php';
$app = new \think\App();
$app->initialize();
$res = \think\facade\Db::name('ads')->where('1=1')->update(['status' => 1]);
echo "Updated rows: " . $res . "\n";
$res = \think\facade\Db::name('ads')->select();
print_r($res->toArray());
