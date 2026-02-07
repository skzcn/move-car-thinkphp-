<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        $config = Db::name('system_config')->column('value', 'name');
        View::assign('config', $config);
        return View::fetch();
    }
}
