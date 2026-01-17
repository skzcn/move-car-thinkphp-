<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class Login extends BaseController
{
    public function index()
    {
        if (Session::has('admin_id')) {
            return redirect((string)url('admin/index/index'));
        }
        return View::fetch();
    }

    public function check()
    {
        if ($this->request->isPost()) {
            try {
                $data = $this->request->post();
                $username = $data['username'] ?? '';
                $password = $data['password'] ?? '';
                $captcha = $data['captcha'] ?? '';

                if (!captcha_check($captcha)) {
                    return json(['code' => 1, 'msg' => '验证码错误']);
                }

                $admin = Db::name('admins')->where('username', $username)->find();

                if (!$admin) {
                    return json(['code' => 1, 'msg' => '用户不存在']);
                }

                if (!password_verify($password, $admin['password'])) {
                    return json(['code' => 1, 'msg' => '密码错误']);
                }

                if ($admin['status'] != 1) {
                    return json(['code' => 1, 'msg' => '账号已禁用']);
                }

                Session::set('admin_id', $admin['id']);
                Session::set('admin_name', $admin['username']);

                return json(['code' => 0, 'msg' => '登录成功', 'url' => (string)url('admin/index/index')]);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '系统错误: ' . $e->getMessage()]);
            }
        }
    }

    public function logout()
    {
        Session::clear();
        return redirect((string)url('admin/login/index'));
    }
}
