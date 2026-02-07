<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class User extends BaseController
{
    public function index()
    {
        $username = $this->request->param('u', 'default');
        $user = Db::name('users')->where('username', $username)->find();
        if (!$user) {
            return "User not found";
        }
        
        // 获取广告
        $ads = Db::name('ads')
            ->where('status', 1)
            ->order('sort desc, id desc')
            ->select()
            ->toArray();

        View::assign('user', $user);
        View::assign('ads', $ads);
        View::assign('mapConfig', config('map'));
        return View::fetch();
    }

    public function ownerConfirm()
    {
        $username = $this->request->param('u', 'default');
        $user = Db::name('users')->where('username', $username)->find();
        if (!$user) {
            return "User not found";
        }

        // 获取广告
        $ads = Db::name('ads')
            ->where('status', 1)
            ->order('sort desc, id desc')
            ->select()
            ->toArray();

        View::assign('user', $user);
        View::assign('ads', $ads);
        View::assign('mapConfig', config('map'));
        return View::fetch();
    }

    public function login()
    {
        if (Session::has('user_id')) {
            return redirect((string)url('index/index'));
        }

        if ($this->request->isPost()) {
            $data = $this->request->post();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            $user = Db::name('users')->where('username', $username)->find();

            if (!$user || !password_verify($password, $user['password'])) {
                return json(['code' => 1, 'msg' => '用户名或密码错误']);
            }

            if ($user['status'] != 1) {
                return json(['code' => 1, 'msg' => '账号已禁用']);
            }

            Session::set('user_id', $user['id']);
            Session::set('user_name', $user['username']);
            Session::set('user_nickname', $user['nickname'] ?: $user['username']);

            return json(['code' => 0, 'msg' => '登录成功', 'url' => (string)url('index/index')]);
        }
        return View::fetch();
    }

    public function logout()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        Session::delete('user_nickname');
        return redirect((string)url('index/index'));
    }

    public function profile()
    {
        if (!Session::has('user_id')) {
            return redirect((string)url('user/login'));
        }

        $userId = Session::get('user_id');
        $user = Db::name('users')->find($userId);

        // 获取未读公告数量
        $unreadCount = Db::name('user_notices')
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->count();

        // 获取公告列表
        $notices = Db::name('user_notices')
            ->alias('un')
            ->join('notices n', 'un.notice_id = n.id')
            ->where('un.user_id', $userId)
            ->field('n.id, n.title, n.content, n.create_time, un.is_read')
            ->order('n.create_time desc')
            ->select()
            ->toArray();

        if ($this->request->isPost()) {
            $data = $this->request->post();
            
            
            // 排除敏感字段
            unset($data['username']);
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']);
            }
            
            // 确保email被保存
            // $data['email'] = $data['email']; // 已经在$data中了

            $data['update_time'] = time();

            try {
                Db::name('users')->where('id', $userId)->update($data);
                Session::set('user_nickname', $data['nickname'] ?: $user['username']);
                return json(['code' => 0, 'msg' => '保存成功']);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '保存失败: ' . $e->getMessage()]);
            }
        }

        View::assign('user', $user);
        View::assign('unreadCount', $unreadCount);
        View::assign('notices', $notices);
        return View::fetch();
    }

    public function readNotice()
    {
        if (!Session::has('user_id')) {
            return json(['code' => 1, 'msg' => '请先登录']);
        }

        $noticeId = $this->request->param('id');
        $userId = Session::get('user_id');

        if (!$noticeId) {
            return json(['code' => 1, 'msg' => '参数错误']);
        }

        Db::name('user_notices')
            ->where('user_id', $userId)
            ->where('notice_id', $noticeId)
            ->update([
                'is_read' => 1,
                'read_time' => time()
            ]);

        return json(['code' => 0, 'msg' => '已读']);
    }

    public function register()
    {
        if (Session::has('user_id')) {
            return redirect((string)url('index/index'));
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            
            // 简单验证
            if (empty($data['username']) || empty($data['password'])) {
                return json(['code' => 1, 'msg' => '用户名和密码不能为空']);
            }

            // 检查用户名是否已存在
            $exists = Db::name('users')->where('username', $data['username'])->find();
            if ($exists) {
                return json(['code' => 1, 'msg' => '用户名已存在']);
            }

            // 密码哈希加密
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['create_time'] = time();
            $data['update_time'] = time();
            $data['status'] = 1;

            try {
                Db::name('users')->insert($data);
                return json(['code' => 0, 'msg' => '注册成功', 'url' => (string)url('index/index')]);
            } catch (\Exception $e) {
                return json(['code' => 1, 'msg' => '注册失败: ' . $e->getMessage()]);
            }
        }
        return View::fetch();
    }
}
