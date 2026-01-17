<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Session;

class Index extends BaseController
{
    public function initialize()
    {
        if (!Session::has('admin_id')) {
            return redirect((string)url('admin/login/index'))->send();
        }
    }

    public function index()
    {
        View::assign('admin_name', Session::get('admin_name'));
        return View::fetch();
    }
}
