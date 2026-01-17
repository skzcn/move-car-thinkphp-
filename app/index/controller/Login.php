<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class Login extends BaseController
{
    public function index()
    {
        if (Session::has('user_id')) {
            return redirect((string)url('index/user/index'));
        }
        return View::fetch();
    }

    public function check()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            
            $user = Db::name('users')->where('username', $username)->find();
            
            if (!$user) {
                return json(['code' => 1, 'msg' => '用户不存在']);
            }
            
            if (!password_verify($password, $user['password'])) {
                return json(['code' => 1, 'msg' => '密码错误']);
            }
            
            if ($user['status'] != 1) {
                return json(['code' => 1, 'msg' => '账号已禁用']);
            }
            
            Session::set('user_id', $user['id']);
            Session::set('user_name', $user['username']);
            
            return json(['code' => 0, 'msg' => '登录成功', 'url' => (string)url('index/user/index')]);
        }
    }

    public function logout()
    {
        Session::clear();
        return redirect((string)url('index/user/login'));
    }

    public function forget()
    {
        return View::fetch();
    }

    public function sendEmail()
    {
        if ($this->request->isPost()) {
            $email = $this->request->param('email');
            if (empty($email)) {
                return json(['code' => 1, 'msg' => '请输入邮箱']);
            }

            // 检查邮箱是否存在
             $user = Db::name('users')->where('email', $email)->find();
             if (!$user) {
                 return json(['code' => 1, 'msg' => '该邮箱未注册']);
             }

            $token = md5(uniqid(mt_rand(), true));
            $expire = time() + 3600; // 1小时有效期

            // 保存token到缓存
            cache('reset_token_' . $token, ['uid' => $user['id'], 'expire' => $expire], 3600);

            $url = request()->domain() . (string)url('reset', ['token' => $token]);
            $content = "您正在申请重置密码，请点击以下链接重置密码：<br><a href='{$url}'>{$url}</a><br>链接有效期1小时。";

            $result = send_email($email, '找回密码', $content);
            if ($result === true) {
                return json(['code' => 0, 'msg' => '邮件发送成功，请查收']);
            } else {
                return json(['code' => 1, 'msg' => '邮件发送失败: ' . $result]);
            }
        }
    }

    public function reset()
    {
        $token = $this->request->param('token');
        $data = cache('reset_token_' . $token);
        
        if (!$data || $data['expire'] < time()) {
            return '链接已失效';
        }

        View::assign('token', $token);
        return View::fetch();
    }

    public function doReset()
    {
        if ($this->request->isPost()) {
            $token = $this->request->param('token');
            $password = $this->request->param('password');
            
            $data = cache('reset_token_' . $token);
            if (!$data || $data['expire'] < time()) {
                return json(['code' => 1, 'msg' => '链接已失效']);
            }

            try {
                Db::name('users')->where('id', $data['uid'])->update([
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'update_time' => time()
                ]);
                cache('reset_token_' . $token, null); // 清除token
                return json(['code' => 0, 'msg' => '密码重置成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '重置失败']);
            }
        }
    }
}
