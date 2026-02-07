<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Db;

class CheckSmtp extends BaseController
{
    public function index()
    {
        $config = Db::name('system_config')->where('config_group', 'email')->column('value', 'name');
        echo "SMTP Config Check:\n";
        foreach ($config as $key => $value) {
            // Mask password
            if ($key == 'smtp_pass') {
                $value = $value ? '******' : '(empty)';
            } else {
                $value = $value ?: '(empty)';
            }
            echo "$key: $value\n";
        }
        exit;
    }
}
